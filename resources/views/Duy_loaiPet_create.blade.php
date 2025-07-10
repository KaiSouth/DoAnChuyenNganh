<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Thêm vào phần head của trang -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Quản Lý Giống Loài Thú Cưng</title>
    <link rel="stylesheet" href="{{asset('admin/assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/plugins.min.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/kaiadmin.min.css')}}" />
    <link rel="icon" href="{{ asset('admin/assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

    <script src="{{asset('admin/assets/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["{{asset('admin/assets/css/fonts.min.css')}}"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <style>
        :root {
            --sidebar-width: 250px;
            --header-height: 60px;
            --primary-color: #1572E8;
            --secondary-color: #6861CE;
            --success-color: #31CE36;
            --danger-color: #F25961;
        }

        body {
            background: #f4f6f9;
            font-family: 'Public Sans', sans-serif;
            margin: 0;
            min-height: 100vh;
        }

        /* Layout */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }


        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        .sidebar-brand {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-brand i {
            font-size: 24px;
            margin-right: 10px;
        }

        .sidebar-menu {
            padding: 15px 0;
        }

        .menu-header {
            color: #97a6b5;
            padding: 12px 20px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .nav-item {
            margin: 4px 15px;
        }

        .nav-link {
            padding: 12px 20px;
            color: #575962;
            display: flex;
            align-items: center;
            border-radius: 5px;
            transition: all 0.2s;
        }

        .nav-link:hover {
            background: #f4f5f7;
            color: var(--primary-color);
        }

        .nav-link i {
            font-size: 18px;
            margin-right: 10px;
        }

        .nav-link.active {
            background: var(--primary-color);
            color: #fff;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 30px;
        }

        /* Card Styles */
        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.03);
            margin-bottom: 30px;
        }

        .card-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            margin: 0;
            color: #575962;
            font-size: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .card-title i {
            margin-right: 10px;
            color: var(--primary-color);
        }

        .card-body {
            padding: 20px;
        }

        /* Form Styles */
        .form-group label {
            font-weight: 600;
            color: #575962;
            display: flex;
            align-items: center;
        }

        .form-group label i {
            margin-right: 8px;
            color: var(--primary-color);
        }

        .form-control {
            border: 1px solid #eee;
            border-radius: 5px;
            padding: 8px 12px;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(21,114,232,0.15);
        }

        /* Button Styles */
        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            transition: all 0.2s;
        }

        .btn-primary i {
            margin-right: 8px;
        }

        .btn-primary:hover {
            background: #1164cf;
            transform: translateY(-1px);
        }

        /* Table Styles */
        .table-responsive {
            margin-top: 20px;
        }

        .table {
            width: 100%;
            margin-bottom: 0;
        }

        .table thead th {
            border-top: none;
            border-bottom: 2px solid #eee;
            font-weight: 600;
            color: #575962;
            padding: 12px;
        }

        .table tbody td {
            padding: 12px;
            vertical-align: middle;
            border-top: 1px solid #eee;
        }

        .btn-delete {
            background: var(--danger-color);
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s;
        }

        .btn-delete i {
            margin-right: 5px;
        }

        .btn-delete:hover {
            background: #e84e55;
            transform: translateY(-1px);
        }

        /* Alert Styles */
        .alert {
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .alert i {
            margin-right: 10px;
            font-size: 18px;
        }

        .alert-success {
            background: #dff5e8;
            color: #1fa750;
            border: 1px solid #b6e6c9;
        }

        .alert-danger {
            background: #fee8e7;
            color: #f25961;
            border: 1px solid #fccac7;
        }
    </style>
</head>
<body>
      <!-- Sidebar -->
      <div class="sidebar">
            @include('partials.sidebar')
        </div>
    <div class="wrapper">
        <!-- Sidebar -->

        <!-- Main Content -->
        <div class="main-content">
            <!-- Form Card -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-plus-circle"></i>
                        Thêm Giống Loài Mới
                    </h4>
                </div>

                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('giong-loai.save') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="TenGiongLoai">
                                <i class="fas fa-tag"></i>
                                Tên Giống Loài
                            </label>
                            <input type="text" class="form-control" id="TenGiongLoai" name="TenGiongLoai"
                                   placeholder="Nhập tên giống loài" required>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Lưu Giống Loài
                        </button>
                    </form>
                </div>
            </div>

            <!-- Table Card -->
            <div class="card">
                <!-- Thêm vào phần card-header của Table Card -->
<div class="card-header">
    <h4 class="card-title">
        <i class="fas fa-list"></i>
        Danh Sách Giống Loài
    </h4>
    <div class="search-box">
        <div class="input-group">
            <input name="searchInput" type="text" class="form-control" id="searchInput"
                   placeholder="Tìm kiếm giống loài...">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button" id="searchBtn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên Giống Loài</th>
                                    <th>Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($giongLoaiList as $giongLoai)
                                    <tr>
                                        <td>{{ $giongLoai->MaGiongLoai }}</td>
                                        <td>{{ $giongLoai->TenGiongLoai }}</td>
                                        <td>
                                            <form action="{{ route('giong-loai.delete', $giongLoai->MaGiongLoai) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Bạn chắc chắn muốn xóa?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete">
                                                    <i class="fas fa-trash"></i>
                                                    Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Chưa có giống loài nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('admin/assets/js/core/jquery-3.7.1.min.js')}}"></script>
<script>
$(document).ready(function() {
    const searchInput = $('#searchInput');
    const searchBtn = $('#searchBtn');
    const tableBody = $('.table tbody');
    let searchTimeout;

    // Hàm tạo row HTML
    function createTableRow(item) {
        const csrf = $('meta[name="csrf-token"]').attr('content');
        return `
            <tr>
                <td>${item.MaGiongLoai}</td>
                <td>${item.TenGiongLoai}</td>
                <td>
                    <form action="/giong-loai/delete/${item.MaGiongLoai}"
                          method="POST"
                          onsubmit="return confirm('Bạn chắc chắn muốn xóa?');">
                        <input type="hidden" name="_token" value="${csrf}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn-delete">
                            <i class="fas fa-trash"></i>
                            Xóa
                        </button>
                    </form>
                </td>
            </tr>
        `;
    }

    // Hàm tìm kiếm
    function performSearch() {
        const searchValue = searchInput.val().trim();

        // Nếu ô tìm kiếm trống, giữ nguyên dữ liệu hiện tại
        if (searchValue === '') {
            return;
        }

        // Hiển thị loading
        tableBody.html('<tr><td colspan="3" class="text-center">Đang tìm kiếm...</td></tr>');

        // Gọi API search
        $.ajax({
            url: '{{ route("giong-loai.search") }}',
            method: 'GET',
            data: { search: searchValue },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                tableBody.empty();

                if (response.length === 0) {
                    tableBody.html('<tr><td colspan="3" class="text-center">Không tìm thấy kết quả</td></tr>');
                    return;
                }

                response.forEach(item => {
                    tableBody.append(createTableRow(item));
                });
            },
            error: function(xhr) {
                tableBody.html('<tr><td colspan="3" class="text-center text-danger">Có lỗi xảy ra khi tìm kiếm</td></tr>');
                console.error('Search error:', xhr.responseText);
            }
        });
    }

    // Xử lý sự kiện input với debounce
    searchInput.on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(performSearch, 300); // Debounce 300ms
    });

    // Xử lý sự kiện click nút tìm kiếm
    searchBtn.click(performSearch);

    // Xử lý sự kiện nhấn Enter
    searchInput.on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            performSearch();
        }
    });
});
</script>
    <script src="{{asset('admin/assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/core/bootstrap.min.js')}}"></script>
</body>
</html>
