<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
    <title>Dashboard Nhân Viên</title>
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


        .content {
            margin-left: 250px;
            padding: 30px;
            background: #f4f6f9;
            min-height: 100vh;
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #3498db;
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .employee-card {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .icon {
            width: 40px;
            height: 40px;
            background: #e8f4ff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: #3498db;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 12px;
            color: #7f8c8d;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 15px;
            color: #2c3e50;
            font-weight: 500;
        }

        .schedule-section {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }

        .schedule-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn-group {
            display: flex;
            gap: 10px;
        }

        .btn-schedule {
            padding: 8px 20px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-schedule.active {
            background: #3498db;
            color: #fff;
        }

        .schedule-table-container {
            max-height: 600px;
            overflow-y: auto;
            border-radius: 8px;
            border: 1px solid #eee;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f8fafc;
            padding: 15px;
            font-weight: 600;
            color: #2c3e50;
            border-bottom: 2px solid #eee;
        }

        .table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
            color: #444;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-working {
            background: #e8f6ff;
            color: #3498db;
        }

        .status-off {
            background: #fff3e0;
            color: #f39c12;
        }

        @media (max-width: 1200px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .content {
                margin-left: 0;
                padding: 15px;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .btn-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<div class="sidebar">
        @include('partials.sidebar')
    </div>
<div class="d-flex">

    <div class="content">
        <h2 class="page-title">Thông Tin Nhân Viên</h2>

        <div class="dashboard-container">
            <!-- Employee Info Card -->
            <div class="employee-card">
                <div class="info-item">
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Tên Nhân Viên</div>
                        <div class="info-value">{{ $employee->TenNhanVien }}</div>
                    </div>
                </div>

                <div class="info-item">
                    <div class="icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Chức Vụ</div>
                        <div class="info-value">{{ $employee->ChucVu }}</div>
                    </div>
                </div>

                <div class="info-item">
                    <div class="icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Số Điện Thoại</div>
                        <div class="info-value">{{ $employee->SDT }}</div>
                    </div>
                </div>

                <div class="info-item">
                    <div class="icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $employee->Email }}</div>
                    </div>
                </div>

                <div class="info-item">
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Lương Theo Giờ</div>
                        <div class="info-value">{{ number_format($employee->LuongTheoGio, 0, ',', '.') }} VND</div>
                    </div>
                </div>
            </div>

            <!-- Schedule Section -->
            <div class="schedule-section">
                <div class="schedule-header">
                    <h3 class="mb-0">Lịch Làm Việc</h3>
                    <div class="btn-group">
                        <a href="{{ route('work.schedule', ['id' => $employee->MaNhanVien, 'type' => 'week']) }}"
                           class="btn btn-schedule {{ request('type') == 'week' ? 'active' : '' }}">
                            Xem theo tuần
                        </a>
                        <a href="{{ route('work.schedule', ['id' => $employee->MaNhanVien, 'type' => 'month']) }}"
                           class="btn btn-schedule {{ request('type') == 'month' ? 'active' : '' }}">
                            Xem theo tháng
                        </a>
                    </div>
                </div>

                @if($hasSchedule)
                <div class="schedule-table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Ngày</th>
                                <th>Loại Công Việc</th>
                                <th>Trạng Thái</th>
                                <th>Chi Tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedule as $day)
                            <tr>
                                <td>{{ $day['date'] }}</td>
                                @if($day['status'] === 'working')
                                    <td>{{ $day['details']->LoaiCongViec }}</td>
                                    <td>
                                        <span class="status-badge status-working">
                                            {{ $day['details']->TrangThai }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="schedule-details">
                                            <div><strong>Loại DV:</strong> {{ $day['details']->MaDichVu ?? 'N/A' }}</div>
                                            <div><strong>Ca:</strong> {{ $day['details']->CaLamViecMoTa ?? 'N/A' }}</div>
                                            <div><strong>Ngày PC:</strong> {{ \Carbon\Carbon::parse($day['details']->NgayPhanCong)->format('d/m/Y') }}</div>
                                        </div>
                                    </td>
                                @else
                                    <td colspan="3">
                                        <span class="status-badge status-off">Nghỉ</span>
                                    </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <div class="alert alert-warning">
                        {{ $message }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('admin/assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/core/bootstrap.min.js') }}"></script>

</body>
</html>
