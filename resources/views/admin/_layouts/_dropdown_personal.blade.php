<li class="nav-item dropdown dropdown-large">
    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
        <div class="user-setting d-flex align-items-center gap-1">
            <img src="{{ asset('admin/assets/images/avatars/avatar-1.png') }}" class="user-img" alt="">
            <div class="user-name d-none d-sm-block">{!! auth()->user()->name !!}</div>
        </div>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
{{--        <li>--}}
{{--            <a class="dropdown-item" href="#">--}}
{{--                <div class="d-flex align-items-center">--}}
{{--                    <img src="{{ asset('admin/assets/images/avatars/avatar-1.png') }}" alt="" class="rounded-circle" width="60" height="60">--}}
{{--                    <div class="ms-3">--}}
{{--                        <h6 class="mb-0 dropdown-user-name">{!! auth()->user()->email !!}</h6>--}}
{{--                        <small class="mb-0 dropdown-user-designation text-secondary">{{ auth()->user()->getRoleNames()[0] }}</small>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li><hr class="dropdown-divider"></li>--}}
{{--        <li>--}}
{{--            <a class="dropdown-item" href="pages-user-profile.html">--}}
{{--                <div class="d-flex align-items-center">--}}
{{--                    <div class="setting-icon"><i class="bi bi-person-fill"></i></div>--}}
{{--                    <div class="setting-text ms-3"><span>Profile</span></div>--}}
{{--                </div>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li>--}}
{{--            <a class="dropdown-item" href="#">--}}
{{--                <div class="d-flex align-items-center">--}}
{{--                    <div class="setting-icon"><i class="bi bi-gear-fill"></i></div>--}}
{{--                    <div class="setting-text ms-3"><span>Setting</span></div>--}}
{{--                </div>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li>--}}
{{--            <a class="dropdown-item" href="index2.html">--}}
{{--                <div class="d-flex align-items-center">--}}
{{--                    <div class="setting-icon"><i class="bi bi-speedometer"></i></div>--}}
{{--                    <div class="setting-text ms-3"><span>Dashboard</span></div>--}}
{{--                </div>--}}
{{--            </a>--}}
{{--        </li>--}}

        <li><hr class="dropdown-divider"></li>
        <li>
            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <div class="d-flex align-items-center">
                    <div class="setting-icon"><i class="bi bi-lock-fill"></i></div>
                    <div class="setting-text ms-3"><span>Выход</span></div>
                </div>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</li>
