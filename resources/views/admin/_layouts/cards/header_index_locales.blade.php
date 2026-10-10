<div class="row mb-3">
    <div class="col-12 text-center">
        @foreach(config('app.locales') as $locale => $title)
            <a href="{{ Str::remove('/public', route('setlocale', ['lang' => $locale])) }}" class="btn btn-{{ $locale == app()->getLocale() ? 'primary' : 'outline-success bg-light-success' }} btn-sm mx-1">
                <i class="flag-icon flag-icon-{{ config('app.country_codes')[$locale] }} flag-icon-squared rounded-circle"></i>
                <span class="mx-1">
                    {{ Str::upper($locale) }}
                </span>
            </a>
        @endforeach
    </div>
</div>
