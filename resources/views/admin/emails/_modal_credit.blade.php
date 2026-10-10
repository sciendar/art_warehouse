<div class="modal fade" id="modal_{{ $item->id ?? '' }}_credit" tabindex="-1" aria-labelledby="modal_{{ $item->id ?? '' }}_credit_label" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ isset($item) ? route('admin.emails.update',$item) : route('admin.emails.store') }}" class="was-validated" method="POST" enctype="multipart/form-data">
                @isset($item) @method('PATCH') @endisset
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="modal_{{ $item->id ?? '' }}_credit_label">{!! isset($item) ? 'Добавить' : 'Изменить' !!}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body text-start">
                    @foreach(config('app.locales') as $locale => $locale_title)
                        @php
                            $LANG = 'text_' . $locale;
                        @endphp
                        <label for="{{ $LANG }}" class="mb-1">
                            <img src="{{ asset('admin/assets/images/flag_' . $locale . '.png') }}" width="18px" alt=""> Название {{ $locale }}
                        </label>
                        <textarea class="form-control mb-3" type="text" name="{{ $LANG }}" id="{{ $LANG }}" placeholder="Введите данные" aria-label="default input example" maxlength="175" required>{{ $item->$LANG ?? old($LANG) }}</textarea>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
