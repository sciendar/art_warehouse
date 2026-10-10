<label class="form-label" for="{{ $data }}">
    @isset($flag)
        <span class="mx-2"><i class="flag-icon flag-icon-{{ $flag }} flag-icon-squared rounded-circle"></i></span>
    @endisset
    {{ $label }}
    @isset($required)
        @include('admin._layouts.forms._field_is_required')
    @endisset
</label>
<textarea name="{{ $data }}" id="{{ $data }}" class="{{ $class ?? 'form-control SUMMERNOTE_CKEDITOR mb-3' }}" style="min-height: 250px" placeholder="Введите данные" aria-label="default input example" maxlength="2500"  @isset($required) required @endisset>{{ (isset($value) || isset($item)) ? ($value ?? $item->$data) : old($data) }}</textarea>

@push('scripts')
    @once
        <link href="{{ asset('admin/my_plugins/summernote/summernote-bs5.css') }}" rel="stylesheet">
        <script src="{{ asset('admin/my_plugins/summernote/summernote-bs5.js') }}"></script>

        <script>
            $(document).ready(function() {
                $('.SUMMERNOTE_CKEDITOR').summernote({
                    fontName: 'Arial',
                    fontSize: 48,
                    height: 200,
                    toolbar: [
                        // [groupName, [list of button]]
                        ['style', ['clear']],
                        ['style', ['undo','redo']],
                        ['style', ['bold', 'italic']], // , 'underline'
                        ['font', ['superscript', 'subscript']], // 'strikethrough',
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol']],
                        ['para', ['paragraph']],
                        ['insert', ['link']], // , 'video'
                        ['insert', ['picture']],
                        ['table', ['table']],
                        // ['height', ['height']],
                        ['view', ['codeview']],//'fullscreen',
                        ['view', ['help']],
                    ]
                });
            });
        </script>
    @endonce
@endpush

@push('styles')
    <style>
        .TEXT{
            text-indent: 1.5em;
            text-align: justify;
        }
        .TABLE_NAME{
            text-align: center;
            font-style: italic;
        }
    </style>
@endpush

@php
    $label = null; $data = null; $LANG = null; $type = null; $id = null; $class = null; $value = null; $pattern = null; $length = null; $placeholder = null; $required = null; $other = null;
@endphp
