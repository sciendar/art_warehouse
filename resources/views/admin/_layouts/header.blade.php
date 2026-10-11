<header class="top-header">
    <nav class="navbar navbar-expand justify-content-between">
        <div class="mobile-toggle-icon d-xl-none">
            <i class="bi bi-list"></i>
        </div>
        <div class="top-navbar d-none d-xl-block">
{{--            <ul class="navbar-nav align-items-center">--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link" href="index.html">Dashboard</a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link" href="app-emailbox.html">Email</a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link" href="javascript:;">Projects</a>--}}
{{--                </li>--}}
{{--                <li class="nav-item d-none d-xxl-block">--}}
{{--                    <a class="nav-link" href="javascript:;">Events</a>--}}
{{--                </li>--}}
{{--                <li class="nav-item d-none d-xxl-block">--}}
{{--                    <a class="nav-link" href="app-to-do.html">Todo</a>--}}
{{--                </li>--}}
{{--            </ul>--}}
        </div>
{{--        <div class="search-toggle-icon d-xl-none ms-auto">--}}
{{--            <i class="bi bi-search"></i>--}}
{{--        </div>--}}
{{--        <form class="searchbar d-none d-xl-flex ms-auto">--}}
{{--            <div class="position-absolute top-50 translate-middle-y search-icon ms-3"><i class="bi bi-search"></i></div>--}}
{{--            <input class="form-control" type="text" placeholder="Type here to search">--}}
{{--            <div class="position-absolute top-50 translate-middle-y d-block d-xl-none search-close-icon"><i class="bi bi-x-lg"></i></div>--}}
{{--        </form>--}}
        <div class="top-navbar-right ms-3">
            <ul class="navbar-nav align-items-center">
                @if(Route::is('*.paintings.*') && !auth()->user()->is_admin())
                    <li class="nav-item dropdown dropdown-large">
                        <form action="{{ route('admin.change_warehouse') }}" method="POST">
                            @csrf
                            <select class="single-select" name="warehouse_id" id="my_warehouse_id" data-select2-id="my_warehouse_id" tabindex="-1" aria-hidden="true" onchange="this.form.submit()">
                                @foreach(\App\Helpers\CacheHelper::warehouses() as $warehouse)
                                    <option value="{{ $warehouse->id }}" @if(auth()->user()->warehouse_id == $warehouse->id) selected @endif>{{ $warehouse->title }} ({{ $warehouse->country_title }})</option>
                                @endforeach
                            </select>
                        </form>
                    </li>
                @endif
{{--                @include('admin._layouts._dropdown_messages')--}}
{{--                @include('admin._layouts._dropdown_notifications')--}}
{{--                @include('admin._layouts._dropdown_items')--}}
                @include('admin._layouts._dropdown_personal')
            </ul>
        </div>
    </nav>
</header>
