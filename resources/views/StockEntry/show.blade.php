<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Chi Tiết Phiếu Nhập</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('admin/assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />

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

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/plugins.min.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/kaiadmin.min.css')}}" />

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2196F3;
            --secondary-color: #607D8B;
            --success-color: #4CAF50;
            --danger-color: #F44336;
            --warning-color: #FFC107;
        }

        body {
            font-family: 'Public Sans', sans-serif;
            background-color: #f4f6f8;
            color: #333;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 240px;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            background: #2c3e50;
            z-index: 1000;
            overflow-y: hidden; 
        }

        .sidebar:hover {
            overflow-y: auto; 
        }

        .main-panel {
            flex: 1;
            margin-left: 240px;
            padding: 24px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            color: #1a237e;
            font-size: 2rem;
            margin-bottom: 24px;
            font-weight: 600;
        }

        .detail-info {
            background: #f8f9fa;
            padding: 24px;
            border-radius: 8px;
            margin-bottom: 32px;
        }

        .detail-info img {
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .detail-info p {
            margin-bottom: 16px;
            line-height: 1.6;
        }

        .detail-info strong {
            color: var(--secondary-color);
            min-width: 120px;
            display: inline-block;
        }

        .table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .table thead {
            background: #f8f9fa;
        }

        .table th {
            font-weight: 600;
            color: var(--secondary-color);
            border-bottom: 2px solid #dee2e6;
            padding: 16px;
        }

        .table td {
            padding: 16px;
            vertical-align: middle;
        }

        .btn {
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
        }

        .btn-warning {
            background: var(--warning-color);
            border: none;
            color: #000;
        }

        .btn-danger {
            background: var(--danger-color);
            border: none;
        }
    </style>
  </head>

  <body>
    <div class="wrapper">
        @include('partials.sidebar')
    
        <div class="main-panel">
            <div class="container">
                <h1>Chi Tiết Phiếu Nhập #{{ $receipt->MaPhieuNhap }}</h1>
    
                <div class="detail-info">
                    <p><strong>Ngày Nhập:</strong> {{ $receipt->NgayNhap }}</p>
                    <p><strong>Mã Nhà Cung Cấp:</strong> {{ $receipt->MaNhaCungCap }}</p>
                    <p><strong>Tên Nhà Cung Cấp:</strong> {{ $receipt->TenNhaCungCap }}</p>
                    <p><strong>Tổng Tiền:</strong> {{ number_format($receipt->TongTien, 2) }} đ</p>
                </div>
    
                <h3>Danh Sách Chi Tiết Phiếu Nhập</h3>
                @if($details->isEmpty())
                    <div class="alert alert-info">
                        Chưa có chi tiết nào cho phiếu nhập này.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tên Vật Tư</th>
                                    <th>Đơn Vị Tính</th>
                                    <th>Số Lượng</th>
                                    <th>Đơn Giá</th>
                                    <th>Thành Tiền</th>
                                    <th>Ngày Sản Xuất</th>
                                    <th>Ngày Hết Hạn</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($details as $detail)
                                    <tr>
                                        <td>{{ $detail->TenVatTu }}</td>
                                        <td>{{ $detail->DonViTinh }}</td>
                                        <td>{{ $detail->SoLuong }}</td>
                                        <td>{{ number_format($detail->DonGia, 2) }} đ</td>
                                        <td>{{ number_format($detail->ThanhTien, 2) }} đ</td>
                                        <td>{{ $detail->NgaySanXuat }}</td>
                                        <td>{{ $detail->NgayHetHan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script src="{{ asset('admin/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/bootstrap.min.js') }}"></script>
  </body>
</html>
