{{-- resources/views/detailproduct.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $type == 'vat_tu' ? $product->TenVatTu : $product->TenDichVu }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Roboto:wght@700&display=swap" rel="stylesheet">

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
        /* Giá ban đầu (gạch ngang và màu xám) */
.price-old {
    text-decoration: line-through; /* Gạch ngang */
    color: #6c757d; /* Màu xám */
    font-size: 1.25rem; /* Kích thước chữ */
}

/* Giá sau khi giảm (màu đỏ và đậm) */
.price-new {
    color: #e74c3c; /* Màu đỏ */
    font-weight: bold; /* Chữ đậm */
    font-size: 1.5rem; /* Kích thước chữ lớn hơn */
}

/* Khoảng cách giữa giá cũ và giá mới */
.price-wrapper {
    display: flex; /* Sắp xếp theo dạng dòng ngang */
    align-items: center; /* Căn giữa các phần tử */
    gap: 10px; /* Khoảng cách giữa giá cũ và giá mới */
}

/* Dấu "đ" cuối cùng */
.price-suffix {
    font-size: 1.25rem; /* Kích thước chữ */
}

    </style>
</head>

<body class="bg-gray-50">
    @include('partials._navbar', ['user_id' => session('user_id')])
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Product Image -->
                <div class="relative">
                    <img src="{{ $type == 'vat_tu' 
                                ? $product->HinhAnh 
                                : $product->HinhAnh }}" 
                    alt="{{ $type == 'vat_tu' ? $product->TenVatTu : $product->TenDichVu }}" 
                    class="w-full rounded-lg object-cover aspect-square">
                
                </div>

                <!-- Product Details -->
                <div class="flex flex-col">
                    <h1 class="text-3xl font-bold text-gray-900" style="margin-bottom: 10px">
                        {{ $type == 'vat_tu' ? $product->TenVatTu : $product->TenDichVu }}
                    </h1>
                    <div class="flex items-center space-x-4 text-gray-600" style="margin-bottom: 10px">
                        <span>Thương hiệu: </span>
                        <span class="border-l pl-4">
                            Tình trạng:
                            @if ($type == 'vat_tu')
                                @if ($stock > 0)
                                    <span class="text-green-600">Còn hàng ({{ $stock }})</span>
                                @else
                                    <span class="text-red-600">Hết hàng</span>
                                @endif
                            @else
                                <span class="text-blue-600">Có thể đặt</span>
                            @endif
                            
                        </span>
                    </div>

                    <div class="text-2xl font-bold text-primary" style="margin-bottom: 10px">
                        @if (isset($product->GiaSauGiam) && $product->GiaSauGiam < ($type == 'vat_tu' ? $product->DonGiaBan : $product->DonGia))
                            <span class="line-through text-gray-500">
                                {{ number_format($type == 'vat_tu' ? $product->DonGiaBan : $product->DonGia, 0, ',', '.') }}đ
                            </span>
                            <span class="text-red-600 font-bold ml-2">
                                {{ number_format($product->GiaSauGiam, 0, ',', '.') }}đ
                            </span>
                        @else
                            {{ number_format($type == 'vat_tu' ? $product->DonGiaBan : $product->DonGia, 0, ',', '.') }}đ
                        @endif
                    </div>
                    

                    <div class="flex items-center space-x-4" style="margin-bottom: 25px">
                        <span class="text-gray-700">Số lượng:</span>
                        <div class="flex items-center border rounded-md">
                            <button class="px-4 py-2 border-r hover:bg-gray-100" onclick="updateQuantity(-1)">-</button>
                            <input type="number" id="quantity" value="1"
                                class="w-20 text-center py-2 border-none focus:ring-0" min="1"
                                @if ($type == 'vat_tu' && $stock) max="{{ $stock }}" @endif>
                            <button class="px-4 py-2 border-l hover:bg-gray-100"
                                onclick="updateQuantity(1)">+</button>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <!-- Nút thêm vào giỏ hàng -->
                        @if ($type == 'vat_tu')
                            <button id="add-to-cart"
                                class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary-dark">
                                THÊM VÀO GIỎ HÀNG
                            </button>
                            <!-- Nút thanh toán -->
                            <button id="checkout"
                                class="bg-secondary text-white px-6 py-3 rounded-lg hover:bg-secondary-dark">
                                THANH TOÁN
                            </button>
                        @else
                            <a class="btn btn-primary py-2 px-3 open-booking-modal"
                                data-id="{{ $product->MaDichVu }}" data-name="{{ $product->TenDichVu }}"
                                href="javascript:void(0);">
                                <i class="bi bi-cart"></i> THÊM VÀO GIỎ HÀNG
                            </a>
                            <a class="btn btn-primary py-2 px-3 open-booking-modal"
                            data-id="{{ $product->MaDichVu }}" data-name="{{ $product->TenDichVu }}"
                            href="javascript:void(0);">
                            <i class="bi bi-cart"></i> THANH TOÁN
                        </a>
                        @endif   
                        
                    </div>
                    <div class="modal fade" id="bookingServiceModal" tabindex="-1" aria-labelledby="bookingServiceModalLabel" aria-hidden="true">
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
                    <!-- Benefits -->
                    <div class="mt-8 border rounded-lg p-4">
                        <h3 class="text-lg font-semibold mb-4">Duy nhất tại PetShop</h3>
                        <ul class="space-y-4">
                            <li class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Giao hàng miễn phí cho đơn từ 499k</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Giao hàng nhanh trong 2h</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Tích điểm với mọi sản phẩm</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01">
                                    </path>
                                </svg>
                                <span>Sản phẩm chất lượng cao cho thú cưng</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
            <div class="mt-8">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                        <button class="border-b-2 border-green-500 py-4 px-1 text-sm font-medium text-green-600">
                            Mô tả sản phẩm
                        </button>
                    </nav>
                </div>

                <div class="py-6 prose max-w-none">
                    <!-- Mô tả sản phẩm -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Thông tin chi tiết</h3>
                        <div class="text-gray-600 space-y-4">
                            <p>{{ $product->MoTa ?? 'Đang cập nhật...' }}</p>
                        </div>
                    </div>

                    <!-- Thông tin thêm về cửa hàng -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Về PetShop của chúng tôi</h3>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-medium text-green-600 mb-2">Cam kết chất lượng</h4>
                                <ul class="list-disc list-inside space-y-2 text-gray-600">
                                    <li>100% sản phẩm chính hãng, có giấy tờ nguồn gốc rõ ràng</li>
                                    <li>Kiểm tra kỹ lưỡng về chất lượng và date sản phẩm</li>
                                    <li>Đổi trả miễn phí nếu có vấn đề về chất lượng</li>
                                    <li>Tư vấn chuyên sâu bởi đội ngũ bác sĩ thú y</li>
                                </ul>
                            </div>

                            <div>
                                <h4 class="font-medium text-green-600 mb-2">Dịch vụ khách hàng</h4>
                                <ul class="list-disc list-inside space-y-2 text-gray-600">
                                    <li>Tư vấn miễn phí 24/7 qua hotline</li>
                                    <li>Giao hàng nhanh trong 2h trong nội thành</li>
                                    <li>Đổi trả dễ dàng trong 7 ngày</li>
                                    <li>Tích điểm và ưu đãi cho khách hàng thân thiết</li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h4 class="font-medium text-green-600 mb-2">Chính sách bán hàng</h4>
                            <div class="text-gray-600 space-y-2">
                                <p>✓ Cam kết giá tốt nhất thị trường</p>
                                <p>✓ Miễn phí vận chuyển cho đơn hàng từ 499k</p>
                                <p>✓ Chiết khấu hấp dẫn cho đơn hàng số lượng lớn</p>
                                <p>✓ Tích điểm 5% giá trị đơn hàng để mua sắm lần sau</p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h4 class="font-medium text-green-600 mb-2">Thông tin hữu ích</h4>
                            <div class="text-gray-600 space-y-2">
                                <p>🏥 Đội ngũ bác sĩ thú y giàu kinh nghiệm luôn sẵn sàng tư vấn</p>
                                <p>📱 Theo dõi chúng tôi trên mạng xã hội để cập nhật tin tức mới nhất</p>
                                <p>📧 Đăng ký newsletter để nhận thông tin khuyến mãi sớm nhất</p>
                            </div>
                        </div>
                    </div>

                    <!-- Hướng dẫn sử dụng -->
                    @if ($type == 'vat_tu')
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold mb-4">Hướng dẫn sử dụng</h3>
                            <div class="bg-blue-50 p-6 rounded-lg text-gray-600 space-y-4">
                                <div class="flex items-start space-x-3">
                                    <svg class="w-6 h-6 text-blue-500 mt-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-medium">Liều lượng và cách dùng:</p>
                                        <p>Tham khảo ý kiến bác sĩ thú y để được tư vấn liều lượng phù hợp cho thú cưng
                                            của bạn.</p>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-3">
                                    <svg class="w-6 h-6 text-blue-500 mt-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    <div>
                                        <p class="font-medium">Lưu ý quan trọng:</p>
                                        <ul class="list-disc list-inside">
                                            <li>Bảo quản sản phẩm ở nơi khô ráo, thoáng mát</li>
                                            <li>Để xa tầm tay trẻ em</li>
                                            <li>Kiểm tra kỹ hạn sử dụng trước khi dùng</li>
                                            <li>Ngưng sử dụng nếu thấy thú cưng có dấu hiệu bất thường</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('partials.footer')


    <script src="{{ asset('admin/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/bootstrap.min.js') }}"></script>
    <script>
        // Quantity selector functionality
        function updateQuantity(change) {
            const input = document.getElementById('quantity');
            const newValue = parseInt(input.value) + change;
            const max = input.hasAttribute('max') ? parseInt(input.getAttribute('max')) : Infinity;

            if (newValue >= 1 && newValue <= max) {
                input.value = newValue;
            }
        }

        $(document).on('click', '.open-booking-modal', function(e) {
            e.preventDefault();
            const serviceId = $(this).data('id');
            const serviceName = $(this).data('name');
            $('#serviceId').val(serviceId);
            $('#serviceName').val(serviceName);
            $('#bookingServiceModal').modal('show');
        });
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
        const productId = '{{ $type == 'vat_tu' ? $product->MaVatTu : $product->MaDichVu }}';
        const productType = '{{ $type }}';

        // Xử lý thêm vào giỏ hàng
        document.getElementById('add-to-cart').addEventListener('click', function() {
            if (productType === 'dich_vu') {
                // Chuyển hướng đến bookingService nếu là dịch vụ
                window.location.href = '{{ route('bookingService.create') }}';
            } else {
                // Nếu là sản phẩm, thêm vào giỏ hàng
                fetch('{{ route('addToCart') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            alert(data.message); // Thông báo thành công khi thêm vào giỏ hàng
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });

        // Xử lý thanh toán
        document.getElementById('checkout').addEventListener('click', function() {
            fetch('{{ route('checkout') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productType === 'vat_tu' ? productId : null,
                        service_id: productType === 'dich_vu' ? productId : null
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.redirect) {
                        window.location.href = data
                            .redirect; // Chuyển hướng tới trang giỏ hàng hoặc bookingService
                    }
                })
                .catch(error => console.error('Error:', error));
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
