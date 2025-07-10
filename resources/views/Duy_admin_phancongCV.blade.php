<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Phân Công Công Việc</title>

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
    <style>
        body {
            background-color: #f4f6f9;
        }
        .content-wrapper {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 30px;
            margin: 20px;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .btn-action {
            margin-right: 5px;
            margin-bottom: 5px;
        }
        .search-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }

        .pagination a, .pagination span {
            padding: 8px 12px;
            margin: 0 5px;
            border: 1px solid #ddd;
            color: #333;
            text-decoration: none;
        }

        .pagination .current {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .pagination .disabled {
            color: #999;
            pointer-events: none;
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
                    <h1 class="page-title">Danh Sách Phân Công Công Việc</h1>
                </div>
                <div class="search-section">
                    <form action="{{ route('admin.assignments.search') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên bác sĩ" value="{{ request('keyword') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="month" class="form-control">
                                    <option value="">-- Chọn tháng --</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                            Tháng {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            </div>
                            <div class="col-md-3 text-right">
                                <a href="{{ route('admin.assignments.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus"></i> Thêm Mới
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Mã PC</th>
                                <th>Nhân Viên</th>
                                <th>Loại Công Việc</th>
                                <th>Ngày Làm</th>
                                <th>Ca Làm</th>
                                <th>Trạng Thái</th>
                                <th>Dịch Vụ</th>
                                <th>Bác Sĩ</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assignments as $assignment)
                                <tr>
                                    <td>{{ $assignment->MaPhanCong }}</td>
                                    <td>{{ $assignment->TenNhanVien }}</td>
                                    <td>{{ $assignment->LoaiCongViec }}</td>
                                    <td>{{ \Carbon\Carbon::parse($assignment->NgayLamViec)->format('d/m/Y') }}</td>
                                    <td>{{ $assignment->CaLamViecMoTa }}</td>
                                    <td>
                                        <span class="badge
                                            {{ $assignment->TrangThai == 'Làm việc' ? 'badge-success' :
                                                ($assignment->TrangThai == 'Nghỉ' ? 'badge-warning' : 'badge-secondary') }}">
                                            {{ $assignment->TrangThai }}
                                        </span>
                                    </td>
                                    <td>{{ $assignment->TenDichVu ?? 'N/A' }}</td>
                                    <td>{{ $assignment->BacSiHoTen ?? 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.assignments.edit', ['id' => $assignment->MaPhanCong]) }}"
                                                class="btn btn-sm btn-warning btn-action">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>

                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.assignments.detailLichKham', ['id' => $assignment->MaPhanCong]) }}" class="btn btn-sm btn-secondary">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">
                                        <i class="fas fa-info-circle"></i> Không có dữ liệu phân công
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="pagination">
                    @if ($assignments->currentPage() == 1)
                        <span class="disabled">Trước</span>
                    @else
                        <a href="{{ $assignments->previousPageUrl() }}">Trước</a>
                    @endif

                    @for ($i = 1; $i <= $assignments->lastPage(); $i++)
                        @if ($i == $assignments->currentPage())
                            <span class="current">{{ $i }}</span>
                        @else
                            <a href="{{ $assignments->url($i) }}">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($assignments->hasMorePages())
                        <a href="{{ $assignments->nextPageUrl() }}">Tiếp theo</a>
                    @else
                        <span class="disabled">Tiếp theo</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('admin/assets/js/core/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/core/bootstrap.min.js')}}"></script>

    <script>
        $(document).ready(function() {
            // Xác nhận xóa
            $('.delete-btn').on('click', function(e) {
                if (!confirm('Bạn có chắc chắn muốn xóa phân công này?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
