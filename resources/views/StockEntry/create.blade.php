<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhập kho</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/kaiadmin.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --secondary-color: #475569;
            --success-color: #22c55e;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --background-color: #f8fafc;
            --border-color: #e2e8f0;
            --sidebar-width: 280px;
            --header-height: 70px;
        }

        body {
            font-family: 'Public Sans', system-ui, -apple-system, sans-serif;
            background-color: var(--background-color);
            color: #1e293b;
            min-height: 100vh;
        }

        /* Improved Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: #1e1b4b;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            padding: 1.5rem;
            color: #fff;
            transition: all 0.3s ease;
            z-index: 50;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-brand {
            padding: 1rem;
            margin-bottom: 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.7);
            border-radius: 0.5rem;
            transition: all 0.2s;
            text-decoration: none;
        }

        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .sidebar-menu a.active {
            background: var(--primary-color);
            color: #fff;
        }

        .sidebar-menu i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
        }

        /* Main Content Area */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
        }

        /* Improved Form Styles */
        .form-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border-color);
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--secondary-color);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            transition: all 0.2s;
            font-size: 0.975rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            outline: none;
        }

        /* Enhanced Table Styles */
        .table-container {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th {
            background: #f8fafc;
            padding: 1rem;
            font-weight: 600;
            text-align: left;
            color: var(--secondary-color);
            border-bottom: 2px solid var(--border-color);
        }

        .table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .table tr:hover {
            background-color: #f8fafc;
        }

        /* Button Styles */
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        .btn-success {
            background-color: var(--success-color);
            color: white;
        }

        .btn-success:hover {
            background-color: #16a34a;
        }

        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        /* Total Amount Section */
        .total-section {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-amount {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .sidebar {
                width: 80px;
                padding: 1rem 0.5rem;
            }

            .sidebar-brand, .menu-text {
                display: none;
            }

            .main-content {
                margin-left: 80px;
            }

            .form-container {
                padding: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .grid-cols-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <main class="main-content">
            <div class="form-container fade-in">
                <div class="form-header">
                    <h1 class="form-title">Tạo phiếu nhập kho</h1>
                </div>

                <form id="stockEntryForm" method="POST" action="{{ route('StockEntry.store') }}">
                    @csrf
                    
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div class="form-group">
                            <label class="form-label" for="NgayNhap">
                                <i class="far fa-calendar-alt mr-2"></i>Ngày nhập hàng
                            </label>
                            <input type="date" id="NgayNhap" name="NgayNhap" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="MaNhaCungCap">
                                <i class="fas fa-building mr-2"></i>Nhà cung cấp
                            </label>
                            <select id="MaNhaCungCap" name="MaNhaCungCap" class="form-control" required>
                                <option value="">Chọn nhà cung cấp</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->MaNhaCungCap }}">{{ $supplier->TenNhaCungCap }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-800">
                                <i class="fas fa-list-ul mr-2"></i>Chi tiết vật tư
                            </h2>
                            <button type="button" id="addMaterialBtn" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                <span>Thêm vật tư</span>
                            </button>
                        </div>
                        
                        <div class="table-container">
                            <table class="table" id="materialsTable">
                                <thead>
                                    <tr>
                                        <th>Vật tư</th>
                                        <th class="text-center">Số lượng</th>
                                        <th class="text-center">Đơn giá</th>
                                        <th class="text-center">DVT</th>
                                        <th class="text-center">Thành tiền</th>
                                        <th class="text-center">Ngày sản xuất</th>
                                        <th class="text-center">Ngày hết hạn</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="materialRows">
                                    <!-- Dynamic rows will be added here -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="total-section">
                        <div class="total-amount">
                            <i class="fas fa-calculator mr-2"></i>
                            Tổng tiền: <span id="totalAmount">0</span>đ
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i>
                            <span>Lưu phiếu nhập</span>
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
    <script src="{{ asset('admin/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        let materials = [];
        
        $('#MaNhaCungCap').change(function() {
            const supplierId = $(this).val();
            if (supplierId) {
                $.get(`/StockEntry/suppliers/${supplierId}/materials`, function(data) {
                    materials = data;
                    updateMaterialDropdowns();
                });
            }
        });
// Thêm vật tư
$('#addMaterialBtn').click(function() {
    const rowHtml = `
        <tr class="material-row fade-in">
            <td>
                <select name="materials[][MaVatTu]" class="form-control material-select" required>
                    <option value="">Chọn vật tư</option>
                    ${materials.map(m => `<option value="${m.MaVatTu}">${m.TenVatTu}</option>`).join('')}
                </select>
            </td>
            <td>
                <input type="number" name="materials[][SoLuong]" class="form-control quantity text-center" min="1" required>
            </td>
            <td>
                <input type="number" name="materials[][DonGia]" class="form-control price text-center" min="0" required>
            </td>
            <td>
                <input type="text" name="materials[][DonViTinh]" class="form-control unit text-center" required>
            </td>
            <td class="text-center">
                <span class="subtotal">0</span>đ
            </td>
            <td>
                <input type="date" name="materials[][NgaySanXuat]" class="form-control text-center">
            </td>
            <td>
                <input type="date" name="materials[][NgayHetHan]" class="form-control text-center">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger remove-row">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    `;
    $('#materialRows').append(rowHtml);
});

// Xóa dòng vật tư
$(document).on('click', '.remove-row', function() {
    const row = $(this).closest('tr');
    row.remove();
    calculateTotal(); // Tính lại tổng sau khi xóa
});

// Tính tổng tiền khi nhập số lượng và đơn giá
$(document).on('input', '.quantity, .price', function() {
    const row = $(this).closest('tr');
    const quantity = parseFloat(row.find('.quantity').val()) || 0;
    const price = parseFloat(row.find('.price').val()) || 0;
    const subtotal = quantity * price;
    row.find('.subtotal').text(subtotal.toLocaleString('vi-VN')); // Hiển thị thành tiền
    calculateTotal(); // Tính lại tổng sau khi thay đổi
});

// Tính tổng tiền của tất cả các vật tư
function calculateTotal() {
    let total = 0;
    $('.subtotal').each(function() {
        total += parseFloat($(this).text().replace(/[,.]/g, '')) || 0;
    });
    
    // Hiển thị tổng tiền với animation
    const totalElement = $('#totalAmount');
    totalElement.addClass('highlight');
    totalElement.text(total.toLocaleString('vi-VN'));
    setTimeout(() => {
        totalElement.removeClass('highlight');
    }, 300);
}

$('#stockEntryForm').submit(function(e) {
    e.preventDefault(); // Ngừng submit mặc định để kiểm tra dữ liệu

    let isValid = true;
    const requiredFields = $(this).find('[required]');

    requiredFields.each(function() {
        if (!$(this).val()) {
            isValid = false;
            $(this).addClass('error'); // Thêm class error nếu trường không hợp lệ
        } else {
            $(this).removeClass('error');
        }
    });

    if (!isValid) {
        showNotification('Vui lòng điền đầy đủ thông tin', 'error');
        return; // Dừng việc submit nếu có trường thiếu thông tin
    }

    // Kiểm tra nếu không có dòng vật tư nào được thêm vào
    if ($('#materialRows tr').length === 0) {
        showNotification('Vui lòng thêm ít nhất một vật tư', 'error');
        return;
    }

    // Kiểm tra từng dòng vật tư có đầy đủ thông tin chưa
    const materials = [];
    $('#materialRows tr').each(function(index) {
        const materialSelect = $(this).find('.material-select');
        const quantity = $(this).find('.quantity').val();
        const price = $(this).find('.price').val();
        const unit = $(this).find('.unit').val();
        const manufactureDate = $(this).find('input[name="materials[][NgaySanXuat]"]').val();
        const expiryDate = $(this).find('input[name="materials[][NgayHetHan]"]').val();


        if (!materialSelect.val() || !quantity || !price || !unit) {
            isValid = false;
            materialSelect.addClass('error');
            $(this).find('.quantity').addClass('error');
            $(this).find('.price').addClass('error');
        }

        // Thêm vật tư vào mảng
        materials.push({
            MaVatTu: materialSelect.val(),
            SoLuong: quantity,
            DonGia: price,
            DonViTinh: unit,
            NgaySanXuat: manufactureDate,
            NgayHetHan: expiryDate
        });
    });

    if (!isValid) {
        showNotification('Vui lòng điền đầy đủ thông tin vật tư', 'error');
        return;
    }

    // Nếu tất cả các trường hợp trên đều hợp lệ, tiếp tục gửi form
    const submitBtn = $(this).find('button[type="submit"]');
    const originalText = submitBtn.html();
    submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...');
    submitBtn.prop('disabled', true);

    // Thêm mảng materials vào dữ liệu form
    let  formData = $(this).serializeArray();

    // Xóa dữ liệu cũ của materials
    formData = formData.filter(field => !field.name.startsWith('materials['));

    // Thêm dữ liệu mảng vật tư dưới dạng một mảng thay vì chuỗi JSON
    materials.forEach((material, index) => {
        formData.push({ name: `materials[${index}][MaVatTu]`, value: material.MaVatTu });
        formData.push({ name: `materials[${index}][SoLuong]`, value: material.SoLuong });
        formData.push({ name: `materials[${index}][DonGia]`, value: material.DonGia });
        formData.push({ name: `materials[${index}][DonViTinh]`, value: material.DonViTinh });
        formData.push({ name: `materials[${index}][NgaySanXuat]`, value: material.NgaySanXuat });
        formData.push({ name: `materials[${index}][NgayHetHan]`, value: material.NgayHetHan });
    });

    // Kiểm tra dữ liệu trước khi gửi đi
    console.log(formData); // Thêm dòng này để kiểm tra dữ liệu gửi đi

    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: formData,
        success: function(response) {
            if (response.success) {
                showNotification('Tạo phiếu nhập thành công', 'success');
                setTimeout(() => {
                    window.location.href = "{{ route('StockEntry.index') }}";
                }, 1500);
            } else {
                showNotification('Có lỗi xảy ra. Vui lòng thử lại', 'error');
            }
        },
        error: function(xhr) {
            const message = xhr.responseJSON?.message || 'Có lỗi xảy ra. Vui lòng thử lại';
            showNotification(message, 'error');
        },
        complete: function() {
            submitBtn.html(originalText);
            submitBtn.prop('disabled', false);
        }
    });
});


// Hiển thị thông báo
function showNotification(message, type = 'success') {
    const notification = $(`
        <div class="notification ${type}">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `).appendTo('body');
    
    setTimeout(() => {
        notification.addClass('show');
    }, 100);
    
    setTimeout(() => {
        notification.removeClass('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}


        // Add these additional styles to your existing CSS
        const additionalStyles = `
            <style>
                .highlight {
                    animation: highlight 0.3s ease-out;
                }

                @keyframes highlight {
                    0% { background-color: rgba(79, 70, 229, 0.2); }
                    100% { background-color: transparent; }
                }

                .error {
                    border-color: var(--danger-color) !important;
                }

                .notification {
                    position: fixed;
                    top: 1rem;
                    right: 1rem;
                    padding: 1rem;
                    border-radius: 0.5rem;
                    background: white;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                    transform: translateX(120%);
                    transition: transform 0.3s ease-out;
                    z-index: 1000;
                }

                .notification.show {
                    transform: translateX(0);
                }

                .notification.success {
                    border-left: 4px solid var(--success-color);
                }

                .notification.error {
                    border-left: 4px solid var(--danger-color);
                }

                .notification i {
                    font-size: 1.25rem;
                }

                .notification.success i {
                    color: var(--success-color);
                }

                .notification.error i {
                    color: var(--danger-color);
                }
            </style>
        `;
        $('head').append(additionalStyles);

        // Mobile sidebar toggle
        const toggleSidebar = () => {
            $('.sidebar').toggleClass('active');
        };

        // Close sidebar when clicking outside on mobile
        $(document).on('click', function(e) {
            if (window.innerWidth <= 768) {
                if (!$(e.target).closest('.sidebar').length && !$(e.target).closest('.sidebar-toggle').length) {
                    $('.sidebar').removeClass('active');
                }
            }
        });
    </script>
</body>
</html>