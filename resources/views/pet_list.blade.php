<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Thú Cưng</title>
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
        /* Content Styling */
        .content {
            margin-left: 270px;
            padding: 20px;
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
        @if(isset($noPetsMessage))
        <div class="alert alert-warning">{{ $noPetsMessage }}</div>
    @endif
            <h1 class="my-4">Danh Sách Thú Cưng</h1>
            <!-- Form tìm kiếm -->
            <form style="display: flex;" action="{{ route('pet.search') }}" method="GET" class="mb-3">
                <input style="width: 50%;" type="text" name="search" placeholder="Tìm theo tên chủ sở hữu" class="form-control" required>
                <button style="margin-left: 10px; height: 100%;" type="submit" class="btn btn-primary mt-2">Tìm Kiếm</button>
            </form>

            <a href="{{ route('pet.create') }}" class="btn btn-primary mb-3">Thêm Thú Cưng Mới</a>
            <a href="{{ route('giong-loai.create') }}" class="btn btn-primary mb-3 ml-2">Thêm Loại Thú Cưng</a>
            @if(isset($noPetsMessage))
                <div class="alert alert-warning">{{ $noPetsMessage }}</div>
            @endif

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Mã Thú Cưng</th>
                        <th>Tên Thú Cưng</th>
                        <th>Giới Tính</th>
                        <th>Tuổi</th>
                        <th>Chủ Sở Hữu</th>
                        <th>Giống Loài</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pets as $pet)
                    <tr>
                        <td>{{ $pet->MaThuCung }}</td>
                        <td>{{ $pet->TenThuCung }}</td>
                        <td>{{ $pet->GioiTinh }}</td>
                        <td>{{ $pet->Tuoi }}</td>
                        <td>{{ $pet->TenChuSoHuu }}</td>
                        <td>{{ $pet->TenGiongLoai }}</td>
                        <td>
                            <a href="{{ route('pet.details', $pet->MaThuCung) }}" class="btn btn-sm btn-info">Chi Tiết</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Không có thú cưng nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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
