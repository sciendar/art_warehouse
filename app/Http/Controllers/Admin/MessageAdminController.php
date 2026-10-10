<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Message;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageAdminController extends AdminController
{
    protected string $model = Message::class;

    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource($this->model);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $columns = [
            ($this->model)::cell_headers('№'),
            ($this->model)::cell_headers('actions'),
            'Автор',
            'Тема',
            'Сообщение',
            'К-во сообщений',
            ($this->model)::alias('created_at'),
        ];

        $items = Message::with('user', 'theme', 'lot', 'last_message')
            ->withCount('messages')
            ->where('message_id', null)
            ->latest()
            ->paginate(100)
            ->withQueryString();

        return view(($this->model)::folder(suffix: 'index'), compact('columns', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return $this->credit();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->post_credit($request, new $this->model());
    }

    /**
     * Display the specified resource.
     * @param Message $message
     * @return View
     */
    public function show(Message $message): View
    {
//        $item = $message;
//
//        $items = Message::where('message_id', $item->id)
//            ->oldest()
//            ->get();
//        foreach ($items as $this_item) {
//            if ($this_item->name != null && $this_item->read_at == null) {
//                $this_item->read_at = now();
//                $this_item->save();
//            }
//        }
//
//        return view(($this->model)::folder(suffix: 'show'), compact('columns', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param Message $message
     * @return View
     */
    public function edit(Message $message): View
    {
        return $this->credit($message);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Message $message
     * @return RedirectResponse
     */
    public function update(Request $request, Message $message)
    {
        return $this->post_credit($request, $message);
//        $message->edit($request->only('test'));
//        $message->read_at = null;
//        $message->save();
//
//        $item             = Message::add($request->all());
//        $item->message_id = $message->id;
//        $item->author_id  = auth()->id();
//        $item->upload_file($request->file('file'));
//        $item->save();
//        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }

    public function credit($item = null)
    {
        return view(($this->model)::folder(suffix: 'credit'), compact('item'));
    }

    public function post_credit($request, $item)
    {
        $validator = $this->validate_data($request);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $validated = $validator->validated();

        try {
//            if ($this->is_sync_or_sort($request)) {
//                return $this->sort_and_sync($request, $item);
//            }

            $item->edit($request->only($item->getFillable()));
            $item->is_active = $request->has('is_active');
            $item->save();

//            $item->sync_territories($request->territory_ids);
//            $item->sync_tags($request->tag_ids);

            return redirect()->route(($this->model)::route(suffix: 'edit'), $item)->with('success', 'Information saved');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function validate_data($request)
    {
        $rules = [
            'territory_ids'   => 'nullable|array',
            'territory_ids.*' => 'nullable|integer|exists:territories,id',
            'title_uk'        => 'required|string|max:255',
            'title_en'        => 'nullable|string|max:255',
            'text_uk'         => 'required|string|max:25000',
            'text_en'         => 'nullable|string|max:25000',

            'intro_title_uk' => 'nullable|string|max:255',
            'intro_title_en' => 'nullable|string|max:255',
            'intro_text_uk'  => 'nullable|string|max:2500',
            'intro_text_en'  => 'nullable|string|max:2500',

            'seo_title_uk'       => 'nullable|string|max:255',
            'seo_title_en'       => 'nullable|string|max:255',
            'seo_keywords_uk'    => 'nullable|string|max:255',
            'seo_keywords_en'    => 'nullable|string|max:255',
            'seo_description_uk' => 'nullable|string|max:255',
            'seo_description_en' => 'nullable|string|max:255',
        ];

        $messages = [
            'required' => 'Поле :attribute является обязательным.',
        ];

        return Validator::make($request->all(), $rules);// , $messages
    }
}
