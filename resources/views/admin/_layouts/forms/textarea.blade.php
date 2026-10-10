<label class="form-label" for="{{ $data }}">
    @isset($flag)
        <span class="mx-2"><i class="flag-icon flag-icon-{{ $flag }} flag-icon-squared rounded-circle"></i></span>
    @endisset
    {{ $label }}
    @isset($required)
        @include('admin._layouts.forms._field_is_required')
    @endisset
</label>
<textarea class="form-control" name="{{ $data }}" length="{{ $length ?? 25000 }}" pattern="{{ $pattern ?? (($length ?? 25000) ? '[\D\d\s]{2,' . ($length ?? 25000) . '}' : '[\D\d\s]{2,25000}') }}"
    id="{{ $id ?? $data }}" {{ isset($required) ? 'required' : null }} rows="{{ $rows ?? 3 }}" {{ $other ?? null }}>{{ $value ?? ($item->$data ?? old($data)) }}</textarea>

@php
    $label = null; $data = null; $LANG = null; $type = null; $id = null; $class = null; $value = null; $pattern = null; $length = null; $placeholder = null; $required = null; $other = null;
@endphp
