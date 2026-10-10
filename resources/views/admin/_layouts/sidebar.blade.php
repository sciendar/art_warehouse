<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <a href="{{ route('admin.home') }}">
                <img src="{{ asset('admin/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
            </a>
        </div>
        <div>
            <a href="{{ route('admin.home') }}">
                <h4 class="logo-text">{{ config('app.name') }}</h4>
            </a>
        </div>
{{--        <div class="toggle-icon ms-auto">--}}
{{--            <i class="bi bi-chevron-double-left"></i>--}}
{{--        </div>--}}
    </div>

    <ul class="metismenu" id="menu">
        @include('admin._layouts.menu._item', App\Models\Painting::menu())
        @if(auth()->user()->hasRole(['admin', 'super_admin']))
            @include('admin._layouts.menu._item', App\Models\User::menu())
            <hr>
            <li @if(Route::is('*.countries.*', '*.warehouses.*')) class="mm-active" @endif>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon">
                        <i class="bi bi-grid-1x2"></i>
                    </div>
                    <div class="menu-title">Сущности</div>
                </a>
                <ul @if(Route::is('*.countries.*', '*.warehouses.*')) class="mm-collapse mm-show" @endif>
                    @include('admin._layouts.menu._item_child', App\Models\Country::menu())
                    @include('admin._layouts.menu._item_child', App\Models\Warehouse::menu())
                </ul>
            </li>
        @endif
        @if(auth()->user()->hasRole('super_admin'))
            <hr>
            <li class="menu-label">Для админов</li>
            @include('admin._layouts.menu._item', App\Models\Visit::menu())
            @include('admin._layouts.menu._item', App\Models\Ip::menu())
        @endif
    </ul>
</aside>
