<label class="form-label" for="image">
    {!! $label !!}
    @include('admin._layouts.forms._field_is_required')
</label>
<div class="col-sm-2 imgUp">
    <input type="hidden" name="class" value="{{ $madel ?? null }}">
    <div class="imagePreview" style="background: url({{ asset(isset($item->path) ? $item->path : '/admin/assets/images/no_image.jpg') }}) center center / contain no-repeat; "></div>
    <input type="hidden" name="old_image" value="{{ $item?->path }}">
    <label class="btn btn-primary IMAGE_BUTTON">
        {{ isset($item->id) ? 'Замінити' : 'Додати' }}<input type="file" name="image" id="image" class="uploadFile img" accept="image/png, image/jpeg" style="width: 0px;height: 0px;overflow: hidden;">
    </label>
</div>

@push('styles')
    <style>
        .imagePreview {
            width: 100%;
            height: 180px;
            background-position: center center;
            {{--background:url({{ asset('/admin/assets/images/no_image.jpg') }});--}}
            background-color:#fff;
            background-size: contain;
            background-repeat: no-repeat;
            display: inline-block;
            box-shadow: 0px -3px 6px 2px rgba(0,0,0,0.2);
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
        /*.del {*/
        /*    !*position:absolute;*!*/
        /*    top:0px;*/
        /*    right:15px;*/
        /*    width:30px;*/
        /*    height:30px;*/
        /*    text-align:center;*/
        /*    line-height:30px;*/
        /*    !*background-color:rgba(255,255,255,0.6);*!*/
        /*    color: red;*/
        /*    cursor:pointer;*/
        /*}*/
    </style>
@endpush

@push('scripts')
    <script>
        $(document).on("change",".uploadFile", function() {
            let uploadFile = $(this);
            let files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

            if (/^image/.test( files[0].type)) { // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function(){ // set image data as background of div
                    //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                    uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
                }
            }
        });

        document.getElementById('image').addEventListener('change', function(e) {
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

                    let alt = $('#title');
                    let alt_en = $('#title');
                    let alt_value = alt.val();
                    if (!alt_value) {
                        let name = file.name.replace(/\.[^/.]+$/, ""); // Удаляем расширение
                        alt.val(name);
                        alt_en.val(name);
                        let size = file.size;
                    }
                    // console.log(alt, alt.value, file);
                }
            }
        });
    </script>
@endpush
