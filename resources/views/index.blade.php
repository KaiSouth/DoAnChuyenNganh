<!-- D:\DoAnTotNghiep\root\resources\views\index.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--Hello-->
<head>
    <meta charset="utf-8">
    <title>PET SHOP - Mẫu Website Cửa Hàng Thú Cưng</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Chăm sóc thú cưng chất lượng cao" name="keywords">
    <meta content="Cửa hàng cung cấp dịch vụ và sản phẩm chăm sóc thú cưng hàng đầu" name="description">

    <!-- Favicon -->
    <link href="{{asset('img/favicon.ico')}}" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Roboto:wght@700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{asset('js/flaticon/font/flaticon.css')}}" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('js/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <style>/* Đảm bảo ảnh có chiều cao cố định và đồng bộ */
        .custom-height {
            height: 300px; /* Đặt chiều cao cố định cho ảnh */
            object-fit: cover; /* Cắt ảnh cho vừa khung */
            object-position: center; /* Giữ phần trung tâm của ảnh */
        }
        
        /* Đặt chiều cao cố định cho vùng chứa nội dung (text) */
        .content-container {
            height: 100px; /* Đặt chiều cao cố định */
            display: flex; /* Đảm bảo căn giữa nội dung */
            flex-direction: column; /* Xếp nội dung theo chiều dọc */
            justify-content: center; /* Căn giữa theo chiều dọc */
            align-items: center; /* Căn giữa theo chiều ngang */
            overflow: hidden; /* Giấu nội dung tràn ra ngoài */
            text-align: center; /* Căn giữa text */
        }
        
        /* Đảm bảo tên không quá dài */
        .text-truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        </style>
</head>

<body>

    @include('partials._navbar', ['user_id' => session('user_id')])

    
    
    


    <!-- Hero Start -->
    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row justify-content-start">
                <div class="col-lg-8 text-center text-lg-start">
                    <h1 class="display-1 text-uppercase text-dark mb-lg-4">Pet Shop</h1>
                    <h1 class="text-uppercase text-white mb-lg-4">Hãy làm thú cưng của bạn hạnh phúc</h1>
                    <p class="fs-4 text-white mb-lg-4">Chúng tôi cung cấp các dịch vụ chăm sóc tốt nhất để đảm bảo sức khỏe và hạnh phúc cho thú cưng của bạn mỗi ngày.</p>
                    <div class="d-flex align-items-center justify-content-center justify-content-lg-start pt-5">
                    <button class="btn btn-primary" onclick="window.location.href='{{ route('appointment.form') }}'">Đặt Lịch Khám</button>
                        <button type="button" class="btn-play" data-bs-toggle="modal"
                            data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
                            <span></span>
                        </button>
                        <h5 class="font-weight-normal text-white m-0 ms-4 d-none d-sm-block">Phát Video</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->


    <!-- Video Modal Start -->
    <!-- <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Video Youtube</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body"> -->
                    <!-- 16:9 aspect ratio -->
                    <!-- <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="" id="video" allowfullscreen allowscriptaccess="always"
                            allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Video Modal End -->


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
                        <h6 class="text-primary text-uppercase">Giới thiệu</h6>
                        <h1 class="display-5 text-uppercase mb-0">Chúng tôi luôn khiến thú cưng của bạn hạnh phúc</h1>
                    </div>
                    <h4 class="text-body mb-4">Với kinh nghiệm nhiều năm trong việc chăm sóc thú cưng, chúng tôi cam kết mang lại dịch vụ tốt nhất cho bạn và người bạn nhỏ của mình.</h4>
                    <div class="bg-light p-4">
                        <ul class="nav nav-pills justify-content-between mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item w-50" role="presentation">
                                <button class="nav-link text-uppercase w-100 active" id="pills-1-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1"
                                    aria-selected="true">Sứ mệnh của chúng tôi</button>
                            </li>
                            <li class="nav-item w-50" role="presentation">
                                <button class="nav-link text-uppercase w-100" id="pills-2-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-2" type="button" role="tab" aria-controls="pills-2"
                                    aria-selected="false">Tầm nhìn của chúng tôi</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
                                <p class="mb-0">Sứ mệnh của chúng tôi là đảm bảo mỗi thú cưng đều được chăm sóc chu đáo và tận tình, mang lại cuộc sống khỏe mạnh và hạnh phúc nhất.</p>
                            </div>
                            <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">
                                <p class="mb-0">Tầm nhìn của chúng tôi là trở thành địa chỉ tin cậy hàng đầu trong lĩnh vực chăm sóc thú cưng, với các dịch vụ toàn diện và chất lượng cao.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Services Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase">Dịch vụ</h6>
                <h1 class="display-5 text-uppercase mb-0">Dịch vụ chăm sóc thú cưng xuất sắc của chúng tôi</h1>
            </div>
            <div class="row g-5">
                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <i class="flaticon-house display-1 text-primary me-4"></i>
                        <div>
                            <h5 class="text-uppercase mb-3">Dịch vụ nuôi thú</h5>
                            <p>Chúng tôi cung cấp môi trường an toàn và thoải mái cho thú cưng của bạn khi bạn vắng nhà.</p>
                            <a class="text-primary text-uppercase" href="{{ route('listproduct') }}">Đọc thêm<i class="bi bi-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <i class="flaticon-food display-1 text-primary me-4"></i>
                        <div>
                            <h5 class="text-uppercase mb-3">Dịch vụ cho ăn</h5>
                            <p>Đảm bảo thú cưng của bạn nhận được dinh dưỡng đầy đủ và hợp lý mỗi ngày.</p>
                            <a class="text-primary text-uppercase" href="{{ route('listproduct') }}">Đọc thêm<i class="bi bi-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <i class="flaticon-grooming display-1 text-primary me-4"></i>
                        <div>
                            <h5 class="text-uppercase mb-3">Dịch vụ chải lông</h5>
                            <p>Giúp thú cưng của bạn luôn sạch sẽ và mượt mà với các dịch vụ chải lông chuyên nghiệp.</p>
                            <a class="text-primary text-uppercase" href="{{ route('listproduct') }}">Đọc thêm<i class="bi bi-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <i class="flaticon-cat display-1 text-primary me-4"></i>
                        <div>
                            <h5 class="text-uppercase mb-3">Huấn luyện thú cưng</h5>
                            <p>Đào tạo và huấn luyện để thú cưng của bạn trở nên ngoan ngoãn và biết nghe lời.</p>
                            <a class="text-primary text-uppercase" href="{{ route('listproduct') }}">Đọc thêm<i class="bi bi-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <i class="flaticon-dog display-1 text-primary me-4"></i>
                        <div>
                            <h5 class="text-uppercase mb-3">Tập thể dục cho thú cưng</h5>
                            <p>Đảm bảo thú cưng của bạn luôn khỏe mạnh và năng động thông qua các bài tập phù hợp.</p>
                            <a class="text-primary text-uppercase" href="{{ route('listproduct') }}">Đọc thêm<i class="bi bi-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <i class="flaticon-vaccine display-1 text-primary me-4"></i>
                        <div>
                            <h5 class="text-uppercase mb-3">Điều trị thú cưng</h5>
                            <p>Các dịch vụ y tế chuyên nghiệp giúp thú cưng của bạn luôn khỏe mạnh và an toàn.</p>
                            <a class="text-primary text-uppercase" href="{{ route('listproduct') }}">Đọc thêm<i class="bi bi-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Services End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
    <div class="container">
        <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
            <h6 class="text-primary text-uppercase">Sản phẩm</h6>
            <h1 class="display-5 text-uppercase mb-0">Sản phẩm cho những người bạn tốt nhất của bạn</h1>
        </div>
        <div class="owl-carousel product-carousel">
            @foreach ($vattu as $product)
            <div class="pb-5">
                <div class="product-item position-relative bg-light d-flex flex-column text-center" style="max-height: 400px; min-height: 400px;">
                    <!-- Product Image with fixed size and object-fit for consistency -->
                    <div class="d-flex justify-content-center align-items-center" style="height: 200px; overflow: hidden;">
                        <img class="img-fluid mb-4"
                             src="{{ $product->HinhAnh }}"
                             alt="{{ $product->TenVatTu }}"
                             style="max-height: 150px; object-fit: cover;">
                    </div>

                    <!-- Product Name with fixed height and overflow ellipsis -->
                    <h6 class="text-uppercase" style="height: 40px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        {{ $product->TenVatTu }}
                    </h6>

                    <!-- Price with fixed height and crossed out price if applicable -->
                    <h6 class="text-danger mb-0">
                        @if ($product->GiaSauGiam < $product->DonGiaBan)
                            <del>{{ number_format($product->DonGiaBan, 0, ',', '.') }} VNĐ</del>
                            <span class="text-primary">{{ number_format($product->GiaSauGiam, 0, ',', '.') }} VNĐ</span>
                        @else
                            <span class="text-primary">{{ number_format($product->DonGiaBan, 0, ',', '.') }} VNĐ</span>
                        @endif
                    </h6>

                    <!-- Action Buttons (Buy and View Details) -->
                    <div class="btn-action d-flex justify-content-center">
                        <a class="btn btn-primary py-2 px-3 add-to-cart"
                           data-id="{{ $product->MaVatTu }}"
                           data-type="vat_tu"
                           href="javascript:void(0)">
                           <i class="bi bi-cart"></i> Mua
                        </a>
                        <a class="btn btn-primary py-2 px-3"
                        href="{{ route('detailserviceproduct', ['id' => $product->MaVatTu]) }}?type=vat_tu">
                        <i class="bi bi-eye"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
    </div>
</div>

    <!-- Products End -->


    <!-- Offer Start -->
    <div class="container-fluid bg-offer my-5 py-5">
        <div class="container py-5">
            <div class="row gx-5 justify-content-start">
                <div class="col-lg-7">
                    <div class="border-start border-5 border-dark ps-5 mb-5">
                        <h6 class="text-dark text-uppercase">Ưu đãi đặc biệt</h6>
                        <h1 class="display-5 text-uppercase text-white mb-0">Giảm 50% cho tất cả sản phẩm trong đơn hàng đầu tiên của bạn</h1>
                    </div>
                    <p class="text-white mb-4">Đừng bỏ lỡ cơ hội đặc biệt này! Mua sắm ngay hôm nay để nhận ưu đãi giảm giá cực lớn cho lần mua đầu tiên của bạn.</p>
                    <a href="{{ route('listproduct') }}" class="btn btn-light py-md-3 px-md-5 me-3">Mua ngay</a>
                    <a href="{{ route('about') }}" class="btn btn-outline-light py-md-3 px-md-5">Đọc thêm</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Offer End -->

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


    <!-- Testimonial Start -->
    <div class="container-fluid bg-testimonial py-5" style="margin: 45px 0;">
        <div class="container py-5">
            <div class="row justify-content-end">
                <div class="col-lg-7">
                    <div class="owl-carousel testimonial-carousel bg-white p-5">
                        <div class="testimonial-item text-center">
                            <div class="position-relative mb-4">
                                <img class="img-fluid mx-auto" src="{{asset('img/testimonial-1.jpg')}}" alt="">
                                <div class="position-absolute top-100 start-50 translate-middle d-flex align-items-center justify-content-center bg-white" style="width: 45px; height: 45px;">
                                    <i class="bi bi-chat-square-quote text-primary"></i>
                                </div>
                            </div>
                            <p>Pet Shop đã mang lại cho tôi những dịch vụ chăm sóc tuyệt vời cho thú cưng của mình. Nhân viên rất nhiệt tình và chuyên nghiệp.</p>
                            <hr class="w-25 mx-auto">
                            <h5 class="text-uppercase">Nguyễn Văn A</h5>
                            <span>Khách hàng</span>
                        </div>
                        <div class="testimonial-item text-center">
                            <div class="position-relative mb-4">
                                <img class="img-fluid mx-auto" src="{{asset('img/testimonial-2.jpg')}}" alt="">
                                <div class="position-absolute top-100 start-50 translate-middle d-flex align-items-center justify-content-center bg-white" style="width: 45px; height: 45px;">
                                    <i class="bi bi-chat-square-quote text-primary"></i>
                                </div>
                            </div>
                            <p>Tôi rất hài lòng với dịch vụ grooming cho thú cưng tại đây. Thú cưng của tôi luôn được chăm sóc cẩn thận và rất thích nơi này.</p>
                            <hr class="w-25 mx-auto">
                            <h5 class="text-uppercase">Trần Thị B</h5>
                            <span>Khách hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->


    <!-- Footer Start -->
    @include('partials.footer')

    <!-- Footer End -->


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
