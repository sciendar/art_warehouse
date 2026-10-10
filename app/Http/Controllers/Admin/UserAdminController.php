<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Http\Requests\UserRequest;
use App\Mail\UserAdditionalInformation;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Query\Builder;
use Spatie\Permission\Models\Role;

class UserAdminController extends AdminController
{
    protected string $model = User::class;

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
            'Данные',
            'Роль',
            'Склад',
            'Картины',
            'Дата'
        ];

        $items = $this->new_query()
            ->with('warehouses:id,country_id,title,city,address', 'warehouses.country:id,title')
            ->withCount('paintings')
            ->when(request()->filled('warehouse_id'), function ($query) {
                $query->where('warehouse_id', request()->warehouse_id);
            })
            ->when(request()->filled('email'), function ($query) {
                $query->whereLike('email', '%' . request()->string('email')->toString() . '%');
            })
            ->when(request()->filled('name'), function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->whereLike('name', '%' . request()->string('name')->toString() . '%');
                });
            })
            ->orderByDesc('id')
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
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request)
    {
        return $this->post_credit($request, new ($this->model));
    }

    /**
     * Display the specified resource.
     * @param User $user
     * @return void
     */
    public function show(User $user)
    {
//        $item = $user;
//        return view('admin.users.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return $this->credit($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        return $this->post_credit($request, $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
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
            $role = Role::where('id', $request->role_id)->first();
            if (!$role) {
                return back()->withInput()->with('error', 'Выбранная роль не найдена');
            }

            $item->edit($request->only($item->getFillable()));
            $item->is_active    = $request->has('is_active');
            $item->password     = $request->has('password')
                ? Hash::make($request->password)
                : $item->password;
            $item->warehouse_id = $request->warehouses[0] ?? null;
            $item->save();

            $item->sync_warehouses($request->warehouses);
            $item->assignRole($role);

            return $this->redirect_to_edit($item);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function additional_information_needed(Request $request, User $user)
    {
        try {
            Mail::to($user->email)->send(new UserAdditionalInformation($user));//$user->email
        } catch (\Exception $e) {
            dd($e);
        }
        return back()->with('success', 'Письмо с запросом отправлено');
    }
}
