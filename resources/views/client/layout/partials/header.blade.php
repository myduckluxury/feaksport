<header class="main-header-wrapper position-relative">
    <div class="header-top">
        <div class="pt--3 pb--0 ps-3 pe-3">
            <div class="row">
                <div class="col-12">
                    <div class="header-top-align">
                        <div class="header-top-align-start">
                            <div class="desc">
                                <p>Vận chuyển trên toàn quốc nhanh chóng</p>
                            </div>
                        </div>
                        <div class="header-top-align-end">
                            <div class="header-info-items">
                                <div class="info-items">
                                    <ul>
                                        <li class="number"><i class="fa fa-phone"></i><a href="tel://0123456789">0988.002.157</a>
                                        </li>
                                        <li class="email"><i class="fa fa-envelope"></i><a href="mailto://demo@example.com">freaksport@gmail.com</a></li>
                                        <li class="account" style="display: flex"><i class="fa fa-user"></i>
                                            {{-- @dd(Auth::user()) --}}
                                            @if (Auth::check())
                                            <a href="#" class="nav-link dropdown-toggle mt-1" data-bs-toggle="dropdown">
                                                <span class="d-none d-lg-inline-flex">Tài khoản</span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                                                @if (Auth::user()->role == 'staff' || Auth::user()->role == 'manager')
                                                <a href="{{route('dashboard.index')}}" class="dropdown-item fas fa-user-shield">Trang quản trị</a>
                                                @endif
                                                <a href="{{ route('order.list') }}" class="dropdown-item">Đơn hàng</a>
                                                <a href="{{  route('profile')}}" class="dropdown-item">Hồ sơ</a>
                                                <a href="{{  route('change-password')}}" class="dropdown-item">Đổi mật
                                                    khẩu</a>
                                                <a href="{{  route('logout')}}" class="dropdown-item">Đăng xuất</a>
                                            </div>
                                            @else
                                            <a href="{{ route('signin.signin') }}" class="nav-link mt-1">
                                                <span class="d-none d-lg-inline-flex">Đăng nhập</span>
                                            </a>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-middle">
        <div class="container pt--0 pb--0">
            <div class="align-items-center">
                <div class="header-middle-align">
                    <div class="header-middle-align-start">
                        <div class="header-logo-area">
                            <a href="{{ route('home') }}">
                                <img class="logo-main" src="{{ asset('client/img/logo1.webp')}}" width="170" height="34" alt="Logo" />
                                <img class="logo-light" src="{{ asset('client/img/logo-light.webp')}}" width="131" height="34" alt="Logo" />
                            </a>
                        </div>
                    </div>
                    <div class="header-middle-align-center">
                        <div class="header-search-area">
                            <form action="{{ route('search') }}" class="header-searchbox">
                                <input type="search" name="keyword" class="form-control" placeholder="Search" required value="{{ request('keyword') }}">
                                <button class="btn-submit" type="submit"><i class="pe-7s-search"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="header-middle-align-end">
                        <div class="header-action-area">
                            <div class="shopping-search">
                                <button class="shopping-search-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#AsideOffcanvasSearch" aria-controls="AsideOffcanvasSearch"><i class="pe-7s-search icon"></i></button>
                            </div>
                            <div class="shopping-wishlist">
                                <a class="shopping-wishlist-btn" href="{{ route('wishlist.index') }}">
                                    <i class="pe-7s-like icon"></i>
                                </a>
                            </div>
                            <div class="shopping-cart ms-3">
                                <button class="shopping-cart-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#AsideOffcanvasCart" aria-controls="offcanvasRightLabel">
                                    <i class="pe-7s-shopbag icon"></i>
                                    @if (session('cart'))
                                    <sup class="shop-count">{{ count(session('cart', [])) }}</sup>
                                    @endif
                                </button>
                            </div>
                            <button class="btn-menu" type="button" data-bs-toggle="offcanvas" data-bs-target="#AsideOffcanvasMenu" aria-controls="AsideOffcanvasMenu">
                                <i class="pe-7s-menu"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-area header-default">
        <div class="no-gutter align-items-center position-relative w-100 header-align">
            <div class="header-navigation-area container">
                <ul class="main-menu nav justify-content-between">
                    <li class=""><a class="fs-6 fw-bold" href="{{ route('home') }}"><span>Trang
                                chủ</span></a>
                    </li>
                    <li><a class="fs-6 fw-bold" href="{{ route('product.index') }}"><span>Sản
                                phẩm</span></a></li>
                    <li class=""><a class="fs-6 fw-bold" href="{{ route('about.index') }}"><span>Về chúng
                                tôi</span></a>
                    </li>
                    <li><a class="fs-6 fw-bold" href="{{ route('blog.index') }}"><span>Tin tức</span></a>
                    </li>
                    <li><a class="fs-6 fw-bold" href="{{ route('contact.form') }}"><span>Liên hệ</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>



    <!-- Màn hình loading -->
<div id="loading-screen">
    <div class="loader-container">
        <div class="half-loader"></div> <!-- Hiệu ứng xoay -->
        <div class="logo-wrapper">
            <img src="{{ asset('client/img/logo1.webp') }}" alt="FreakSport" class="loading-logo">
        </div>
    </div>
</div>

    <style>
   /* Màn hình loading */
#loading-screen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f5f5f5, #e0e0e0); /* Gradient nhẹ */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    transition: opacity 0.5s ease-in-out;
}

/* Chứa logo và vòng xoay */
.loader-container {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Vòng quay nửa cung */
.half-loader {
    width: 90px;
    height: 90px;
    border: 5px solid transparent;
    border-top: 5px solid #f39c12; /* Màu cam */
    border-radius: 50%;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
    animation: spin 1.2s cubic-bezier(0.4, 0, 0.2, 1) infinite;
}

/* Vùng chứa logo với hình tròn */
.logo-wrapper {
    width: 80px;
    height: 80px;
    background: white;
    border-radius: 50%; /* Làm tròn */
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Bóng nhẹ */
    position: relative;
    z-index: 10;
}

/* Logo FreakSport */
.loading-logo {
    width: 60px; /* Chỉnh kích thước logo */
    height: auto;
    transition: opacity 0.5s ease-in-out;
}

/* Hiệu ứng xoay */
@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

/* Ẩn hiệu ứng loading */
.hide-loading {
    opacity: 0;
    visibility: hidden;
}



    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
         $(document).ready(function() {
        // Ẩn màn hình loading khi trang tải xong
        setTimeout(function() {
            $("#loading-screen").addClass("hide-loading");
        }, 500);

        // Hiển thị loading khi nhấn vào liên kết
        $("a").on("click", function(e) {
            var url = $(this).attr("href");

            if (!url || url === "#" || url.startsWith("javascript") || $(this).attr("target") === "_blank") {
                return;
            }

            $("#loading-screen").removeClass("hide-loading").fadeIn(300);
            e.preventDefault();

            setTimeout(function() {
                window.location.href = url;
            }, 1000);
        });
    });
    </script>

</header>
