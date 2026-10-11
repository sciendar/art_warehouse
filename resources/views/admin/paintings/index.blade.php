@extends('admin._layouts._layout')

@section('title', $title)

@section('breadcrumb')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        @include('admin._layouts._breadcrumbs', ['is_add'=>false])
    </div>
    <hr/>
@endsection

@section('content')
    @yield('breadcrumb')

    <div class="card">
        <div class="card-body py-3">
            @include($folder . '._filters')
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row justify-content-between">
                <div class="col mt-2">
                    <span class="text-primary mx-2" data-bs-toggle="tooltip" title="Последняя дата добавления">
                        <span class="mx-1">
                            <i class="bi bi-plus-square"></i>
                        </span>
                        {{ $max_created_at ?? '--' }}
                    </span>
                    <span class="text-primary mx-2" data-bs-toggle="tooltip" title="Последняя дата отправки">
                        <span class="mx-1">
                            <i class="bi bi-box2"></i>
                        </span>
                        {{ $max_tracking_at ?? '--' }}
                    </span>
                </div>
                <div class="col-auto text-end">
                    <a href="{{ route('admin.paintings.index', array_merge(request()->query(), ['type' => 'card'])) }}" class="btn {{ (!isset($_GET['type']) || $_GET['type'] == 'card') ? 'btn-primary' : 'btn-outline-primary' }} mx-1">
                        <div class="d-flex align-items-center">
                            <div class="tab-icon">
                                <i class="bi bi-ui-checks-grid"></i>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('admin.paintings.index', array_merge(request()->query(), ['type' => 'table'])) }}" class="btn {{ (isset($_GET['type']) && $_GET['type'] == 'table') ? 'btn-primary' : 'btn-outline-primary' }} mx-1">
                        <div class="d-flex align-items-center">
                            <div class="tab-icon">
                                <i class="bi bi-ui-checks"></i>
                            </div>
                        </div>
                    </a>
                    <span class="mx-3"> </span>
                    @if(!auth()->user()->hasRole('manager'))
                        <a href="{{ route($route . '.create') }}" class="btn btn-outline-primary">
                            Добавить
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body">
            @include('admin._layouts._pagination')

            @if(!isset($_GET['type']) || $_GET['type'] == 'card')
                <div class="row justify-content-center">
                    @foreach($items as $item)
                        <div class="col-md-3 my-3">
                            @include($folder . '._index_card')
                        </div>
                    @endforeach
                </div>
            @else
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    @include('admin._includes.tables.thead')
                    <tbody>
                    @foreach($items as $item)
                        @include($folder . '._index_table')
                    @endforeach
                    </tbody>
                    @include('admin._includes.tables.tfoot')
                </table>
            @endif

            @include('admin._layouts._pagination', ['is_top' => false])
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('admin/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('admin/assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/form-select2.js') }}"></script>
@endpush
