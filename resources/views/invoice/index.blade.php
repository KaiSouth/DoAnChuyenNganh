<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Hóa Đơn</title>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/kaiadmin.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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
            margin-top: 0px !important;
            max-width: 95%;
            margin-left: auto;
            margin-right: auto;
        }

        .header {
            padding: 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 600;
            color: #343a40;
            margin: 0;
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

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th, .table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            vertical-align: middle;
            text-align: center;
        }

        .table th {
            background: #343a40;
            color: white;
            font-weight: 600;
        }

        .status-dropdown {
            padding: 6px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 10px;
        }

        .btn-view {
            display: flex;
    align-items: center;
    gap: 5px;
    padding: 5px 10px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;

        }

        .btn-view:hover {
            background: #218838;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .status-pending {
            background: #ffeeba;
            color: #856404;
        }

        .status-confirmed {
            background: #cce5ff;
            color: #004085;
        }

        .status-preparing {
            background: #d4edda;
            color: #155724;
        }

        .status-delivering {
            background: #b8daff;
            color: #004085;
        }

        .status-completed {
            background: #c3e6cb;
            color: #155724;
        }
        /* CSS */
        .modal-content {
    border-radius: 10px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    font-family: Arial, sans-serif;
}

.modal-header {
    background-color: #f1f1f1;
    padding: 20px;
    border-bottom: 2px solid #ddd;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
}

.modal-body {
    padding: 20px;
}

.detail-title {
    font-weight: bold;
    color: #666;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.detail-value {
    color: #333;
    margin-bottom: 1rem;
    font-size: 1rem;
}

.section-title {
    font-size: 1.2rem;
    font-weight: bold;
    color: #007bff;
    margin-bottom: 1rem;
}

hr {
    margin: 20px 0;
    border: 0;
    border-top: 1px solid #ddd;
}

#invoiceItemsList li {
    margin-bottom: 10px;
    font-size: 1rem;
    color: #007bff;
    font-weight: bold;
}

.text-danger {
    color: #dc3545 !important;
}

.text-warning {
    color: #ffc107 !important;
}


.font-weight-bold {
  font-weight: 600;
}

hr {
  margin: 1.5rem 0;
  border: 1px solid #dee2e6;
}

#invoiceItemsList li {
  margin-bottom: 0.75rem;
  font-size: 1.1rem;
  color: #007bff;
}

#invoiceItemsList li strong {
  font-weight: 600;
}

#invoiceCode, #invoiceDate, #customerName, #transactionType, #totalAmount, #invoiceStatus,
#appointmentDate, #appointmentTime, #appointmentAddress, #appointmentDiagnosis, #appointmentCost {
  font-size: 1.1rem;
  color: #212529;
}

#invoiceCode {
  color: #28a745;
}

#invoiceDate, #appointmentDate, #appointmentTime {
  color: #17a2b8;
}

#totalAmount, #appointmentCost {
  color: #dc3545;
}

#invoiceStatus {
  color: #ffc107;
}

button.btn-close {
  font-size: 1.25rem;
}
.table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            overflow: hidden;
        }

        .table th {
            background: #3498db; /* Màu xanh nước biển */
            color: white; /* Chữ màu trắng để dễ đọc */
            padding: 15px;
            text-align: center;
            border: 1px solid #2980b9; /* Viền màu xanh đậm hơn một chút */
        }


        .table td {
            vertical-align: middle; /* Căn giữa nội dung theo chiều dọc */
    height: 60px; /* Đảm bảo chiều cao tối thiểu cho mỗi ô */
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
            background: #2980b9; /* Màu xanh đậm hơn khi hover */
            cursor: pointer; 
        }
        /* Container for the items */
.items-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    margin-top: 20px;
}

/* Individual item card */
.item-card {
    width: 220px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    background-color: #ffffff;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Card image section */
.item-card-image {
    position: relative;
    width: 100%;
    height: 160px;
    background-color: #f8f9fa;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Image styling */
.item-image {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
    border-radius: 5px;
}

/* Card details section (name and price) */
.item-card-details {
    padding: 15px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

/* Item name */
.item-name {
    font-size: 16px;
    font-weight: bold;
    color: #333;
    margin-bottom: 8px;
    line-height: 1.3;
}

/* Item price */
.item-price {
    font-size: 14px;
    color: #27ae60;
    font-weight: 600;
}

/* Hover effect */
.item-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
}

/* Optional: Small adjustments to spacing */
#invoiceItemsList {
    margin-top: 20px;
}
/* Container để căn chỉnh dropdown và nút */
.action-container {
    display: flex; /* Sử dụng Flexbox */
    align-items: center; /* Căn giữa theo chiều dọc */
    justify-content: space-between; /* Khoảng cách giữa các phần tử */
    gap: 10px; /* Khoảng cách giữa dropdown và nút */
    width: 100%; /* Đảm bảo chiều rộng bao phủ toàn bộ ô */
}

/* Dropdown */
.status-dropdown {
    padding: 5px 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

/* Nút Chi tiết */
.btn-view {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 5px 10px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
}

.btn-view:hover {
    background-color: #218838;
}



    </style>
</head>
<body>
    <div class="wrapper">
        @include('partials.sidebar')
        
        <div class="main-panel">
            <div class="container">
                <div class="header">
                    <h1>Quản lý Hóa Đơn</h1>
                </div>

                <!-- Tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pending-tab" data-bs-toggle="tab" href="#pending">Chờ xác nhận</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="confirmed-tab" data-bs-toggle="tab" href="#confirmed">Đã xác nhận</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="in-progress-tab" data-bs-toggle="tab" href="#in-progress">Đang xử lý</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="completed-tab" data-bs-toggle="tab" href="#completed">Hoàn thành</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="rejected-tab" data-bs-toggle="tab" href="#rejected">Từ Chối Đơn Hàng</a> <!-- Tab mới -->
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content">
                    @foreach(['pending', 'confirmed', 'in-progress', 'completed','rejected'] as $status)
                    <div class="tab-pane fade {{ $status == 'pending' ? 'show active' : '' }}" id="{{ $status }}">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Mã HĐ</th>
                                        <th>Ngày xuất</th>
                                        <th>Khách hàng</th>
                                        <th>Loại giao dịch</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($invoices[$status]) > 0)
                                    @foreach($invoices[$status] as $invoice)
                                    <tr>
                                        <td>#{{ $invoice->MaHoaDon }}</td>
                                        <td>{{ date('d/m/Y', strtotime($invoice->NgayXuatHoaDon)) }}</td>
                                        <td>{{ $invoice->HoTen }}</td>
                                        <td>
                                            <span class="badge {{ $invoice->LoaiGiaoDich == 'VatTu' ? 'bg-primary' : 'bg-info' }}">
                                                {{ $invoice->LoaiGiaoDich }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($invoice->TongTien, 0, ',', '.') }}đ</td>
                                        <td>
                                            <span class="status-badge status-{{ strtolower($invoice->TrangThai) }}">
                                                {{ $invoice->TrangThai }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-container">
                                                @if($status != 'rejected' && $status != 'completed')
                                                    <select style="width:130px;" class="status-dropdown" onchange="updateStatus({{ $invoice->MaHoaDon }}, this.value)">
                                                        @if($invoice->has_vattu > 0)
                                                            @foreach($statusOptions['VatTu'] as $option)
                                                                <option value="{{ $option }}" {{ $invoice->TrangThai == $option ? 'selected' : '' }}>
                                                                    {{ $option }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            @foreach($statusOptions['DichVu'] as $option)
                                                                <option value="{{ $option }}" {{ $invoice->TrangThai == $option ? 'selected' : '' }}>
                                                                    {{ $option }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                @endif
                                                <button style="width:90px;" class="btn-view" onclick="viewInvoice({{ $invoice->MaHoaDon }})">
                                                    <i class="fas fa-eye"></i> Chi tiết
                                                </button>
                                            </div>
                                        </td>
                                        
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">Chưa có hóa đơn</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

   <!-- Invoice Detail Modal -->
<div class="modal fade" id="invoiceDetailModal" tabindex="-1" aria-labelledby="invoiceDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceDetailModalLabel">Chi tiết hóa đơn</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="invoiceDetailContent">
                <div id="invoiceDetail" class="container-fluid">
                    <!-- Invoice Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="detail-title">Mã hóa đơn:</p>
                            <p class="detail-value" id="invoiceCode"></p>
                            <p class="detail-title">Ngày xuất:</p>
                            <p class="detail-value" id="invoiceDate"></p>
                            <p class="detail-title">Khách hàng:</p>
                            <p class="detail-value" id="customerName"></p>
                        </div>
                        <div class="col-md-6">
                            <p class="detail-title">Loại giao dịch:</p>
                            <p class="detail-value" id="transactionType"></p>
                            <p class="detail-title">Tổng tiền:</p>
                            <p class="detail-value text-danger" id="totalAmount"></p>
                            <p class="detail-title">Trạng thái:</p>
                            <p class="detail-value text-warning" id="invoiceStatus"></p>
                        </div>
                    </div>
                    <hr>
                    <!-- Appointment Info -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="section-title">Thông tin lịch khám:</h6>
                        </div>
                        <div class="col-md-6">
                            <p class="detail-title">Ngày khám:</p>
                            <p class="detail-value" id="appointmentDate"></p>
                            <p class="detail-title">Giờ khám:</p>
                            <p class="detail-value" id="appointmentTime"></p>
                        </div>
                        <div class="col-md-6">
                            <p class="detail-title">Địa chỉ:</p>
                            <p class="detail-value" id="appointmentAddress"></p>
                            <p class="detail-title">Chuẩn đoán:</p>
                            <p class="detail-value" id="appointmentDiagnosis"></p>
                            <p class="detail-title">Chi phí khám:</p>
                            <p class="detail-value text-danger" id="appointmentCost"></p>
                        </div>
                    </div>
                    <hr>
                    <!-- Product/Service Details -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="section-title">Chi tiết sản phẩm/dịch vụ:</h6>
                            <ul id="invoiceItemsList" class="list-unstyled"></ul>
                        </div>
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
        function updateStatus(invoiceId, newStatus) {
            if (confirm('Bạn có chắc muốn cập nhật trạng thái hóa đơn này?')) {
                fetch(`/invoices/${invoiceId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra khi cập nhật trạng thái');
                    }
                });
            }
        }

        function viewInvoice(invoiceId) {
            fetch(`/invoices/${invoiceId}/detail`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('invoiceDetailContent').innerHTML = html;
                    new bootstrap.Modal(document.getElementById('invoiceDetailModal')).show();
                });
        }
        function viewInvoice(invoiceId) {
    $.ajax({
        url: '/invoices/' + invoiceId, // Call the show route
        method: 'GET',
        success: function(response) {
            const invoiceDetails = response.invoice; // Danh sách chi tiết hóa đơn
            console.log('Invoice details:', invoiceDetails);

            if (invoiceDetails.length === 0) {
                alert("Không tìm thấy chi tiết hóa đơn!");
                return;
            }

            // Lấy thông tin hóa đơn chung từ dòng đầu tiên
            const invoice = invoiceDetails[0];
            $('#invoiceCode').text(invoice.MaHoaDon);
            $('#invoiceDate').text(formatDate(invoice.NgayXuatHoaDon));
            $('#customerName').text(invoice.TenKhachHang);
            $('#transactionType').text(invoice.LoaiGiaoDich);
            $('#totalAmount').text(formatCurrency(invoice.TongTien));
            $('#invoiceStatus').text(invoice.TrangThai);

            // Lấy thông tin lịch hẹn (nếu có)
            $('#appointmentDate').text(formatDate(invoice.NgayKham));
            $('#appointmentTime').text(invoice.GioKham);
            $('#appointmentAddress').text(invoice.DiaChi);
            $('#appointmentDiagnosis').text(invoice.ChuanDoan);
            $('#appointmentCost').text(formatCurrency(invoice.ChiPhiKham));

            // Xây dựng danh sách vật tư và dịch vụ
            let itemsListHtml = `<div class="items-container">`;

                invoiceDetails.forEach(item => {
    // Vật tư
    if (item.TenVatTu) {
        const vatTuEditUrl = `/products-services/edit/vattu/${item.MaVatTu}`;

        itemsListHtml += `
            <a href="${vatTuEditUrl}" class="item-link">
                <div class="item-card">
                    <div class="item-card-image">
                        <img src="${item.VatTuHinhAnh ? item.VatTuHinhAnh : '/Image/img_product/default.jpg'}" alt="" class="item-image">
                    </div>
                    <div class="item-card-details">
                        <strong class="item-name">${item.TenVatTu}</strong>
                        <span class="item-price">${formatCurrency(item.DonGiaBan)}</span>
                        <span class="item-quantity">Số lượng: ${item.SoLuong}</span>
                    </div>
                </div>
            </a>
        `;
    }

    // Dịch vụ
    if (item.TenDichVu) {
        const dichVuEditUrl = `/products-services/edit/dichvu/${item.MaDichVu}`;

        itemsListHtml += `
            <a href="${dichVuEditUrl}" class="item-link">
                <div class="item-card">
                    <div class="item-card-image">
                        <img src="${item.DichVuHinhAnh ? item.DichVuHinhAnh : '/Image/img_service/default.jpg'}" alt="" class="item-image">
                    </div>
                    <div class="item-card-details">
                        <strong class="item-name">${item.TenDichVu}</strong>
                        <span class="item-price">${formatCurrency(item.DonGia)}</span>
                        <span class="item-quantity">Số lượng: ${item.SoLuong}</span>
                    </div>
                </div>
            </a>
        `;
    }
});


            itemsListHtml += `</div>`; // Đóng container

            // Cập nhật modal với danh sách vật tư/dịch vụ
            $('#invoiceItemsList').html(itemsListHtml);

            // Hiển thị modal
            $('#invoiceDetailModal').modal('show');
        },
        error: function(error) {
            console.log('Error fetching invoice details:', error);
        }
    });
}




// Function to format date
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString(); // Bạn có thể tùy chỉnh định dạng ngày tháng
}

// Function to format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
}



    </script>
</body>
</html>