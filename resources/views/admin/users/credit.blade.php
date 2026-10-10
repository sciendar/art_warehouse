@extends('admin._layouts._layout')

@section('title', 'Аукционы')

@section('breadcrumb')
    @include('admin._layouts._breadcrumbs', ['icon'=>'<i class="bi bi-people"></i>'])
@endsection

@section('content')
    @yield('breadcrumb')

    <div class="card">
        <form action="{{ isset($item) ? route($route . '.update', $item) : route($route . '.store') }}" class="was-validated" method="POST" enctype="multipart/form-data">
            @isset($item) @method('PATCH') @endisset
            @csrf

            <div class="card-body">
                <div class="row">
                    <div class="col mb-3">
                        @include('admin._layouts.forms.input', ['data'=>'name','label'=>$model::alias('name'),'required'=>true])
                    </div>
                    <div class="col mb-3">
                        @include('admin._layouts.forms.input', ['data'=>'email','label'=>$model::alias('email'),'required'=>true])
                    </div>
                    <div class="col mb-3">
                        @include('admin._layouts.forms.input', ['data'=>'phone','label'=>$model::alias('phone')])
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        @include('admin._layouts.forms.select_roles')
                    </div>

                    <div class="col mb-3">
                        @include('admin._layouts.forms.multi_select_warehouses', ['required'=>true])
                    </div>

                    <div class="col mb-3">
                        @include('admin._layouts.forms.password')
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const role_select = document.getElementById('role_id');
            const warehouse_select = document.getElementById('warehouses');

            function toggleWarehouseRequired() {
                const value = parseInt(role_select.value);
                if (value === @json(\App\Models\Role::STOREKEEPER)) {
                    warehouse_select.setAttribute('required', 'required');
                    // Для Select2 добавляем класс, чтобы показать обязательность
                    $(warehouse_select).next('.select2-container').find('.select2-selection').css('border-color', '#dc3545');
                } else {
                    warehouse_select.removeAttribute('required');
                    $(warehouse_select).next('.select2-container').find('.select2-selection').css('border-color', '');
                }
            }

            // Инициализация
            toggleWarehouseRequired();

            // Событие для Select2
            $(role_select).on('change', toggleWarehouseRequired);
        });
    </script>
@endpush
