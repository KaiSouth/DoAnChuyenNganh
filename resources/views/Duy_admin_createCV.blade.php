<!-- resources/views/Duy_admin_createCV.blade.php -->

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Mới Phân Công Công Việc</title>

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
            @include('partials.sidebar')
        </div>

        <!-- Content -->
        <div class="content">
            <h1 class="my-4">Thêm Mới Phân Công Công Việc</h1>

            <!-- Display validation errors -->
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Form to create a new assignment -->
            <form action="{{ route('admin.assignments.store') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Employee selection -->
                    <div class="col-md-6 form-group">
                        <label for="MaNhanVien">Nhân Viên</label>
                        <select name="MaNhanVien" id="MaNhanVien" class="form-control" required>
                            <option value="">-- Chọn Nhân Viên --</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->MaNhanVien }}" {{ old('MaNhanVien') == $employee->MaNhanVien ? 'selected' : '' }}>
                                    {{ $employee->TenNhanVien }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Job type -->
                    <div class="col-md-6 form-group">
                        <label for="LoaiCongViec">Loại Công Việc</label>
                        <input type="text" name="LoaiCongViec" id="LoaiCongViec" class="form-control" value="{{ old('LoaiCongViec') }}" required>
                    </div>
                </div>

                <div class="row">
                    <!-- Work date -->
                    <div class="col-md-6 form-group">
                        <label for="NgayLamViec">Ngày Làm Việc</label>
                        <input type="date" name="NgayLamViec" id="NgayLamViec" class="form-control" value="{{ old('NgayLamViec') }}" required>
                    </div>

                    <!-- Shift selection -->
                    <div class="col-md-6 form-group">
                        <label for="MaCaLamViec">Ca Làm Việc</label>
                        <select name="MaCaLamViec" id="MaCaLamViec" class="form-control" required>
                            <option value="">-- Chọn Ca Làm Việc --</option>
                            @foreach($shifts as $shift)
                                <option value="{{ $shift->MaCaLamViec }}" {{ old('MaCaLamViec') == $shift->MaCaLamViec ? 'selected' : '' }}>
                                    {{ $shift->MoTa }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <!-- Status -->
                   <!-- Trong file Duy_admin_createCV.blade.php -->
                    <!-- Thay thế phần input trạng thái bằng select box -->
                    <div class="col-md-6 form-group">
                        <label for="TrangThai">Trạng Thái</label>
                        <select name="TrangThai" id="TrangThai" class="form-control" required>
                            <option value="Làm việc" selected>Làm việc</option>
                            <option value="Đề xuất">Đề xuất</option>
                            <!-- Thêm các trạng thái khác nếu cần -->
                        </select>
                    </div>


                    <!-- Service selection -->
                    <div class="col-md-6 form-group">
                        <label for="MaDichVu">Dịch Vụ</label>
                        <select name="MaDichVu" id="MaDichVu" class="form-control">
                            <option value="">-- Chọn Dịch Vụ (Tùy Chọn) --</option>
                            @foreach($services as $service)
                                <option value="{{ $service->MaDichVu }}" {{ old('MaDichVu') == $service->MaDichVu ? 'selected' : '' }}>
                                    {{ $service->TenDichVu }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <!-- Vet selection -->
                    <div class="col-md-6 form-group">
                        <label for="MaBacSi">Bác Sĩ</label>
                        <select name="MaBacSi" id="MaBacSi" class="form-control">
                            <option value="">-- Chọn Bác Sĩ (Tùy Chọn) --</option>
                            @foreach($vets as $vet)
                                <option value="{{ $vet->MaBacSi }}" {{ old('MaBacSi') == $vet->MaBacSi ? 'selected' : '' }}>
                                    {{ $vet->HoTen }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Thêm Mới</button>
                <a href="{{ route('admin.assignments.index') }}" class="btn btn-secondary">Quay Lại</a>
            </form>
        </div>
    </div>

    <!-- JS Files -->
    <script src="{{asset('admin/assets/js/core/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/core/bootstrap.min.js')}}"></script>

    <!-- Additional JS Plugins -->
    <script src="{{asset('admin/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/plugin/chart.js/chart.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/plugin/chart-circle/circles.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/plugin/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/plugin/jsvectormap/jsvectormap.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/plugin/jsvectormap/world.js')}}"></script>
    <script src="{{asset('admin/assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>
</body>
</html>
