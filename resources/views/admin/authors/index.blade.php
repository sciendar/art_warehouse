@extends('admin._layout')

@section('title', 'Авторы')

@section('breadcrumb')
    @include('admin._include.breadcrumb', ['icon'=>'<i class="bi bi-question-octagon"></i>','add'=>true])
@endsection

@section('content')
    @yield('breadcrumb')
    <div class="card">
        <div class="card-body">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                @include('admin._include.tables.thead')
                <tbody>
                    @foreach($items as $item)
                        @include($folder . '._index_table')
                    @endforeach
                </tbody>
                @include('admin._include.tables.tfoot')
            </table>
        </div>
    </div>
@endsection
