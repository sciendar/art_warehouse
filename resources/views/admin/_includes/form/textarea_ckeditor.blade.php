<label for="{{ $data }}" class="mb-1">
    <i class="flag-icon flag-icon-{{ $LANG }}"></i> {{ $label }} {{ $LANG }}
    <strong class="text-primary mx-2" data-bs-toggle="tooltip" title="Данное поле поддерживает HTML-теги">
        <i class="bi bi-code-square"></i>
    </strong>
</label>
<textarea name="{{ $data }}" id="{{ $data }}" class="{{ $class ?? 'form-control CKEDITOR mb-3' }}" style="min-height: 250px" placeholder="Введите данные" aria-label="default input example" maxlength="2500" @required($required ?? false)>{{ (isset($value) || isset($item)) ? ($value ?? $item->$data) : old($data) }}</textarea>

@once
    @push('scripts')
        <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    @endpush
@endonce

@push('scripts')
    <script>
        {{--CKEDITOR.replace({{ Str::remove('[]', $data) . $rand }} , {--}}
        {{--    allowedContent: true--}}
        {{--} );--}}
        $(".CKEDITOR").each(function () {
            let id = $(this).attr('id');
            CKEDITOR.replace(id, {
                allowedContent: true
            });
        });
    </script>
@endpush
