<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaintingStatus;
use App\Http\Controllers\AdminController;
use App\Http\Requests\PaintingRequest;
use App\Mail\MyMail;
use App\Mail\NewPainting;
use App\Models\Image;
use App\Models\Painting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Image\Image as SpatieImage;
use Spatie\Image\Manipulations;

class ImageAdminController extends AdminController
{
    protected string $model = Image::class;

    public function __construct()
    {
        parent::__construct();
//        $this->authorizeResource($this->model);
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

        $items = $this->new_query()
            ->latest()
            ->paginate(100)
            ->withQueryString();

        return view($this->folder(suffix: 'index'), compact('columns', 'items'));
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
        //
    }

    public function credit($item = null)
    {
        $code = $this->code($item);
        return view($this->folder(suffix: 'credit'), compact('item', 'code'));
    }

    public function post_credit($request, $item)
    {
        $is_new          = !$item->id;
        $user            = auth()->user();
        $old_painting_at = $user->last_painting_at ?? now()->subDays();

        try {
            $item->edit($request->only($item->getFillable()));
            if ($is_new) {
                $item->user_id      = $user->id;
                $item->warehouse_id = $user->warehouse_id ?? 0;
                $item->code         = $this->code();
            }
            $item->save();

            $user->touch('last_painting_at');

            $this->credit_images($item, $request);

            if ($is_new === true && ($old_painting_at?->format('d.m.Y') != now()->format('d.m.Y'))) {
                Mail::to(['demy2@ukr.net',
                          'vitalipskaya@gmail.com'])->send(new NewPainting($item, $user));
//                (new MyMail())->to('demy2@ukr.net')->send(new NewPainting($item));
            }

            return $this->redirect_to_edit($item);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function rotate(Request $request, Image $image)
    {
        dd($image, $request);
    }

}
