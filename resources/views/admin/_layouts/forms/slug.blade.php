<label class="form-label" for="slug">
    <span class="mx-2"><i class="bi bi-link-45deg"></i></span>
    Slug
    <span class="text-danger mx-2" data-bs-toggle="tooltip" title="Для автоматичного формування залиш поле порожнім">
        <i class="bi bi-question-circle"></i>
    </span>
    <span class="text-danger text-small d-none" id="slug_error"></span>
</label>

<div class="input-group mb-1">
    <div class="input-group mb-3">
        <div class="input-group-text">
            <input class="form-check-input is_check" name="is_slug" type="checkbox">
        </div>
        @include('admin._layouts.forms.input',['data'=>'slug','id'=>'slug','other'=>'disabled'])
    </div>
</div>

@push('styles')
    <style>
        /*.input-group > .form-control:not(:first-child), .input-group > .custom-select:not(:first-child) {*/
        /*    border-top-left-radius: 5px;*/
        /*    border-bottom-left-radius: 5px;*/
        /*}*/
        .input-group > .form-control:not(:last-child), .input-group > .custom-select:not(:last-child) {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $('body').on('click', '.is_check', function () {
            const SLUG = "#slug";
console.log(this.checked, this)
            if (this.checked) {
                $(SLUG).prop('disabled', false);
                // $(SLUG).prop('required', true);
            } else {
                $(SLUG).prop('disabled', true);
                // $(SLUG).prop('required', false);
            }
        });

        $(document).on('input','#slug',function (){
            const slug_error = "#slug_error";
            let slug = $(this).val();
            let model = "{{ $model }}";
            let id = "{{ isset($item) ? $item->id : null }}";

            if (slug.length >= 3) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'model': model,
                        'slug': slug,
                        'id': id,
                    },
                    type: "POST",
                    url: @json(route('js.slug')),
                    success: function(result) {
                        if (result.is_slug === true){
                            $(slug_error).removeClass('d-none');
                            // $(slug_error).innerHTML = '123455666';
                            document.getElementById("slug_error").textContent="\"" + result.slug + "\" is already in the system";
                        } else {
                            $(slug_error).addClass('d-none');
                        }
                    },
                    error:function(result) {
                        // console.log('Error');
                        // console.log(data);
                    },
                });
            }
        });
    </script>
@endpush
