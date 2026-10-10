<tr>
    <td class="text-center align-middle" style="width: 75px">
        {{ $loop->iteration }}
    </td>
    <td class="text-center align-middle" style="width: 75px">
        @include('admin._include.tables.td_status')
        <hr class="text-muted my-1">
        @include('admin._include.tables.td_edit')
        <hr class="text-muted my-1">
        <span class="text-muted">#</span>
        {{ $item->id }}
    </td>
    <td class="text-center align-middle" style="width: 75px">
        @include('admin._include.tables.td_locales', ['params' => ['title', 'description']])
    </td>
    <td class="text-center align-middle" style="width: 150px">
        <img src="{{ $item->get_i_image() }}" alt="" width="125px">
    </td>
    <td>
        <b>
            {!! $item->title !!}
        </b>
        <br>
        {!! Str::limit($item->description, 250, ' ...') !!}
    </td>
    <td class="text-center align-middle" style="width: 100px">
	    {{ $item->created_at?->format('d.m.Y') }}
        <br>
        {{ $item->created_at?->format('H:i:s') }}
    </td>
</tr>
