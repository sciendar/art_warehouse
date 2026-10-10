@extends('admin._layouts._layout')

@section('content')
    <div class="card">
        @include('admin._layouts.cards.header_index', ['is_add' => false])
        <div class="card-body">
            @include($folder . '._filters')

            @include('admin._layouts._pagination')
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    @include('admin._layouts.table.thead')
                    <tbody>
                        @foreach($items as $item)
                            @include($folder . '._table_index')
                        @endforeach
                    </tbody>
                    @include('admin._layouts.table.tfoot')
                </table>
            </div>
            @include('admin._layouts._pagination', ['is_top' => false])
        </div>
    </div>
@endsection
