<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Làm Việc Của Bác Sĩ {{ $doctor->HoTen }}</title>

    <link rel="stylesheet" href="{{asset('admin/assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/plugins.min.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/kaiadmin.min.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/demo.css')}}" />
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
        .schedule-table {
            table-layout: fixed;
            word-wrap: break-word;
        }
        .schedule-table th, .schedule-table td {
            vertical-align: top;
            border: 1px solid #dee2e6;
            padding: 10px;
        }
        .doctor-header {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
        }
        .assignment {
            margin-bottom: 10px;
            padding: 5px;
            border-bottom: 1px solid #e9ecef;
        }
        .status-working {
            color: green;
            font-weight: bold;
        }
        .status-off {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            @include('partials.sidebar')
        </div>

        <!-- Content -->
        <div class="content">
            <h2 class="mb-4"><i class="fas fa-calendar-alt"></i>Lịch Làm Việc Của Bác Sĩ: {{ $doctor->HoTen }} </h2>
            <p>Thời gian: Từ <strong>{{ $dateRange['start'] }}</strong> đến <strong>{{ $dateRange['end'] }}</strong></p>

            <!-- Select View Type: Month or Week -->
            <form method="GET" action="{{ route('doctor.schedule.byId', ['maBacSi' => $doctor->MaBacSi]) }}" class="mb-3">
                <div class="form-group">
                    <label for="view_type">Chọn khoảng thời gian:</label>
                    <select name="view_type" id="view_type" class="form-control" onchange="this.form.submit()">
                        <option value="month" {{ $viewType == 'month' ? 'selected' : '' }}>Theo Tháng</option>
                        <option value="week" {{ $viewType == 'week' ? 'selected' : '' }}>Theo Tuần</option>
                    </select>
                </div>
            </form>

            @if (empty($schedule) || count($schedule) === 0)
                <div class="alert alert-info">
                    Bác sĩ {{ $doctor->HoTen }} không có lịch làm việc trong khoảng thời gian này.
                </div>
            @else
                <table class="table table-bordered schedule-table">
                    <thead>
                        <tr>
                            <th>Ngày <i class="fas fa-calendar-day"></i></th>
                            <th>Loại Công Việc <i class="fas fa-briefcase"></i></th>
                            <th>Trạng Thái <i class="fas fa-check-circle"></i></th>
                            <th>Dịch Vụ (Nếu Có) <i class="fas fa-concierge-bell"></i></th>
                            <th>Hành Động <i class="fas fa-cogs"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schedule as $date => $assignmentsOnDate)
                            <tr>
                                <td>{{ $date }}</td>
                                <td>
                                    @foreach ($assignmentsOnDate as $assignment)
                                        <div class="assignment">
                                            {{ $assignment['LoaiCongViec'] }}
                                        </div>
                                    @endforeach
                                </td>
                                <!-- <td>
                                    @foreach ($assignmentsOnDate as $assignment)
                                        <div class="assignment">
                                            {{ $assignment['TenCaLamViec'] }}
                                        </div>
                                    @endforeach
                                </td> -->
                                <td>
                                    @foreach ($assignmentsOnDate as $assignment)
                                        <div class="assignment">
                                            @if ($assignment['TrangThai'] === 'Đề xuất')
                                                <form method="POST" action="{{ route('confirm.assignment', ['id' => $assignment['MaPhanCong']]) }}" style="display: inline-block;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">Xác nhận</button>
                                                </form>
                                                <form method="POST" action="{{ route('reject.assignment', ['id' => $assignment['MaPhanCong']]) }}" style="display: inline-block;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm">Từ chối</button>
                                                </form>
                                            @else
                                                <span class="{{ $assignment['TrangThai'] === 'Xác nhận' ? 'status-working' : 'status-off' }}">
                                                    {{ $assignment['TrangThai'] }}
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($assignmentsOnDate as $assignment)
                                        <div class="assignment">
                                            {{ $assignment['TenDichVu'] ?? 'Không có' }}
                                        </div>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($assignmentsOnDate as $assignment)
                                        <div class="assignment">
                                            <a href="{{ route('admin.assignments.detailLichKham', ['id' => $assignment['MaPhanCong']]) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> <!-- Icon xem chi tiết -->
                                            </a>
                                            <a href="{{ route('admin.assignments.edit', ['id' => $assignment['MaPhanCong']]) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> <!-- Icon sửa -->
                                            </a>
                                        </div>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <a href="{{ route('doctor.schedule.byId',['maBacSi'=>session('manage_id')]) }}" class="btn btn-secondary mt-3">Quay Lại</a>
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
