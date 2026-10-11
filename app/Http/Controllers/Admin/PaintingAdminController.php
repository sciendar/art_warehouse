<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaintingStatus;
use App\Http\Controllers\AdminController;
use App\Http\Requests\PaintingRequest;
use App\Mail\MyMail;
use App\Mail\NewPainting;
use App\Models\Image;
use App\Models\Painting;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Image\Enums\Orientation;
use Spatie\Image\Image as SpatieImage;

class PaintingAdminController extends AdminController
{
    protected string $model = Painting::class;

    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource($this->model);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $columns = [
            ($this->model)::cell_headers('№'),
            ($this->model)::cell_headers('actions'),
            'Фото',
            'Описание',
            'Склад',
            'Дата'
        ];

        $items_query = $this->new_query()
            ->with('warehouse:id,country_id,title,city,address', 'warehouse.country:id,title', 'images')
            ->where('status', request()->status ?? PaintingStatus::IN_STOCK)
            ->when(request()->filled('warehouse_id'), function ($query) {
                $query->where('warehouse_id', request()->warehouse_id);
            })
            ->when(request()->filled('user_id'), function ($query) {
                $query->where('user_id', request()->user_id);
            })
            ->when(auth()->user()->hasRole('storekeeper'), function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->when(request()->filled('description'), function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->whereLike('description', '%' . request()->string('description')->toString() . '%');
                });
            })
            ->when(request()->filled('code'), function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->whereLike('code', '%' . request()->string('code')->toString() . '%');
                });
            });

        $items = $items_query->latest()
            ->paginate(100)
            ->withQueryString();

        $counts = $items_query->clone()
            ->reorder()                  // сбрасывает все orderBy
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $all_counts = $this->new_query()
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $max_created_at  = $items_query->clone()
            ->orderByDesc('created_at')
            ->value('created_at')
            ?->format('d.m.Y H:i');
        $max_tracking_at = $items_query->clone()
            ->orderByDesc('tracking_at')
            ->value('tracking_at')
            ?->format('d.m.Y H:i');

        return view($this->folder(suffix: 'index'), compact('columns', 'items', 'counts', 'all_counts', 'max_created_at', 'max_tracking_at'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->credit();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaintingRequest $request)
    {
        return $this->post_credit($request, new ($this->model));
    }

    /**
     * Display the specified resource.
     */
    public function show(Painting $painting)
    {
        $item = $painting;
        return view($this->folder(suffix: 'show'), compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Painting $painting)
    {
        return $this->credit($painting);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaintingRequest $request, Painting $painting)
    {
        return $this->post_credit($request, $painting);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Painting $painting)
    {
        $painting->delete();
        return redirect()->route('admin.paintings.index');
    }

    public function credit($item = null)
    {
        $code = $this->code($item);
        return view($this->folder(suffix: 'credit'), compact('item', 'code'));
    }

    public function post_credit($request, $item)
    {
        $is_new = !$item->id;

        if ((count(array_filter($request->images ?? [])) + count(array_filter($request->old_images ?? []))) == 0) {
            return back()->with('error', 'Наличие изображения обязательно');
        }

        if (auth()->user()->is_admin()) {
            if (!$request->has('warehouse_user_id') || !Str::contains($request->warehouse_user_id, '_')) {
                return back()->with('error', 'Необходимо выбрать склад');
            }
            $user      = User::find(Str::after($request->warehouse_user_id, '_'));
            $warehouse = Warehouse::find(Str::before($request->warehouse_user_id, '_'));
        } else {
            $user      = auth()->user();
            $warehouse = $user->warehouse;
        }
        if (!$user || !$warehouse) {
            return back()->with('error', 'Что-то не так с выбором склада. Обратитесь к админу');
        }

        try {
            if ($item->track_number != $request->track_number && $item->status != $request->status && $request->status == PaintingStatus::SENT) {
                $item->tracking_at = now();
            }
            $item->edit($request->only($item->getFillable()));
            dd($item, $request->only($item->getFillable()));
            if ($is_new) {
                $item->code         = $this->code($item, $warehouse);
                $item->warehouse_id = (int)$warehouse->id;
                $item->user_id      = (int)$user->id;
            }
            if ($request->has('note') && trim($item->note) != trim($request->note)) {
                $item->note = $request->note . "\r\n" . $item->note;
            }
            $item->save();
            $user->touch('last_painting_at');

            $this->credit_images($item, $request);
            $this->rotate_images($request);
//            $this->redirection($item, $old_warehouse_user_id);

//            if ($is_new === true && ($old_painting_at?->format('d.m.Y') != now()->format('d.m.Y'))) {
//                Mail::to(['demy2@ukr.net',
//                          'vitalipskaya@gmail.com'])->send(new NewPainting($item, $user));
////                (new MyMail())->to('demy2@ukr.net')->send(new NewPainting($item));
//            }

            return $this->redirect_to_edit($item);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function credit_images($item, $request)
    {
        if ($request->has('old_images') && is_array($request->file('images')) && count($request->file('images'))) {
            foreach ((array)$request->old_images as $key => $old_image) {
                if (isset($request->file('images')[$key])) {
                    $image = new Image();
                    $image->upload_image($request->file('images')[$key]);
                    $image->save();
                    $ids[] = $image->id;

                    $image_path   = public_path($image->path);
                    $spatie_image = SpatieImage::load($image_path);
//                    $spatie_image->orientation();
                    $spatie_image->height(800);
                    $spatie_image->format('jpg');
                    $spatie_image->save();

                    $path        = str_replace('storage/', '', $image->path);
                    $image->size = Storage::disk('public')->size($path);
                    $image->save();
                } else {
                    $ids[] = $old_image;
                }
            }
            $item->sync_images($ids ?? []);
        }
    }

    public function rotate_images($request)
    {
        if ($request->has('rotate_90') || $request->has('rotate_270')) {
            $image = Image::find($request->rotate_90 ?? $request->rotate_270);
            if ($image) {
                $image_path   = public_path($image->path);
                $spatie_image = SpatieImage::load($image_path);
                $spatie_image->orientation($request->has('rotate_90') ? Orientation::Rotate90 : Orientation::Rotate270);
                $spatie_image->format('jpg');
                $spatie_image->save();
            }
        }
    }

    public function redirection($item, $old_warehouse_user_id)
    {
        if (auth()->user()->is_admin()) {
            $old_warehouse_id = Str::before($old_warehouse_user_id, '_');
            $old_user_id      = Str::after($old_warehouse_user_id, '_');
//        dd($item, $old_warehouse_user_id, $old_warehouse_id, $old_user_id);
            if ($old_warehouse_id != null && $old_user_id != null && ($old_warehouse_id != $item->warehouse_id || $old_user_id != $item->user_id)) {
                try {
                    DB::transaction(function () use ($item, $old_warehouse_id, $old_user_id) {
                        $warehouse     = DB::table('warehouses')->where('id', $old_warehouse_id)->first();
                        $new_warehouse = DB::table('warehouses')->where('id', $item->warehouse_id)->first();
                        $image_ids     = DB::table('image_painting')->where('painting_id', $item->id)->pluck('image_id')->toArray();

                        $new_item               = $item->replicate(['code']);
                        $new_item->status       = PaintingStatus::IN_STOCK;
                        $new_item->user_id      = $item->user_id;
                        $new_item->painting_id  = $item->id;
                        $new_item->warehouse_id = $new_warehouse->id;
                        $new_item->created_at   = now();
                        $new_item->updated_at   = now();
                        $new_item->code         = $this->code($new_item, $new_warehouse);
                        if ($warehouse->id != $new_warehouse->id) {
                            $new_item->note = now()->format('d.m.Y H:i') . ': Перенаправлено со склада #' . $warehouse->id . ' | ' . $warehouse->code . ' | ' . $warehouse->title . '(' . $warehouse->city . ')' . "\r\n" . $new_item->note;
                            $item->note     = now()->format('d.m.Y H:i') . ': Перенаправлено на склад #' . $new_warehouse->id . ' | ' . $warehouse->code . ' | ' . $new_warehouse->title . '(' . $new_warehouse->city . ')' . "\r\n" . $item->note;

                        }
                        $new_item->save();
                        $new_item->sync_images($image_ids);

                        $item->status       = PaintingStatus::SENT;
                        $item->warehouse_id = $old_warehouse_id;
                        $item->user_id      = $old_user_id;
                        $item->save();
                    });
                } catch (\Exception $e) {
                    dd($e->getMessage());
                    // Логирование ошибки
                    \Log::error('Ошибка при перемещении товара: ' . $e->getMessage());
                    // Пробрасываем исключение дальше
                    throw $e;
                }
            }
        }
    }

    public function code($item = null, $warehouse = null)
    {
        if ($item != null && isset($item->code)) {
            return $item->code;
        }

        $count = DB::table('paintings')
            ->where('warehouse_id', $warehouse?->id)
            ->count();
        return $warehouse?->code != null
            ? $warehouse?->code . '_' . Str::padLeft($count + 1, 5, 0)
            : null;
    }
}
