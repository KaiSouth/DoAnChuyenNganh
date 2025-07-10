<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Hồ Sơ Thú Cưng</title>

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/kaiadmin.min.css') }}" />
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
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f4f6f9;
        }
        .pet-detail-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 30px;
            margin: 20px;
        }
        .pet-detail-header {
            border-bottom: 2px solid #007bff;
            padding-bottom: 15px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }
        .pet-detail-header h2 {
            margin-left: 10px;
            color: #333;
        }
        .form-group label {
            font-weight: 600;
            color: #333;
        }
        .required-mark {
            color: red;
            margin-left: 4px;
        }
        .pet-image-preview {
            max-width: 200px;
            max-height: 200px;
            border-radius: 10px;
            object-fit: cover;
        }
    </style>
</head>
<body>
<div class="sidebar">
            @include('partials.sidebar')
        </div>
    <div class="wrapper">
        <!-- Sidebar -->
        <!-- Main Content -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="pet-detail-container">
                    <div class="pet-detail-header">
                        <i class="fas fa-paw fa-2x text-primary"></i>
                        <h2>Chi Tiết Hồ Sơ Thú Cưng</h2>
                    </div>

                    <!-- Hiển thị lỗi -->
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach($errors->all() as $error)
                                <p class="mb-0">
                                    <i class="fas fa-exclamation-circle"></i> {{ $error }}
                                </p>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('pet.save') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="MaThuCung" value="{{ $pet->MaThuCung }}">

                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="TenThuCung">
                                            Tên Thú Cưng
                                            <span class="required-mark">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dog"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="TenThuCung"
                                                   name="TenThuCung"
                                                   value="{{ old('TenThuCung', $pet->TenThuCung) }}"
                                                   required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="GioiTinh">
                                            Giới Tính
                                            <span class="required-mark">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-venus-mars"></i>
                                                </span>
                                            </div>
                                            <select class="form-control" id="GioiTinh"
                                                    name="GioiTinh" required>
                                                <option value="Đực"
                                                    {{ old('GioiTinh', $pet->GioiTinh) == 'Đực' ? 'selected' : '' }}>
                                                    Đực
                                                </option>
                                                <option value="Cái"
                                                    {{ old('GioiTinh', $pet->GioiTinh) == 'Cái' ? 'selected' : '' }}>
                                                    Cái
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="Tuoi">
                                            Tuổi
                                            <span class="required-mark">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="number" class="form-control"
                                                   id="Tuoi" name="Tuoi"
                                                   value="{{ old('Tuoi', $pet->Tuoi) }}"
                                                   required min="0">
                                        </div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="MaKhachHang">
                                            Chủ Sở Hữu
                                            <span class="required-mark">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-user"></i>
                                                </span>
                                            </div>
                                            <select class="form-control"
                                                    id="MaKhachHang"
                                                    name="MaKhachHang"
                                                    required>
                                                @foreach($customers as $customer)
                                                    <option value="{{ $customer->MaKhachHang }}"
                                                        {{ old('MaKhachHang', $pet->MaKhachHang) == $customer->MaKhachHang ? 'selected' : '' }}>
                                                        {{ $customer->HoTen }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="MaGiongLoai">
                                            Giống Loài
                                            <span class="required-mark">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-paw"></i>
                                                </span>
                                            </div>
                                            <select class="form-control"
                                                    id="MaGiongLoai"
                                                    name="MaGiongLoai"
                                                    required>
                                                @foreach($breeds as $breed)
                                                    <option value="{{ $breed->MaGiongLoai }}"
                                                        {{ old('MaGiongLoai', $pet->MaGiongLoai) == $breed->MaGiongLoai ? 'selected' : '' }}>
                                                        {{ $breed->TenGiongLoai }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="HinhAnh">Hình Ảnh</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-image"></i>
                                                </span>
                                            </div>
                                            <input type="file"
                                                   class="form-control"
                                                   id="HinhAnh"
                                                   name="HinhAnh"
                                                   accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 text-center">
                                <label>Ảnh Thú Cưng</label>
                                <img src="{{ $pet->HinhAnh ?? asset('default-pet-image.png') }}"
                                     alt="Ảnh Thú Cưng"
                                     class="pet-image-preview img-fluid mb-3">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="GhiChu">Ghi Chú</label>
                            <textarea class="form-control"
                                      id="GhiChu"
                                      name="GhiChu"
                                      rows="3">{{ old('GhiChu', $pet->GhiChu) }}</textarea>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Cập Nhật
                            </button>
                            <a href="{{ route('pet.list') }}" class="btn btn-secondary btn-lg ml-2">
                                <i class="fas fa-arrow-left"></i> Quay Lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Libraries -->
    <script src="{{ asset('admin/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/bootstrap.min.js') }}"></script>

    <script>
        // Xem trước ảnh khi tải lên
        $('#HinhAnh').on('change', function(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                $('.pet-image-preview').attr('src', reader.result);
            };
            reader.readAsDataURL(input.files[0]);
        });
    </script>
</body>
</html>
