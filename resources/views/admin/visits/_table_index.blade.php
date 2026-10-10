<tr>
    <td class="align-content-center text-center" style="width: 75px">
        {{ $item->id }}
    </td>
    <td>
        <span class="fw-semibold">{{ Str::upper($item->method) }}</span>
        <span class="badge bg-{{ $item->statusColor() }}">{{ $item->status_code }}</span>
        <br>
        <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer">
            <span class="mx-1"><i class="bi bi-box-arrow-up-right"></i></span>{{ $item->url }}
        </a>
    </td>
    <td>
        <span class="mx-1"><i class="bi bi-laptop"></i></span>{{ $item->device_type }}<br>
        <span class="mx-1"><i class="bi bi-pc-display-horizontal"></i></span> {{ $item->platform_label() }}<br>
        <span class="mx-1"><i class="bi bi-window-sidebar"></i></span> {{ $item->browser_label() }}<br>
    </td>

    <td class="align-content-center text-center">
        {{ $item->ip }}
        <br>
        {{ $item->ip_details?->country }}, {{ $item->ip_details?->region }}, {{ $item->ip_details?->city }}
        <br>
        {{ $item->ip_details?->lat }} {{ $item->ip_details?->lon }}
    </td>
    <td class="align-content-center text-center" style="width: 75px">
        {!! $item->date_time_format() !!}
    </td>
</tr>
