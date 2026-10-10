<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CacheHelper;
use App\Http\Controllers\AdminController;
use App\Models\Author;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthorAdminController extends AdminController
{
    protected string $model = Author::class;

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
            ($this->model)::cell_headers('langs'),
            ($this->model)::alias('images'),
            'Название | Описание',
            ($this->model)::alias('created_at'),
        ];
        $items   = $this->new_query()
            ->paginate(100)
            ->withQueryString();
        return view($this->folder(suffix: 'index'), compact('columns', 'items'));
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
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->post_credit($request, new $this->model());
    }

    /**
     * Display the specified resource.
     * @param Author $author
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param Author $author
     * @return View
     */
    public function edit(Author $author): View
    {
        return $this->credit($author);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Author $author
     * @return RedirectResponse
     */
    public function update(Request $request, Author $author): RedirectResponse
    {
        return $this->post_credit($request, $author);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        //
    }

    public function credit($item = null): View
    {
        return view($this->folder(suffix: 'credit'), compact('item'));
    }

    public function post_credit($request, $item)
    {
        try {
            $validated = $request->validated();

            $item->fill($request->safe()->only($item->getFillable()));
            $item->save();

            foreach (CacheHelper::locales() as $key => $title) {
                Cache::forget('authors_' . $key);
            }

            return $this->redirect_to_edit($item);
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
