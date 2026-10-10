@isset($columns)
    <tfoot>
        <tr>
            @foreach($columns as $column)
                <th class="text-center">
                    {!! $column !!}
                </th>
            @endforeach
        </tr>
    </tfoot>
@endisset
