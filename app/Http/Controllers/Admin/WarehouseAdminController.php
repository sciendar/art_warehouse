<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Http\Requests\WarehouseRequest;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class WarehouseAdminController extends AdminController
{
    protected string $model = Warehouse::class;

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
            'Склад',
            'Картины',
            'Дата'
        ];

        $items = $this->new_query()
            ->with('country:id,title')
            ->withCount('paintings')
            ->when(request()->filled('country_id'), function ($query) {
                $query->where('country_id', request()->country_id);
            })
            ->when(request()->filled('name'), function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->whereLike('name', '%' . request()->string('name')->toString() . '%');
                });
            })
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
    public function store(WarehouseRequest $request)
    {
        return $this->post_credit($request, new ($this->model));
    }

    /**
     * Display the specified resource.
     */
    public function show(Warehouse $warehouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse)
    {
        return $this->credit($warehouse);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WarehouseRequest $request, Warehouse $warehouse)
    {
        return $this->post_credit($request, $warehouse);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        //
    }

    public function credit($item = null)
    {
        return view($this->folder(suffix: 'credit'), compact('item'));
    }

    public function post_credit($request, $item)
    {
        try {
            $item->edit($request->only($item->getFillable()));
            $item->is_active = $request->has('is_active');
            $item->code = Str::upper($request->code);
            $item->save();

            Cache::forget('warehouses');
            return $this->redirect_to_edit($item);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}
