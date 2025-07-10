<!DOCTYPE html>
<html lang="en">

<head>
    <title>PET SHOP</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Roboto:wght@700&display=swap" rel="stylesheet">
    <!-- Icon Font Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>
        .product-price .original-price {
            text-decoration: line-through;
            color: #888;
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .product-price .discounted-price {
            color: #e74c3c;
            font-weight: bold;
            font-size: 1.3rem;
        }

        :root {
            --primary-color: #51D5CB;
            --secondary-color: #F2F8F8;
            --text-color: #444444;
            --shadow-color: rgba(0, 0, 0, 0.1);
            --accent-color: #FF6B6B;
            --border-radius: 12px;
        }

        body {
            background-color: var(--secondary-color);
            color: var(--text-color);
            font-family: 'Poppins', sans-serif;
        }

        #product-list {
            cursor: pointer;
        }

        /* Filter Section Styles */
        .filter-section {
            background: linear-gradient(to bottom, #ffffff, #f8f9fa);
            padding: 25px;
            border-radius: var(--border-radius);
            box-shadow: 0 8px 20px var(--shadow-color);
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }

        .filter-section:hover {
            transform: translateY(-5px);
        }

        .filter-section h4 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--primary-color);
            position: relative;
        }

        .filter-section h4::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 50px;
            height: 2px;
            background-color: var(--accent-color);
        }

        .filter-option {
            margin: 12px 0;
            display: flex;
            align-items: center;
            padding: 8px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .loading-spinner {
            display: inline-block;
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .filter-option:hover {
            background-color: var(--secondary-color);
        }

        .filter-option input[type="radio"],
        .filter-option input[type="checkbox"] {
            margin-right: 12px;
            cursor: pointer;
            width: 18px;
            height: 18px;
            accent-color: var(--primary-color);
        }

        .filter-option label {
            cursor: pointer;
            font-size: 0.95rem;
            margin-bottom: 0;
            color: var(--text-color);
        }

        .btn-filter {
            background: linear-gradient(135deg, var(--primary-color), #45C1B8);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(81, 213, 203, 0.3);
        }

        .btn-filter:hover {
            background: linear-gradient(135deg, #45C1B8, var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(81, 213, 203, 0.4);
        }

        /* Product Grid Styles */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            padding: 15px;
        }

        .product-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 8px 20px var(--shadow-color);
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            flex-direction: column;
            text-decoration: none;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 30px var(--shadow-color);
        }

        .product-image {
            padding-top: 75%;
            position: relative;
            overflow: hidden;
            background: linear-gradient(45deg, #f3f4f6, #ffffff);
        }

        .product-image img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.1);
        }

        .product-details {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .product-price {
            font-size: 1.25rem;
            color: var(--primary-color);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .product-price::before {
            content: '₫';
            font-size: 0.9em;
        }

        /* Pagination Styles */
        .pagination-container {
            margin-top: 40px;
            padding: 20px 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .pagination {
            display: inline-flex;
            gap: 8px;
        }

        .page-link {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: white;
            color: var(--text-color);
            border: 2px solid var(--primary-color);
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .page-item.active .page-link,
        .page-link:hover {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .page-item.disabled .page-link {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            color: #6c757d;
            pointer-events: none;
        }

        .product-card {
            position: relative;
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 8px 20px var(--shadow-color);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product-card a {
            text-decoration: none;
            color: inherit;
        }

        .add-to-cart {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 40px;
            height: 40px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .search-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            position: relative;
        }

        #search-input {
            flex-grow: 1;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 1rem;
            color: var(--text-color);
            background-color: #f9f9f9;
            transition: box-shadow 0.3s ease;
            width: 702%;
        }

        #search-input:focus {
            box-shadow: 0 0 5px var(--primary-color);
            outline: none;
        }

        #search-button {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            padding: 10px 15px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        #search-button:hover {
            background-color: #45C1B8;
            transform: translateY(-2px);
        }

        #search-button i {
            margin-right: 5px;
        }

        .add-to-cart i {
            font-size: 1.2rem;
            color: #51D5CB;
        }

        .add-to-cart:hover {
            background-color: #51D5CB;
        }

        .add-to-cart:hover i {
            color: white;
        }

        .product-image {
            position: relative;
            background: linear-gradient(45deg, #f3f4f6, #ffffff);
            padding-top: 75%;
            overflow: hidden;
        }

        .product-image img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .filter-section {
                margin-bottom: 20px;
            }

            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
                gap: 20px;
            }

            .product-details {
                padding: 15px;
            }

            .page-link {
                width: 35px;
                height: 35px;
            }
        }

        @media (max-width: 576px) {
            .product-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar Start -->
    @include('partials._navbar', ['user_id' => session('user_id')])
    <!-- Navbar End -->


    <div class="container-fluid py-5">
        <div class="container">
            <div class="search-bar mb-4">
                <input type="text" id="search-input" class="form-control" placeholder="Tìm kiếm sản phẩm...">
                <button id="search-button" class="btn btn-primary mt-2 w-100">
                    <i class="bi bi-search me-2"></i>Tìm kiếm
                </button>
            </div>
            <div class="row">
                <!-- Filter Section -->
                <div class="col-lg-3">
                    <div class="filter-section">
                        <h4>BỘ LỌC TÌM KIẾM</h4>

                        <div class="mb-4">
                            <h5 class="mb-3">Loại hình</h5>
                            <div class="filter-option">
                                <input type="radio" name="type" value="vat_tu" id="vat-tu">
                                <label for="vat-tu">Vật tư</label>
                            </div>
                            <div class="filter-option">
                                <input type="radio" name="type" value="dich_vu" id="dich-vu">
                                <label for="dich-vu">Dịch vụ</label>
                            </div>
                        </div>

                        <div id="category-list">
                        </div>

                        <button id="apply-filter" class="btn-filter w-100 mt-4">
                            <i class="bi bi-funnel-fill me-2"></i>
                            ÁP DỤNG
                        </button>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="col-lg-9">
                    <div id="product-list" class="product-grid">
                        @if ($vattu->count() > 0)
                            @foreach ($vattu as $item)
                                <div class="product-card">
                                    <a href="{{ route('detailserviceproduct', ['id' => $item->type === 'vat_tu' ? $item->MaVatTu : $item->MaDichVu]) }}?type={{ $item->type }}">
                                        <div class="product-image">
                                            <img src="{{ $item->type === 'vat_tu'
                                            ? ($item->HinhAnh 
                                                ? $item->HinhAnh 
                                                : asset('Image/img_product/default.jpg'))
                                            : ($item->HinhAnh 
                                                ? $item->HinhAnh 
                                                : asset('Image/img_service/default.jpg')) }}"
                                 alt="{{ $item->TenVatTu ?? $item->TenDichVu }}" class="img-fluid">
                            
                                        </div>
                                        <div class="product-details">
                                            <div class="product-name">
                                                {{ $item->TenVatTu ?? $item->TenDichVu }}
                                            </div>
                                            <div class="product-price">
                                                @if ($item->GiaSauGiam < $item->DonGiaBan)
                                                    <span class="original-price">
                                                        {{ number_format($item->DonGiaBan, 0, ',', '.') }} đ
                                                    </span>
                                                    <span class="discounted-price">
                                                        {{ number_format($item->GiaSauGiam, 0, ',', '.') }} đ
                                                    </span>
                                                @else
                                                    <span class="discounted-price">
                                                        {{ number_format($item->GiaSauGiam, 0, ',', '.') }} đ
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="add-to-cart">
                                        <i class="bi bi-cart-plus-fill"></i>
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center w-100">Không có sản phẩm hoặc dịch vụ nào.</p>
                        @endif
                    </div>
                    


                <!-- Pagination Controls -->
                <div class="pagination-container">
                    <div class="d-flex justify-content-center align-items-center">
                        <nav>
                            <ul class="pagination">
                                <li class="page-item {{ $vattu->currentPage() == 1 ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $vattu->previousPageUrl() }}">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $vattu->lastPage(); $i++)
                                    <li class="page-item {{ $vattu->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $vattu->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li
                                    class="page-item {{ $vattu->currentPage() == $vattu->lastPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $vattu->nextPageUrl() }}">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    @include('partials.footer')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <script>
        // Xử lý sự kiện khi nhấn nút "ÁP DỤNG"
        document.getElementById('apply-filter').addEventListener('click', function() {
            loadProducts(1); // Load trang đầu tiên khi áp dụng bộ lọc
        });

        function loadProducts(page) {
            let selectedType = document.querySelector('input[name="type"]:checked') 
                ? document.querySelector('input[name="type"]:checked').value 
                : null;
            let selectedCategories = [];
            console.log(selectedType);

            // Lấy các category đã được chọn
            document.querySelectorAll('.category-checkbox:checked').forEach(function(checkbox) {
                selectedCategories.push(checkbox.value);
            });

            $.ajax({
                url: '{{ route('filter') }}',  // Đường dẫn đến route filter
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    type: selectedType,
                    categories: selectedCategories,
                    page: page
                },
                success: function(response) {
                    let productList = document.getElementById('product-list');
                    productList.innerHTML = ''; // Xóa các sản phẩm cũ
                    console.log(response);

                    response.data.forEach(function(item) {
                        // Xây dựng URL cho từng sản phẩm, sử dụng tham số id và type
                        let productUrl = `{{ route('detailserviceproduct', ['id' => '__id__']) }}?type=__type__`;
                        productUrl = productUrl.replace('__id__', item.MaVatTu || item.MaDichVu)
                                                .replace('__type__', item.type);
                        // Kiểm tra hình ảnh tồn tại cho vật tư hoặc dịch vụ
                        let imageUrl = selectedType === 'vat_tu'
                            ? (item.HinhAnh 
                                ? item.HinhAnh  // Use the URL directly if HinhAnh is provided
                                : '/Image/img_product/default.jpg')  // Fallback to default image URL if no HinhAnh
                            : (item.HinhAnh 
                                ? item.HinhAnh  // Use the URL directly if HinhAnh is provided
                                : '/Image/img_service/default.jpg');  // Fallback to default image URL if no HinhAnh


                        // Xây dựng HTML cho sản phẩm
                        let productCard = `
                            <div class="product-card">
                                <a href="${productUrl}">
                                    <div class="product-image">
                                        <img src="${imageUrl}" alt="${item.TenVatTu || item.TenDichVu}" class="img-fluid">
                                    </div>
                                    <div class="product-details">
                                        <div class="product-name">${item.TenVatTu || item.TenDichVu}</div>
                                        <div class="product-price">
                                            ${item.GiaSauGiam < item.DonGiaBan 
                                                ? `<span class="original-price">${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(item.DonGiaBan)}</span>
                                                <span class="discounted-price">${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(item.GiaSauGiam)}</span>`
                                                : `<span class="discounted-price">${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(item.GiaSauGiam)}</span>`
                                            }
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="add-to-cart">
                                    <i class="bi bi-cart-plus-fill"></i>
                                </a>
                            </div>
                        `;

                        productList.innerHTML += productCard;
                    });

                    // Cập nhật phân trang nếu cần
                    updatePagination(response.pagination);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText); // In chi tiết lỗi từ server
                    let productList = document.getElementById('product-list');
                    productList.innerHTML = '<p class="text-center text-danger">Có lỗi xảy ra khi lọc dữ liệu. Vui lòng thử lại sau.</p>';
                }
            });
        }
        function fileExists(url) {
            let xhr = new XMLHttpRequest();
            xhr.open('HEAD', url, false);
            xhr.send();
            return xhr.status !== 404;
        }
        function updatePagination(pagination) {
            let paginationContainer = document.querySelector('.pagination-container');
            let html = `
                <div class="d-flex justify-content-between align-items-center">
                    <div class="showing-results">
                        Hiển thị ${pagination.from}-${pagination.to} của ${pagination.total} sản phẩm
                    </div>
                    <nav>
                        <ul class="pagination">
            `;

            // Previous page
            html += `
                <li class="page-item ${pagination.current_page === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="loadProducts(${pagination.current_page - 1}); return false;">
                        &laquo;
                    </a>
                </li>
            `;

            // Page numbers
            for (let i = 1; i <= pagination.last_page; i++) {
                html += `
                    <li class="page-item ${pagination.current_page === i ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="loadProducts(${i}); return false;">
                            ${i}
                        </a>
                    </li>
                `;
            }

            // Next page
            html += `
                <li class="page-item ${pagination.current_page === pagination.last_page ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="loadProducts(${pagination.current_page + 1}); return false;">
                        &raquo;
                    </a>
                </li>
            `;

            // Kết thúc danh sách phân trang và các thành phần phân trang
            html += `
                        </ul>
                    </nav>
                </div>
            </div>
            `;

            paginationContainer.innerHTML = html;
        }

        // Lắng nghe sự kiện chọn Vật tư hoặc Dịch vụ
        document.querySelectorAll('input[name="type"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                let vatTuSection = document.getElementById('category-vat-tu');
                let dichVuSection = document.getElementById('category-dich-vu');

                if (this.value === 'vat_tu') {
                    vatTuSection.style.display = 'block';
                    dichVuSection.style.display = 'none';
                } else if (this.value === 'dich_vu') {
                    vatTuSection.style.display = 'none';
                    dichVuSection.style.display = 'block';
                }
            });
        });
        $(document).ready(function() {
            // Lắng nghe sự kiện thay đổi loại hình (Vật tư hoặc Dịch vụ)

            document.querySelectorAll('input[name="type"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    let selectedType = this.value;

                    // Gửi yêu cầu AJAX đến server để lấy danh mục
                    $.ajax({
                        url: '{{ route('get-categories') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            type: selectedType
                        },
                        success: function(response) {
                            // Xóa danh sách category cũ
                            let categorySection = document.getElementById(
                                'category-list');
                            categorySection.innerHTML = '';

                            // Thêm danh mục mới vào giao diện
                            response.forEach(function(category) {
                                let categoryHtml;

                                // Kiểm tra loại dữ liệu để hiển thị đúng thuộc tính
                                if (selectedType === 'vat_tu') {
                                    categoryHtml = `<div class="filter-option">
                                                        <input type="checkbox" class="category-checkbox" value="${category.MaLoaiVatTu}" id="category-${category.MaLoaiVatTu}">
                                                        <label for="category-${category.MaLoaiVatTu}">${category.TenLoaiVatTu}</label>
                                                    </div>`;
                                } else if (selectedType === 'dich_vu') {
                                    categoryHtml = `<div class="filter-option">
                                                        <input type="checkbox" class="category-checkbox" value="${category.MaLoaiDichVu}" id="category-${category.MaLoaiDichVu}">
                                                        <label for="category-${category.MaLoaiDichVu}">${category.TenLoaiDichVu}</label>
                                                    </div>`;
                                }

                                categorySection.innerHTML += categoryHtml;
                            });
                        }
                    });
                });
            });
        });
        // Thêm vào phần script của bạn
        $(document).ready(function() {
    // Xử lý sự kiện khi nhấn nút tìm kiếm
    $('#search-button').click(function() {
        performSearch();
    });

    // Xử lý sự kiện khi nhấn Enter trong ô tìm kiếm
    $('#search-input').keypress(function(e) {
        if (e.which == 13) { // Enter key
            performSearch();
        }
    });

    function performSearch() {
        let keyword = $('#search-input').val();

        if (keyword.trim() === '') {
            return; // Không tìm kiếm nếu từ khóa trống
        }

        $.ajax({
            url: '{{ route('search') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                keyword: keyword
            },
            beforeSend: function() {
                // Có thể thêm loading spinner ở đây
                $('#product-list').html('<div class="text-center">Đang tìm kiếm...</div>');
            },
            success: function(response) {
                let productList = $('#product-list');
                productList.empty();
                console.log(response)
                if (response.data.length === 0) {
                    productList.html('<p class="text-center">Không tìm thấy sản phẩm nào phù hợp.</p>');
                    return;
                }

                // Hiển thị kết quả tìm kiếm
                response.data.forEach(function(item) {
                    let detailUrl = `/detailserviceproduct/${item.MaVatTu || item.MaDichVu}?type=${item.type}`;
                    
                    // Xử lý giá hiển thị
                    let originalPrice = item.DonGiaBan || item.DonGia || 0; // Giá gốc
                    let discountedPrice = item.GiaSauGiam || originalPrice; // Giá sau giảm (nếu có)

                    // Chuyển đổi giá thành số và định dạng lại
                    let originalPriceFormatted = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(originalPrice);
                    let discountedPriceFormatted = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(discountedPrice);

                    // Xây dựng HTML cho sản phẩm
                    let productCard = `
                        <div class="product-card">
                            <a href="${detailUrl}">
                                <div class="product-image">
                                    <img src="${item.HinhAnh || '/Image/img_product/default.jpg'}" alt="${item.TenVatTu || item.TenDichVu}">
                                </div>
                                <div class="product-details">
                                    <div class="product-name">${item.TenVatTu || item.TenDichVu}</div>
                                    <div class="product-price">
                                        ${discountedPrice < originalPrice
                                            ? `<span class="original-price">${originalPriceFormatted}</span>
                                               <span class="discounted-price">${discountedPriceFormatted}</span>`
                                            : `<span class="discounted-price">${discountedPriceFormatted}</span>`
                                        }
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="add-to-cart">
                                <i class="bi bi-cart-plus-fill"></i>
                            </a>
                        </div>
                    `;
                    productList.append(productCard);
                });

                // Ẩn phân trang khi hiển thị kết quả tìm kiếm
                $('.pagination-container').hide();
            },
            error: function() {
                $('#product-list').html('<p class="text-center text-danger">Có lỗi xảy ra khi tìm kiếm. Vui lòng thử lại sau.</p>');
            }
        });
    }

    // Thêm nút "Xóa tìm kiếm" để quay lại danh sách ban đầu
    let clearButton = $('<button>', {
        class: 'btn btn-outline-secondary mt-2 w-100',
        text: 'Xóa tìm kiếm'
    }).insertAfter('#search-button');

    clearButton.click(function() {
        $('#search-input').val('');
        // Tải lại trang để hiển thị danh sách ban đầu
        location.reload();
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
