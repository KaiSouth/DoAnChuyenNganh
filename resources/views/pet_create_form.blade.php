<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Hồ Sơ Thú Cưng Mới</title>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}" />
    <link rel="icon" href="{{ asset('admin/assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

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
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            background-color: #343a40;
            color: #fff;
        }

        .sidebar .nav-link {
            color: #fff;
        }

        .sidebar .nav-link:hover {
            color: #007bff;
        }

        .content {
            margin-left: 270px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #343a40;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn {
            margin-right: 10px;
        }

        .alert {
            margin-bottom: 20px;
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
            <h1 class="my-4"><i class="fas fa-paw"></i> Tạo Hồ Sơ Thú Cưng Mới</h1>

            <!-- Hiển thị lỗi -->
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('pet.save') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="TenThuCung">Tên Thú Cưng</label>
                        <input type="text" class="form-control" id="TenThuCung" name="TenThuCung" value="{{ old('TenThuCung') }}" required>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="GioiTinh">Giới Tính</label>
                        <select class="form-control" id="GioiTinh" name="GioiTinh" required>
                            <option value="">Chọn Giới Tính</option>
                            <option value="Đực" {{ old('GioiTinh') == 'Đực' ? 'selected' : '' }}>Đực</option>
                            <option value="Cái" {{ old('GioiTinh') == 'Cái' ? 'selected' : '' }}>Cái</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="Tuoi">Tuổi</label>
                        <input type="number" class="form-control" id="Tuoi" name="Tuoi" value="{{ old('Tuoi') }}" required min="0">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="MaKhachHang">Chủ Sở Hữu</label>
                        <select class="form-control" id="MaKhachHang" name="MaKhachHang" required>
                            <option value="">Chọn Chủ Sở Hữu</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->MaKhachHang }}" {{ old('MaKhachHang') == $customer->MaKhachHang ? 'selected' : '' }}>
                                    {{ $customer->HoTen }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="MaGiongLoai">Giống Loài</label>
                        <select class="form-control" id="MaGiongLoai" name="MaGiongLoai" required>
                            <option value="">Chọn Giống Loài</option>
                            @foreach($breeds as $breed)
                                <option value="{{ $breed->MaGiongLoai }}" {{ old('MaGiongLoai') == $breed->MaGiongLoai ? 'selected' : '' }}>
                                    {{ $breed->TenGiongLoai }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="HinhAnh">Hình Ảnh (URL)</label>
                        <input type="text" class="form-control" id="HinhAnh" name="HinhAnh" value="{{ old('HinhAnh') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="GhiChu">Ghi Chú</label>
                    <textarea class="form-control" id="GhiChu" name="GhiChu" rows="3">{{ old('GhiChu') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Tạo Mới</button>
                <a href="{{ route('pet.list') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay Lại</a>
            </form>
        </div>
    </div>

    <script src="{{asset('admin/assets/js/core/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/core/bootstrap.min.js')}}"></script>
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
