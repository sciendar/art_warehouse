<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CacheHelper;
use App\Http\Controllers\AdminController;
use App\Models\Condition;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ConditionAdminController extends AdminController
{
    protected string $model = Condition::class;

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
            ($this->model)::cell_headers('Название | Описание'),
            ($this->model)::alias('created_at'),
        ];

        $items   = $this->new_query()
            ->when($_GET['title'] ?? null, function ($query) {
                $query->whereLike('title', '%' . $_GET['title'] . '%');
            })
            ->latest()
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
     */
    public function store(Request $request)
    {
        return $this->post_credit($request, new $this->model());
    }

    /**
     * Display the specified resource.
     */
    public function show(Condition $condition): View
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Condition $condition): View
    {
        return $this->credit($condition);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Condition $condition)
    {
        return $this->post_credit($request, $condition);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Condition $condition)
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
            $item->is_active = $request->has('is_active');
            $item->save();

            foreach (CacheHelper::locales() as $key => $title) {
                Cache::forget('conditions_' . $key);
            }

            return $this->redirect_to_edit($item);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function validate_data($request)
    {
        $rules = [
            'title'        => 'required|string|max:255',
        ];

        $messages = [
            'required' => 'Поле :attribute является обязательным.',
        ];

        return Validator::make($request->all(), $rules);// , $messages
    }
}
