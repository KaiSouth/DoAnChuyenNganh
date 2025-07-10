<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Quản lý nhân viên</title>
 <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}" />

<!-- Fonts and icons -->
<script src="{{ asset('admin/assets/js/plugin/webfont/webfont.min.js') }}"></script>
<script>
    WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
            families: [
                "Font Awesome 5 Solid",
                "Font Awesome 5 Regular",
                "Font Awesome 5 Brands",
                "simple-line-icons",
            ],
            urls: ["{{ asset('admin/assets/css/fonts.min.css') }}"],
        },
        active: function () {
            sessionStorage.fonts = true;
        },
    });
</script>

<style>
    /* Sidebar Styling */
    .sidebar .nav-item {
        margin-bottom: 15px;
    }

    .sidebar .nav-link {
        font-size: 16px;
        color: #333;
    }

    .sidebar .nav-link:hover {
        color: #007bff;
    }

    /* Content Styling */
    .content {
        margin-left: 270px;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .form-group input {
        width: 100%;
        border-radius: 5px;
        border: 1px solid #ced4da;
        padding: 10px;
    }

    .form-group input:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .alert {
        border-radius: 5px;
        margin-bottom: 20px;
    }
</style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar">
        @include('partials.sidebar')
    </div>

    <!-- Content -->
    <div class="content">
        <h2 class="my-4 text-center">Thêm Nhân Viên Mới</h2>

        <!-- Thông báo lỗi -->
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.nhanvien.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="TenNhanVien">Tên Nhân Viên</label>
                        <input type="text" id="TenNhanVien" name="TenNhanVien"
                               class="form-control" placeholder="Nhập tên nhân viên" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ChucVu">Chức Vụ</label>
                        <input type="text" id="ChucVu" name="ChucVu"
                               class="form-control" placeholder="Nhập chức vụ" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="SDT">Số Điện Thoại</label>
                        <input type="text" id="SDT" name="SDT"
                               class="form-control" placeholder="Nhập số điện thoại" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input type="email" id="Email" name="Email"
                               class="form-control" placeholder="Nhập email" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="LuongTheoGio">Lương Theo Giờ</label>
                        <input type="number" id="LuongTheoGio" name="LuongTheoGio"
                               class="form-control" placeholder="Nhập lương" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="TaiKhoan">Tài Khoản</label>
                        <input type="text" id="TaiKhoan" name="TaiKhoan"
                               class="form-control" placeholder="Tạo tài khoản" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="MatKhau">Mật Khẩu</label>
                        <input type="password" id="MatKhau" name="MatKhau"
                               class="form-control" placeholder="Nhập mật khẩu" required>
                    </div>
                </div>
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-success mr-2">
                    <i class="fas fa-save mr-1"></i>Lưu Nhân Viên
                </button>
                <a href="{{ route('admin.nhanvien.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i>Quay Lại
                </a>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('admin/assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/core/bootstrap.min.js') }}"></script>

<!-- Các script plugin khác -->
<script src="{{ asset('admin/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/plugin/chart.js/chart.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/plugin/chart-circle/circles.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/plugin/jsvectormap/world.js') }}"></script>
<script src="{{ asset('admin/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
</body>
</html>
