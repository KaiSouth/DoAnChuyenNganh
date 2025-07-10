<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Nhân Viên</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}" />
    <link rel="icon" href="{{ asset('admin/assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('admin/assets/js/plugin/webfont/webfont.min.js') }}"></script>
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
                urls: ["{{ asset('admin/assets/css/fonts.min.css') }}"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <style>
        /* Sidebar styling */
        .sidebar .nav-item {
            margin-bottom: 15px;
        }

        .sidebar .nav-link {
            font-size: 16px;
            color: #333;
        }

        .sidebar .nav-link:hover {
            color: #007bff;
        }

        /* Content styling */
        .content {
            margin-left: 270px;
            padding: 20px;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
        }

        /* Form styling */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .btn {
            margin-right: 10px;
        }
    </style>
</head>

<body>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            @include('partials.sidebar') <!-- Sidebar content will be included here -->
        </div>

        <!-- Content -->
        <div class="content">
            <h1 class="my-4">Danh Sách Nhân Viên</h1>
            <a href="{{ route('admin.nhanvien.create') }}" class="btn btn-primary">Thêm Nhân Viên Mới</a>

            <form action="{{ route('admin.nhanvien.search') }}" method="GET" class="mt-3">
                <div class="input-group">
                    <input type="text" name="query" placeholder="Tìm kiếm nhân viên..." class="form-control" />
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary">Tìm kiếm</button>
                    </div>
                </div>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Tên Nhân Viên</th>
                        <th>Chức Vụ</th>
                        <th>Điện Thoại</th>
                        <th>Email</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($nhanViens as $nhanVien)
                    <tr>
                        <td>{{ $nhanVien->TenNhanVien }}</td>
                        <td>{{ $nhanVien->ChucVu }}</td>
                        <td>{{ $nhanVien->SDT }}</td>
                        <td>{{ $nhanVien->Email }}</td>
                        <td>
                            <a href="{{ route('admin.nhanvien.edit', $nhanVien->MaNhanVien) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('admin.nhanvien.delete', $nhanVien->MaNhanVien) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- JS Files -->
    <script src="{{ asset('admin/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/bootstrap.min.js') }}"></script>
    <!-- Additional JS Plugins -->
    <script src="{{ asset('admin/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

</body>
</html>
