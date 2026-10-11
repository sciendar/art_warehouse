@php
    $length = $length ?? 250;
    $value = $data != 'password'
        ? $value ?? (((isset($type) && isset($item) && $type == 'date')) ? ($item->$data != null ? $item->$data : now())->format('Y-m-d') : (old($data) ?? ($item ?? null)?->$data))
        : (!isset($item) ? Str::random(16) : null);
@endphp

@isset($label)
    <label class="form-label" for="{{ $data }}">
        @isset($flag)
            <i class="flag-icon flag-icon-{{ $LANG }}"></i>
        @endisset
        {!! $label !!} {!! isset($flag) ? $LANG : null !!}
        @isset($required)
            @include('admin._layouts.forms._field_is_required')
        @endisset
    </label>
@endisset

<input
    type="{{ $type ?? 'text' }}"
    id="{{ $id ?? $data }}"
    name="{{ $name ?? $data }}"
    class="{{ $class ?? 'form-control' }}"
    value="{{ $value }}"
    pattern="{{ $pattern ?? '[\D\d\s]{1,' . $length . '}' }}"
    placeholder="{{ $placeholder ?? 'Введите данные' }}"
    @if($data != 'slug')
        length="{{ $length }}"
    @endif
    @isset($step) step="{{ $step }}" @endisset
    @isset($max) max="{{ $max }}" @endisset
    @isset($min) min="{{ $min }}" @endisset

    @isset($datamask) data-mask="{{ $datamask }}" @endisset
    @required($required ?? false)
    {{ $other ?? null }}
    @isset($onkeyup) onkeyup="this.value = this.value.replace({{$onkeyup}}, '');" @endisset
>

@php
  $label = null; $data = null; $LANG = null; $type = null; $id = null; $class = null; $value = null; $pattern = null; $length = null; $placeholder = null; $required = null; $other = null;
@endphp
