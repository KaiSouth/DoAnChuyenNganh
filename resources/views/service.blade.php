<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>PET SHOP - Pet Shop Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

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
</head>

<body>


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm py-3 py-lg-0 px-3 px-lg-0">
        <a href="{{ route('index') }}" class="navbar-brand ms-lg-5">
            <h1 class="m-0 text-uppercase text-dark"><i class="bi bi-shop fs-1 text-primary me-3"></i>Pet Shop</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="{{ route('index') }}" class="nav-item nav-link active">TRANG CHỦ</a>
                <a href="{{ route('about') }}" class="nav-item nav-link">VỀ CHÚNG TÔI</a>
                <div class="nav-item dropdown" style="position: relative;">
                    <a href="{{ route('service') }}" class="nav-link text-uppercase" style="position: relative;">
                        DỊCH VỤ
                    </a>
                    <div class="dropdown-menu-custom"
                        style="display: none; position: absolute; top: calc(100% - 1px); left: 0; background-color: white; border-radius: 5px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); padding: 0; margin: 0; z-index: 1000; text-align: center; white-space: nowrap;">
                        <a href="{{ route('bookingService.create') }}" class="nav-link text-uppercase"
                            style="color: #000; padding: 10px 15px; text-decoration: none; font-weight: 500; font-size: 16px; margin: 0;">
                            ĐẶT DỊCH VỤ
                        </a>
                    </div>
                </div>
                <a href="{{ route('product') }}" class="nav-item nav-link">SẢN PHẨM</a>
                <a href="{{ route('userdashboard') }}" class="nav-item nav-link">HỒ SƠ</a>
                @if (session()->has('user_id'))
                    <!-- <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="nav-item nav-link btn btn-link"> <i class="fas fa-sign-out-alt"></i></button>
                    </form> -->
                    <a href="{{ route('logout') }}" class="nav-item nav-link">ĐĂNG XUẤT<i
                            class="fas fa-sign-out-alt"></i> </a>
                @else
                    <a href="{{ route('login.form') }}" class="nav-item nav-link ">ĐĂNG NHẬP <i
                            class="fas fa-sign-in-alt"></i></a>
                @endif
                <a href="{{ route('cart') }}" class="nav-item nav-link">GIỎ HÀNG <i
                        class="fas fa-shopping-cart"></i></a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Services Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase">DỊCH VỤ</h6>
                <h1 class="display-5 text-uppercase mb-0">CÁC DỊCH VỤ CỦA CHÚNG TÔI</h1>
            </div>
            <div class="row g-5">
                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <i class="flaticon-house display-1 text-primary me-4"></i>
                        <div>
                            <h5 class="text-uppercase mb-3">TRÔNG GIỮ THÚ CƯNG</h5>
                            <p>Chúng tôi đảm bảo chăm sóc thú cưng của bạn tận tình khi bạn đi xa. Thú cưng sẽ được ở
                                trong môi trường an toàn và thoải mái</p>
                            <a class="text-primary text-uppercase" href="">Tìm hiểu thêm<i
                                    class="bi bi-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <i class="flaticon-food display-1 text-primary me-4"></i>
                        <div>
                            <h5 class="text-uppercase mb-3">CHO THÚ CƯNG ĂN</h5>
                            <p>Chúng tôi luôn tính toán và cung cấp chế độ ăn uống phù hợp, lành mạnh để đảm bảo sức
                                khỏe của thú cưng luôn trong trạng thái tốt nhất</p>
                            <a class="text-primary text-uppercase" href="">Tìm hiểu thêm<i
                                    class="bi bi-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <i class="flaticon-grooming display-1 text-primary me-4"></i>
                        <div>
                            <h5 class="text-uppercase mb-3">CHĂM SÓC LÔNG</h5>
                            <p>Dịch vụ cắt tỉa và chăm sóc lông chuyên nghiệp để thú cưng của bạn luôn sạch sẽ, gọn gàng
                                và đáng yêu</p>
                            <a class="text-primary text-uppercase" href="">Tìm hiểu thêm<i
                                    class="bi bi-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <i class="flaticon-cat display-1 text-primary me-4"></i>
                        <div>
                            <h5 class="text-uppercase mb-3">HUẤN LUYỆN CHO THÚ CƯNG</h5>
                            <p>Chúng tôi cung cấp các khóa huấn luyện để giúp thú cưng của bạn trở nên ngoan ngoãn và
                                vâng lời hơn</p>
                            <a class="text-primary text-uppercase" href="">Read More<i
                                    class="bi bi-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <i class="flaticon-dog display-1 text-primary me-4"></i>
                        <div>
                            <h5 class="text-uppercase mb-3">CÁC BÀI TẬP THỂ DỤC CHO THÚ CƯNG</h5>
                            <p>Thú cưng của bạn sẽ được vận động đúng cách để duy trì sức khỏe và tinh thần tốt nhất mỗi
                                ngày</p>
                            <a class="text-primary text-uppercase" href="">Read More<i
                                    class="bi bi-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <i class="flaticon-vaccine display-1 text-primary me-4"></i>
                        <div>
                            <h5 class="text-uppercase mb-3">Chăm Sóc Y Tế</h5>
                            <p>Dịch vụ khám chữa bệnh và tiêm phòng định kỳ để bảo vệ sức khỏe lâu dài cho thú cưng của
                                bạn</p>
                            <a class="text-primary text-uppercase" href="">TÌM HIỂU THÊM<i
                                    class="bi bi-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Services End -->


    <!-- Testimonial Start -->
    <div class="container-fluid bg-testimonial py-5" style="margin: 45px 0;">
        <div class="container py-5">
            <div class="row justify-content-end">
                <div class="col-lg-7">
                    <div class="owl-carousel testimonial-carousel bg-white p-5">
                        <div class="testimonial-item text-center">
                            <div class="position-relative mb-4">
                                <img class="img-fluid mx-auto" src="{{ asset('img/testimonial-1.jpg') }}"
                                    alt="">
                                <div class="position-absolute top-100 start-50 translate-middle d-flex align-items-center justify-content-center bg-white"
                                    style="width: 45px; height: 45px;">
                                    <i class="bi bi-chat-square-quote text-primary"></i>
                                </div>
                            </div>
                            <p>Dolores sed duo clita tempor justo dolor et stet lorem kasd labore dolore lorem ipsum. At
                                lorem lorem magna ut et, nonumy et labore et tempor diam tempor erat. Erat dolor rebum
                                sit ipsum.</p>
                            <hr class="w-25 mx-auto">
                            <h5 class="text-uppercase">Client Name</h5>
                            <span>Profession</span>
                        </div>
                        <div class="testimonial-item text-center">
                            <div class="position-relative mb-4">
                                <img class="img-fluid mx-auto" src="{{ asset('img/testimonial-2.jpg') }}"
                                    alt="">
                                <div class="position-absolute top-100 start-50 translate-middle d-flex align-items-center justify-content-center bg-white"
                                    style="width: 45px; height: 45px;">
                                    <i class="bi bi-chat-square-quote text-primary"></i>
                                </div>
                            </div>
                            <p>Dolores sed duo clita tempor justo dolor et stet lorem kasd labore dolore lorem ipsum. At
                                lorem lorem magna ut et, nonumy et labore et tempor diam tempor erat. Erat dolor rebum
                                sit ipsum.</p>
                            <hr class="w-25 mx-auto">
                            <h5 class="text-uppercase">Client Name</h5>
                            <span>Profession</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->
  <!-- Pricing Plan Start -->
  <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase">Bảng giá</h6>
                <h1 class="display-5 text-uppercase mb-0">Bảng giá dịch vụ chăm sóc thú cưng</h1>
            </div>
            <div class="row g-5">
                <div class="col-lg-4">
                    <div class="bg-light text-justify pt-5 mt-lg-5">
                        <h2 class="text-uppercase text-center">Cơ bản</h2>
                        <h6 class="text-body mb-5 text-center">Lựa chọn tiết kiệm</h6>
                        <div class="text-justify bg-primary p-4 mb-2">
                            <h1 class="display-4 text-white mb-0 text-center">
                             200.000<small class="align-top" style="font-size: 22px; line-height: 45px;">VND</small><small class="align-bottom" style="font-size: 16px; line-height: 40px;">/Lần</small>
                            </h1>
                        </div>
                        <div class="text-justify p-4">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span>Tắm rửa cơ bản</span>
                                <i class="bi bi-check2 fs-4 text-primary"></i>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span>Cắt móng và chăm sóc móng</span>
                                <i class="bi bi-check2 fs-4 text-primary"></i>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span>Kiểm tra sức khỏe tổng quát</span>
                                <i class="bi bi-x fs-4 text-danger"></i>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span>Tư vấn dinh dưỡng cơ bản</span>
                                <i class="bi bi-x fs-4 text-danger"></i>
                            </div>
                            <a href="{{route('appointment.form')}}" class="btn btn-primary text-uppercase py-2 px-4 my-3 d-block text-center">Đặt ngay</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="bg-light text-justify pt-5">
                        <h2 class="text-uppercase text-center">Tiêu chuẩn</h2>
                        <h6 class="text-body mb-5 text-center">Lựa chọn tốt nhất</h6>
                        <div class="text-justify bg-dark p-4 mb-2">
                            <h1 class="display-4 text-white mb-0 text-center">
                            500.000<small class="align-top" style="font-size: 22px; line-height: 45px;">VND</small><small class="align-bottom" style="font-size: 16px; line-height: 40px;">/Lần</small>
                            </h1>
                        </div>
                        <div class="text-justify p-4">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span>Tắm rửa và chải lông</span>
                                <i class="bi bi-check2 fs-4 text-primary"></i>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span>Cắt móng và chăm sóc móng chuyên sâu</span>
                                <i class="bi bi-check2 fs-4 text-primary"></i>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span>Kiểm tra sức khỏe tổng quát</span>
                                <i class="bi bi-check2 fs-4 text-primary"></i>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span>Tư vấn dinh dưỡng và chế độ ăn</span>
                                <i class="bi bi-x fs-4 text-danger"></i>
                            </div>
                            <a href="{{route('appointment.form')}}" class="btn btn-primary text-uppercase py-2 px-4 my-3 d-block text-center">Đặt ngay</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="bg-light text-justify pt-5 mt-lg-5">
                        <h2 class="text-uppercase text-center">Mở rộng</h2>
                        <h6 class="text-body mb-5 text-center">Dịch vụ toàn diện</h6>
                        <div class="text-justify bg-primary p-4 mb-2">
                            <h1 class="display-4 text-white mb-0 text-center">
                            700.000<small class="align-top" style="font-size: 22px; line-height: 45px;">VND</small><small class="align-bottom" style="font-size: 16px; line-height: 40px;">/Lần</small>
                            </h1>
                        </div>
                        <div class="text-justify p-4">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span>Tắm rửa và chải lông cao cấp</span>
                                <i class="bi bi-check2 fs-4 text-primary"></i>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span>Cắt móng, chăm sóc da và lông</span>
                                <i class="bi bi-check2 fs-4 text-primary"></i>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span>Kiểm tra sức khỏe chuyên sâu</span>
                                <i class="bi bi-check2 fs-4 text-primary"></i>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span>Tư vấn dinh dưỡng và chế độ ăn tùy chỉnh</span>
                                <i class="bi bi-check2 fs-4 text-primary"></i>
                            </div>
                            <a href="{{route('appointment.form')}}" class="btn btn-primary text-uppercase py-2 px-4 my-3 d-block text-center">Đặt ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Pricing Plan End -->



    <!-- Footer Start -->
    <div class="container-fluid bg-light mt-5 py-5">
        <div class="container pt-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Liên Hệ Với Chúng Tôi
                    </h5>
                    <p class="mb-4">Nếu bạn có bất kỳ câu hỏi hoặc thắc mắc nào, đừng ngần ngại liên hệ với chúng
                        tôi. Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn!</p>
                    <p class="mb-2"><i class="bi bi-geo-alt text-primary me-2"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="bi bi-envelope-open text-primary me-2"></i>info@example.com</p>
                    <p class="mb-0"><i class="bi bi-telephone text-primary me-2"></i>+012 345 67890</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">LIÊN KẾT NHANH</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-body mb-2" href="#"><i
                                class="bi bi-arrow-right text-primary me-2"></i>TRANG CHỦ</a>
                        <a class="text-body mb-2" href="#"><i
                                class="bi bi-arrow-right text-primary me-2"></i>VỀ CHÚNG TÔI</a>
                        <a class="text-body mb-2" href="#"><i
                                class="bi bi-arrow-right text-primary me-2"></i>DỊCH VỤ</a>
                        <a class="text-body mb-2" href="#"><i
                                class="bi bi-arrow-right text-primary me-2"></i>BÀI VIẾT MỚI NHẤT</a>
                        <a class="text-body" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>LIÊN
                            HỆ VỚI CHÚNG TÔI</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">LIÊN KẾT PHỔ BIẾN</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-body mb-2" href="#"><i
                                class="bi bi-arrow-right text-primary me-2"></i>TRANG CHỦ</a>
                        <a class="text-body mb-2" href="#"><i
                                class="bi bi-arrow-right text-primary me-2"></i>DỊCH VỤ</a>
                        <a class="text-body mb-2" href="#"><i
                                class="bi bi-arrow-right text-primary me-2"></i>SẢN PHẨM</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">GỬI PHẢN HỒI CHO CHÚNG
                        TÔI</h5>
                    <form action="">
                        <div class="input-group">
                            <input type="text" class="form-control p-3" placeholder="Your Email">
                            <button class="btn btn-primary">Sign Up</button>
                        </div>
                    </form>
                    <h6 class="text-uppercase mt-4 mb-3">Follow Us</h6>
                    <div class="d-flex">
                        <a class="btn btn-outline-primary btn-square me-2" href="#"><i
                                class="bi bi-twitter"></i></a>
                        <a class="btn btn-outline-primary btn-square me-2" href="#"><i
                                class="bi bi-facebook"></i></a>
                        <a class="btn btn-outline-primary btn-square me-2" href="#"><i
                                class="bi bi-linkedin"></i></a>
                        <a class="btn btn-outline-primary btn-square" href="#"><i
                                class="bi bi-instagram"></i></a>
                    </div>
                </div>
                <div class="col-12 text-center text-body">
                    <a class="text-body" href="">Terms & Conditions</a>
                    <span class="mx-1">|</span>
                    <a class="text-body" href="">Privacy Policy</a>
                    <span class="mx-1">|</span>
                    <a class="text-body" href="">Customer Support</a>
                    <span class="mx-1">|</span>
                    <a class="text-body" href="">Payments</a>
                    <span class="mx-1">|</span>
                    <a class="text-body" href="">Help</a>
                    <span class="mx-1">|</span>
                    <a class="text-body" href="">FAQs</a>
                </div>
            </div>
        </div>
    </div>
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

    <script>
        document.querySelector('.nav-item.dropdown').addEventListener('mouseover', function() {
            this.querySelector('.dropdown-menu-custom').style.display = 'block';
        });
        document.querySelector('.nav-item.dropdown').addEventListener('mouseout', function() {
            this.querySelector('.dropdown-menu-custom').style.display = 'none';
        });
    </script>
</body>

</html>
