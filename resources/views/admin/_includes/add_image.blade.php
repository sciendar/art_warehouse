
<div class="upload-wrap">
    <label for="{{ $data }}">
        {{ $label }}
    </label>
    <div class="uploadpreview {{ $data }}" style="background-image: url({{ isset($item) ? asset($item->$data) : asset('admin/img/no_image.jpg') }})">
{{--        <img class="img-container" src="{{ asset($item->get_i_image($loop->index) }}" alt="" style="max-height: 150px">--}}
    </div>
    <input class="image {{ $data }}" type="hidden" name="{{ $data }}" id="image_{{ $data }}" value="{{ isset($item) ? $item->$data : '' }}">
    <input class="form-control" id="{{ $data }}" type="file" accept="image/*" size="1024" max-file-size="1024" @if(isset($item) && is_array($item->$data) && count(array_filter($item->$data)) > 0) value="{{ $item->$data }}" @endif>
</div>

@push('scripts')
    <script>
        document.getElementById('{{ $data }}').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const maxSize = 1 * 1024 * 1024; // 1 МБ = 1048576 байт

            if (file && file.size > maxSize) {
                alert('File is too big! Maximum size: 1 Mb');
                e.target.value = ''; // Сбрасываем выбор файла
            } else {
                let id = $(this).attr("id");
                let newimage = new FileReader();
                newimage.readAsDataURL(file);
                newimage.onload = function(e) {
                    $('.uploadpreview.' + id).css('background-image', 'url(' + e.target.result + ')');
                    $('#image_' + id).val(e.target.result);

                    let alt = $('#alt');
                    let alt_value = alt.val();
                    if (!alt_value) {
                        let name = file.name.replace(/\.[^/.]+$/, ""); // Удаляем расширение
                        alt.val(name); // Устанавливаем значение
                        let size = file.size;
                    }
                    console.log(alt, alt.value, file);
                }
            }
        });
    </script>
@endpush

@once
    @push('styles')
        <style>
            .uploadpreview{
                width:250px;
                height:250px;
                display:block;
                border:1px solid #ccc;
                margin:0 auto 15px;
                background-size:100% auto;
                background-repeat:no-repeat;
                background-position:center;
            }

            .upload-wrap{
                float:left;
                width:300px;
            }

            input[type="file"] {
                color: transparent;
                /*margin: 0 auto;*/
                display: block;
                margin-bottom: 5px;
            }
        </style>
    @endpush
    @push('scripts')
        <script>


            {{--$('#alt').on('input', function() {--}}
            {{--    // this.value или $(this).val() — текущее значение--}}
            {{--    let alt = this.value--}}
            {{--    if(alt.length >= 3) {--}}
            {{--        $.ajax({--}}
            {{--            headers: {--}}
            {{--                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
            {{--            },--}}
            {{--            data: {--}}
            {{--                'id': @json($item->id ?? null),--}}
            {{--                'alt': alt,--}}
            {{--            },--}}
            {{--            type: "POST",--}}
            {{--            url: @json(route('js.is_alt')),--}}
            {{--            success: function(result) {--}}
            {{--                if (result.is_alt === true) {--}}
            {{--                    $('#alt_error').removeClass('d-none');--}}
            {{--                } else {--}}
            {{--                    $('#alt_error').addClass('d-none');--}}
            {{--                }--}}
            {{--                console.log(result);--}}
            {{--            },--}}
            {{--            error:function(result) {--}}
            {{--                // console.log('Error');--}}
            {{--                // console.log(data);--}}
            {{--            },--}}
            {{--        });--}}
            {{--    }--}}
            {{--    console.log('Значение поля изменилось:', $(this).val());--}}
            {{--});--}}
        </script>
    @endpush
@endonce
