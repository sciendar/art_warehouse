@php
    $translations = $item?->translations;
@endphp

@foreach($LOCALES as $locale => $title)
    @php
        $true_count = 0;
        $params = $params ?? ['title'];
        $trans = $translations?->where('locale', $locale)->first();
        foreach ($params as $param) {
            $true_count += ($trans?->$param != null);
        }
    @endphp

    <i class="flag-icon flag-icon-{{ $locale }}"></i>
    @if($true_count == count($params))
        <span class="text-success">
            <i class="bi bi-check-circle"></i>
        </span>
    @elseif($true_count > 0)
        <span class="text-warning">
            <i class="bi bi-exclamation-triangle"></i>
        </span>
    @else
        <span class="text-danger">
            <i class="bi bi-x-circle"></i>
        </span>
    @endif
    <br>
@endforeach
