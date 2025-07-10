<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Dịch Vụ và Vật Tư</title>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/kaiadmin.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
        .header-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .icon-trash {
            background-color: #dc3545;
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .icon-trash i {
            font-size: 1.2rem;
        }

        .icon-trash:hover {
            background-color: #c82333;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background-color: rgba(76, 175, 80, 0.1);
            border: 1px solid var(--success-color);
            color: var(--success-color);
        }

        .alert-icon {
            width: 24px;
            height: 24px;
        }

        .alert-message {
            flex: 1;
            font-weight: 500;
        }
   </style>
</head>
<body>
  
    
    <div class="wrapper">
        <!-- Sidebar -->
        @include('partials.sidebar')
        <!-- End Sidebar -->

        
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
                    <h1>Quản lý Dịch Vụ và Vật Tư</h1>
                    <div class="header-buttons">
                        <button class="btn-add-item" data-bs-toggle="modal" data-bs-target="#addItemModal">+ Thêm Vật Tư</button>
                        <a href="{{ route('products_services.trash') }}" class="icon-trash" title="Thùng Rác">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>         
                </div>
                
                <!-- Add Item Modal -->
                <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addItemModalLabel">Thêm Vật Tư hoặc Dịch Vụ</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addItemForm" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="itemType" class="form-label">Chọn loại:</label>
                                        <select id="itemType" class="form-select" onchange="handleItemTypeChange()">
                                            <option value="">-- Chọn --</option>
                                            <option value="vattu">Vật Tư</option>
                                            <option value="dichvu">Dịch Vụ</option>
                                        </select>
                                    </div>  
                                    <div class="mb-3" id="itemCategoryContainer" style="display: none;">
                                        <label for="itemCategory" class="form-label">Loại:</label>
                                        <select id="itemCategory" class="form-select">
                                            <!-- Options sẽ được thêm vào thông qua JavaScript -->
                                        </select>
                                    </div>
                                    <div id="vattuFields" style="display: none;">
                                        <div class="mb-3">
                                            <label for="TenVatTu" class="form-label">Tên Vật Tư:</label>
                                            <input type="text" class="form-control" id="TenVatTu" name="TenVatTu">
                                        </div>
                                        <div class="mb-3">
                                            <label for="DonViTinh" class="form-label">Đơn Vị Tính:</label>
                                            <input type="text" class="form-control" id="DonViTinh" name="DonViTinh">
                                        </div>
                                        <div class="mb-3">
                                            <label for="DonGiaBan" class="form-label">Đơn Giá Bán:</label>
                                            <input type="number" class="form-control" id="DonGiaBan" name="DonGiaBan">
                                        </div>
                                        <div class="mb-3">
                                            <label for="MoTaVatTu" class="form-label">Mô Tả Vật Tư:</label>
                                            <textarea class="form-control" id="MoTaVatTu" name="MoTaVatTu"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="NhaCungCap" class="form-label">Nhà Cung Cấp:</label>
                                            <select id="NhaCungCap" class="form-select" name="MaNhaCungCap">
                                                <option value="">-- Chọn Nhà Cung Cấp --</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    
                                    <div id="dichvuFields" style="display: none;">
                                        <div class="mb-3">
                                            <label for="TenDichVu" class="form-label">Tên Dịch Vụ:</label>
                                            <input type="text" class="form-control" id="TenDichVu" name="TenDichVu">
                                        </div>
                                        <div class="mb-3">
                                            <label for="DonGia" class="form-label">Đơn Giá:</label>
                                            <input type="number" class="form-control" id="DonGia" name="DonGia">
                                        </div>
                                        <div class="mb-3">
                                            <label for="MoTaDichVu" class="form-label">Mô Tả Dịch Vụ:</label>
                                            <textarea class="form-control" id="MoTaDichVu" name="MoTaDichVu"></textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="HinhAnh" class="form-label">Hình Ảnh:</label>
                                        <input type="file" class="form-control" id="HinhAnh" name="HinhAnh" accept="image/*">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="button" class="btn btn-primary" onclick="submitForm()">Lưu</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div class="toolbar">
                    <div class="search-section">
                        <form action="{{ route('products_services.index') }}" method="GET" class="d-flex flex-grow-1 gap-2">
                            <input type="text" name="search" class="search-input" placeholder="Tìm kiếm dịch vụ hoặc vật tư..." value="{{ $search }}">
                            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                        </form>
                    </div>
                </div>

                <!-- Tabs -->
                <ul class="nav nav-tabs" id="productServiceTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ request()->input('tab') != 'vattu' ? 'active' : '' }}" id="dichvu-tab" data-bs-toggle="tab" href="#dichvu" role="tab">Dịch Vụ</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ request()->input('tab') == 'vattu' ? 'active' : '' }}" id="vattu-tab" data-bs-toggle="tab" href="#vattu" role="tab">Vật Tư</a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="productServiceTabContent">
                    <!-- Dịch Vụ Tab -->
                    <div class="tab-pane fade {{ request()->input('tab') != 'vattu' ? 'show active' : '' }}" id="dichvu" role="tabpanel">
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
                                    @foreach ($dichVus as $dichVu)
                                    <tr>
                                        <td>{{ $dichVu->TenDichVu }}</td>
                                        <td>
                                            <img src="{{ $dichVu->HinhAnh 
                                            ? $dichVu->HinhAnh 
                                                        : asset('Image/img_service/default.jpg') }}"
                                            alt="{{ $dichVu->HinhAnh }}" 
                                            class="img-fluid">
                                        
                                        </td>
                                        <td>{{ number_format($dichVu->DonGia) }}đ</td>
                                        <td>{{ \Illuminate\Support\Str::limit($dichVu->MoTa, 50) }}</td>
                                        <td>{{ $dichVu->TenLoaiDichVu }}</td>
                                      
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn-edit" onclick="window.location.href='{{ route('products_services.edit', ['dichvu', 'id' => $dichVu->MaDichVu]) }}'">xem</button>
                                                <button class="btn-delete" onclick="deleteItem('dichvu', {{ $dichVu->MaDichVu }})">Xóa</button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination-wrapper">
                            {{ $dichVus->appends(['search' => $search, 'tab' => 'dichvu'])->fragment('dichvu')->links('pagination::bootstrap-4') }}
                        </div>
                    </div>

                    <!-- Vật Tư Tab -->
                    <div class="tab-pane fade {{ request()->input('tab') == 'vattu' ? 'show active' : '' }}" id="vattu" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tên Vật Tư</th>
                                        <th>Hình Ảnh</th>
                                        <th>Nhà Cung Cấp</th>
                                        <th>Đơn Vị Tính</th>
                                        <th>Đơn Giá Bán</th>
                                        <th>Mô Tả</th>
                                        <th>Loại Vật Tư</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vatTus as $vatTu)
                                    <tr>
                                        <td>{{ $vatTu->TenVatTu }}</td>
                                        <td>
                                            <img src="{{ $vatTu->HinhAnh 
                                            ? $vatTu->HinhAnh 
                                            : asset('Image/img_product/default.jpg') }}"
                                 alt="{{ $vatTu->TenVatTu }}" class="img-fluid">
                            
                                        </td>
                                        <td>{{ $vatTu->TenNhaCungCap ?? 'Chưa xác định' }}</td> <!-- Hiển thị tên nhà cung cấp -->
                                        
                                        
                                        <td>{{ $vatTu->DonViTinh }}</td>
                                        <td>{{ number_format($vatTu->DonGiaBan) }}đ</td>
                                        <td>{{ \Illuminate\Support\Str::limit($vatTu->MoTa, 50) }}</td>
                                        <td>{{ $vatTu->TenLoaiVatTu }}</td>
                                   
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn-edit" onclick="window.location.href='{{ route('products_services.edit', ['vattu', 'id' => $vatTu->MaVatTu]) }}'">xem</button>
                                                <button class="btn-delete" onclick="deleteItem('vattu', {{ $vatTu->MaVatTu }})">Xóa</button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination-wrapper">
                            {{ $vatTus->appends(['search' => $search, 'tab' => 'vattu'])->fragment('vattu')->links('pagination::bootstrap-4') }}
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
        document.addEventListener('DOMContentLoaded', function () {
            let urlParams = new URLSearchParams(window.location.search);
            let activeTab = urlParams.get('tab') || 'dichvu';
            let tabElement = document.getElementById(`${activeTab}-tab`);
            if (tabElement) {
                new bootstrap.Tab(tabElement).show();
            }

            document.querySelectorAll('.nav-link').forEach(tab => {
                tab.addEventListener('click', function () {
                    let selectedTab = tab.getAttribute('href').replace('#', '');
                    urlParams.set('tab', selectedTab);
                    window.history.replaceState(null, '', '?' + urlParams.toString());
                });
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            const alertBox = document.querySelector(".alert");
            if (alertBox) {
                setTimeout(() => {
                    alertBox.style.transition = "opacity 0.5s";
                    alertBox.style.opacity = "0";
                    setTimeout(() => alertBox.remove(), 500);
                }, 10000);
            }
        });
    </script>

   <script>
    function submitForm() {
        console.log("Đang gửi form...");
        const formData = new FormData(document.getElementById("addItemForm"));
        const itemType = document.getElementById("itemType").value;
        const itemCategory = document.getElementById("itemCategory").value;
        formData.append("itemType", itemType);
        formData.append("itemCategory", itemCategory);

        if (itemType === 'vattu') {
            formData.append("MoTa", document.getElementById("MoTaVatTu").value);
        } else if (itemType === 'dichvu') {
            formData.append("MoTa", document.getElementById("MoTaDichVu").value);
        }

        fetch('/products-services/add-item', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Thêm mới thành công!');
                location.reload();
            } else {
                console.log("Lỗi chi tiết:", data.error);
                alert('Có lỗi xảy ra!');
            }
        })
        .catch(error => console.error('Error:', error));
    }


    function handleItemTypeChange() {
        const itemType = document.getElementById("itemType").value;
        const itemCategoryContainer = document.getElementById("itemCategoryContainer");
        const itemCategory = document.getElementById("itemCategory");
        const vattuFields = document.getElementById("vattuFields");
        const dichvuFields = document.getElementById("dichvuFields");
        const nhaCungCapSelect = document.getElementById("NhaCungCap");

        if (itemType === "vattu") {
            fetch('/api/loai-vat-tu')
                .then(response => response.json())
                .then(data => {
                    itemCategory.innerHTML = "";
                    data.forEach(category => {
                        const option = document.createElement("option");
                        option.value = category.MaLoaiVatTu;
                        option.textContent = category.TenLoaiVatTu;
                        itemCategory.appendChild(option);
                    });
                    itemCategoryContainer.style.display = "block";
                    vattuFields.style.display = "block";
                    dichvuFields.style.display = "none";

                    // Tải danh sách nhà cung cấp
                    fetch('/api/nha-cung-cap')
                        .then(response => response.json())
                        .then(data => {
                            const nhaCungCapSelect = document.getElementById("NhaCungCap");
                            nhaCungCapSelect.innerHTML = '<option value="">-- Chọn Nhà Cung Cấp --</option>'; // Reset dropdown
                            data.forEach(supplier => {
                                const option = document.createElement("option");
                                option.value = supplier.MaNhaCungCap; // Gửi mã nhà cung cấp
                                option.textContent = supplier.TenNhaCungCap; // Hiển thị tên nhà cung cấp
                                nhaCungCapSelect.appendChild(option);
                            });
                        })
                        .catch(error => console.error("Error loading suppliers:", error));
                });
        } else if (itemType === "dichvu") {
            fetch('/api/loai-dich-vu')
                .then(response => response.json())
                .then(data => {
                    itemCategory.innerHTML = "";
                    data.forEach(category => {
                        const option = document.createElement("option");
                        option.value = category.MaLoaiDichVu;
                        option.textContent = category.TenLoaiDichVu;
                        itemCategory.appendChild(option);
                    });
                    itemCategoryContainer.style.display = "block";
                    dichvuFields.style.display = "block";
                    vattuFields.style.display = "none";
                });
        } else {
            itemCategoryContainer.style.display = "none";
            vattuFields.style.display = "none";
            dichvuFields.style.display = "none";
        }
    }

    function deleteItem(itemType, itemId) {
        
        let itemTypeName = itemType === 'vattu' ? 'vật tư' : 'dịch vụ'; 
        var stringcontext ='Bạn có chắc chắn muốn xóa '+itemTypeName +' này?'
        if (confirm(stringcontext)) {
            fetch('/products-services/delete-item', {
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
