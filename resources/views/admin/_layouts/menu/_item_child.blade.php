<li @if(Route::is($route . '.*')) class="mm-active" @endif>
    <a href="{{ route($route . '.index') }}">
        {!! $icon !!}{{ $title }}
        @isset($count)
            <span class="badge bg-primary rounded-pill">{{ $count }}</span>
        @endisset
    </a>
</li>
