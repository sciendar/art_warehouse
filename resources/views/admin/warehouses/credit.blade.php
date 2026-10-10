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
        <form action="{{ isset($item) ? route($route . '.update', $item) : route($route . '.store') }}" class="was-validated" method="POST" enctype="multipart/form-data">
            @isset($item) @method('PATCH') @endisset
            @csrf

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col mb-3">
                                @include('admin._layouts.forms.input', ['data'=>'code','label'=>$model::alias('code'),'length'=>5,'required'=>true])
                            </div>
                            <div class="col mb-3">
                                @include('admin._layouts.forms.input', ['data'=>'title','label'=>$model::alias('title'),'required'=>true])
                            </div>
                        </div>
                    </div>
                    <div class="col mb-3">
                        @include('admin._layouts.forms.select_countries', ['required'=>true])
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        @include('admin._layouts.forms.input', ['data'=>'city','label'=>$model::alias('city'),'required'=>true])
                    </div>
                    <div class="col mb-3">
                        @include('admin._layouts.forms.input', ['data'=>'address','label'=>$model::alias('address'),'required'=>true])
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row justify-content-end">
                    <div class="col-auto">
                        <div class="form-check form-switch mt-1">
                            <input class="form-check-input mx-2" type="checkbox" name="is_active" id="is_active" @if((isset($item) && $item->is_active == true) || !isset($item)) checked @endif style="height: 20px; width: 40px" data-bs-toggle="tooltip" title="Статус">
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </div>
            </div>
        </form>
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
