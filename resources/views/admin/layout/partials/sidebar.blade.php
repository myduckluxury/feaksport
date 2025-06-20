<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="{{ route('dashboard.index') }}" class="navbar-brand mx-4 mb-3">
            <img src="{{ asset('client/img/logo1.webp') }}" width="170" alt="">
        </a>
        <div class="navbar-nav w-100">
            <a href="{{ route('dashboard.index') }}"
                class="nav-item nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}"><i
                    class="fas fa-chart-bar"></i> Dashboard</a>

            <div class="nav-item dropdown">
                <a href="#"
                    class="nav-link dropdown-toggle {{ request()->routeIs('admin-order.index') || request()->routeIs('admin-order.return-request') ? 'active' : '' }}"  data-bs-toggle="dropdown"><i
                        class="fas fa-receipt"></i> Đơn hàng</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('admin-order.index') }}"
                        class="dropdown-item {{ request()->routeIs('admin-order.index') ? 'active' : '' }}">Danh
                        sách</a>
                    <a href="{{ route('admin-order.return-request') }}"
                        class="dropdown-item {{ request()->routeIs('admin-order.return-request') ? 'active' : '' }}">Yêu cầu hoàn trả</a>
                </div>
            </div>

            @if (Auth::user()->role == 'manager')
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('admin.user') || request()->routeIs('admin-staff.index') ? 'active' : '' }}"
                        data-bs-toggle="dropdown"><i class="fas fa-user-cog"></i> Người dùng</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="{{ route('admin.user') }}"
                            class="dropdown-item {{ request()->routeIs('admin.user') ? 'active' : '' }}">Khách hàng</a>
                        <a href="{{ route('admin-staff.index') }}" class="dropdown-item {{ request()->routeIs('admin-staff.index') ? 'active' : '' }}">Nhân viên</a>
                    </div>
                </div>
            @else
                <a href="{{ route('admin.user') }}"
                    class="nav-item nav-link {{ request()->routeIs('admin.user') ? 'active' : '' }}"><i
                        class="fas fa-user-cog"></i> Người dùng</a>
            @endif

            <div class="nav-item dropdown">
                <a href="#"
                    class="nav-link dropdown-toggle {{ request()->routeIs('admin-category.index') || request()->routeIs('admin-category.create') ? 'active' : '' }}"
                    data-bs-toggle="dropdown"><i class="fas fa-list-ul"></i> Danh mục</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('admin-category.index') }}"
                        class="dropdown-item {{ request()->routeIs('admin-category.index') ? 'active' : '' }}">Danh
                        sách</a>
                    <a href="{{ route('admin-category.create') }}"
                        class="dropdown-item {{ request()->routeIs('admin-category.create') ? 'active' : '' }}">Thêm
                        mới</a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#"
                    class="nav-link dropdown-toggle {{ request()->routeIs('admin-brand.index') || request()->routeIs('admin-brand.create') ? 'active' : '' }}"
                    data-bs-toggle="dropdown"><i class="fas fa-tag"></i> Thương
                    hiệu</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('admin-brand.index') }}"
                        class="dropdown-item {{ request()->routeIs('admin-brand.index') ? 'active' : '' }}">Danh
                        sách</a>
                    <a href="{{ route('admin-brand.create') }}"
                        class="dropdown-item {{ request()->routeIs('admin-brand.create') ? 'active' : '' }}">Thêm
                        mới</a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#"
                    class="nav-link dropdown-toggle {{ request()->routeIs('admin-product.index') || request()->routeIs('admin-product.create') ? 'active' : '' }}"
                    data-bs-toggle="dropdown"><i class="fas fa-box"></i></i> Sản
                    phẩm</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('admin-product.index') }}"
                        class="dropdown-item {{ request()->routeIs('admin-product.index') ? 'active' : '' }}">Danh
                        sách</a>
                    <a href="{{ route('admin-product.create') }}"
                        class="dropdown-item {{ request()->routeIs('admin-product.create') ? 'active' : '' }}">Thêm
                        mới</a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#"
                    class="nav-link dropdown-toggle {{ request()->routeIs('admin-voucher.index') || request()->routeIs('admin-voucher.create') ? 'active' : '' }}"
                    data-bs-toggle="dropdown"><i class="fas fa-gift"></i> Khuyến
                    mại</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('admin-voucher.index') }}"
                        class="dropdown-item {{ request()->routeIs('admin-voucher.index') ? 'active' : '' }}">Danh
                        sách</a>
                    <a href="{{ route('admin-voucher.create') }}"
                        class="dropdown-item {{ request()->routeIs('admin-voucher.create') ? 'active' : '' }}">Thêm
                        mới</a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#"
                    class="nav-link dropdown-toggle {{ request()->routeIs('admin-blog.index') || request()->routeIs('admin-blog.create') ? 'active' : '' }}"
                    data-bs-toggle="dropdown"><i class="fas fa-newspaper"></i> Tin
                    tức</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('admin-blog.index') }}"
                        class="dropdown-item {{ request()->routeIs('admin-blog.index') ? 'active' : '' }}">Danh
                        sách</a>
                    <a href="{{ route('admin-blog.create') }}"
                        class="dropdown-item {{ request()->routeIs('admin-blog.create') ? 'active' : '' }}">Thêm
                        mới</a>
                </div>
            </div>

            <a href="{{ route('admin-review.index') }}"
                class="nav-item nav-link {{ request()->routeIs('admin-review.index') ? 'active' : '' }}"><i
                    class="fas fa-comments "></i> Đánh giá</a>
        </div>
    </nav>
</div>