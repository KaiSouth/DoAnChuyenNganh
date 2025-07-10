<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Kaiadmin - Bootstrap 5 Admin Dashboard</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="{{ asset('admin/assets/img/kaiadmin/favicon.ico') }}"
      type="image/x-icon"
    />

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
    <link rel="stylesheet" href="{{asset('admin/assets/css/demo.css')}}  )" />
     <!-- CSS Styles for Pagination -->
    <style>
      /* Reset và style chung */
      * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
      }

      body {
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
          background-color: #f5f7fa;
          color: #2d3748;
      }

      /* Main Panel Styles */
      .main-panel {
          min-height: 100vh;
          padding: 20px;
      }

      .container-fluid {
          max-width: 1400px;
          margin: 0 auto;
      }

      .content-wrapper {
          background-color: #ffffff;
          border-radius: 12px;
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
          padding: 24px;
      }

      /* Header Section */
      .page-header {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom: 24px;
          padding-bottom: 16px;
          border-bottom: 1px solid #e2e8f0;
      }

      .page-title {
          font-size: 24px;
          font-weight: 600;
          color: #1a202c;
      }

      /* Button Styles */
      .btn {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          padding: 10px 20px;
          border-radius: 8px;
          font-weight: 500;
          transition: all 0.2s ease;
          cursor: pointer;
          border: none;
          gap: 8px;
      }

      .btn-primary {
          background-color: #3182ce;
          color: white;
          border: none;
      }

      .btn-primary:hover {
          background-color: #2c5282;
          transform: translateY(-1px);
          box-shadow: 0 2px 4px rgba(49, 130, 206, 0.2);
      }

      /* Search Section */
      .search-section {
          margin-bottom: 24px;
      }

      .input-group {
          display: flex;
          gap: 12px;
      }

      .search-input {
          flex: 1;
          padding: 12px 16px;
          border: 1px solid #e2e8f0;
          border-radius: 8px;
          font-size: 14px;
          transition: all 0.2s ease;
      }

      .search-input:focus {
          outline: none;
          border-color: #3182ce;
          box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
      }

      /* Table Styles */
      
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

      /* Image in table */
      .promotion-image img {
          width: 100px;
          height: 70px;
          object-fit: cover;
          border-radius: 6px;
          box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
      }

      /* Action Buttons */
      .action-buttons .button-group {
          display: flex;
          gap: 8px;
      }

      .btn-action {
          padding: 8px 16px;
          border-radius: 6px;
          font-size: 14px;
          display: inline-flex;
          align-items: center;
          gap: 6px;
          transition: all 0.2s ease;
      }

      .btn-edit {
          background-color: #ed8936;
          color: white;
      }

      .btn-edit:hover {
          background-color: #dd6b20;
          transform: translateY(-1px);
      }

      .btn-delete {
          background-color: #e53e3e;
          color: white;
      }

      .btn-delete:hover {
          background-color: #c53030;
          transform: translateY(-1px);
      }

      /* Modal Styles */
      .modal-dialog {
          max-width: 500px;
          margin: 1.75rem auto;
      }

      .modal-content {
          background-color: #ffffff;
          border-radius: 12px;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
          border: none;
      }

      .modal-header {
          padding: 16px 24px;
          border-bottom: 1px solid #e2e8f0;
      }

      .modal-title {
          font-size: 18px;
          font-weight: 600;
          color: #2d3748;
      }

      .modal-body {
          padding: 24px;
      }

      .form-label {
          display: block;
          margin-bottom: 8px;
          font-weight: 500;
          color: #4a5568;
      }

      .form-control {
          width: 100%;
          padding: 10px 16px;
          border: 1px solid #e2e8f0;
          border-radius: 8px;
          transition: all 0.2s ease;
      }

      .form-control:focus {
          outline: none;
          border-color: #3182ce;
          box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
      }

      /* Pagination Styles */
      .pagination-wrapper {
          margin-top: 24px;
          padding-top: 16px;
          border-top: 1px solid #e2e8f0;
      }

      .pagination-container {
          display: flex;
          justify-content: space-between;
          align-items: center;
      }

      .pagination-nav {
          display: flex;
          gap: 8px;
          align-items: center;
      }

      .page-number {
          padding: 8px 16px;
          border-radius: 6px;
          background-color: #fff;
          border: 1px solid #e2e8f0;
          color: #4a5568;
          text-decoration: none;
          transition: all 0.2s ease;
      }

      .page-number.active {
          background-color: #3182ce;
          color: white;
          border-color: #3182ce;
      }

      .page-number:hover:not(.active) {
          background-color: #f7fafc;
          border-color: #cbd5e0;
      }

      .pagination-info {
          color: #718096;
          font-size: 14px;
      }

      /* Responsive Design */
      @media (max-width: 768px) {
          .page-header {
              flex-direction: column;
              gap: 16px;
          }
          
          .input-group {
              flex-direction: column;
          }
          
          .button-group {
              flex-direction: column;
          }
          
          .btn-action {
              width: 100%;
          }
          
          .pagination-container {
              flex-direction: column;
              gap: 16px;
          }
          
          .table-responsive {
              margin: 10px -16px;
          }
      }
    </style>
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      @include('partials.sidebar')
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="container-fluid px-4 py-4">
            <div class="content-wrapper">
                <!-- Header Section -->
                <div class="page-header mb-4">
                    <h1 class="page-title">Quản lý Chương Trình Khuyến Mãi</h1>
                    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addPromotionModal">
                        Thêm Chương Trình Khuyến Mãi
                    </button>
                </div>
                <!-- Popup Modal Thêm Chương Trình Khuyến Mãi -->
                <div class="modal fade" id="addPromotionModal" tabindex="-1" aria-labelledby="addPromotionModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addPromotionModalLabel">Thêm Chương Trình Khuyến Mãi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('promotions.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="TenChuongTrinhGiamGia" class="form-label">Tên Chương Trình</label>
                                        <input type="text" class="form-control" id="TenChuongTrinhGiamGia" name="TenChuongTrinhGiamGia" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ImageUrl" class="form-label">Hình Ảnh</label>
                                        <input type="file" class="form-control" id="ImageUrl" name="ImageUrl" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="MoTa" class="form-label">Mô Tả</label>
                                        <textarea class="form-control" id="MoTa" name="MoTa" rows="3" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="NgayBatDau" class="form-label">Ngày Bắt Đầu</label>
                                        <input type="date" class="form-control" id="NgayBatDau" name="NgayBatDau" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="NgayKetThuc" class="form-label">Ngày Kết Thúc</label>
                                        <input type="date" class="form-control" id="NgayKetThuc" name="NgayKetThuc" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-primary">Lưu</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Search Section -->
                <div class="search-section mb-4">
                    <form action="{{ route('promotions.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text"
                                   name="search"
                                   class="form-control search-input"
                                   placeholder="Tìm kiếm khuyến mãi..."
                                   value="{{ $search }}">
                            <button type="submit" class="btn btn-primary search-btn">
                                <i class="fas fa-search"></i> Tìm kiếm
                            </button>
                        </div>
                    </form>
                </div>
    
                <!-- Table Section -->
                <div class="table-responsive promotion-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>TÊN CHƯƠNG TRÌNH</th>
                                <th>HÌNH ẢNH</th>
                                <th>MÔ TẢ</th>
                                <th>NGÀY BẮT ĐẦU</th>
                                <th>NGÀY KẾT THÚC</th>
                                <th>HÀNH ĐỘNG</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($promotions as $promotion)
                                <tr>
                                    <td class="promotion-name">{{ $promotion->TenChuongTrinhGiamGia }}</td>
                                    <td class="promotion-image">
                                        <img src="{{ $promotion->ImageUrl }}" alt="Hình ảnh khuyến mãi">
                                    </td>
                                    <td class="promotion-desc">
                                        {{ \Illuminate\Support\Str::limit($promotion->MoTa, 50) }}
                                    </td>
                                    <td class="promotion-date">{{ $promotion->NgayBatDau }}</td>
                                    <td class="promotion-date">{{ $promotion->NgayKetThuc }}</td>
                                    <td class="action-buttons">
                                        <div class="button-group">
                                            <a style="width:104px"  href="{{ route('promotions.show', $promotion->MaChuongTrinhGiamGia) }}" 
                                                class="btn-action btn-edit">
                                                 <i class="fas fa-eye"></i>
                                                 <span> Chi Tiết</span>
                                             </a>
                                             
                                            <form action="{{ route('promotions.destroy', $promotion->MaChuongTrinhGiamGia) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn-action btn-delete"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                    <span>Xóa</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        Không có chương trình khuyến mãi nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
    
                <!-- Pagination Section -->
                @if ($promotions->hasPages())
                    <div class="pagination-wrapper">
                        <div class="pagination-container">
                            <div class="pagination-nav">
                                @if ($promotions->onFirstPage())
                                    <span class="pagination-btn disabled">&laquo; Trước</span>
                                @else
                                    <a href="{{ $promotions->previousPageUrl() }}" class="pagination-btn">&laquo; Trước</a>
                                @endif
    
                                <div class="pagination-numbers">
                                    @for ($i = 1; $i <= $promotions->lastPage(); $i++)
                                        <a href="{{ $promotions->url($i) }}" class="page-number {{ ($promotions->currentPage() == $i) ? 'active' : '' }}">
                                            {{ $i }}
                                        </a>
                                    @endfor
                                </div>
    
                                @if ($promotions->hasMorePages())
                                    <a href="{{ $promotions->nextPageUrl() }}" class="pagination-btn">Sau &raquo;</a>
                                @else
                                    <span class="pagination-btn disabled">Sau &raquo;</span>
                                @endif
                            </div>
                            <div class="pagination-info">
                                Hiển thị {{ $promotions->firstItem() }} đến {{ $promotions->lastItem() }} trong tổng số {{ $promotions->total() }} kết quả
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    


    </div>
    
    <script src="{{asset('admin/assets/js/core/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/core/bootstrap.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/kaiadmin.min.js')}}"></script>
 
  </body>
</html>
