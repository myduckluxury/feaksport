<!--== Start Aside Search Menu ==-->
<aside class="aside-search-box-wrapper offcanvas offcanvas-top" tabindex="-1" id="AsideOffcanvasSearch"
    aria-labelledby="offcanvasTopLabel">
    <div class="offcanvas-header">
        <h5 class="d-none" id="offcanvasTopLabel">Aside Search</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i
                class="pe-7s-close"></i></button>
    </div>
    <div class="offcanvas-body">
        <div class="container pt--0 pb--0">
            <div class="search-box-form-wrap">
                <form action="#" method="post">
                    <div class="search-form position-relative">
                        <label for="search-input" class="visually-hidden">Search</label>
                        <input id="search-input" type="search" class="form-control" placeholder="Tìm kiếm sản phẩm">
                        <button class="search-button"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</aside>
<!--== End Aside Search Menu ==-->

<!--== Start Side Menu ==-->
<div class="off-canvas-wrapper offcanvas offcanvas-start" tabindex="-1" id="AsideOffcanvasMenu"
    aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h1 id="offcanvasExampleLabel"></h1>
        <button class="btn-menu-close" data-bs-dismiss="offcanvas" aria-label="Close">menu <i
                class="fa fa-chevron-left"></i></button>
    </div>
    <div class="offcanvas-body">
        <div class="info-items">
            <ul>
                <li class="number"><a href="tel://0123456789"><i class="fa fa-phone"></i>0986.927.182</a></li>
                <li class="email"><a href="mailto://demo@example.com"><i
                            class="fa fa-envelope"></i>cuongmanh1024@gmail.com</a>
                </li>
                <li class="account"><a href="#" class="btn btn-link dropdown-toggle text-decoration-none"
                        data-bs-toggle="dropdown"><i class="fa fa-user dropdown"></i>Tài khoản</a>
                    <ul class="dropdown-menu">
                        @if (Auth::check())
                            @if (Auth::user()->role == 'manager' || Auth::user()->role == 'staff')
                                <li>
                                    <a href="{{route('dashboard.index')}}" class="dropdown-item fas fa-user-shield">Trang quản
                                        trị</a>
                                </li>
                            @endif
                            <li><a href="{{ route('profile') }}" class="dropdown-item">Hồ sơ</a></li>
                            <li><a href="{{route('change-password')}}" class="dropdown-item">Đổi mật khẩu</a></li>
                            <li><a href="{{ route('logout') }}" class="dropdown-item">Đăng xuất</a></li>
                        @else
                            <li><a href="{{ route('signin') }}" class="dropdown-item">Đăng nhập</a></li>
                       @endif
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Mobile Menu Start -->
        <div class="mobile-menu-items">
            <ul class="nav-menu">
                <li><a href="{{ route('home') }}">Trang chủ</a></li>
                <li><a href="{{ route('product.index') }}">Sản phẩm</a></li>
                <li><a href="#">Về chúng tôi</a></li>
                <li><a href="{{ route('blog.index') }}">Tin tức</a></li>
                <li><a href="#">Liên hệ</a></li>
            </ul>
        </div>
        <!-- Mobile Menu End -->
    </div>
</div>
<!--== End Side Menu ==-->