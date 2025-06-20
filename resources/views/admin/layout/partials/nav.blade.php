<nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
    <a href="{{ route('dashboard.index') }}" class="navbar-brand d-flex d-lg-none me-4">
        <img src="{{ asset('client/img/logo1.webp') }}" width="80" alt="">
    </a>
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
    </a>
    <div class="navbar-nav align-items-center ms-auto">
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img class="rounded-circle me-lg-2" src="{{ !empty(Auth::user()->avatar) ? Storage::url(Auth::user()->avatar) : asset('administrator/img/user.jpg')}}" alt=""
                    style="width: 40px; height: 40px;">
                <span class="d-none d-lg-inline-flex">Xin chào: {{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                <a href="{{ route('admin-profile.index', Auth::user()->id) }}" class="dropdown-item">Hồ sơ của tôi</a>
                <a href="{{ route('admin-profile.change-password', Auth::user()->id) }}" class="dropdown-item">Đổi mật khẩu</a>
                <a href="{{ route('logout') }}" class="dropdown-item">Đăng xuất</a>
                <a href="{{route('home')}}" class="dropdown-item">Về trang chính</a>
            </div>
        </div>
    </div>
</nav>