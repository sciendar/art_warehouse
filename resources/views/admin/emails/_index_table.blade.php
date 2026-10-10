<tr>
    <td class="text-center">
        {{ $loop->iteration }}
    </td>
    <td class="text-center">
        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_{{ $item->id }}_credit">
            <span data-bs-toggle="tooltip" title="Редактировать">
                <i class="bi bi-pencil-square"></i>
            </span>
        </a>
        @include('admin.emails._modal_credit')
    </td>
    <td>
        {{ $item->key }}
    </td>
    <td>
        @foreach(config('app.locales') as $LANG_key => $LANG_title)
            @php
                $LANG = 'text_' . $LANG_key;
            @endphp
            <img src="{{ asset('admin/assets/images/flag_' . $LANG_key . '.png') }}" class="mx-2" width="20px" alt=""> {{ $item->$LANG }}
            <br>
        @endforeach
    </td>
    <td class="text-center">
        {{ $item->created_at->format('d.m.Y H:i') }}
    </td>
</tr>
