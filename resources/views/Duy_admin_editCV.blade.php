<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Phân Công Công Việc</title>

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/kaiadmin.min.css')}}" />
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
        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 30px;
            margin: 20px;
        }
        .form-header {
            border-bottom: 2px solid #007bff;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .form-group label {
            font-weight: 600;
            color: #333;
        }
        .required-mark {
            color: red;
            margin-left: 4px;
        }
    </style>
</head>
<body>
     <!-- Sidebar -->
     <div class="sidebar">
            @include('partials.sidebar')
        </div>
    <div class="wrapper">
        <!-- Main Content -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="form-container">
                    <div class="form-header">
                        <h2 class="page-title">
                            <i class="fas fa-tasks"></i> Chỉnh Sửa Phân Công Công Việc
                        </h2>
                    </div>
                    <!-- Hiển thị lỗi xác thực -->
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach($errors->all() as $error)
                                <p class="mb-0"><i class="fas fa-exclamation-circle"></i> {{ $error }}</p>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('admin.assignments.update', ['id' => $assignment->MaPhanCong]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="MaNhanVien">Nhân Viên <span class="required-mark">*</span>>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <select name="MaNhanVien" id="MaNhanVien" class="form-control" required>
                                            <option value="">-- Chọn Nhân Viên --</option>
                                            @foreach($employees as $employee)
                                                <option value="{{ $employee->MaNhanVien }}"
                                                    {{ (old('MaNhanVien') ?? $assignment->MaNhanVien) == $employee->MaNhanVien ? 'selected' : '' }}>
                                                    {{ $employee->TenNhanVien }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="LoaiCongViec">Loại Công Việc <span class="required-mark">*</span>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                        </div>
                                        <input type="text" name="LoaiCongViec" id="LoaiCongViec"
                                               class="form-control"
                                               value="{{ old('LoaiCongViec') ?? $assignment->LoaiCongViec }}"
                                               required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="NgayLamViec">Ngày Làm Việc <span class="required-mark">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        <input type="date" name="NgayLamViec" id="NgayLamViec"
                                               class="form-control"
                                               value="{{ old('NgayLamViec') ?? $assignment->NgayLamViec }}"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="MaCaLamViec">Ca Làm Việc <span class="required-mark">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i>
                                        </div>
                                        <select name="MaCaLamViec" id="MaCaLamViec" class="form-control" required>
                                            <option value="">-- Chọn Ca Làm Việc --</option>
                                            @foreach($shifts as $shift)
                                                <option value="{{ $shift->MaCaLamViec }}"
                                                    {{ (old('MaCaLamViec') ?? $assignment->MaCaLamViec) == $shift->MaCaLamViec ? 'selected' : '' }}>
                                                    {{ $shift->MoTa }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="MaDichVu">Dịch Vụ</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                        </div>
                                        <select name="MaDichVu" id="MaDichVu" class="form-control">
                                            <option value="">-- Chọn Dịch Vụ --</option>
                                            @foreach($services as $service)
                                                <option value="{{ $service->MaDichVu }}"
                                                    {{ (old('MaDichVu') ?? $assignment->MaDichVu) == $service->MaDichVu ? 'selected' : '' }}>
                                                    {{ $service->TenDichVu }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="MaBacSi">Bác Sĩ</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                        </div>
                                        <select name="MaBacSi" id="MaBacSi" class="form-control">
                                            <option value="">-- Chọn Bác Sĩ --</option>
                                            @foreach($vets as $vet)
                                                <option value="{{ $vet->MaBacSi }}"
                                                    {{ (old('MaBacSi') ?? $assignment->MaBacSi) == $vet->MaBacSi ? 'selected' : '' }}>
                                                    {{ $vet->HoTen }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="TrangThai">Trạng Thái</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                        </div>
                                        <input type="text" name="TrangThai" id="TrangThai"
                                               class="form-control"
                                               value="{{ old('TrangThai') ?? 'Đề xuất' }}"
                                               readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Cập Nhật
                            </button>
                            <a href="{{ route('admin.assignments.index') }}" class="btn btn-secondary btn-lg ml-2">
                                <i class="fas fa-arrow-left"></i> Quay Lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Libraries -->
    <script src="{{asset('admin/assets/js/core/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/core/bootstrap.min.js')}}"></script>

    <!-- Dynamic Dropdown Scripts -->
    <script>
        $(document).ready(function() {
            // Xử lý dropdown bác sĩ khi chọn ngày làm việc
            $('#NgayLamViec').on('change', function() {
                const selectedDate = $(this).val();
                if (selectedDate) {
                    $.ajax({
                        url: '{{ route("admin.assignments.getAvailableVets") }}',
                        method: 'GET',
                        data: { NgayLamViec: selectedDate },
                        success: function(response) {
                            const vetsDropdown = $('#MaBacSi');
                            vetsDropdown.empty();
                            vetsDropdown.append('<option value="">-- Chọn Bác Sĩ --</option>');

                            response.forEach(function(vet) {
                                vetsDropdown.append(`<option value="${vet.MaBacSi}">${vet.HoTen}</option>`);
                            });
                        },
                        error: function() {
                            alert('Không thể tải danh sách bác sĩ.');
                        }
                    });
                }
            });

            // Xử lý dropdown bác sĩ khi chọn ca làm việc
            $('#MaCaLamViec').on('change', function() {
                const ngayLamViec = $('#NgayLamViec').val();
                const maCaLamViec = $(this).val();

                if (ngayLamViec && maCaLamViec) {
                    $.ajax({
                        url: '/admin/assignments/check-available-doctors',
                        method: 'GET',
                        data: {
                            NgayLamViec: ngayLamViec,
                            MaCaLamViec: maCaLamViec
                        },
                        success: function(response) {
                            const doctorSelect = $('#MaBacSi');
                            doctorSelect.empty();
                            doctorSelect.append('<option value="">-- Chọn Bác Sĩ --</option>');

                            response.forEach(function(doctor) {
                                doctorSelect.append(`<option value="${doctor.MaBacSi}">${doctor.HoTen}</option>`);
                            });
                        },
                        error: function() {
                            alert('Không thể tải danh sách bác sĩ.');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
