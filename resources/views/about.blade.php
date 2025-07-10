<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>PET SHOP - Pet Shop Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="{{asset('img/favicon.ico')}}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Roboto:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{asset('js/flaticon/font/flaticon.css')}}" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('js/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <!-- <div class="container-fluid border-bottom d-none d-lg-block">
        <div class="row gx-0">
            <div class="col-lg-4 text-center py-2">
                <div class="d-inline-flex align-items-center">
                    <i class="bi bi-geo-alt fs-1 text-primary me-3"></i>
                    <div class="text-start">
                        <h6 class="text-uppercase mb-1">Our Office</h6>
                        <span>123 Street, New York, USA</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center border-start border-end py-2">
                <div class="d-inline-flex align-items-center">
                    <i class="bi bi-envelope-open fs-1 text-primary me-3"></i>
                    <div class="text-start">
                        <h6 class="text-uppercase mb-1">Email Us</h6>
                        <span>info@example.com</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center py-2">
                <div class="d-inline-flex align-items-center">
                    <i class="bi bi-phone-vibrate fs-1 text-primary me-3"></i>
                    <div class="text-start">
                        <h6 class="text-uppercase mb-1">Call Us</h6>
                        <span>+012 345 6789</span>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Topbar End -->


    <!-- Navbar Start -->
    @include('partials._navbar', ['user_id' => session('user_id')])
    <!-- Navbar End -->


    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-5 mb-5 mb-lg-0" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100 rounded" src="{{asset('img/about.jpg')}}" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="border-start border-5 border-primary ps-5 mb-5">
                        <h6 class="text-primary text-uppercase">Về chúng tôi</h6>
                        <h1 class="display-5 text-uppercase mb-0">Chúng Tôi Luôn Giữ Cho Thú Cưng Của Bạn Vui Vẻ</h1>
                    </div>
                    <h4 class="text-body mb-4">Mỗi ngày đều tràn ngập niềm vui cho thú cưng của bạn. Với sự chăm sóc tận tâm, chúng sẽ luôn được yêu thương và hạnh phúc!</h4>
                    <div class="bg-light p-4">
                        <ul class="nav nav-pills justify-content-between mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item w-50" role="presentation">
                                <button class="nav-link text-uppercase w-100 active" id="pills-1-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1"
                                    aria-selected="true">SỨ MỆNH</button>
                            </li>
                            <li class="nav-item w-50" role="presentation">
                                <button class="nav-link text-uppercase w-100" id="pills-2-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-2" type="button" role="tab" aria-controls="pills-2"
                                    aria-selected="false">TẦM NHÌN</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
                                <p class="mb-0">Nhiệm vụ của chúng tôi là mang đến sự chăm sóc tốt nhất cho thú cưng của bạn, đảm bảo rằng chúng luôn khỏe mạnh, hạnh phúc và được yêu thương. Với sự tận tâm, chúng tôi cam kết cung cấp những dịch vụ và sản phẩm chất lượng cao, đáp ứng mọi nhu cầu thiết yếu của thú cưng, từ dinh dưỡng đến chăm sóc y tế. Chúng tôi tin rằng mỗi thú cưng đều xứng đáng nhận được sự quan tâm đặc biệt, giúp chúng có một cuộc sống tốt đẹp hơn bên cạnh gia đình của mình.</p>
                            </div>
                            <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">
                                <p class="mb-0">Tầm nhìn của chúng tôi là trở thành thương hiệu hàng đầu trong lĩnh vực chăm sóc thú cưng, nơi mọi chủ nuôi có thể tin tưởng và gửi gắm sự chăm sóc cho các "thành viên nhỏ" trong gia đình. Chúng tôi không chỉ tập trung vào cung cấp dịch vụ chất lượng mà còn hướng tới việc tạo ra một cộng đồng yêu thương và hỗ trợ thú cưng. Bằng cách phát triển bền vững và không ngừng đổi mới, chúng tôi mong muốn xây dựng một thế giới nơi thú cưng được trân trọng và tận hưởng cuộc sống hạnh phúc nhất.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


   <!-- Offer Start -->
   <div class="container-fluid bg-offer my-5 py-5">
        <div class="container py-5">
            <div class="row gx-5 justify-content-start">
                <div class="col-lg-7">
                    <div class="border-start border-5 border-dark ps-5 mb-5">
                        <h6 class="text-dark text-uppercase">ƯU ĐÃI ĐẶC BIỆT</h6>
                        <h1 class="display-5 text-uppercase text-white mb-0">Tiết Kiệm 50% cho tất cả sản phẩm trong đơn hàng đầu tiên</h1>
                    </div>
                    <p class="text-white mb-4">Nhanh tay nhận ưu đãi với mức giảm giá hấp dẫn!
                    Chúng tôi mang đến cho bạn cơ hội tiết kiệm 50% khi mua bất kỳ sản phẩm nào trong đơn hàng đầu tiên. Hãy tận hưởng trải nghiệm mua sắm với những sản phẩm chất lượng cao và giá cả phải chăng cho thú cưng của bạn. Đừng bỏ lỡ cơ hội này để chăm sóc thú cưng của bạn với mức giá ưu đãi!</p>
                    <a href="" class="btn btn-light py-md-3 px-md-5 me-3">MUA NGAY</a>
                    <a href="" class="btn btn-outline-light py-md-3 px-md-5">Tìm hiểu thêm</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Offer End -->


    <!-- Team Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase">Thành viên đội ngũ</h6>
                <h1 class="display-5 text-uppercase mb-0">Chuyên gia chăm sóc thú cưng chuyên nghiệp</h1>
            </div>
            <div class="owl-carousel team-carousel position-relative" style="padding-right: 25px;">
                @foreach($bacsi as $doctor)
                <div class="team-item">
                    <div class="position-relative overflow-hidden">
                        <!-- Thêm lớp custom-height để đồng nhất chiều cao ảnh -->
                        <img class="img-fluid w-100 custom-height" src=" {{ asset('Image/dogtor.jpg' ) }}" alt="">
                    </div>
                    <!-- Đảm bảo phần mô tả thông tin có chiều cao cố định -->
                    <div class="bg-light text-center p-4 content-container">
                        <h5 class="text-uppercase text-truncate" title="{{ $doctor->HoTen }}">{{ $doctor->HoTen }}</h5>
                        <p class="m-0">{{ $doctor->ChuyenMon }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Team End -->


   <!-- Footer Start -->
   @include('partials.footer')


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('js/easing/easing.min.js')}}"></script>
    <script src="{{asset('js/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('js/owlcarousel/owl.carousel.min.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('js/main.js')}}"></script>
</body>

</html>
