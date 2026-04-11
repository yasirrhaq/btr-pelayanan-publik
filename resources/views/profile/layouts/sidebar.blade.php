<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('profile') ? 'active' : '' }}" aria-current="page" href="{{url('')}}/profile">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('profile/status-layanan*') ? 'active' : '' }}" href="{{url('')}}/profile/status-layanan">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Status Layanan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('profile/password*') ? 'active' : '' }}" href="{{url('')}}/profile/password">
                    <span data-feather="lock" class="align-text-bottom"></span>
                    Ganti Password
                </a>
            </li>
        </ul>
    </div>
</nav>
