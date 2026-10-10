@if(isset($item) && $item->images->count())
    @foreach($item->images as $image)
        <div class="col-sm-2 imgUp">
            <div class="imagePreview" style="background-image: url({{ asset($image->path) }})"></div>
            <input type="hidden" name="old_images[]" value="{{ $image->id }}">
            <label class="btn btn-primary IMAGE_BUTTON">
                Редактировать<input type="file" name="images[]" class="uploadFile img" accept="image/png, image/jpeg" style="width: 0px;height: 0px;overflow: hidden;">
            </label>
            <div class="row justify-content-between">
                <div class="col text-center">
                    <button type="submit" class="btn btn-outline-primary" name="rotate_270" value="{{ $image->id }}">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </button>
                </div>
                <div class="col text-center">
                    <button type="submit" class="btn btn-outline-primary" name="rotate_90" value="{{ $image->id }}">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>
            </div>
            @if(!$loop->first)
                <i class="bi bi-x-circle del"></i>
            @endif
        </div>
{{--        <div class="col-2 ImageCart">--}}
{{--            @isset($label)--}}
{{--                <label class="label mb-1">--}}
{{--                    {{ $label ?? '' }}--}}
{{--                </label>--}}
{{--            @endisset--}}
{{--            <div data-bs-toggle="tooltip" title="Изменить">--}}
{{--                <img class="rounded w-100" data-type="avatar" src="{{ asset($item->get_i_image($loop->index)) }}" >--}}
{{--                <input type="file" class="sr-only d-none" data-type="input" name="image" accept="image/*">--}}
{{--                <input type="hidden" name="images[]" data-type="images" value="{{ $image }}">--}}
{{--            </div>--}}
{{--            @if(isset($min_photo) && $loop->iteration > $min_photo)--}}
{{--                <div class="DEL text-danger" data-bs-toggle="tooltip" title="Удалить">--}}
{{--                    <i class="bi bi-x-circle"></i>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div>--}}
    @endforeach
@else
    <div class="col-sm-2 imgUp">
        <div class="imagePreview"></div>
        <input type="hidden" name="old_images[]">
        <label class="btn btn-primary IMAGE_BUTTON">
            Добавить<input type="file" name="images[]" class="uploadFile img" accept="image/png, image/jpeg" style="width: 0px;height: 0px;overflow: hidden;">
        </label>
    </div>
@endif

@if(($add ?? false) === true)
    <i class="bi bi-plus-circle imgAdd"></i>
@endif

@push('styles')
    <style>
        .imagePreview {
            width: 100%;
            height: 180px;
            background-position: center center;
            background:url({{ asset($DEF_IMAGE) }});
            background-color:#fff;
            background-size: cover;
            background-repeat:no-repeat;
            display: inline-block;
            box-shadow:0px -3px 6px 2px rgba(0,0,0,0.2);
        }
        .IMAGE_BUTTON {
            display:block;
            border-radius:0px;
            box-shadow:0px 4px 6px 2px rgba(0,0,0,0.2);
            margin-top:-5px;
        }
        .imgUp {
            margin-bottom:15px;
        }
        .del {
            /*position:absolute;*/
            top:0px;
            right:15px;
            width:30px;
            height:30px;
            text-align:center;
            line-height:30px;
            /*background-color:rgba(255,255,255,0.6);*/
            color: red;
            cursor:pointer;
        }
        .imgAdd {
            width:0px;
            height:0px;
            border-radius:50%;
            background-color:#4bd7ef;
            color: #003dfc;
            /*box-shadow:0px 0px 2px 1px rgba(0,0,0,0.2);*/
            text-align:center;
            line-height:30px;
            margin-top:0px;
            cursor:pointer;
            font-size:25px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(".imgAdd").click(function(){
            $(this).closest(".row").find('.imgAdd').before('<div class="col-sm-2 imgUp">' +
                '<div class="imagePreview"></div>' +
                '<input type="hidden" name="old_images[]">' +
                '<label class="btn btn-primary IMAGE_BUTTON">' +
                'Добавить' +
                '<input type="file" name="images[]" class="uploadFile img" accept="image/png, image/jpeg" style="width:0px;height:0px;overflow:hidden;">' +
                '</label>' +
                '<i class="fa fa-times del"></i>' +
                '</div>');
        });
        $(document).on("click", "i.del" , function() {
            $(this).parent().remove();
        });
        $(function() {
            $(document).on("change",".uploadFile", function()
            {
                var uploadFile = $(this);
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test( files[0].type)){ // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function(){ // set image data as background of div
                        //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                        uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
                    }
                }

            });
        });
    </script>
@endpush
