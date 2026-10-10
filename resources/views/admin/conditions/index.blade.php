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
        <div class="card-body">
            <div class="">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    @include('admin._includes.tables.thead')
                    <tbody>
                        @foreach($items as $item)
                            @include($folder . '._index_table')
                        @endforeach
                    </tbody>
                    @include('admin._includes.tables.tfoot')
                </table>
            </div>
        </div>
    </div>
@endsection
