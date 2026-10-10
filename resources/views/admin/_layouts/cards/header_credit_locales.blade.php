<div class="row">
    <div class="col-12 text-center">
        <input type="hidden" name="lang" value="{{ app()->getLocale() }}">

        @if(isset($item))
            @foreach(config('app.locales') as $locale => $title)
                @php
                    $trans_item = $item?->translate(app()->getLocale());
                    $color = $trans_item
                        ? ($trans_item->is_active == true ? 'success' : 'danger')
                        : 'secondary';
                @endphp

                <a href="{{ Str::remove('/public', route('setlocale', ['lang' => $locale])) }}" class="btn btn-{{ $locale == app()->getLocale() ? 'primary' : ('outline-' . $color . ' bg-light-' . $color) }} btn-sm mb-3 mx-1">
                    <i class="flag-icon flag-icon-{{ config('app.country_codes')[$locale] }} flag-icon-squared rounded-circle"></i>
                    <span class="mx-1">
                        {{ Str::upper($locale) }}
                    </span>
                </a>
            @endforeach
        @endif
    </div>
</div>
