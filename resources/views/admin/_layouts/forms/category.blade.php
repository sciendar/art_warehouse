<label class="form-label" for="category_id">
    {{ $label ?? 'Main category' }}
    <span class="text-primary" onclick="update_categories({{ $is_only_main ?? false }})" data-bs-toggle="tooltip" title="Update" title="View detail">
        <i class="bi bi-arrow-repeat" id="update_category_data"></i>
    </span>
</label>
<select class="single-select select2-hidden-accessible" name="category_id" id="category_id" data-select2-id="category_id" tabindex="-1" aria-hidden="true" @required($required ?? false) style="width: 100%">
    @include('admin._layouts.forms.category_view_options')
</select>

@push('styles')
    @once
        <link href="{{ asset('admin/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('admin/assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet">
        <style>
            .spinning {
                animation: spin 2s linear infinite;
                display: inline-block;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>
    @endonce
@endpush

@push('scripts')
    @once
        <script src="{{ asset('admin/assets/plugins/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('admin/assets/js/form-select2.js') }}"></script>
    @endonce
    <script>
        $('#category_id').select2();

        let is_only_main = @json($is_only_main ?? false);
        let item_id = @json(($item ?? null)?->id);
        let update_category_data = $('#update_category_data');
        // console.log(is_only_main);
        update_categories(is_only_main);

        // Функция для запуска вращения
        function start_spinning() {
            // console.log('start_spinning');
            update_category_data.addClass('spinning');
        }

        // Функция для остановки вращения
        function stop_spinning() {
            update_category_data.removeClass('spinning');
        }

        // Обработчик клика на кнопку
        update_category_data.on('click', function() {
            const is_only_main = $(this).data('is-only-main');
            update_categories(is_only_main);
        });

        function update_categories(is_only_main = false) {
            start_spinning();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: @json(route('js.categories')),
                type: 'post',
                data: {
                    'is_only_main': is_only_main,
                    'item_id': item_id
                },
                // dataType:"json",
                success:function(data) {
                    console.log(data);
                    $('#category_id').select2('destroy');
                    $('#category_id').html(data);
                    $('#category_id').select2();

                    setTimeout(function() {
                        stop_spinning();
                    }, 500);

                },
                error:function(data) {
                    alert(data.status + 'упс! что-то пошло не так :(');
                    stop_spinning();
                },
            });
        }
    </script>
@endpush
