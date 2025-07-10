<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Khách Hàng</title>

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
        :root {
            --sidebar-width: 250px;
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --hover-color: #3498db;
        }





        /* Content styling */
        .content {
            margin-left: var(--sidebar-width);
            padding: 30px;
            min-height: 100vh;
            background: #f4f6f9;
            transition: all 0.3s ease;
        }

        .content-header {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }

        .form-group label {
            font-weight: 500;
            color: #2c3e50;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 8px 15px;
        }

        .form-control:focus {
            border-color: var(--hover-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .password-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .btn {
            padding: 8px 20px;
            border-radius: 5px;
            font-weight: 500;
        }

        .btn-primary {
            background-color: var(--hover-color);
            border: none;
        }

        .btn-primary:hover {
            background-color: #2980b9;
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


        <!-- Content -->
            <div class="sidebar">
                @include('partials.sidebar')
            </div>
        <div class="content">
            <div class="content-header">
                <h1 class="mb-0"><i class="fas fa-user-edit"></i> Chi Tiết Khách Hàng</h1>
            </div>

            <!-- Alerts -->
            <div class="alert alert-danger" role="alert" id="errorMessages" style="display: none;">
                <i class="fas fa-exclamation-circle"></i>
                <ul class="mb-0"></ul>
            </div>

            <div class="alert alert-success" role="alert" id="successMessage" style="display: none;">
                <i class="fas fa-check-circle"></i> Thông tin khách hàng đã được cập nhật thành công.
            </div>

            <div class="alert alert-info" role="alert" id="infoMessage" style="display: none;">
                <i class="fas fa-info-circle"></i> Không có thay đổi nào được lưu.
            </div>

<!-- Thay thế phần content trong form-container bằng code sau -->
<div class="form-container">
    <div class="row">
        <!-- Form Chi tiết khách hàng -->
        <div class="col-md-6">
            <h4 class="mb-4"><i class="fas fa-user-edit"></i> Thông Tin Cá Nhân</h4>
            <form action="{{ route('customers.update', ['id' => $customer->MaKhachHang]) }}" method="POST" id="customerForm">
            @csrf
                <div class="form-group">
                    <label for="HoTen"><i class="fas fa-user"></i> Họ Tên:</label>
                    <input type="text" id="HoTen" name="HoTen" class="form-control" value="{{$customer->HoTen}}" required>
                </div>

                <div class="form-group">
                    <label for="SDT"><i class="fas fa-phone"></i> Số Điện Thoại:</label>
                    <input type="text" id="SDT" name="SDT" class="form-control" value="{{$customer->SDT}}" required>
                </div>

                <div class="form-group">
                    <label for="Email"><i class="fas fa-envelope"></i> Email:</label>
                    <input type="email" id="Email" name="Email" class="form-control" value="{{$customer->Email }}" required>
                </div>

                <div class="form-group">
                    <label for="TaiKhoan"><i class="fas fa-user-circle"></i> Tài Khoản:</label>
                    <input type="text" id="TaiKhoan" name="TaiKhoan" class="form-control" value="{{$customer->TaiKhoan  }}" required>
                </div>

                <div class="form-group">
                    <label for="DiaChi"><i class="fas fa-map-marker-alt"></i> Địa Chỉ:</label>
                    <textarea id="DiaChi" name="DiaChi" class="form-control" required>{{$customer->DiaChi  }} </textarea>
                </div>

        </div>

        <!-- Form Cập nhật mật khẩu -->
        <div class="col-md-6">
            <h4 class="mb-4"><i class="fas fa-key"></i> Cập Nhật Mật Khẩu</h4>
            <div class="password-form">
                <div class="form-group">
                    <label for="MatKhau">
                        <i class="fas fa-key"></i> Mật Khẩu Mới:
                    </label>
                    <div class="input-group">
                        <input type="password" id="MatKhau" name="MatKhau" class="form-control">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <small class="form-text text-muted">
                        Mật khẩu phải có ít nhất 6 ký tự
                    </small>
                </div>

                <div class="password-strength mt-3">
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                    </div>
                    <small class="form-text text-muted">Độ mạnh mật khẩu</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Buttons -->
    <div class="row mt-4">
        <div class="col-12">
            <hr>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Lưu Thay Đổi
            </button>
            <a href="/" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay Lại
            </a>
        </div>
    </div>
    </form>
</div>

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
