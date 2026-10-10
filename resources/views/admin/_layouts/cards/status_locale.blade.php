@php
    $trans_item = $item->translate($locale->lang);
@endphp

<i class="flag-icon flag-icon-{{ $locale->country_code }} flag-icon-squared rounded-circle"></i>

@if($trans_item != null)
    @if($trans_item->is_active == true)
        <span class="text-success" data-bs-toggle="tooltip" title="Активно">
            <i class="bi bi-check2-circle"></i>
        </span>
    @else
        <span class="text-danger" data-bs-toggle="tooltip" title="Не активно">
            <i class="bi bi-x-circle"></i>
        </span>
    @endif
@else
    <span class="text-warning" data-bs-toggle="tooltip" title="Не создано">
        <i class="bi bi-exclamation-circle"></i>
    </span>
@endif
