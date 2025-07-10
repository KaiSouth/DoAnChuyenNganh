<!DOCTYPE html>
<html lang="en">

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
    @include('partials._navbar', ['user_id' => session('user_id')])
    <!-- Navbar End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div class="border-start border-5 border-primary ps-5" style="max-width: 600px;">
                    <h6 class="text-primary text-uppercase">SẢN PHẨM</h6>
                    <h1 class="display-5 text-uppercase mb-0">SẢN PHẨM BÁN CHẠY NHẤT</h1>
                </div>
                <a href="{{ route('listproduct') }}" class="btn btn-link text-primary text-uppercase">View All</a>
            </div>
            <div class="owl-carousel product-carousel">
                @foreach ($products as $product)
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


    <!-- Services Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div class="border-start border-5 border-primary ps-5" style="max-width: 600px;">
                    <h6 class="text-primary text-uppercase">DỊCH VỤ</h6>
                    <h1 class="display-5 text-uppercase mb-0">DỊCH VỤ BÁN CHẠY NHẤT</h1>
                </div>
                <a href="{{ route('listproduct') }}" class="btn btn-link text-primary text-uppercase">View All</a>
            </div>
            <div class="owl-carousel product-carousel">
                @foreach ($services as $service)
                <div class="pb-5">
                    <div class="product-item position-relative bg-light d-flex flex-column text-center" style="max-height: 400px; min-height: 400px;">
                        <!-- Product Image with fixed size and object-fit for consistency -->
                        <div class="d-flex justify-content-center align-items-center" style="height: 200px; overflow: hidden;">
                            <img class="img-fluid mb-4"
                                src="{{ $service->HinhAnh }}"
                                alt="{{ $service->TenDichVu }}"
                                style="max-height: 150px; object-fit: cover;">
                        </div>

                        <!-- Service Name with fixed height and overflow ellipsis -->
                        <h6 class="text-uppercase" style="height: 40px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $service->TenDichVu }}
                        </h6>

                        <!-- Price with fixed height and crossed out price if applicable -->
                        <h6 class="text-danger mb-0">
                            @if ($service->GiaSauGiam < $service->DonGia)
                                <del>{{ number_format($service->DonGia, 0, ',', '.') }} VNĐ</del>
                                <span class="text-primary">{{ number_format($service->GiaSauGiam, 0, ',', '.') }} VNĐ</span>
                            @else
                                <span class="text-primary">{{ number_format($service->DonGia, 0, ',', '.') }} VNĐ</span>
                            @endif
                        </h6>

                        <!-- Action Buttons (Buy and View Details) -->
                        <div class="btn-action d-flex justify-content-center">
                            <a class="btn btn-primary py-2 px-3 open-booking-modal"
                               data-id="{{ $service->MaDichVu }}"
                               data-name="{{ $service->TenDichVu }}"
                               href="javascript:void(0);">
                               <i class="bi bi-cart"></i> Mua
                            </a>
                            <a class="btn btn-primary py-2 px-3" href="{{ route('detailserviceproduct', ['id' => $service->MaDichVu]) }}?type=dich_vu">
                               <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
    <!-- Services End -->


    <!-- Modal đặt dịch vụ Start -->
    <div class="modal fade" id="bookingServiceModal" tabindex="-1" aria-labelledby="bookingServiceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="bookingServiceForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bookingServiceModalLabel">Đặt Dịch Vụ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="serviceName" class="form-label">Dịch Vụ</label>
                            <input type="text" id="serviceName" class="form-control" readonly>
                            <input type="hidden" id="serviceId" name="MaDichVu">
                        </div>
                        <div class="mb-3">
                            <label for="thucung" class="form-label">Chọn Thú Cưng</label>
                            <select name="MaThuCung" id="thucung" class="form-select" required>
                                <option value="" disabled selected>Chọn thú cưng</option>
                                @foreach ($pets as $pet)
                                    <option value="{{ $pet->MaThuCung }}">{{ $pet->TenThuCung }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="ngay" class="form-label">Ngày</label>
                            <input type="date" id="ngay" name="Ngay" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="gio" class="form-label">Giờ</label>
                            <input type="time" id="gio" name="Gio" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Đặt Dịch Vụ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal đặt dịch vụ End-->


    <!-- Offer Start -->
    <div class="container-fluid bg-offer my-5 py-5">
        <div class="container py-5">
            <div class="row gx-5 justify-content-start">
                <div class="col-lg-7">
                    <div class="border-start border-5 border-dark ps-5 mb-5">
                        <h6 class="text-dark text-uppercase">ƯU ĐÃI ĐẶC BIỆT</h6>
                        <h1 class="display-5 text-uppercase text-white mb-0">Tiết Kiệm 50% cho tất cả sản phẩm trong
                            đơn hàng đầu tiên</h1>
                    </div>
                    <p class="text-white mb-4">Nhanh tay nhận ưu đãi với mức giảm giá hấp dẫn!
                        Chúng tôi mang đến cho bạn cơ hội tiết kiệm 50% khi mua bất kỳ sản phẩm nào trong đơn hàng đầu
                        tiên. Hãy tận hưởng trải nghiệm mua sắm với những sản phẩm chất lượng cao và giá cả phải chăng
                        cho thú cưng của bạn. Đừng bỏ lỡ cơ hội này để chăm sóc thú cưng của bạn với mức giá ưu đãi!</p>
                    <a href="{{ route('listproduct') }}" class="btn btn-light py-md-3 px-md-5 me-3">MUA NGAY</a>
                    <a href="{{ route('about') }}" class="btn btn-outline-light py-md-3 px-md-5">Tìm hiểu thêm</a>
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

    <script>
        $(document).on('click', '.add-to-cart', function(event) {
            event.preventDefault();
            var productId = $(this).data('id');
            var productType = $(this).data('type');
            $.ajax({
                url: "{{ route('addToCart') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId,
                    product_type: productType
                },
                success: function(response) {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    alert("Đã có lỗi xảy ra: " + xhr.responseText);
                }
            });
        });
    </script>

    <script>
        $('#bookingServiceForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('placeServiceBooking') }}",
                method: "POST",
                data: $(this).serialize() + '&_token={{ csrf_token() }}',
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        $('#bookingServiceModal').modal('hide');
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    alert("Đã có lỗi xảy ra: " + xhr.responseText);
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '.open-booking-modal', function(e) {
            e.preventDefault();
            const serviceId = $(this).data('id');
            const serviceName = $(this).data('name');
            $('#serviceId').val(serviceId);
            $('#serviceName').val(serviceName);
            $('#bookingServiceModal').modal('show');
        });
    </script>

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
