<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\View;

abstract class AdminController extends Controller
{
    protected string $model;
    protected string $route;
    protected string $folder;

    public function __construct()
    {
        View::share([
            'model'  => $this->model,
            'route'  => $this->route(),
            'folder' => $this->folder(),
            'titles' => ($this->model)::names(),
            'title'  => ($this->model)::title(),
            'var'    => ($this->model)::var(),
            'icon'   => ($this->model)::icon(),
        ]);
    }

    protected function new_query(): Builder
    {
        return ($this->model)::query();
    }

    protected function folder(?string $suffix = null): string
    {
        return ($this->model)::folder($suffix);
    }


    public function route(?string $suffix = null): string
    {
        return ($this->model)::route($suffix);
    }

    protected function redirect_to_edit(Model $item, string $message = 'Information saved'): RedirectResponse
    {
        return redirect()->route($this->route('edit'), $item)
            ->withHeaders([
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ])
            ->with('success', $message);
    }
}
