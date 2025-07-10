<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Kaiadmin - Bootstrap 5 Admin Dashboard</title>
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

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/demo.css')}}" />
    <style>
        .main-panel{
            padding: 10px;
            border-radius: 0px 10px 10px 0px;
            overflow: hidden;
        }
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --background-color: #f0f4f8;
            --card-bg: #ffffff;
            --text-color: #2c3e50;
            --service-badge: #2196F3;
            --material-badge: #4CAF50;
        }

        * {
            transition: all 0.3s ease;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .promotion-hero {
    background: linear-gradient(135deg, var(--primary-color), #6a5acd);
    color: white;
    padding: 1.5rem 0; /* Reduced from 3rem */
    margin-bottom: 1rem; /* Reduced from 2rem */
    position: relative;
    overflow: hidden;
}

.promotion-hero h1 {
    font-size: 2.5rem; /* Reduced from display-5 */
    margin-bottom: 0;
}

.promotion-image-container {
    position: relative;
    perspective: 800px; /* Slightly reduced */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%; /* Hoặc chiều cao cụ thể nếu cần */
}

.promotion-image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain; 
}

.promotion-image {
    width: 100%;
    max-height: 350px; /* Reduced from 500px */
    object-fit: cover;
    border-radius: 12px; /* Slightly smaller */
    box-shadow: 0 10px 25px rgba(0,0,0,0.15); /* Softer shadow */
    transform: scale(1);
    transition: all 0.4s ease;
}

.promotion-image:hover {
    transform: scale(1.01) rotateX(2deg) rotateY(-2deg); /* Less dramatic transform */
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}

        .card-detail {
            background-color: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .detail-label {
            color: var(--secondary-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .detail-value {
            color: var(--text-color);
            font-size: 1rem;
        }

        .table {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .table thead {
            background-color: #f8f9fa;
        }

        .btn-add {
            background: linear-gradient(135deg, var(--primary-color), #6a5acd);
            border: none;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .btn-add:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 25px rgba(0,0,0,0.15);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-up {
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
        }

        .badge-service {
            background-color: var(--service-badge);
            color: white;
        }

        .badge-material {
            background-color: var(--material-badge);
            color: white;
        }
    </style>
  </head>
    <body>
        <div class="wrapper">
            @include('partials.sidebar')
    
            <div class="main-panel" style="overflow: auto">
                <div class="promotion-hero text-center">
                    <div class="container">
                        <h1 class="display-5 fw-bold text-white animate-up" style="animation-delay: 0.2s;">
                            {{ $promotion->TenChuongTrinhGiamGia }}
                        </h1>
                    </div>
                </div>
                
                <div class="container">
                    <div class="row g-4">
                        <form action="{{ route('promotions.updateCtrKM', $promotion->MaChuongTrinhGiamGia) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- Phương thức PUT cho cập nhật -->
                        
                            <div class="row g-4">
                                <!-- Hình ảnh -->
                                <div class="col-lg-7 promotion-image-container animate-up" style="animation-delay: 0.4s;">
                                    <div class="row g-2">
                                        @if($promotion->ImageUrl)
                                            <img src="{{ $promotion->ImageUrl }}" alt="{{ $promotion->TenChuongTrinhGiamGia }}" class="promotion-image img-fluid">
                                        @endif
                                        <div class="mb-3">
                                            <label for="HinhAnh" class="form-label">Hình Ảnh:</label>
                                            <input type="file" class="form-control" id="ImageUrl" name="ImageUrl" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                        
                                <!-- Thông tin khuyến mãi -->
                                <div class="col-lg-5">
                                    <div class="card-detail animate-up" style="animation-delay: 0.6s;">
                                        <div class="row g-3">
                                            <!-- Mô tả -->
                                            <div class="col-12">
                                                <label for="MoTa" class="form-label">Mô Tả</label>
                                                <textarea class="form-control" id="MoTa" name="MoTa" rows="3">{{ $promotion->MoTa }}</textarea>
                                            </div>
                        
                                            <!-- Ngày bắt đầu -->
                                            <div class="col-6">
                                                <label for="NgayBatDau" class="form-label">Ngày Bắt Đầu</label>
                                                <input type="date" class="form-control" id="NgayBatDau" name="NgayBatDau" value="{{ $promotion->NgayBatDau }}">
                                            </div>
                        
                                            <!-- Ngày kết thúc -->
                                            <div class="col-6">
                                                <label for="NgayKetThuc" class="form-label">Ngày Kết Thúc</label>
                                                <input type="date" class="form-control" id="NgayKetThuc" name="NgayKetThuc" value="{{ $promotion->NgayKetThuc }}">
                                            </div>
                                        </div>
                        
                                        <!-- Nút Cập nhật -->
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-success">Cập Nhật</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                    </div>
            
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card-detail animate-up" style="animation-delay: 0.8s;">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h3 class="mb-0">Danh sách Chi Tiết Khuyến Mãi</h3>
                                    <button type="button" class="btn btn-add" onclick="openDetailModal(false)">
                                        <i class="fas fa-plus me-2"></i> Thêm Chi Tiết
                                    </button>
                                </div>
                                
                                @if($details->isEmpty())
                                    <div class="alert alert-info text-center">
                                        Chưa có chi tiết khuyến mãi nào cho chương trình này.
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>TÊN</th>
                                                    <th>LOẠI</th>
                                                    <th>PHẦN TRĂM GIẢM</th>
                                                    <th>GIẢM TỐI ĐA</th>
                                                    <th>SỐ LƯỢNG</th>
                                                    <th>HÀNH ĐỘNG</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($details as $detail)
                                                    <tr class="animate-up" style="animation-delay: {{ $loop->index * 0.1 }}s">
                                                        <td>{{ $detail->MaDichVu ? $detail->TenDichVu : $detail->TenVatTu }}</td>
                                                        <td>
                                                            <span class="badge {{ $detail->MaDichVu ? 'badge-service' : 'badge-material' }}">
                                                                {{ $detail->MaDichVu ? 'Dịch Vụ' : 'Vật Tư' }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $detail->PhanTramGiam }}%</td>
                                                        <td>{{ number_format($detail->GiamToiDa) }}đ</td>
                                                        <td>{{ $detail->SoLuong }}</td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <button type="button" class="btn btn-warning btn-sm" 
                                                                        onclick="openDetailModal(true, {{ json_encode($detail) }})">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <form action="{{ route('promotions.deleteDetail', ['promotionId' => $promotion->MaChuongTrinhGiamGia, 'detailId' => $detail->MaChiTietGiamGia]) }}" 
                                                                    method="POST" 
                                                                    style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" 
                                                                            class="btn btn-danger btn-sm"
                                                                            onclick="return confirm('Bạn có chắc chắn muốn xóa chi tiết này?')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="detailModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Thêm Chi Tiết Khuyến Mãi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="detailForm" method="POST">
                            @csrf
                            <input type="hidden" name="_method" id="formMethod" value="POST">
                            
                            <div class="mb-3">
                                <label for="type" class="form-label">Loại</label>
                                <select id="type" name="type" class="form-select" required>
                                    <option value="">Chọn loại</option>
                                    <option value="dichvu">Dịch Vụ</option>
                                    <option value="vattu">Vật Tư</option>
                                </select>
                            </div>
                            
                            <div id="select-item-container" class="mb-3">
                                <!-- Dynamic content will be populated here -->
                            </div>
                            
                            <div class="mb-3">
                                <label for="PhanTramGiam" class="form-label">Phần Trăm Giảm</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="PhanTramGiam" name="PhanTramGiam" required min="0" max="100">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="GiamToiDa" class="form-label">Giảm Tối Đa</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="GiamToiDa" name="GiamToiDa" required min="0">
                                    <span class="input-group-text">đ</span>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="SoLuong" class="form-label">Số Lượng</label>
                                <input type="number" class="form-control" id="SoLuong" name="SoLuong" required min="1">
                            </div>
                            
                            <div class="modal-footer px-0 pb-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" id="submitButton" class="btn btn-primary">Thêm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('admin/assets/js/core/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('admin/assets/js/core/popper.min.js') }}"></script>
        <script src="{{ asset('admin/assets/js/core/bootstrap.min.js') }}"></script>
        <script src="{{ asset('admin/assets/js/kaiadmin.min.js') }}"></script>
        <script>
            function openDetailModal(isEdit = false, detail = null) {
                document.getElementById('detailModalLabel').innerText = isEdit ? 'Sửa Chi Tiết Khuyến Mãi' : 'Thêm Chi Tiết Khuyến Mãi';
                document.getElementById('submitButton').innerText = isEdit ? 'Cập Nhật' : 'Thêm';
                const form = document.getElementById('detailForm');
                const methodField = document.getElementById('formMethod');
                
                if (isEdit) {
                    form.action = `/promotions/{{ $promotion->MaChuongTrinhGiamGia }}/details/${detail.MaChiTietGiamGia}`;
                    methodField.value = 'PUT';
                } else {
                    form.action = `/promotions/{{ $promotion->MaChuongTrinhGiamGia }}/details`;
                    methodField.value = 'POST';
                }
                
                if (isEdit && detail) {
                    document.getElementById('type').value = detail.MaDichVu ? 'dichvu' : 'vattu';
                    document.getElementById('PhanTramGiam').value = detail.PhanTramGiam;
                    document.getElementById('GiamToiDa').value = detail.GiamToiDa;
                    document.getElementById('SoLuong').value = detail.SoLuong;
                    updateSelectItem(detail.MaDichVu ? 'dichvu' : 'vattu', detail.MaDichVu || detail.MaVatTu);
                } else {
                    form.reset();
                    document.getElementById('select-item-container').innerHTML = '';
                }
                
                $('#detailModal').modal('show');
            }

            document.getElementById('type').addEventListener('change', function() {
                updateSelectItem(this.value);
            });

            function updateSelectItem(type, selectedId = null) {
                let container = document.getElementById('select-item-container');
                container.innerHTML = '';
                
                if (type === 'dichvu') {
                    let html = `
                        <label for="MaDichVu" class="form-label">Chọn Dịch Vụ</label>
                        <select id="MaDichVu" name="MaDichVu" class="form-select" required>
                            <option value="">Chọn Dịch Vụ</option>
                            @foreach($services as $service)
                                <option value="{{ $service->MaDichVu }}" ${selectedId == '{{ $service->MaDichVu }}' ? 'selected' : ''}>
                                    {{ $service->TenDichVu }}
                                </option>
                            @endforeach
                        </select>`;
                    container.innerHTML = html;
                } else if (type === 'vattu') {
                let html = `
                        <label for="MaVatTu" class="form-label">Chọn Vật Tư</label>
                        <select id="MaVatTu" name="MaVatTu" class="form-select" required>
                            <option value="">Chọn Vật Tư</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->MaVatTu }}" ${selectedId == '{{ $material->MaVatTu }}' ? 'selected' : ''}>
                                    {{ $material->TenVatTu }}
                                </option>
                            @endforeach
                        </select>`;
                    container.innerHTML = html;
                }
            }

            // Add form validation
            document.getElementById('detailForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const type = document.getElementById('type').value;
                const phanTramGiam = document.getElementById('PhanTramGiam').value;
                const giamToiDa = document.getElementById('GiamToiDa').value;
                const soLuong = document.getElementById('SoLuong').value;
                
                // Basic validation
                if (!type) {
                    alert('Vui lòng chọn loại');
                    return;
                }
                
                if (type === 'dichvu' && !document.getElementById('MaDichVu').value) {
                    alert('Vui lòng chọn dịch vụ');
                    return;
                }
                
                if (type === 'vattu' && !document.getElementById('MaVatTu').value) {
                    alert('Vui lòng chọn vật tư');
                    return;
                }
                
                if (phanTramGiam < 0 || phanTramGiam > 100) {
                    alert('Phần trăm giảm phải từ 0 đến 100');
                    return;
                }
                
                if (giamToiDa < 0) {
                    alert('Giảm tối đa không được âm');
                    return;
                }
                
                if (soLuong < 1) {
                    alert('Số lượng phải lớn hơn 0');
                    return;
                }
                
                // If validation passes, submit the form
                this.submit();
            });

            // Format currency inputs
            function formatCurrency(input) {
                let value = input.value.replace(/\D/g, '');
                value = new Intl.NumberFormat('vi-VN').format(value);
                input.value = value;
            }

            // Add animation for table rows
            document.addEventListener('DOMContentLoaded', function() {
                const tableRows = document.querySelectorAll('tbody tr');
                tableRows.forEach((row, index) => {
                    row.style.animation = `fadeIn 0.3s ease-in-out ${index * 0.1}s forwards`;
                });
            });

            // Add tooltip initialization
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Add custom styles for animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes fadeIn {
                    from {
                        opacity: 0;
                        transform: translateY(10px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                
                .table tbody tr {
                    opacity: 0;
                }
                
                .badge {
                    font-weight: 500;
                    padding: 6px 12px;
                    border-radius: 6px;
                }
                
                .bg-info {
                    background-color: #E3F2FD !important;
                    color: #1976D2;
                }
                
                .bg-success {
                    background-color: #E8F5E9 !important;
                    color: #2E7D32;
                }
                
                .input-group-text {
                    background-color: #f8f9fa;
                    border-color: #dee2e6;
                }
                
                .form-control:focus + .input-group-text {
                    border-color: var(--primary-color);
                }
                
                .alert {
                    border-radius: 8px;
                    padding: 16px;
                    border: none;
                    background-color: #E3F2FD;
                    color: #1976D2;
                }
                
                .modal-backdrop.show {
                    opacity: 0.7;
                }
                
                .modal.fade .modal-dialog {
                    transform: scale(0.95);
                    transition: transform 0.2s ease-out;
                }
                
                .modal.show .modal-dialog {
                    transform: none;
                }
            `;
            document.head.appendChild(style);
        </script>
            <!-- Core JS Files -->

    </body>

</html>
