<label class="form-label" for="password">
    Пароль (не трожь, если не меняешь)
</label>

<div class="input-group">
    <div class="input-group">
        <div class="input-group-text">
            <input class="form-check-input is_check_password" name="is_password" id="is_password" type="checkbox" @checked(!isset($item))>
        </div>
        @include('admin._layouts.forms.input',['data'=>'password','id'=>'password','other'=>(isset($item) ? 'disabled' : null),'required'=>(!isset($item))])
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

@if(isset($item))
    @push('scripts')
        <script>
            $('body').on('click', '#is_password', function () {
                const password = $('#password');

                if (this.checked) {
                    // Активируем поле и делаем обязательным
                    password.prop('disabled', false);
                    password.prop('required', true);

                    // Генерируем случайную строку длиной 16 символов через Laravel Str
                    const randomString = '{{ Str::random(16) }}';
                    password.val(randomString);
                } else {
                    // Деактивируем поле, убираем обязательность и очищаем значение
                    password.prop('disabled', true);
                    password.prop('required', false);
                    password.val('');
                }
            });
        </script>
    @endpush
@endif
