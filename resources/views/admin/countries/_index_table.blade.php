<tr>
    <td class="text-center align-middle" style="width: 75px">
        {{ $loop->iteration }}
    </td>
    <td class="text-center align-middle" style="width: 75px">
        @include('admin._includes.tables.td_status', ['param' => 'is_active'])
        <hr class="text-muted my-1">
        @include('admin._includes.tables.td_edit')
        <hr class="text-muted my-1">
        <span class="text-muted">#</span>
        {{ $item->id }}
    </td>

    <td>
        {!! $item->title !!}
    </td>

    <td class="text-center align-middle" style="width: 100px">
        @if($item->created_at != null)
            {{ $item->created_at?->format('d.m.Y') }}
            <br>
            {{ $item->created_at?->format('H:i:s') }}
        @endif
    </td>
</tr>
