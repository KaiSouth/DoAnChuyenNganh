<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Lịch Khám</title>

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/kaiadmin.min.css')}}" />
    <!-- Fonts and icons -->
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
            font-family: 'Public Sans', sans-serif;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }



        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px 0;
        }

        .sidebar a:hover {
            background-color: #563d7c;
        }

        .main-panel {
            flex-grow: 1;
            padding: 20px;
            margin-left: 250px; /* Khoảng cách bằng chiều rộng sidebar */
        }

        .content-wrapper {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .page-header h2 {
            margin: 0;
        }

        .card {
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px 8px 0 0;
        }

        .card-body {
            padding: 20px;
        }

        .info-group {
            margin-bottom: 15px;
        }

        .info-label {
            font-weight: bold;
            color: #555;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th, .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody + tbody {
            border-top: 2px solid #dee2e6;
        }

        .table-sm th, .table-sm td {
            padding: 0.3rem;
        }

        .text-right {
            text-align: right;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        /* Icon cho nút quay lại */
        .btn-secondary i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
<div class="sidebar">
            @include('partials.sidebar')
        </div>
    <div class="wrapper">


        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h2>Chi Tiết Lịch Khám Theo Phân Công</h2>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Thông tin phân công</h5>
                    </div>
                    <div class="card-body">
                        <div class="info-group">
                            <span class="info-label">Bác sĩ:</span> {{ $assignment->TenBacSi }}
                        </div>
                        <div class="info-group">
                            <span class="info-label">Ngày làm việc:</span> {{ date('d/m/Y', strtotime($assignment->NgayLamViec)) }}
                        </div>

                        <div class="info-group">
                            <span class="info-label">Dịch vụ:</span> {{ $assignment->TenDichVu }}
                        </div>
                        <div class="info-group">
                            <span class="info-label">Trạng thái:</span> {{ $assignment->TrangThai }}
                        </div>
                    </div>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Giờ khám</th>
                            <th>Tên thú cưng</th>
                            <th>Địa chỉ</th>
                            <th>Chuẩn đoán</th>
                            <th>Chi phí khám</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lichKhamTrongNgay as $lichKham)
                        <tr>
                            <td>{{ $lichKham->GioKham }}</td>
                            <td>{{ $lichKham->TenThuCung }}
                            <a href="{{route('petData',$lichKham->MaThuCung)}}" class="ml-2">
                                <i class="fas fa-eye"></i>
                            </a>
                            </td>
                            <td>{{ $lichKham->DiaChi }}</td>
                            <td>{{ $lichKham->ChuanDoan }}</td>
                            <td>{{ number_format($lichKham->ChiPhiKham, 0, ',', '.') }} VNĐ</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Không có lịch khám nào trong ngày này</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Nút quay lại -->
                <div class="text-right mt-3">
                    @if(session('role') === 'manager')
                        <a href="{{ route('admin.assignments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-tasks"></i> Quay lại
                        </a>
                    @else
                        <a href="{{ route('doctor.schedule.byId', ['maBacSi' => session('manage_id')]) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <script src="{{asset('admin/assets/js/core/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/core/bootstrap.min.js')}}"></script>
</body>
</html>
