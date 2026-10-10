@php
    $param = $param ?? 'is_active';
    $icon  = $item->$param ? '<i class="bi bi-check-circle"></i>' : '<i class="bi bi-x-circle"></i>';
    $color = $item->$param ? 'text-success' : 'text-danger';
    $title = $item->$param ? 'Активно' : 'Заблокировано';
@endphp

<span class="{{ $color }}" data-bs-toggle="tooltip" title="{{ $title }}">
    {!! $icon !!}
</span>
