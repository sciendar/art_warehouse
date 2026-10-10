@if(($trans ?? true) == true)
    @php
        $is_active_uk = $item->is_active == true;
        $is_active_en = $item->is_active == true && $item->title_en != null;
    @endphp

    <span class="mx-2"><i class="flag-icon flag-icon-ua flag-icon-squared rounded-circle"></i></span>
    @if($is_active_uk === true)
        <span class="text-success" data-bs-toggle="tooltip" title="Активно">
            <i class="bi bi-check2-circle"></i>
        </span>
    @else
        <span class="text-danger" data-bs-toggle="tooltip" title="Не активно">
            <i class="bi bi-x-circle"></i>
        </span>
    @endif
    <br>
    <span class="mx-2"><i class="flag-icon flag-icon-gb flag-icon-squared rounded-circle"></i></span>
    @if($is_active_en === true)
        <span class="text-success" data-bs-toggle="tooltip" title="Активно">
            <i class="bi bi-check2-circle"></i>
        </span>
    @else
        <span class="text-danger" data-bs-toggle="tooltip" data-bs-originaltitle="Не активно">
            <i class="bi bi-x-circle"></i>
        </span>
    @endif
@else
    @if($item->is_active == true)
        <span class="text-success" data-bs-toggle="tooltip" title="Активно">
            <i class="bi bi-check2-circle"></i>
        </span>
    @else
        <span class="text-danger" data-bs-toggle="tooltip" title="Не активно">
            <i class="bi bi-x-circle"></i>
        </span>
    @endif
@endif
