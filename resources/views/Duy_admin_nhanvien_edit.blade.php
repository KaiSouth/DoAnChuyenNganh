<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Nhân Viên</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}" />
    <link rel="icon" href="{{ asset('admin/assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

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
</head>
<body>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar" style="width: 250px; background-color: #f8f9fa;">
            @include('partials.sidebar') <!-- Sidebar content will be included here -->
        </div>

        <!-- Content -->
        <div class="content" style="margin-left: 270px; padding: 20px;">
            <h1 class="my-4"><i class="fas fa-user-edit"></i> Chỉnh Sửa Nhân Viên</h1>

            <!-- Display validation errors -->
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Form to update employee details -->
            <form action="{{ route('admin.nhanvien.update', $nhanVien->MaNhanVien) }}" method="POST">
                @csrf
                @method('POST')

                <div class="row">
                    <!-- Employee Name -->
                    <div class="col-md-6 form-group">
                        <label for="TenNhanVien">Tên Nhân Viên</label>
                        <input type="text" name="TenNhanVien" id="TenNhanVien" class="form-control" value="{{ $nhanVien->TenNhanVien }}" required>
                    </div>

                    <!-- Position -->
                    <div class="col-md-6 form-group">
                        <label for="ChucVu">Chức Vụ</label>
                        <input type="text" name="ChucVu" id="ChucVu" class="form-control" value="{{ $nhanVien->ChucVu }}" required>
                    </div>
                </div>

                <div class="row">
                    <!-- Phone -->
                    <div class="col-md-6 form-group">
                        <label for="SDT">Số Điện Thoại</label>
                        <input type="text" name="SDT" id="SDT" class="form-control" value="{{ $nhanVien->SDT }}" required>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6 form-group">
                        <label for="Email">Email</label>
                        <input type="email" name="Email" id="Email" class="form-control" value="{{ $nhanVien->Email }}" required>
                    </div>
                </div>

                <div class="row">
                    <!-- Hourly Salary -->
                    <div class="col-md-6 form-group">
                        <label for="LuongTheoGio">Lương Theo Giờ</label>
                        <input type="number" name="LuongTheoGio" id="LuongTheoGio" class="form-control" value="{{ $nhanVien->LuongTheoGio }}" required>
                    </div>

                    <!-- Account -->
                    <div class="col-md-6 form-group">
                        <label for="TaiKhoan">Tài Khoản</label>
                        <input type="text" name="TaiKhoan" id="TaiKhoan" class="form-control" value="{{ $nhanVien->TaiKhoan }}" required>
                    </div>
                </div>

                <div class="row">
                    <!-- Password -->
                    <div class="col-md-6 form-group">
                        <label for="MatKhau">Mật Khẩu</label>
                        <input type="password" name="MatKhau" id="MatKhau" class="form-control">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cập Nhật</button>
                <a href="{{ route('admin.nhanvien.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay Lại</a>
            </form>
        </div>
    </div>

    <!-- JS Files -->
    <script src="{{asset('admin/assets/js/core/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/core/bootstrap.min.js')}}"></script>

    <!-- Additional JS Plugins -->
    <script src="{{asset('admin/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/plugin/chart.js/chart.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/plugin/chart-circle/circles.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/plugin/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/plugin/jsvectormap/jsvectormap.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/plugin/jsvectormap/world.js')}}"></script>
    <script src="{{asset('admin/assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

</body>
</html>
