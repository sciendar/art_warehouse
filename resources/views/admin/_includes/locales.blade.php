@php
    $translations = ($item ?? null)?->translations;
@endphp

<div class="card mb-3">
    <div class="card-body">
        <div class="row justify-content-center">
            @foreach($LOCALES as $locale => $title)
                @if(Route::is('*.index'))
                    @php
                        $color = 'primary';
                        $outline = $LANG != $locale ? '-outline' : '';
                        $disabled = $locale == $LANG ? 'disabled' : '';
                    @endphp
                @else
                    @php
                        $trans = $translations?->where('locale', $locale)->first();
                        $disabled = !isset($item) && $locale != $MAIN_LANG ? 'disabled' : '';
                        $outline = $LANG != $locale ? '-outline' : '';
                        $true_count = 0;
                        foreach ($required as $param) {
                            $true_count += (isset($item) && $trans?->$param != null);
                        }
                        if ($true_count == count($required)) {
                            $color = 'primary';
                        } elseif ($true_count > 0) {
                            $color = 'warning';
                        } else {
                            $color = 'danger';
                        }
                    @endphp
                @endif
                    <div class="col-auto">
                        <a href="{{ request()->fullUrlWithQuery(['lang' => $locale]) }}" class="btn btn{{ $outline }}-{{ $color }} {{ $disabled }}">
                            <i class="flag-icon flag-icon-{{ $locale }}"></i>
                            <span class="mx-1">
                            {{ Str::upper($title) }}
                        </span>
                        </a>
                    </div>
            @endforeach
        </div>
    </div>
</div>
