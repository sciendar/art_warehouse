<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class VisitAdminController extends AdminController
{
    protected string $model = Visit::class;

    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource($this->model);
    }

    public function index(): View
    {
        $columns = [
            '#',
            'Сторінка',
            'Гаджет',
            'IP | Місце',
            'Дата',
        ];

        $items = $this->new_query()
            ->with('ip_details')
            ->when(request()->filled('url'), fn ($query) => $query->where('url', 'like', '%' . request()->string('url')->toString() . '%'))
            ->when(request()->filled('status_code'), fn ($query) => $query->where('status_code', request()->integer('status_code')))
            ->when(request()->filled('country'), fn ($query) => $query->where('country', request()->string('country')->toString()))
            ->when(request()->filled('created_at'), fn ($query) => $query->whereDay('created_at', Carbon::createFromFormat('Y-m-d', request()->string('created_at')->toString())))
            ->latest()
            ->paginate(100)
            ->withQueryString();

        $status_codes = $this->new_query()
            ->whereNotNull('status_code')
            ->distinct()
            ->orderBy('status_code')
            ->pluck('status_code');

//        $countries = $this->new_query()
//            ->whereNotNull('country')
//            ->distinct()
//            ->orderBy('country')
//            ->pluck('country');

        return view($this->folder('index'), compact('columns', 'items', 'status_codes'));
    }
}
