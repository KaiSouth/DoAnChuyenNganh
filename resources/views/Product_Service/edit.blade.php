<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa {{ $itemType === 'vattu' ? 'Vật tư' : 'Dịch vụ' }}</title>
    <link rel="stylesheet" href="{{asset('admin/assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/plugins.min.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/kaiadmin.min.css')}}" />
    <style>
        /* Đảm bảo không có phần tử nào phủ lên */
    
        :root {
            --primary-gradient: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            --secondary-gradient: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
            --text-primary: #2c3e50;
            --text-secondary: #34495e;
            --background-primary: #f4f6f9;
            --background-secondary: #ffffff;
            --border-radius: 16px;
            --box-shadow: 0 15px 35px rgba(0,0,0,0.1), 0 5px 15px rgba(0,0,0,0.07);
        }
    
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }
    
        body {
            font-family: 'Inter', sans-serif;
            background: var(--background-primary);
            line-height: 1.6;
            color: var(--text-primary);
            overflow-x: hidden;
        }
    
        .luxe-container {
            display: flex;
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
        }
    
        .luxe-sidebar {
            width: 280px;
            background: var(--primary-gradient);
            color: white;
            padding: 30px 20px;
            box-shadow: -10px 0 30px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }
    
        .luxe-main-content {
            position: relative;
            z-index: 2;
            flex-grow: 1;
            padding: 40px;
            background: transparent;
        }
    
        .luxe-card {
            background: var(--background-secondary);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 40px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }
    
        .luxe-form-group {
            margin-bottom: 25px;
            position: relative;
        }
    
        .luxe-form-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--text-secondary);
            position: relative;
            padding-left: 15px;
        }
    
        /* Xóa phần tử ::before trong label */
        .luxe-form-label .label-icon {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 16px;
            background: var(--primary-gradient);
            border-radius: 3px;
        }
    
        .luxe-form-control {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e0e6ed;
            border-radius: var(--border-radius);
            font-size: 16px;
            background: #f9fafc;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
    
        .luxe-form-control:focus {
            border-color: #5e72e4;
            box-shadow: 0 0 0 3px rgba(94,114,228,0.1);
            outline: none;
        }
    
        .image-upload-container {
            position: relative;
            max-width: 300px;
            margin: 0 auto 25px;
        }
    
        .image-preview {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }
    
        .image-upload-overlay {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(255,255,255,0.9);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            cursor: pointer;
        }
    
        .luxe-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 15px;
        }
    
        .luxe-table th {
            background: var(--primary-gradient);
            color: white;
            padding: 15px;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }
    
        .luxe-table tr {
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
    
        .luxe-table td {
            padding: 15px;
            border-bottom: 1px solid #f1f3f5;
        }
    
        .luxe-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 15px 25px;
            border-radius: var(--border-radius);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
    
        .luxe-btn-primary {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 10px 20px rgba(37,117,252,0.3);
        }
    
        .luxe-btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 25px rgba(37,117,252,0.4);
        }
    
        .luxe-btn-secondary {
            background: var(--secondary-gradient);
            color: white;
            box-shadow: 0 10px 20px rgba(253,160,133,0.3);
        }
    
        .luxe-btn-secondary:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 25px rgba(253,160,133,0.4);
        }
    
        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 20px;
            margin-top: 30px;
        }
    
        input, textarea, select {
            pointer-events: auto;
            z-index: 10;
        }
    
        @media (max-width: 768px) {
            .luxe-sidebar {
                width: 100%;
                position: static;
                height: auto;
            }
    
            .luxe-main-content {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
    
</head>
<body>
    <div class="wrapper">
        @include('partials.sidebar')

        <div class="main-panel">
            <div class="luxe-main-content">
                <div class="luxe-card">
                    <h2 class="mb-4">
                        <i class="{{ $itemType === 'vattu' ? 'fas fa-boxes' : 'fas fa-concierge-bell' }} me-2"></i>
                        Chỉnh sửa {{ $itemType === 'vattu' ? 'Vật tư' : 'Dịch vụ' }}
                    </h2>
        
                    <form action="{{ route('products_services.update', ['itemType' => $itemType, 'id' => $item->MaVatTu ?? $item->MaDichVu]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
        
                        @if($itemType === 'vattu')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="image-upload-container">

                                    <img src="{{ $item->HinhAnh ? $item->HinhAnh : asset('Image/img_product/default.jpg') }}" 
                                    alt="{{ $item->TenVatTu }}" class="image-preview">
                               
                                    
                                </div>
                                <div class="mb-3">
                                    <label for="HinhAnh" class="form-label">Hình Ảnh:</label>
                                    <input type="file" class="form-control" id="HinhAnh" name="HinhAnh" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6 luxe-form-group">
                                        <label class="luxe-form-label">Tên vật tư</label>
                                        <input type="text" name="TenVatTu" class="luxe-form-control" value="{{ $item->TenVatTu }}" required>
                                    </div>
                                    <div class="col-md-6 luxe-form-group">
                                        <label class="luxe-form-label">Loại vật tư</label>
                                        <select name="MaLoaiVatTu" class="luxe-form-control" required>
                                            @foreach($loaiVatTu as $loai)
                                                <option value="{{ $loai->MaLoaiVatTu }}" 
                                                    {{ $item->MaLoaiVatTu == $loai->MaLoaiVatTu ? 'selected' : '' }}>
                                                    {{ $loai->TenLoaiVatTu }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
        
                                <div class="row mt-3">
                                    <div class="col-md-6 luxe-form-group">
                                        <label class="luxe-form-label">Đơn vị tính</label>
                                        <input type="text" name="DonViTinh" class="luxe-form-control" value="{{ $item->DonViTinh }}" required>
                                    </div>
                                    <div class="col-md-6 luxe-form-group">
                                        <label class="luxe-form-label">Đơn giá bán</label>
                                        <input type="number" name="DonGiaBan" class="luxe-form-control" value="{{ $item->DonGiaBan }}" required>
                                    </div>
                                </div>
        
                                <div class="row mt-3">
                                    <div class="col-md-12 luxe-form-group">
                                        <label class="luxe-form-label">Nhà cung cấp</label>
                                        <select name="MaNhaCungCap" class="luxe-form-control" required>
                                            @foreach($nhaCungCap as $supplier)
                                                <option value="{{ $supplier->MaNhaCungCap }}"
                                                    {{ $item->MaNhaCungCap == $supplier->MaNhaCungCap ? 'selected' : '' }}>
                                                    {{ $supplier->TenNhaCungCap }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-md-12 luxe-form-group">
                                        <label class="luxe-form-label">Mô tả</label>
                                        <textarea name="MoTa" class="luxe-form-control" rows="3">{{ $item->MoTa }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <div class="mt-4 luxe-card">
                            <h4 class="mb-3">
                                <i class="fas fa-boxes me-2"></i>Danh sách lô hàng
                            </h4>
                            <div class="table-responsive">
                                <table class="luxe-table">
                                    <thead>
                                        <tr>
                                            <th>Mã lô hàng</th>
                                            <th>Ngày sản xuất</th>
                                            <th>Ngày hết hạn</th>
                                            <th>Số lượng tồn kho</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($loHangs as $loHang)
                                        <tr>
                                            <td>{{ $loHang->MaLoHang }}</td>
                                            <td>{{ date('d/m/Y', strtotime($loHang->NgaySanXuat)) }}</td>
                                            <td>{{ date('d/m/Y', strtotime($loHang->NgayHetHan)) }}</td>
                                            <td>
                                                <input type="number" 
                                                       name="soLuong[{{ $loHang->MaLoHang }}]" 
                                                       class="luxe-form-control" 
                                                       value="{{ $loHang->SoLuongTonKho }}" 
                                                       min="0"
                                                       readonly>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
        
                        @else
                        <div class="row">
                            <div class="col-md-4">
                                <div class="image-upload-container">
                                    <img src="{{ $item->HinhAnh ? $item->HinhAnh : asset('Image/img_service/default.jpg') }}" 
     alt="{{ $item->TenDichVu }}" class="image-preview">

                              
                                </div>
                                <div class="mb-3">
                                    <label for="HinhAnh" class="form-label">Hình Ảnh:</label>
                                    <input type="file" class="form-control" id="HinhAnh" name="HinhAnh" accept="image/*">
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6 luxe-form-group">
                                        <label class="luxe-form-label">Tên dịch vụ</label>
                                        <input type="text" name="TenDichVu" class="luxe-form-control" value="{{ $item->TenDichVu }}" required>
                                    </div>
                                    <div class="col-md-6 luxe-form-group">
                                        <label class="luxe-form-label">Loại dịch vụ</label>
                                        <select name="MaLoaiDichVu" class="luxe-form-control" required>
                                            @foreach($loaiDichVu as $loai)
                                                <option value="{{ $loai->MaLoaiDichVu }}" 
                                                    {{ $item->MaLoaiDichVu == $loai->MaLoaiDichVu ? 'selected' : '' }}>
                                                    {{ $loai->TenLoaiDichVu }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                    
                                <div class="row mt-3">
                                    <div class="col-md-12 luxe-form-group">
                                        <label class="luxe-form-label">Đơn giá</label>
                                        <input type="number" name="DonGia" class="luxe-form-control" value="{{ $item->DonGia }}" required>
                                    </div>
                                </div>
                    
                                <div class="row mt-3">
                                    <div class="col-md-12 luxe-form-group">
                                        <label class="luxe-form-label">Mô tả</label>
                                        <textarea name="MoTa" class="luxe-form-control" rows="3">{{ $item->MoTa }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
        
                        <div class="action-buttons">
                            <a href="{{ route('products_services.index') }}" class="luxe-btn luxe-btn-secondary">
                                <i class="fas fa-times me-2"></i>Hủy
                            </a>
                            <button type="submit" class="luxe-btn luxe-btn-primary">
                                <i class="fas fa-save me-2"></i>Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS Files -->
    <script src="{{ asset('admin/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/kaiadmin.min.js') }}"></script>
    <script>
        const currencyInputs = document.querySelectorAll('input[name="DonGiaBan"], input[name="DonGia"]');
        currencyInputs.forEach(input => {
            input.addEventListener('input', function(e) {
                let value = this.value.replace(/\D/g, '');
                if (value !== '') {
                    value = parseInt(value).toLocaleString('vi-VN');
                    this.value = value;
                }
            });

            input.addEventListener('blur', function(e) {
                let value = this.value.replace(/\D/g, '');
                if (value !== '') {
                    this.value = parseInt(value);
                }
            });
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const required = this.querySelectorAll('[required]');
            let isValid = true;

            required.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Vui lòng điền đầy đủ thông tin bắt buộc');
            }
        });
    </script>
</body>
</html>