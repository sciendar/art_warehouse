@extends('admin._layouts._layout')

@section('title', $title)

@section('breadcrumb')
    @include('admin._layouts._breadcrumbs', ['icon'=>'<i class="bi bi-people"></i>'])
@endsection

@section('content')
    @yield('breadcrumb')

    <div class="card">
        <div class="card-header py-3">

        </div>
        <div class="card-body">
{{--            <table id="example" class="table table-striped table-bordered" style="width:100%">--}}
{{--                @include('admin._includes.tables.thead')--}}
{{--                <tbody>--}}
{{--                @foreach($lots as $item)--}}
{{--                    @include($folder . '._show_table')--}}
{{--                @endforeach--}}
{{--                </tbody>--}}
{{--                @include('admin._includes.tables.tfoot')--}}
{{--            </table>--}}
        </div>
    </div>
@endsection
