<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PET SHOP - Giỏ hàng</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Roboto:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('js/flaticon/font/flaticon.css') }}" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('js/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        
/* Card Styling */
.card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
}

/* Hover Effect on Card */
.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

/* Card Body */
.card-body {
    background: linear-gradient(to right, #f0f8ff, #e6f7ff);
    padding: 2rem;
    border-radius: 12px;
}

/* Title */
.card-title {
    font-size: 1.6rem;
    color: cadetblue;
    text-transform: uppercase;
    letter-spacing: 1px;
}
    </style>
</head>

<body>
    <!-- Navbar Start -->
    @include('partials._navbar', ['user_id' => session('user_id')])
    <!-- Navbar End -->


    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Tài Khoản Của Tôi</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li><a href="{{ route('userdashboard.profile') }}" class="text-decoration-none">Hồ Sơ</a>
                            </li>
                            <li><a href="{{ route('userdashboard.pets') }}" class="text-decoration-none">Thú Cưng</a>
                            </li>
                            <li><a href="{{ route('userdashboard.orders') }}" class="text-decoration-none">Đơn Hàng</a>
                            </li>
                            <li><a href="{{ route('userdashboard.appointments') }}" class="text-decoration-none">Lịch
                                    Khám</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Main Content Start -->
            <div class="col-lg-9">
                @yield('content')
            </div>
            <!-- Main Content End -->
        </div>
    </div>


    <!-- Footer Start -->
    @include('partials.footer')
   
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/easing/easing.min.js') }}"></script>
    <script src="{{ asset('js/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('js/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.querySelector('.nav-item.dropdown').addEventListener('mouseover', function() {
            this.querySelector('.dropdown-menu-custom').style.display = 'block';
        });
        document.querySelector('.nav-item.dropdown').addEventListener('mouseout', function() {
            this.querySelector('.dropdown-menu-custom').style.display = 'none';
        });
    </script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
