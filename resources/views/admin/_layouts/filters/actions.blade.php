@if(isset($_GET) && count($_GET) > 0)
    <div class="col-auto mt-3">
        <a href="{{ route($route . '.index') }}" type="submit" class="btn btn-outline-danger my-2">
            Очистить
        </a>
    </div>
@endif
<div class="col-auto mt-3">
    <button type="submit" class="btn btn-outline-primary my-2">
        Искать
    </button>
</div>

@push('styles')
    <link href="{{ asset('admin/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('admin/assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/form-select2.js') }}"></script>
@endpush
