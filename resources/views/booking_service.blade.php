<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>PET SHOP - Mẫu Website Cửa Hàng Thú Cưng</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Chăm sóc thú cưng chất lượng cao" name="keywords">
    <meta content="Cửa hàng cung cấp dịch vụ và sản phẩm chăm sóc thú cưng hàng đầu" name="description">

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

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 15px;
            border: 1px solid #dee2e6;
            text-decoration: none;
            color: #4DCAC1;
            border-radius: 5px;
            background-color: #f8f9fa;
            transition: background-color 0.2s, color 0.2s;
            margin: 0 5px;
        }

        .pagination-link.active {
            color: #fff;
            background-color: #4DCAC1;
        }

        .pagination-link:hover {
            background-color: #e0f7fa;
            color: #00796b;
        }
    </style>

<style>
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        list-style: none;
        padding: 0;
    }

    /* CSS cho icon x */
    #clear-search {
        cursor: pointer;
        background-color: #ff4d4d;
        color: white;
        border: none;
        position: absolute;
        right: 50px; /* Điều chỉnh vị trí */
        top: 50%;
        transform: translateY(-50%);
        border-radius: 50%;
        padding: 5px 8px;
        z-index: 1000; /* Đảm bảo icon luôn nổi lên trên */
    }
</style>
</head>

<body>
    <!-- Navbar Start -->
    @include('partials._navbar', ['user_id' => session('user_id')])
    <!-- Navbar End -->


    <!-- Booking Service start -->
    <div class="container my-5">
        <!-- Thông báo thành công hoặc lỗi -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <h2 class="text-center mb-4">Đặt Dịch Vụ Cho Thú Cưng</h2>
        <!-- Form Tìm kiếm -->
    <form method="GET" action="{{ route('bookingService.create') }}" class="mb-4">
        @csrf
        <div class="input-group" style="position: relative;">
            <input type="text" class="form-control" name="keyword" placeholder="Tìm kiếm dịch vụ..."
                value="{{ request('keyword') }}" style="border-radius: 30px 0 0 30px; padding-left: 30px;">
            @if (request('keyword'))
                <span class="input-group-text" id="clear-search" onclick="clearSearch()"
                    style="cursor: pointer; background-color: #ff4d4d; color: white; border: none;
                    position: absolute; right: 110px; top: 50%; transform: translateY(-50%); border-radius: 50%;
                    padding: 5px 8px; z-index: 1000;">
                    <i class="fas fa-times"></i>
                </span>
            @endif
            <button class="btn btn-primary" type="submit" style="border-radius: 0 30px 30px 0;">Tìm kiếm</button>
        </div>
    </form>
        <form id="bookingForm" method="POST">
            @csrf
            <!-- Chọn dịch vụ -->
            <div id="serviceList">
                @foreach ($dichvus as $dichvu)
                    <div>
                        <input type="checkbox" name="MaDichVu[]" value="{{ $dichvu->MaDichVu }}"
                            class="form-check-input" id="dichvu_{{ $dichvu->MaDichVu }}"
                            {{ in_array($dichvu->MaDichVu, $selectedServices) ? 'checked' : '' }}>
                        <label class="form-check-label" for="dichvu_{{ $dichvu->MaDichVu }}">
                            {{ $dichvu->TenDichVu }} - {{ number_format($dichvu->DonGia, 0, ',', '.') }} VND
                        </label>
                    </div>
                @endforeach
            </div>
            <!-- Phân trang -->
            <div id="paginationLinks">
                @include('bookingservice.pagination', [
                    'currentPage' => $currentPage,
                    'totalPages' => $totalPages,
                ])
            </div>
            <!-- Ngày -->
            <div class="mb-3">
                <label for="ngay" class="form-label">Ngày:</label>
                <input type="date" name="Ngay" id="ngay" class="form-control"
                    value="{{ request('Ngay') }}" required>
            </div>
            <!-- Giờ -->
            <div class="mb-3">
                <label for="gio" class="form-label">Giờ:</label>
                <input type="time" name="Gio" id="gio" class="form-control"
                    value="{{ request('Gio') }}" required>
            </div>
            <!-- Chọn thú cưng -->
            <div class="mb-3">
                <label for="thucung" class="form-label">Chọn thú cưng:</label>
                <select name="MaThuCung" id="thucung" class="form-select" required>
                    <option value="" disabled selected>Chọn thú cưng</option>
                    @foreach ($thucungs as $thucung)
                        <option value="{{ $thucung->MaThuCung }}"
                            {{ $thucung->MaThuCung == request('MaThuCung') ? 'selected' : '' }}>
                            {{ $thucung->TenThuCung }}
                        </option>
                    @endforeach
                </select>
            </div>
            <!-- Nút đặt dịch vụ -->
            <button type="submit" class="btn btn-primary w-100">Đặt dịch vụ</button>
        </form>
    </div>
    <!-- Booking Service End -->


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

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script>
        $(document).ready(function() {
            $(document).on('change', 'input[name="MaDichVu[]"]', function() {
                const selectedServices = $('input[name="MaDichVu[]"]:checked').map(function() {
                    return $(this).val();
                }).get();
                $.ajax({
                    url: '{{ route('saveSelectedServices') }}',
                    method: 'POST',
                    data: {
                        selectedServices: selectedServices,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Session updated:', response.data);
                    },
                    error: function(xhr) {
                        console.error('Failed to update session:', xhr.responseText);
                    }
                });
            });
            $(document).ready(function() {
                $(document).on('click', '.pagination-link', function(e) {
                    e.preventDefault();
                    const page = $(this).data('page');
                    const formData = $('#bookingForm').serialize();
                    $.ajax({
                        url: '{{ route('bookingService.create') }}',
                        method: 'GET',
                        data: formData + `&page=${page}`,
                        success: function(response) {
                            $('#serviceList').html(response.serviceListHTML);
                            $('#paginationLinks').html(response.paginationHTML);
                            $('.pagination-link').removeClass('active');
                            $(`.pagination-link[data-page="${page}"]`).addClass(
                                'active');
                        },
                        error: function(xhr) {
                            console.error('Failed to load services:', xhr.responseText);
                        }
                    });
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

    <script>
        function clearSearch() {
            document.querySelector('input[name="keyword"]').value = '';
            document.querySelector('form').submit();
        }
    </script>

    <script>
        function clearSearch() {
            window.location.href = "{{ route('bookingService.create') }}";
        }
    </script>

</body>

</html>
