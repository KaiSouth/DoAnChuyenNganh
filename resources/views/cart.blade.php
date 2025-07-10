<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PET SHOP - Giỏ hàng</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta content="width=device-width, initial-scale=1.0" name="viewport">

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


    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase">Giỏ hàng</h6>
                <h1 class="display-5 text-uppercase mb-0">Sản phẩm trong giỏ hàng của bạn</h1>
            </div>
            <!-- Nút Xóa Tất Cả -->
            <div class="d-flex justify-content-between mb-4">
                <h5 class="text-uppercase mb-0">Sản phẩm trong giỏ hàng của bạn</h5>
                <button class="btn btn-danger delete-all">Xóa tất cả</button>
            </div>
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <!-- Tiêu đề các cột -->
                        <div class="row align-items-center mb-4 pb-2 border-bottom">
                            <div class="col-md-5">
                                <h5 class="text-uppercase mb-0">Sản phẩm/Dịch vụ</h5>
                            </div>
                            <div class="col-md-2 text-center">
                                <h5 class="text-uppercase mb-0">Giá</h5>
                            </div>
                            <div class="col-md-2 text-center">
                                <h5 class="text-uppercase mb-0">Số lượng</h5>
                            </div>
                            <div class="col-md-2 text-center">
                                <h5 class="text-uppercase mb-0">Tổng</h5>
                            </div>
                            <div class="col-md-1 text-center">
                                <h5 class="text-uppercase mb-0">Xóa</h5>
                            </div>
                        </div>
                        @foreach ($cartItems as $item)
                            @if ($item['type'] === 'product')
                                <!-- Hiển thị sản phẩm -->
                                <div class="row align-items-center mb-4 pb-2 border-bottom">
                                    <div class="col-md-5 d-flex align-items-center">
                                        <div>
                                            <h6 class="text-uppercase mb-1">{{ $item['name'] }}</h6>
                                            <span class="text-muted">Loại: Sản phẩm</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        @if ($item['discountPercent'] > 0)
                                            <span class="text-muted text-decoration-line-through">
                                                {{ number_format($item['originalPrice'], 0, ',', '.') }}đ
                                            </span><br>
                                            <span class="text-danger">-{{ $item['discountPercent'] }}%</span><br>
                                            <span>{{ number_format($item['discountedPrice'], 0, ',', '.') }}đ</span>
                                        @else
                                            <span>{{ number_format($item['originalPrice'], 0, ',', '.') }}đ</span>
                                        @endif
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <input type="number" class="form-control text-center quantity-input"
                                            data-id="{{ $item['id'] }}" value="{{ $item['quantity'] }}"
                                            min="1">
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <span
                                            id="item-total-{{ $item['id'] }}">{{ number_format($item['discountedPrice'] * $item['quantity'], 0, ',', '.') }}đ</span>
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <button class="btn btn-danger btn-sm delete-item"
                                            data-id="{{ $item['id'] }}" data-type="product">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @elseif ($item['type'] === 'service')
                                <!-- Hiển thị dịch vụ -->
                                <div class="row align-items-center mb-4 pb-2 border-bottom">
                                    <div class="col-md-5 d-flex align-items-center">
                                        <div>
                                            <h6 class="text-uppercase mb-1">{{ $item['name'] }}</h6>
                                            <span class="text-muted">Loại: Dịch vụ - Thú cưng:
                                                {{ $item['pet_name'] }}</span><br>
                                            <span class="text-muted">Ngày: {{ $item['date'] }} - Giờ:
                                                {{ $item['time'] }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        @if ($item['discountPercent'] > 0)
                                            <span class="text-muted text-decoration-line-through">
                                                {{ number_format($item['originalPrice'], 0, ',', '.') }}đ
                                            </span><br>
                                            <span class="text-danger">-{{ $item['discountPercent'] }}%</span><br>
                                            <span>{{ number_format($item['discountedPrice'], 0, ',', '.') }}đ</span>
                                        @else
                                            <span>{{ number_format($item['originalPrice'], 0, ',', '.') }}đ</span>
                                        @endif
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <span>1</span>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <span>{{ number_format($item['discountedPrice'], 0, ',', '.') }}đ</span>
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <button class="btn btn-danger btn-sm delete-item"
                                            data-id="{{ $item['id'] }}" data-type="service">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @elseif ($item['type'] === 'appointment')
                                <!-- Hiển thị lịch khám -->
                                <div class="row align-items-center mb-4 pb-2 border-bottom">
                                    <div class="col-md-5 d-flex align-items-center">
                                        <div>
                                            <h6 class="text-uppercase mb-1">{{ $item['name'] }}</h6>
                                            <span class="text-muted">Loại: Lịch khám - Thú cưng:
                                                {{ $item['pet_name'] }}</span><br>
                                            <span class="text-muted">Bác sĩ: {{ $item['doctor_name'] }}</span><br>
                                            <span class="text-muted">Ngày: {{ $item['date'] }} - Giờ:
                                                {{ $item['time'] }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <span>{{ number_format($item['price'], 0, ',', '.') }}đ</span>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <span>1</span>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <span>{{ number_format($item['price'], 0, ',', '.') }}đ</span>
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <button class="btn btn-danger btn-sm delete-item"
                                            data-id="{{$item['id']}}" data-type="appointment">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <!-- Tổng giỏ hàng -->
                <div class="col-lg-4">
                    <div class="bg-light p-4 mb-4">
                        <h5 class="text-uppercase mb-3">Tổng giỏ hàng</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="text-uppercase">Tổng tiền hàng</h6>
                            <h6 id="totalProductAmount">{{ number_format($totalProductAmount, 0, ',', '.') }}đ</h6>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="text-uppercase">Tổng tiền dịch vụ</h6>
                            <h6 id="totalServiceAmount">{{ number_format($totalServiceAmount, 0, ',', '.') }}đ</h6>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="text-uppercase">Tổng tiền khám</h6>
                            <h6 id="totalAppointmentAmount">{{ number_format($totalAppointmentAmount, 0, ',', '.') }}đ
                            </h6>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="text-uppercase">Phí vận chuyển</h6>
                            <h6 id="totalAppointmentAmount">{{ number_format($shippingFee, 0, ',', '.') }}đ
                            </h6>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="text-uppercase">Tổng cộng</h6>
                            <h6 id="totalWithShipping">{{ number_format($totalWithShipping, 0, ',', '.') }}đ</h6>
                        </div>
                        <button class="btn btn-primary w-100 py-3">
                            <a style="color:black" href="{{ route('payment') }}">Tiến hành thanh toán</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->


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
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const itemId = this.dataset.id;
                const newQuantity = parseInt(this.value);
                if (newQuantity < 1) {
                    alert('Số lượng phải lớn hơn hoặc bằng 1.');
                    this.value = 1;
                    return;
                }
                fetch(`/cart/update-quantity/${itemId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        quantity: newQuantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                    if (data.success) {
                        // Cập nhật lại UI sau khi thành công
                        document.querySelector(`#item-total-${itemId}`).innerText = data.itemTotal;
                        document.querySelector('#totalProductAmount').innerText = data.totalProductAmount;
                        document.querySelector('#totalServiceAmount').innerText = data.totalServiceAmount;
                        document.querySelector('#totalAppointmentAmount').innerText = data.totalAppointmentAmount;
                        document.querySelector('#totalWithShipping').innerText = data.totalWithShipping;
                    } else {
                        alert('Có lỗi xảy ra khi cập nhật số lượng.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi cập nhật số lượng.');
                });

            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Xoá từng mục
            $('.delete-item').on('click', function() {
                const itemId = $(this).data('id');
                const itemType = $(this).data('type');
                if (!itemId || !itemType) {
                    alert('Không thể xoá mục: Thiếu thông tin ID hoặc loại.');
                    return;
                }
                $.ajax({
                    url: "{{ route('cart.removeItem') }}",
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: itemId,
                        type: itemType
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Xoá mục không thành công: ' + (response.message ||
                                'Lỗi không xác định.'));
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Có lỗi xảy ra khi xoá mục.');
                    }
                });
            });
            // Xoá tất cả
            $('.delete-all').on('click', function() {
                $.ajax({
                    url: "{{ route('cart.clear') }}",
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Xoá tất cả không thành công.');
                        }
                    },
                    error: function() {
                        alert('Có lỗi xảy ra khi xoá tất cả.');
                    }
                });
            });
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
