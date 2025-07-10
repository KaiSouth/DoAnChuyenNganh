<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Dịch Vụ và Vật Tư</title>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/kaiadmin.min.css') }}">
   <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f5f7f9;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .main-panel {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px; /* Thêm khoảng cách trên */
            max-width: 95%; /* Giới hạn chiều rộng để không bị sát lề */
            margin-left: auto;
            margin-right: auto;
        }

        .header {
            padding: 28px;
            display: flex;
            align-items: center;
            margin-bottom: 15px; /* Giảm khoảng cách */
        }

        .header h1 {
            font-size: 24px;
            font-weight: 600;
            color: #343a40;
            margin: 0;
        }

        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search-section {
            padding: 5px 28px;

            display: flex;
            gap: 10px;
            align-items: center;
            flex: 1;
        }

        .search-input {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-primary {
            background: #2196F3;
            color: white;
            transition: background 0.3s;
        }

        .btn-primary:hover {
            background: #1e88e5;
        }

        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
            margin-bottom: 15px;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #555;
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 4px 4px 0 0;
        }

        .nav-tabs .nav-link.active {
            background-color: #2196F3;
            color: white;
        }

        .tab-content {
            background: white;
            border-radius: 4px;
        }
        /* Table Styling */
        
      .table {
            width: 100%;
            overflow: hidden;
            border-collapse: separate;
        }

        .table th {
            background: #3498db; /* Màu xanh nước biển */
            color: white; /* Chữ màu trắng để dễ đọc */
            padding: 15px;
            text-align: center;
            border: 1px solid #2980b9; /* Viền màu xanh đậm hơn một chút */
        }

        .table td {
            background: white;
            padding: 15px;
            text-align: center;
            
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .table tr {
            transition: transform 0.3s ease;
        }

        .table tr:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer; 

        }

        .table img {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }


        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .btn-view, .btn-edit, .btn-delete {
            padding: 6px 12px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            color: white;
            font-weight: 500;
            transition: background 0.3s;
        }

        .btn-view {
            background: #28a745;
        }

        .btn-view:hover {
            background: #218838;
        }

        .btn-edit {
            background: #2196F3;
        }

        .btn-edit:hover {
            background: #1e88e5;
        }

        .btn-delete {
            background: #dc3545;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .pagination {
            display: flex;
            gap: 5px;
        }

        .page-link {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: #2196F3;
            text-decoration: none;
        }

        .page-link.active {
            background: #2196F3;
            color: white;
            border-color: #2196F3;
        }
        .header {
            margin-top: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
            padding: 10px 28px; /* Tạo khoảng cách trên dưới */
        }
        .main-panel>.container{
            margin-top:0px !important; 
            margin-left: 10px !important;
        }
        .header h1 {
            font-size: 24px;
            font-weight: 700;
            color: #343a40;
            margin: 0;
        }

        .btn-add-item {
            padding: 8px 16px;
            background: #007bff;
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 8px; /* Tạo bo góc mềm */
            cursor: pointer;
            transition: background 0.3s ease;
            font-size: 14px;
        }

        .btn-add-item:hover {
            background: #0069d9;
        }

        /* Search Container Styling */
        .search-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .search-form {
            display: flex;
            align-items: center;
            background: white;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        .search-input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            outline: none;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .search-input:focus {
            border-color: #2196F3;
        }

        .btn-primary {
            padding: 10px 20px;
            margin-left: 10px;
            background: #2196F3;
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background: #1e88e5;
        }

   </style>
</head>
<body>
  
    <div class="wrapper">
        @include('partials.sidebar')
        
        <div class="main-panel">
            <div class="container">
                <div class="header">
                    <h1>Thùng Rác - Sản Phẩm Đã Xóa</h1>
                    <a href="{{ route('products_services.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>
                
                <!-- Thanh tìm kiếm -->
                <div class="toolbar">
                    <div class="search-section">
                        <form action="{{ route('products_services.trash') }}" method="GET" class="d-flex flex-grow-1 gap-2">
                            <input type="text" name="search" class="search-input" placeholder="Tìm kiếm dịch vụ hoặc vật tư..." value="{{ $search }}">
                            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                        </form>
                    </div>
                </div>
    
                <!-- Tabs cho Vật Tư và Dịch Vụ -->
                <ul class="nav nav-tabs" id="productServiceTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="dichvu-tab" data-bs-toggle="tab" href="#dichvu" role="tab">Dịch Vụ</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="vattu-tab" data-bs-toggle="tab" href="#vattu" role="tab">Vật Tư</a>
                    </li>
                </ul>
                
                <!-- Nội dung Tab -->
                <div class="tab-content" id="productServiceTabContent">
                    <!-- Tab Dịch Vụ -->
                    <div class="tab-pane fade show active" id="dichvu" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tên Dịch Vụ</th>
                                        <th>Hình Ảnh</th>
                                        <th>Đơn Giá</th>
                                        <th>Mô Tả</th>
                                        <th>Loại Dịch Vụ</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($dichVus->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center">Không có dịch vụ nào bị xóa</td>
                                        </tr>
                                    @else
                                        @foreach ($dichVus as $dichVu)
                                        <tr>
                                            <td>{{ $dichVu->TenDichVu }}</td>
                                            <td><img src="{{ asset('images/' . $dichVu->HinhAnh) }}" alt="Hình Ảnh Dịch Vụ" style="width: 50px; height: 50px; object-fit: cover;"></td>
                                            <td>{{ number_format($dichVu->DonGia) }} đ</td>
                                            <td>{{ \Illuminate\Support\Str::limit($dichVu->MoTa, 50) }}</td>
                                            <td>{{ $dichVu->TenLoaiDichVu }}</td>
                                            <td><button class="btn btn-warning" onclick="undoDelete('dichvu', {{ $dichVu->MaDichVu }})">Hoàn Tác</button></td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination-wrapper">
                            {{ $dichVus->appends(['search' => $search, 'tab' => 'dichvu'])->links() }}
                        </div>
                    </div>
    
                    <!-- Tab Vật Tư -->
                    <div class="tab-pane fade" id="vattu" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tên Vật Tư</th>
                                        <th>Hình Ảnh</th>
                                        <th>Đơn Vị Tính</th>
                                        <th>Đơn Giá Bán</th>
                                        <th>Mô Tả</th>
                                        <th>Loại Vật Tư</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($vatTus->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center">Không có vật tư nào bị xóa</td>
                                        </tr>
                                    @else
                                        @foreach ($vatTus as $vatTu)
                                        <tr>
                                            <td>{{ $vatTu->TenVatTu }}</td>
                                            <td><img src="{{ asset('images/' . $vatTu->HinhAnh) }}" alt="Hình Ảnh Vật Tư" style="width: 50px; height: 50px; object-fit: cover;"></td>
                                            <td>{{ $vatTu->DonViTinh }}</td>
                                            <td>{{ number_format($vatTu->DonGiaBan) }} đ</td>
                                            <td>{{ \Illuminate\Support\Str::limit($vatTu->MoTa, 50) }}</td>
                                            <td>{{ $vatTu->TenLoaiVatTu }}</td>
                                            <td><button class="btn btn-warning" onclick="undoDelete('vattu', {{ $vatTu->MaVatTu }})">Hoàn Tác</button></td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination-wrapper">
                            {{ $vatTus->appends(['search' => $search, 'tab' => 'vattu'])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="{{ asset('admin/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/bootstrap.min.js') }}"></script>
    <script>
        function undoDelete(itemType, itemId) {
            if (confirm("Bạn có chắc chắn muốn khôi phục mục này?")) {
                fetch('/products-services/undo-delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        itemType: itemType,
                        id: itemId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.message);
                        console.error(data.error);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>
    

</body>
</html>
