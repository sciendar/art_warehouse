<tr>
    <td class="text-center align-middle" style="width: 75px">
        {{ $loop->iteration }}
    </td>
    <td class="text-center align-middle" style="width: 75px">
{{--        <span class="badge bg-{{ $item->status->color }}">--}}
{{--            {{ $item->status->title }}--}}
{{--        </span>--}}
{{--        <hr class="text-muted my-1">--}}
        @include('admin._includes.tables.td_status')
        <hr class="text-muted my-1">
        @include('admin._includes.tables.td_edit')
        <hr class="text-muted my-1">
        <span class="text-muted">#</span>
        {{ $item->id }}
    </td>
    <td>
        <span class="text-primary mx-3" data-bs-toggle="tooltip" title="ФИО">
            <i class="bi bi-person"></i>
        </span>
        {!! $item->name !!}
        <br>
        <span class="text-primary mx-3" data-bs-toggle="tooltip" title="Емейл">
            <i class="bi bi-envelope-at"></i>
        </span>
        {!! $item->email !!}
        <br>
        <span class="text-primary mx-3" data-bs-toggle="tooltip" title="Телефон">
            <i class="bi bi-phone-vibrate"></i>
        </span>
        {!! $item->phone !!}
    </td>
    <td class="text-center align-middle">
        {{ Arr::join($item->getRoleNames()->toArray(), ', ', ' и ') }}
    </td>
    <td>
        @foreach($item->warehouses as $warehouse)
            {!! $warehouse?->title !!}
            <br>
            {!! $warehouse?->country->title !!}, {!! $warehouse?->city ?? $NO_DATA !!}, {!! $warehouse?->address ?? $NO_DATA !!}
        @endforeach
    </td>

    <td class="text-center align-middle" style="width: 100px">
        @if($item->paintings_count)
            <a href="{{ route('admin.paintings.index', ['user_id'=>$item->id]) }}" target="_blank">
                {{ $item->paintings_count }}
            </a>
        @endif
    </td>
    <td class="text-center align-middle" style="width: 100px">
	    {{ $item->created_at != null ? $item->created_at->format('Y.m.d') : '??' }}
        <br>
        {{ $item->created_at != null ? $item->created_at?->format('H:i:s') : '??' }}
    </td>
</tr>
