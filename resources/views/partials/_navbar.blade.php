<style>
    /* Hover effect for dropdown */
    .nav-item.dropdown:hover .dropdown-menu {
        display: block;
    }

    /* Optional: Add transition effect for smoother appearance */
    .nav-item.dropdown .dropdown-menu {
        display: none;
        transition: opacity 0.3s ease;
    }


</style>
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm py-3 py-lg-0 px-3 px-lg-0">
    <a href="{{route('index')}}" class="navbar-brand ms-lg-5">
        <h1 class="m-0 text-uppercase text-dark"><i class="bi bi-shop fs-1 text-primary me-3"></i>Pet Shop</h1>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0">
            <a href="{{ route('index') }}" class="nav-item nav-link">TRANG CHỦ</a>
            <a href="{{ route('about') }}" class="nav-item nav-link">VỀ CHÚNG TÔI</a>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle text-uppercase" data-bs-toggle="dropdown">DỊCH VỤ</a>
                <div class="dropdown-menu">
                    <a href="{{ route('bookingService.create') }}" class="dropdown-item text-uppercase">ĐẶT DỊCH VỤ</a>
                    <a href="{{ route('appointment.form') }}" class="dropdown-item text-uppercase">ĐẶT LỊCH KHÁM</a>

                </div>
             
            </div>
            <a href="{{ route('product') }}" class="nav-item nav-link">SẢN PHẨM</a>
            <!-- Giỏ Hàng: chỉ còn icon giỏ hàng -->
            <a href="{{ route('cart') }}" class="nav-item nav-link">
                <i class="fas fa-shopping-cart"></i> Giỏ Hàng
            </a>
            <!-- Hồ Sơ: Dropdown mở khi hover, align left -->
            <div class="nav-item dropdown" style="margin-right: 0;">
                <a href="#" class="nav-link dropdown-toggle text-uppercase" data-bs-toggle="dropdown" aria-expanded="false" style="margin-right: 30px;">HỒ SƠ</a>
                <div class="dropdown-menu dropdown-menu-end" style="right: 0; left: auto;"> <!-- This makes the dropdown align left -->
                    <a href="{{ route('userdashboard') }}" class="dropdown-item text-uppercase">Thông tin tài khoản</a>
                    @if(session()->has('user_id'))
                    <a href="{{ route('logoutUser') }}" class="dropdown-item text-uppercase">ĐĂNG XUẤT</a>
                    @else
                    <a href="{{ route('login.form') }}" class="dropdown-item text-uppercase">ĐĂNG NHẬP</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</nav>
