<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Http\Requests\IpRequest;
use App\Models\Ip;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class IpAdminController extends AdminController
{
    protected string $model = Ip::class;

    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource($this->model);
    }

    public function index(Request $request): View
    {
        $columns = [
            ($this->model)::cell_headers('№'),
            ($this->model)::cell_headers('actions'),//'Статус',
            'IP',
            'Розташування',
            ($this->model)::alias('created_at'),
        ];

        $items = $this->newQuery()
            ->select('id', 'is_active', 'is_admin', 'ip', 'country', 'city', 'created_at')
            ->when($request->filled('is_active'), fn ($query) => $query->where('is_active', $request->boolean('is_active')))
            ->when($request->filled('is_admin'), fn ($query) => $query->where('is_admin', $request->boolean('is_admin')))
            ->when($request->filled('ip'), fn ($query) => $query->where('ip', 'like', '%'.$request->string('ip')->toString().'%'))
            ->when($request->filled('country'), fn ($query) => $query->where('country', 'like', '%'.$request->string('country')->toString().'%'))
            ->latest()
            ->paginate(100)
            ->withQueryString();

        return view($this->resourceFolder('index'), compact('columns', 'items'));
    }

    public function edit(Ip $ip): View
    {
        return $this->form($ip);
    }

    public function update(IpRequest $request, Ip $ip): RedirectResponse
    {
        return $this->persistResource($request, $ip);
    }

    protected function form(?Ip $item = null): View
    {
        return $this->renderForm($item);
    }

    protected function persistResource(IpRequest $request, Ip $item): RedirectResponse
    {
        try {
            $validated = $request->validated();

            $item->is_active = $validated['is_active'];
            $item->is_admin = $validated['is_admin'];
            $item->save();

            Cache::forget('ip_exceptions');
            Cache::forget('ip_allowed');

            return $this->redirectToEdit($item);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}
