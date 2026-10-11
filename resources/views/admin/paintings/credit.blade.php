@extends('admin._layouts._layout')

@section('title', $title)

@section('breadcrumb')
    @include('admin._layouts._breadcrumbs')
@endsection

@section('content')
    @yield('breadcrumb')

    <div class="card">
        <form action="{{ isset($item) ? route($route . '.update',$item) : route($route . '.store') }}" class="was-validated" method="POST" enctype="multipart/form-data">
            @isset($item) @method('PATCH') @endisset
            @csrf

            <div class="card-header">
                @isset($item)
                    <div class="row">
                        <div class="col-auto text-primary" data-bs-toggle="tooltip" title="Дата добавления">
                            <span class="mx-1">
                                <i class="bi bi-plus-square"></i>
                            </span>
                            {{ $item->created_at?->format('Y.m.d H:i') ?? '--' }}
                        </div>
                        <div class="col-auto text-primary" data-bs-toggle="tooltip" title="Дата последнего обновления">
                            <span class="mx-1">
                                <i class="bi bi-pencil-square"></i>
                            </span>
                            {{ $item->updated_at?->format('Y.m.d H:i') ?? '--' }}
                        </div>
                        <div class="col-auto text-primary" data-bs-toggle="tooltip" title="Дата отправки">
                            <span class="mx-1">
                                <i class="bi bi-box2"></i>
                            </span>
                            {{ $item->tracking_at?->format('Y.m.d H:i') ?? '--' }}
                        </div>
                    </div>
                @endisset
            </div>
            <div class="card-body">
                <div class="row">
                    @include('admin._layouts.forms.images',['add'=>true])
                </div>

                <div class="row">
                    <div class="col mb-3">
                        @include('admin._layouts.forms.input', ['data'=>'code','label'=>$model::alias('code'),'value'=>$code,'other'=>'disabled readonly'])
                    </div>
                    <div class="col mb-3">
                        @include('admin._layouts.forms.input', ['data'=>'title','label'=>$model::alias('title')])
                    </div>
                    <div class="col mb-3">
                        @include('admin._layouts.forms.select_statuses')
                    </div>
                    @if(auth()->user()->is_admin())
                        <div class="col mb-3">
                            @include('admin._layouts.forms.select_warehouses_users', ['required'=>true])
                        </div>
{{--                    @else--}}
{{--                        @php($user = auth()->user())--}}
{{--                        <input type="hidden" name="warehouse_user_id" value="{{ $user->warehouse_id }}_{{ $user->id }}">--}}
                    @endif
                </div>

                <div class="row">
                    <div class="col mb-3">
                        @include('admin._layouts.forms.input', ['data'=>'track_number','label'=>$model::alias('track_number')])
                    </div>
                </div>

                <div class="row">
                    <div class="col-md mb-3">
                        @include('admin._layouts.forms.textarea', ['data'=>'description','label'=>$model::alias('description')])
                    </div>
                </div>

                <div class="row">
                    <div class="col-md mb-3">
                        @include('admin._layouts.forms.textarea', ['data'=>'condition','label'=>$model::alias('condition')])
                    </div>
                </div>

                <div class="row">
                    <div class="col-md mb-3">
                        @include('admin._layouts.forms.textarea', ['data'=>'note','label'=>$model::alias('note')])
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        @include('admin._layouts.forms.input', ['data'=>'url','label'=>$model::alias('url')])
                    </div>
                    <div class="col mb-3">
                        @include('admin._layouts.forms.input', ['data'=>'auction_id','label'=>$model::alias('auction_id')])
                    </div>
                    <div class="col mb-3">
                        @include('admin._layouts.forms.input', ['data'=>'lot','label'=>$model::alias('lot')])
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="row justify-content-end">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const status = document.getElementById('status');
            const track_number = document.getElementById('track_number');

            function toggleTrackNumberRequired() {
                const value = parseInt(status.value);
                if (value === @json(\App\Enums\PaintingStatus::SENT)) {
                    track_number.setAttribute('required', 'required');
                } else {
                    track_number.removeAttribute('required');
                }
            }

            // Инициализация
            toggleTrackNumberRequired();

            // Событие для Select2
            $(status).on('change', toggleTrackNumberRequired);
        });
    </script>
@endpush
