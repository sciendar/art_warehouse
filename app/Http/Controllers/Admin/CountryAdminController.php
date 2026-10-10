<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CacheHelper;
use App\Http\Controllers\AdminController;
use App\Http\Requests\CountryRequest;
use App\Models\Country;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class CountryAdminController extends AdminController
{
    protected string $model = Country::class;

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
            ($this->model)::alias('title'),
            ($this->model)::alias('created_at'),
        ];
        $items   = $this->new_query()
            ->when($_GET['title'] ?? null, function ($query) {
                $query->whereLike('title', '%' . $_GET['title'] . '%');
            })
            ->orderBy('title')
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
    public function store(CountryRequest $request)
    {
        return $this->post_credit($request, new $this->model());
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country): View
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country): View
    {
        return $this->credit($country);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CountryRequest $request, Country $country)
    {
        return $this->post_credit($request, $country);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
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
            $item->fill($request->only($item->getFillable()));
            $item->is_active = $request->has('is_active');
            $item->save();

            Cache::forget('countries');
            return $this->redirect_to_edit($item);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}
