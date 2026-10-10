<li @if(Route::is($route . '.*')) class="mm-active" @endif>
    <a href="{{ route($route . '.index') }}" class="d-flex justify-content-between align-items-center">
        <div class="d-flex">
            <div class="parent-icon">
                {!! $icon !!}
            </div>
            <div class="menu-title">
                {{ $title }}
            </div>
        </div>
        @isset($count)
            <span class="badge bg-primary rounded-pill">{{ $count }}</span>
        @endisset
    </a>
</li>
