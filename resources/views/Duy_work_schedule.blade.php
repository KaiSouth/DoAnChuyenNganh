<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch Phân Công Công Việc Nhân viên</title>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}" />
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

        .content {
            margin-left: 270px;
            padding: 20px;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .btn {
            margin-top: 20px;
        }
    </style>

</head>

<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar">
        @include('partials.sidebar')  <!-- Include your sidebar content here -->
    </div>

    <!-- Content -->
    <div class="content">
        <h2>Lịch Phân Công Công Việc</h2>
        <div class="d-flex justify-content-between mb-3">
            <div>
                <a href="{{ route('work.schedule', ['id' => request()->route('id'), 'type' => 'week']) }}"
                class="btn btn-primary {{ $type === 'week' ? 'active' : '' }}">
                    Xem theo tuần
                </a>
                <a href="{{ route('work.schedule', ['id' => request()->route('id'), 'type' => 'month']) }}"
                class="btn btn-primary {{ $type === 'month' ? 'active' : '' }}">
                    Xem theo tháng
                </a>
            </div>
        </div>
        @if($hasSchedule)
            <table class="table table-bordered">
                <thead class="thead-dark">
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
                                <td>{{ $day['details']->TrangThai }}</td>
                                <td>
                                    <strong>Loại Dịch Vụ:</strong> {{ $day['details']->MaDichVu ?? 'N/A' }}<br>
                                    <strong>Ca Làm Việc:</strong> {{ $day['details']->CaLamViecMoTa ?? 'N/A' }}<br>
                                    <strong>Ngày Phân Công:</strong> {{ \Carbon\Carbon::parse($day['details']->NgayPhanCong)->format('d/m/Y') }}
                                </td>
                            @else
                                <td colspan="3">Nghỉ</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-warning">
                {{ $message }}
            </div>
        @endif

        <a href="{{ route('employee.dashboard', ['id' => request()->route('id')]) }}" class="btn btn-secondary">Quay Lại</a>
    </div>
</div>

<script src="{{ asset('admin/assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/core/bootstrap.min.js') }}"></script>

</body>
</html>
