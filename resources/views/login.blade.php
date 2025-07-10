<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>PET SHOP - Đăng nhập/Đăng ký</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

     <!-- Favicon -->
     <link href="{{asset('img/favicon.ico')}}" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Roboto:wght@700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('js/flaticon/font/flaticon.css')}}" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('js/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">



    <style>
        :root {
            --primary-color: #7AB730;
            --primary-dark: #689c29;
            --secondary-color: #F8F9FA;
        }

        body {
            background-color: #f5f5f5;
            font-family: 'Poppins', sans-serif;
        }

        .navbar-brand h1 {
            font-family: 'Roboto', sans-serif;
        }

        .auth-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 40px 0;
            background: linear-gradient(135deg, rgba(122, 183, 48, 0.1) 0%, rgba(255, 255, 255, 0.1) 100%);
        }

        .form-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;  /* Giảm padding từ 40px xuống 30px */
            max-width: 700px; /* Tăng max-width để chứa 2 cột */
            width: 100%;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
        }

        .register-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .mb-3 {
            margin-bottom: 15px; /* Giảm margin từ 1rem xuống 15px */
        }

        .form-control {
            height: 45px; /* Giảm height từ 50px xuống 45px */
        }

        .btn-auth {
            height: 45px; /* Giảm height từ 50px xuống 45px */
        }



        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-header h2 {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .form-control {
            height: 50px;
            border-radius: 10px;
            border: 2px solid #eee;
            padding: 10px 15px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(122, 183, 48, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
        }

        .btn-auth {
            height: 50px;
            border-radius: 10px;
            background-color: var(--primary-color);
            border: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .btn-auth:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        .form-switch-text {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }

        .form-switch-link {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .form-switch-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .auth-forms {
            position: relative;
            height: auto;
            overflow: hidden;
        }

        #loginForm, #registerForm {
            transition: all 0.5s ease;
            position: relative;
            width: 100%;
        }

        .hide-form {
            display: none;
            opacity: 0;
            transform: translateX(-100%);
        }

        .show-form {
            display: block;
            opacity: 1;
            transform: translateX(0);
        }

        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .page-header {
            background: var(--secondary-color);
            padding: 30px 0;
            border-bottom: 1px solid #eee;
        }

        .page-header .border-start {
            border-color: var(--primary-color)!important;
        }

        @media (max-width: 768px) {
            .register-row {
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }
    </style>
</head>

<body>
     <!-- Navbar Start -->
     @include('partials._navbar', ['user_id' => session('user_id')])
    <!-- Navbar End -->


    <!-- <div class="page-header">
        <div class="container">
            <div class="border-start border-5 ps-5">
                <h6 class="text-primary text-uppercase">Tài khoản</h6>
                <h1 class="display-6 text-uppercase mb-0">Đăng nhập / Đăng ký</h1>
            </div>
        </div>
    </div> -->

    <!-- Auth Section -->
    <div class="auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-container">
                        <div class="auth-forms">
                            <!-- Login Form -->
                            <div id="loginForm" class="show-form">
                                <div class="form-header">
                                    <h2>Đăng nhập</h2>
                                    <p>Chào mừng bạn quay trở lại!</p>
                                </div>
                                <form action="{{ route('login.handle') }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="loginTaiKhoan" class="form-label">Tài khoản</label>
                                        <input type="text" class="form-control" id="loginTaiKhoan" name="TaiKhoan" required placeholder="Nhập tài khoản của bạn">
                                    </div>
                                    <div class="mb-4">
                                        <label for="loginMatKhau" class="form-label">Mật khẩu</label>
                                        <input type="password" class="form-control" id="loginMatKhau" name="MatKhau" required placeholder="Nhập mật khẩu của bạn">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-auth w-100">Đăng nhập</button>
                                </form>
                                <div class="form-switch-text">
                                    <p>Chưa có tài khoản? <a href="#" class="form-switch-link" id="showRegister">Đăng ký ngay</a></p>
                                </div>
                            </div>

                            <!-- Register Form -->
                            <div id="registerForm" class="hide-form">
        <div class="form-header">
            <h2>Đăng ký</h2>
            <p>Tạo tài khoản mới</p>
        </div>
        <form action="{{ route('register.handle') }}" method="POST">
            @csrf
            <div class="register-row">
                <div class="mb-3">
                    <label for="registerHoTen" class="form-label">Họ tên</label>
                    <input type="text" class="form-control" id="registerHoTen" name="HoTen" required placeholder="Nhập họ tên của bạn" value="{{ old('HoTen') }}">
                </div>
                <div class="mb-3">
                    <label for="registerSDT" class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" id="registerSDT" name="SDT" required placeholder="Nhập số điện thoại của bạn" value="{{ old('SDT') }}">
                </div>
                <div class="mb-3">
                    <label for="registerEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="registerEmail" name="Email" required placeholder="Nhập email của bạn" value="{{ old('Email') }}">
                </div>
                <div class="mb-3">
                    <label for="registerTaiKhoan" class="form-label">Tài khoản</label>
                    <input type="text" class="form-control" id="registerTaiKhoan" name="TaiKhoan" required placeholder="Nhập tài khoản của bạn" value="{{ old('TaiKhoan') }}">
                </div>
                <div class="mb-3">
                    <label for="registerMatKhau" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" id="registerMatKhau" name="MatKhau" required placeholder="Nhập mật khẩu của bạn">
                </div>
                <div class="mb-3">
                    <label for="registerMatKhau_confirmation" class="form-label">Xác nhận mật khẩu</label>
                    <input type="password" class="form-control" id="registerMatKhau_confirmation" name="MatKhau_confirmation" required placeholder="Xác nhận mật khẩu của bạn">
                </div>
                <div class="mb-3 full-width">
                    <label for="registerDiaChi" class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control" id="registerDiaChi" name="DiaChi" required placeholder="Nhập địa chỉ của bạn" value="{{ old('DiaChi') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-auth w-100">Đăng ký</button>
        </form>
        <div class="form-switch-text">
            <p>Đã có tài khoản? <a href="#" class="form-switch-link" id="showLogin">Đăng nhập</a></p>
        </div>
    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.footer')

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Show register form
            $('#showRegister').click(function(e) {
                e.preventDefault();
                $('#loginForm').removeClass('show-form').addClass('hide-form');
                setTimeout(function() {
                    $('#registerForm').removeClass('hide-form').addClass('show-form');
                }, 300);
            });

            // Show login form
            $('#showLogin').click(function(e) {
                e.preventDefault();
                $('#registerForm').removeClass('show-form').addClass('hide-form');
                setTimeout(function() {
                    $('#loginForm').removeClass('hide-form').addClass('show-form');
                }, 300);
            });
        });
    </script>
</body>
</html>
