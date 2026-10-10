<!doctype html>
<html lang="{{ app()->getLocale() }}" class="light-theme sf-js-enabled">
    <head>
        @include('admin._layouts.metas')
        @include('admin._layouts.styles')
        <title>
            @yield('title', 'Avenor')
        </title>
    </head>

    <body class="pace-done">
        <div class="wrapper">
            @php($is_auth = auth()->check() && auth()->user()->auth_at >= now())
            @if($is_auth)
                @include('admin._layouts.header')
                @include('admin._layouts.sidebar')
            @endif

            <main class="{{ $is_auth ? 'page-content' : 'authentication-content' }}">
                @include('admin._layouts._messages')
                @yield('content')
            </main>

            <div class="overlay nav-toggle-icon"></div>

            <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        </div>

        @stack('modals')
        @include('admin._layouts.scripts')
    </body>
</html>
