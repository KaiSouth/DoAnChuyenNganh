<!-- Duy_admin_doctor_view -->

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Bác Sĩ</title>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/kaiadmin.min.css') }}" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
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
        /* Sidebar Styling */

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

        /* Content Styling */
        .content {
            margin-left: 270px;
            padding: 20px;
        }

        /* Table Styling */
        .table th, .table td {
            vertical-align: middle;
        }

        .form-group input {
            width: 300px;
            display: inline-block;
        }
    </style>
</head>
<body>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            @include('partials.sidebar')
        </div>

        <!-- Content -->
        <div class="content">
            <h2 class="my-4">Danh Sách Bác Sĩ</h2>
            <a href="{{ route('admin.doctors.create') }}" class="btn btn-success">Thêm Mới Bác Sĩ</a>

            <!-- Tìm kiếm bác sĩ -->
            <form action="{{ route('admin.doctors.search') }}" method="get">
                <div class="form-group">
                    <input type="text" name="searchTerm" placeholder="Tìm kiếm bác sĩ theo mã hoặc tên" class="form-control" value="{{ old('searchTerm') }}">
                    <button type="submit" class="btn btn-primary mt-2">Tìm kiếm</button>
                </div>
            </form>

            <!-- Thông báo thành công hoặc lỗi -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <!-- Hiển thị danh sách bác sĩ -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Mã Bác Sĩ</th>
                        <th>Tên Bác Sĩ</th>
                        <th>Chuyên Môn</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doctors as $doctor)
                        <tr>
                            <td>{{ $doctor->MaBacSi }}</td>
                            <td>{{ $doctor->HoTen }}</td>
                            <td>{{ $doctor->ChuyenMon }}</td>
                            <td>
                                <a href="{{ route('admin.doctors.edit', $doctor->MaBacSi) }}" class="btn btn-warning btn-sm">Sửa</a>
                                <form action="{{ route('admin.doctors.delete', $doctor->MaBacSi) }}" method="post" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bác sĩ này không?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Nếu không có bác sĩ nào sau tìm kiếm -->
            @if($doctors->isEmpty())
                <div class="alert alert-warning">
                    Không tìm thấy bác sĩ nào với từ khóa "{{ request('searchTerm') }}".
                </div>
            @endif
        </div>
    </div>
    <script src="{{asset('admin/assets/js/core/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/core/bootstrap.min.js')}}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{asset('admin/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>

    <!-- Chart JS -->
    <script src="{{asset('admin/assets/js/plugin/chart.js/chart.min.js')}}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{asset('admin/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

    <!-- Chart Circle -->
    <script src="{{asset('admin/assets/js/plugin/chart-circle/circles.min.js')}}"></script>

    <!-- Datatables -->
    <script src="{{asset('admin/assets/js/plugin/datatables/datatables.min.js')}}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{asset('admin/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{asset('admin/assets/js/plugin/jsvectormap/jsvectormap.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/plugin/jsvectormap/world.js')}}"></script>

    <!-- Sweet Alert -->
    <script src="{{asset('admin/assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>
</body>
</html>
