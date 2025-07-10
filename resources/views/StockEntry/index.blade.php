<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Phiếu Nhập Kho</title>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/kaiadmin.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .main-panel {
            margin-left: 250px;
            padding: 20px;
        }
        .container {
            
            margin-top: 0px !important;
            margin: 20px auto;
            max-width: 100%;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        .btn-action {
            margin: 0 5px;
            padding: 6px 12px;
            border-radius: 4px;
        }
        .material-row {
            background-color: #f9f9f9;
        }
        .modal-dialog {
            max-width: 800px;
        }
        #materialContainer {
            max-height: 300px;
            overflow-y: auto;
        }
        .header {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
        }
        .header-buttons {
            display: flex;
            gap: 10px;
        }
        .search-container{
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        @include('partials.sidebar')

        <div class="main-panel">
            <div class="container">
                @if(session('success'))
                <div class="alert alert-success">
                    <svg class="alert-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="alert-message">{{ session('success') }}</div>
                </div>
                @endif

                <div class="header">
                    <h1>Quản lý Phiếu Nhập Kho</h1>
                    <div class="header-buttons">
                        <button class="btn btn-success">
                            <a href="{{ route('StockEntry.create') }}" style="color: white; text-decoration: none;">+ Thêm Phiếu Nhập</a>
                        </button>
                    </div>
                </div>

                <div class="search-container mb-3">
                    <form id="searchForm" class="d-flex">
                        <input type="text" id="searchInput" class="form-control me-2" 
                               placeholder="Tìm kiếm theo nhà cung cấp..." 
                               name="search" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </form>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Mã Phiếu</th>
                            <th>Ngày Nhập</th>
                            <th>Nhà Cung Cấp</th>
                            <th>Tổng Tiền</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($receipts as $receipt)
                        <tr>
                            <td>{{ $receipt->MaPhieuNhap }}</td>
                            <td>{{ $receipt->NgayNhap }}</td>
                            <td>{{ $receipt->TenNhaCungCap }}</td>
                            <td>{{ number_format($receipt->TongTien) }} VND</td>
                            <td>
                                <button class="btn btn-primary btn-sm btn-action" 
                                    onclick="window.location.href='{{ route('StockEntry.show', $receipt->MaPhieuNhap) }}'">
                                    Xem Chi Tiết
                                </button>

                         
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $receipts->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>

                <!-- Add Receipt Modal (Same as previous implementation) -->
                <div class="modal fade" id="addReceiptModal" tabindex="-1">
                    <!-- Modal content remains the same as in the previous example -->
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('admin/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/bootstrap.min.js') }}"></script>
    <script>
    
    </script>
</body>
</html>