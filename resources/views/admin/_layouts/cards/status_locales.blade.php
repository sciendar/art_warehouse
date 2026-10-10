@foreach($LOCALES->where('lang', $LANG) as $locale)
    @include('admin._layouts.cards.status_locale')
    <br>
@endforeach

@foreach($LOCALES->where('lang', '!=', $LANG) as $locale)
    @include('admin._layouts.cards.status_locale')
    <br>
@endforeach
