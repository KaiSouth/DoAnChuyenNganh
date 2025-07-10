<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Vấn Đề</title>
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
        }
        .header {
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
        }
        .status-pending {
            background: #ffeeba;
            color: #856404;
        }
        .status-completed {
            background: #c3e6cb;
            color: #155724;
        }
        .btn-action {
            padding: 5px 10px;
            border-radius: 4px;
            margin: 0 5px;
        }
        .btn-view {
            background: #007bff;
            color: white;
            border: none;
        }
        .btn-resolve {
            background: #28a745;
            color: white;
            border: none;
        }
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
    </style>
</head>
<body>
    <div class="wrapper">
        @include('partials.sidebar')
        
        <div class="main-panel">
            <div class="container">
                <div class="header">
                    <h1>Quản lý Vấn Đề</h1>
                </div>

                <!-- Tabs -->
                <ul class="nav nav-tabs mb-4" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pending-tab" data-bs-toggle="tab" href="#pending">
                            Chờ xử lý
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="resolved-tab" data-bs-toggle="tab" href="#resolved">
                            Đã xử lý
                        </a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- Chờ xử lý -->
                    <div class="tab-pane fade show active" id="pending">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Mã Vấn Đề</th>
                                        <th>Mã Hóa Đơn</th>
                                        <th>Trạng Thái</th>
                                        <th>Mô Tả</th>
                                        <th>Hình Ảnh</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($pendingIssues) > 0)
                                    @foreach($pendingIssues as $issue)
                                    <tr>
                                        <td>#{{ $issue->MaVanDe }}</td>
                                        <td>#{{ $issue->MaHoaDon }}</td>
                                        <td>
                                            <span class="status-badge status-pending">{{ $issue->TrangThai }}</span>
                                        </td>
                                        <td>{{ $issue->MoTa }}</td>
                                        <td>
                                            @if($issue->img)
                                                <img src="{{ asset('uploads/issues/' . $issue->img) }}" 
                                                     alt="Issue Image" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <span>Không có</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-action btn-view" 
                                                    onclick="viewInvoice({{ $issue->MaVanDe }})">
                                                <i class="fas fa-eye"></i> Chi tiết
                                            </button>
                                            <button class="btn btn-action btn-resolve" 
                                                    onclick="resolveIssue({{ $issue->MaVanDe }})">
                                                <i class="fas fa-check"></i> Giải quyết
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">Chưa có vấn đề nào cần xử lý</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Đã xử lý -->
                    <div class="tab-pane fade" id="resolved">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Mã Vấn Đề</th>
                                        <th>Mã Hóa Đơn</th>
                                        <th>Trạng Thái</th>
                                        <th>Mô Tả</th>
                                        <th>Hình Ảnh</th>
                                        <th>Thao Tác</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($resolvedIssues) > 0)
                                    @foreach($resolvedIssues as $issue)
                                    <tr>
                                        <td>#{{ $issue->MaVanDe }}</td>
                                        <td>#{{ $issue->MaHoaDon }}</td>
                                        <td>
                                            <span class="status-badge status-completed">{{ $issue->TrangThai }}</span>
                                        </td>
                                        <td>{{ $issue->MoTa }}</td>
                                        <td>
                                            @if($issue->img)
                                                <img src="{{ $issue->img }}" 
                                                     alt="Issue Image" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <span>Không có</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-action btn-view" 
                                                    onclick="viewInvoice({{ $issue->MaVanDe }})">
                                                <i class="fas fa-eye"></i> Chi tiết
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">Chưa có vấn đề nào đã xử lý</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="resolveIssueModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Giải quyết vấn đề</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="resolveIssueForm">
                    <div class="modal-body">
                        <input type="hidden" id="resolveIssueId" name="ma_van_de">
    
                        <div class="mb-3">
                            <label for="resolveInvoiceCode" class="form-label">Mã Hóa Đơn</label>
                            <input type="text" class="form-control" id="resolveInvoiceCode" readonly>
                        </div>
    
                        <div class="mb-3">
                            <label for="resolveStatus" class="form-label">Trạng Thái</label>
                            <select class="form-select" id="resolveStatus" name="status">
                                <option value="Chờ Xử Lý">Chờ Xử Lý</option>
                                <option value="Đã Xử Lý">Đã Xử Lý</option>
                            </select>
                        </div>
    
                        <div class="mb-3">
                            <label for="resolveDescription" class="form-label">Mô Tả</label>
                            <textarea class="form-control" id="resolveDescription" name="description" rows="3"></textarea>
                        </div>
    
                        <div class="mb-3">
                            <label for="resolveImage" class="form-label">Upload Hình Ảnh</label>
                            <input type="file" class="form-control" id="resolveImage" name="image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-success">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal Chi tiết -->
    <div class="modal fade" id="issueDetailModal" tabindex="-1" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chi tiết vấn đề</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="issueDetailContent">
                    <!-- Content will be loaded dynamically -->
                    <div>
                        <h6>Mã Hóa Đơn: <span id="invoiceCode">#12345</span></h6>
                        <p><strong>Ngày xuất hóa đơn: </strong><span id="invoiceDate">2024-01-21</span></p>
                        <p><strong>Khách hàng: </strong><span id="customerName">Lê Thị G</span></p>
                        <p><strong>Loại giao dịch: </strong><span id="transactionType">Banking</span></p>
                        <p><strong>Tổng tiền: </strong><span id="totalAmount">1,000,000 VNĐ</span></p>
                        <p><strong>Trạng thái hóa đơn: </strong><span id="invoiceStatus">Chờ xử lý</span></p>
    
                        <!-- Thông tin xử lý vấn đề -->
                        <p><strong>Trạng thái vấn đề: </strong><span id="issueStatus">Đang xử lý</span></p>
                        <p><strong>Mô tả vấn đề: </strong><span id="issueDescription">Vấn đề chưa rõ</span></p>
    
                        <!-- Hình ảnh xử lý vấn đề -->
                        <div id="issueImageContainer" style="display: none;">
                            <p><strong>Hình ảnh xử lý vấn đề:</strong></p>
                            <img id="issueImage" src="" alt="Hình ảnh xử lý vấn đề" style="width: 100%; max-height: 400px; object-fit: cover;"/>
                        </div>
    
                        <!-- Chi tiết vật tư và dịch vụ -->
                        <div id="invoiceItemsList" class="items-container">
                            <!-- Sẽ được cập nhật với item card layout -->
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
function viewInvoice(invoiceId) {
    $.ajax({
        url: '/issues/' + invoiceId, // Gọi route lấy thông tin hóa đơn
        method: 'GET',
        success: function(response) {
            if (response.success) {
                const invoiceDetails = response.invoice;
                // Cập nhật thông tin cơ bản (chỉ lấy từ hóa đơn đầu tiên)
                const firstInvoice = invoiceDetails[0];
                console.log(firstInvoice);

                $('#invoiceCode').text('#' + (firstInvoice.MaHoaDon || 'N/A'));
                $('#invoiceDate').text(firstInvoice.NgayXuatHoaDon || 'N/A');
                $('#customerName').text(firstInvoice.TenKhachHang || 'N/A');
                $('#transactionType').text(firstInvoice.LoaiGiaoDich || 'N/A');
                $('#totalAmount').text(formatCurrency(firstInvoice.TongTien || 0));
                $('#invoiceStatus').text(firstInvoice.TrangThai || 'N/A');
                $('#issueStatus').text(firstInvoice.TrangThaiVD || 'N/A');
                $('#issueDescription').text(firstInvoice.MoTaVD  || 'Không có mô tả'); // Cập nhật issueDescription

                // Cập nhật chi tiết vật tư và dịch vụ
                let itemsListHtml = `<div class="items-container">`;

                invoiceDetails.forEach(item => {
                    // VatTu (Materials)
                    if (item.TenVatTu) {
                        const vatTuImageUrl = item.HinhAnhVT 
                            ? item.HinhAnhVT 
                            : '/Image/img_product/default.jpg';

                        const vatTuEditUrl = `/products-services/edit/vattu/${item.MaVatTu}`;

                        itemsListHtml += `
                            <div class="item-card">
                                <div class="item-card-image">
                                    <a href="${vatTuEditUrl}">
                                        <img src="${vatTuImageUrl}" alt="${item.TenVatTu}" class="item-image">
                                    </a>
                                </div>
                                <div class="item-card-details">
                                    <strong class="item-name">
                                        <a href="${vatTuEditUrl}">${item.TenVatTu}</a>
                                    </strong>
                                    <span class="item-price">${formatCurrency(item.DonGiaVT)}</span>
                                    <span class="item-quantity">Số lượng: ${item.SoLuong}</span>
                                </div>
                            </div>
                        `;
                    }

                    // DichVu (Services)
                    if (item.TenDichVu) {
                        const dichVuImageUrl = item.HinhAnhDV 
                            ? item.HinhAnhDV 
                            : '/Image/img_service/default.jpg';

                        const dichVuEditUrl = `/products-services/edit/dichvu/${item.MaDichVu}`;

                        itemsListHtml += `
                            <div class="item-card">
                                <div class="item-card-image">
                                    <a href="${dichVuEditUrl}">
                                        <img src="${dichVuImageUrl}" alt="${item.TenDichVu}" class="item-image">
                                    </a>
                                </div>
                                <div class="item-card-details">
                                    <strong class="item-name">
                                        <a href="${dichVuEditUrl}">${item.TenDichVu}</a>
                                    </strong>
                                    <span class="item-price">${formatCurrency(item.DonGiaDV)}</span>
                                    <span class="item-quantity">Số lượng: ${item.SoLuong}</span>
                                </div>
                            </div>
                        `;
                    }
                });

                itemsListHtml += `</div>`; // Đóng container items

                // Cập nhật danh sách vật tư và dịch vụ
                $('#invoiceItemsList').html(itemsListHtml);

                // Hiển thị modal chi tiết
                $('#issueDetailModal').modal('show');
            } else {
                alert(response.message || 'Có lỗi xảy ra');
            }
        },
        error: function(xhr) {
            alert('Có lỗi xảy ra khi tải thông tin: ' + (xhr.responseJSON?.message || 'Unknown error'));
        }
    });
}

        function formatCurrency(amount) {
            if (!amount) return '0 VNĐ';
            return new Intl.NumberFormat('vi-VN', { 
                style: 'currency', 
                currency: 'VND' 
            }).format(amount);
        }
        function resolveIssue(issueId) {
    $.ajax({
        url: '/issues/' + issueId + '/resolve',  
        method: 'GET',
        success: function(response) {
            if (response.success) {
                const issue = response.issue;
           
                // Điền thông tin vào modal
                $('#resolveIssueId').val(issue.MaVanDe);
                $('#resolveInvoiceCode').val(issue.MaHoaDon);
                $('#resolveStatus').val(issue.TrangThai);
                $('#resolveDescription').val(issue.MoTa);
                $('#resolveImage').val('');

                // Hiển thị modal
                $('#resolveIssueModal').modal('show');
            } else {
                alert(response.message || 'Có lỗi xảy ra');
            }
        },
        error: function(xhr) {
            alert('Không thể lấy thông tin vấn đề: ' + (xhr.responseJSON?.message || 'Unknown error'));
        }
    });
}
// Cấu hình mặc định cho các yêu cầu AJAX để gửi CSRF token
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#resolveIssueForm').on('submit', function(e) {
    e.preventDefault();

    // Create FormData object
    var formData = new FormData(this);

    // Get the issue ID
    var issueId = $('#resolveIssueId').val();

    // Add status and description
    formData.set('TrangThai', $('#resolveStatus').val());
    formData.set('MoTa', $('#resolveDescription').val());

    // Handle image upload
    var fileInput = $('#resolveImage')[0];
    var imageFile = null;

    if (fileInput.files.length > 0) {
        imageFile = fileInput.files[0];
        
        // Additional image validation
        var allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        var maxSize = 2 * 1024 * 1024; // 2MB

        if (!allowedTypes.includes(imageFile.type)) {
            alert('Chỉ cho phép tải lên các định dạng ảnh JPG, PNG và GIF.');
            return;
        }

        if (imageFile.size > maxSize) {
            alert('Kích thước ảnh không được vượt quá 2MB.');
            return;
        }

        // Add image to FormData
        formData.append('img', imageFile);
    }

    // Debug logging
    console.log('File Input:', imageFile);
    console.log('FormData contents:');
    for (var pair of formData.entries()) {
        console.log(pair[0] + ': ', pair[1]);
    }

    // AJAX request
    $.ajax({
        url: '/issues/' + issueId + '/resolve',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                alert('Vấn đề đã được giải quyết thành công!');
                $('#resolveIssueModal').modal('hide');
                location.reload();  // Refresh page
            } else {
                alert(response.message || 'Có lỗi xảy ra');
            }
        },
        error: function(xhr) {
            var errorMessage = xhr.responseJSON && xhr.responseJSON.message 
                ? xhr.responseJSON.message 
                : 'Có lỗi xảy ra khi lưu vấn đề';
            alert(errorMessage);
        }
    });
});

// Format Date (dd/mm/yyyy)
function formatDate(date) {
    const d = new Date(date);
    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = d.getFullYear();
    return `${day}/${month}/${year}`;
}

// Format Currency
function formatCurrency(amount) {
    return amount ? new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount) : '0';
}




    </script>
</body>
</html>