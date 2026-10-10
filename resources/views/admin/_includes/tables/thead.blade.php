@isset($columns)
    <thead>
    <tr>
        @foreach($columns as $column)
            <th class="text-center">
                {!! $column !!}
            </th>
        @endforeach
    </tr>
    @if(!isset($d_none) || $d_none !== false)
        <tr>
            @foreach($columns as $col)
                <th class="{{ isset($marker) ? Helper::is_select_column($marker, $loop->index) : null }} text-center align-middle w-auto" id="filter_col{{ $loop->iteration }}" data-column="{{ $loop->index }}">
                    <input type="text" class="column_filter w-100" id="col{{ $loop->index }}_filter">
                    <input type="radio" class="column_filter d-none" name="col{{ $loop->index }}" id="col{{ $loop->index }}_regex">
                    <input type="radio" class="column_filter d-none" name="col{{ $loop->index }}" id="col{{ $loop->index }}_smart" checked="checked">
                </th>
            @endforeach
        </tr>
    @endif
    </thead>
@endisset

@pushonce('scripts')
    <script src="{{ asset('admin/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>

    <script src="{{ asset('admin/assets/js/table-datatable.js') }}"></script>

    <script>
        function filterGlobal() {
            $('#example')
                .DataTable()
                .search($('#global_filter').val(), $('#global_regex').prop('checked'), $('#global_smart').prop('checked'))
                .draw();
        }

        function filterColumn(i) {
            $('#example')
                .DataTable()
                .column(i)
                .search(
                    $('#col' + i + '_filter').val(),
                    $('#col' + i + '_regex').prop('checked'),
                    $('#col' + i + '_smart').prop('checked')
                )
                .draw();
        }

        $(document).ready(function () {
            $('#example').DataTable({
                dom: 'PQrt',//'PQlBfrtip',
                pageLength: 100,
                searchPanes:{
                    cascadePanes: true,
                    viewTotal: true
                },
                // buttons: [ 'colvis',//'searchBuilder'
                // {
                //     extend: 'searchBuilder',
                //     config: {
                //         depthLimit: 2
                //     }
                // }
                // ],

                order: [[0, @json($sort ?? 'desc')]],
                autoWidth: false,
                // "serverSide": true,
                orderCellsTop: true,

                pagingType: "full_numbers", // добавляет ссылки на первую и последнюю страницы
                language: {
                    paginate: {
                        first:      "<<",
                        last:       ">>",
                        next:       ">",
                        previous:   "<",
                    },
                },
            });

            $('input.global_filter').on('keyup click', function () {
                filterGlobal();
            });

            $('input.column_filter').on('keyup click', function () {
                filterColumn($(this).parents('th').attr('data-column'));
            });
        });
    </script>
@endpushonce
