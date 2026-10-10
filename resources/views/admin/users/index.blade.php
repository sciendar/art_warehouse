@extends('admin._layouts._layout')

@section('title', $title)

@section('breadcrumb')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        @include('admin._layouts._breadcrumbs')
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
        <div class="card-body">
            @include('admin._layouts._pagination')
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                @include('admin._includes.tables.thead', ['sort'=>'asc'])
                <tbody>
                    @foreach($items as $item)
                        @include($folder . '._index_table')
                    @endforeach
                </tbody>
                @include('admin._includes.tables.tfoot')
            </table>
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
