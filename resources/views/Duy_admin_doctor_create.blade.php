<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Bác Sĩ Mới</title>

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/kaiadmin.min.css')}}" />
     <!-- Fonts and icons -->
     <script src="{{asset('admin/assets/js/plugin/webfont/webfont.min.js')}}"></script>
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
                urls: ["{{asset('admin/assets/css/fonts.min.css')}}"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f4f6f9;
        }
        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 30px;
            margin: 20px;
        }
        .form-header {
            border-bottom: 2px solid #007bff;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .form-group label {
            font-weight: 600;
            color: #333;
        }
        .required-mark {
            color: red;
            margin-left: 4px;
        }
    </style>
</head>
<body>
     <!-- Sidebar -->
     <div class="sidebar">
            @include('partials.sidebar')
        </div>
    <div class="wrapper">


        <!-- Main Content -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="form-container">
                    <div class="form-header">
                        <h2 class="page-title">
                            <i class="fas fa-user-md"></i> Thêm Bác Sĩ Mới
                        </h2>
                    </div>

                    <!-- Thông báo -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach($errors->all() as $error)
                                <p class="mb-0"><i class="fas fa-exclamation-circle"></i> {{ $error }}</p>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                  <!-- Sửa các lỗi cú pháp trong form hiện tại và thêm các trường còn thiếu -->
<form action="{{ route('admin.doctors.store') }}" method="POST">
    @csrf
    <div class="row">
        <!-- Họ tên và Chuyên môn -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="HoTen">Họ và tên <span class="required-mark">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" name="HoTen" id="HoTen" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="ChuyenMon">Chuyên môn <span class="required-mark">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-stethoscope"></i></span>
                    </div>
                    <input type="text" name="ChuyenMon" id="ChuyenMon" class="form-control" required>
                </div>
            </div>
        </div>
    </div>

    <!-- Ngày sinh và Giới tính -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="NgaySinh">Ngày sinh <span class="required-mark">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                    <input type="date" name="NgaySinh" id="NgaySinh" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="GioiTinh">Giới tính <span class="required-mark">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                    </div>
                    <select name="GioiTinh" id="GioiTinh" class="form-control" required>
                        <option value="">Chọn giới tính</option>
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                        <option value="Khác">Khác</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Thêm các trường còn thiếu -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="SDT">Số điện thoại <span class="required-mark">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="tel" name="SDT" id="SDT" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="Email">Email <span class="required-mark">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" name="Email" id="Email" class="form-control" required>
                </div>
            </div>
        </div>
    </div>

    <!-- Tài khoản và Mật khẩu -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="TaiKhoan">Tài khoản <span class="required-mark">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                    </div>
                    <input type="text" name="TaiKhoan" id="TaiKhoan" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="MatKhau">Mật khẩu <span class="required-mark">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" name="MatKhau" id="MatKhau" class="form-control" required>
                </div>
            </div>
        </div>
    </div>

    <!-- Lương theo giờ -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="LuongTheoGio">Lương theo giờ (VNĐ) <span class="required-mark">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-money-bill"></i></span>
                    </div>
                    <input type="number" name="LuongTheoGio" id="LuongTheoGio" class="form-control" required>
                </div>
            </div>
        </div>
    </div>

    <!-- Nút submit và quay lại -->

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Lưu Thông Tin
                            </button>
                            <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary btn-lg ml-2">
                                <i class="fas fa-arrow-left"></i> Quay Lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Libraries -->
    <script src="{{asset('admin/assets/js/core/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/core/bootstrap.min.js')}}"></script>

    <!-- Validation Script -->
    <script>
        $(document).ready(function() {
            $('form').on('submit', function(e) {
                // Validation ở client-side
                let isValid = true;

                // Kiểm tra các trường bắt buộc
                $(this).find('[required]').each(function() {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                // Ngăn submit nếu chưa hợp lệ
                if (!isValid) {
                    e.preventDefault();
                    alert('Vui lòng điền đầy đủ thông tin');
                }
            });
        });
    </script>
</body>
</html>
