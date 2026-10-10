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
{{--    <div class="card">--}}
{{--        <div class="card-body py-3">--}}
{{--            <form action="{{ route('admin.lots.index') }}" method="GET">--}}
{{--                <div class="row align-items-center m-0">--}}
{{--                    <div class="col mb-md-0 mb-3">--}}
{{--                        <select class="single-select" name="auction_id" id="auction_id" data-select2-id="auction_id" tabindex="-1" aria-hidden="true">--}}
{{--                            @foreach($auctions as $auction)--}}
{{--                                <option value="{{ $auction->id }}" @if((isset($_GET['auction_id']) && $_GET['auction_id'] == $auction->id) || (!isset($_GET['auction_id']) && $loop->first)) selected @endif>--}}
{{--                                    {{ $auction->date_time != null ? $auction->date_time->format('d.m.Y') : '--.--.----' }} - {{ $auction->title }}--}}
{{--                                </option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}

{{--                    <div class="col-md-2 col-3">--}}
{{--                        <select class="form-select" name="status" id="status">--}}
{{--                            <option value="" @if(!isset($_GET['status']) || is_int($_GET['status'])) selected @endif>--}}
{{--                                Все статусы--}}
{{--                            </option>--}}
{{--                            @foreach($statuses as $status)--}}
{{--                                <option value="{{ $status->id }}" @if(isset($_GET['status']) && $_GET['status'] == $status->id) selected @endif>--}}
{{--	                                {{ $status->title }}--}}
{{--                                </option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                    <div class="col-auto">--}}
{{--                        <button class="btn btn-outline-primary" type="submit">Применить</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="card">
        <div class="card-header py-3">

        </div>
        <div class="card-body">
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
@endsection

@push('styles')
    <link href="{{ asset('admin/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('admin/assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/form-select2.js') }}"></script>
@endpush
