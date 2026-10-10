<tr>
    <td class="text-center align-middle" style="width: 75px">
        {{ $loop->iteration }}
    </td>
    <td class="text-center align-middle" style="width: 75px">
        @include('admin._includes.tables.td_status')
        <hr class="text-muted my-1">
        @include('admin._includes.tables.td_show')
        <hr class="text-muted my-1">
        <span class="text-muted">#</span>
        {{ $item->id }}
    </td>

    <td>
        @if($item->user_id != null)
            <a href="{{ route('admin.users.show', $item->user) }}">
                {!! $item->user->first_name !!} {!! $item->user->last_name !!}
            </a>
        @endif
        <hr class="my-1">
        {{ $item->name }}<br>
        {{ $item->email }}
    </td>
    <td>
        {{ $item->theme_id != null ? $item->theme->title : '--' }}
    </td>
    <td>
        @if($item->read_at == null) <b> @endif
        {{ Str::limit($item->text, 50, ' ...') }}
        @if($item->read_at == null) </b> @endif
    </td>
    <td class="text-center">
        {{ $item->messages_count }}
    </td>
    <td class="text-center align-middle" style="width: 100px">
	    {{ $item->created_at?->format('d.m.Y') }}
        <br>
        {{ $item->created_at?->format('H:i:s') }}
    </td>
</tr>
