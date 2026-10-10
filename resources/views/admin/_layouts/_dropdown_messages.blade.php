<li class="nav-item dropdown dropdown-large">
    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
        <div class="messages">
            <span class="notify-badge">5</span>
            <i class="bi bi-messenger"></i>
        </div>
    </a>
    <div class="dropdown-menu dropdown-menu-end p-0">
        <div class="p-2 border-bottom m-2">
            <h5 class="h5 mb-0">Messages</h5>
        </div>
        <div class="header-message-list p-2">
            <div class="dropdown-item bg-light radius-10 mb-1">
                <form class="dropdown-searchbar position-relative">
                    <div class="position-absolute top-50 start-0 translate-middle-y px-3 search-icon"><i class="bi bi-search"></i></div>
                    <input class="form-control" type="search" placeholder="Search Messages">
                </form>
            </div>
            <a class="dropdown-item" href="#">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('admin/assets/images/avatars/avatar-1.png') }}" alt="" class="rounded-circle" width="52" height="52">
                    <div class="ms-3 flex-grow-1">
                        <h6 class="mb-0 dropdown-msg-user">Amelio Joly <span class="msg-time float-end text-secondary">1 m</span></h6>
                        <small class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">The standard chunk of lorem...</small>
                    </div>
                </div>
            </a>
            <a class="dropdown-item" href="#">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('admin/assets/images/avatars/avatar-2.png') }}" alt="" class="rounded-circle" width="52" height="52">
                    <div class="ms-3 flex-grow-1">
                        <h6 class="mb-0 dropdown-msg-user">Althea Cabardo <span class="msg-time float-end text-secondary">7 m</span></h6>
                        <small class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">Many desktop publishing</small>
                    </div>
                </div>
            </a>
            <a class="dropdown-item" href="#">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('admin/assets/images/avatars/avatar-3.png') }}" alt="" class="rounded-circle" width="52" height="52">
                    <div class="ms-3 flex-grow-1">
                        <h6 class="mb-0 dropdown-msg-user">Katherine Pechon <span class="msg-time float-end text-secondary">2 h</span></h6>
                        <small class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">Making this the first true</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="p-2">
            <div><hr class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
                <div class="text-center">View All Messages</div>
            </a>
        </div>
    </div>
</li>
