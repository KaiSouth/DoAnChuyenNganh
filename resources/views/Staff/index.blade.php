<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhân viên</title>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/kaiadmin.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


    <style>
        .btn-trash {
            background: transparent;
            border: none;
            color: #3498db !important;  /* Red color for trash */
            font-size: 20px;
            cursor: pointer;
            padding: 0;
            margin: 0;
        }

        .btn-trash:hover {
            color: #c82333 !important;  /* Darker red when hovered */
        }

        .btn-trash:focus {
            outline: none;  /* Remove outline when focused */
        }

        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --text-color: #2c3e50;
            --background-color: #f4f6f7;
            --card-background: #ffffff;
            --hover-color: #2980b9;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: var(--background-color);
            line-height: 1.6;
            color: var(--text-color);
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 265px;
            display: block;
            z-index: 1002;
            color: #fff;
            font-weight: 200;
            background: #fff;
            -webkit-box-shadow: 4px 4px 10px rgba(69,65,78,.06);
            -moz-box-shadow: 4px 4px 10px rgba(69,65,78,.06);
            box-shadow: 4px 4px 10px rgba(69,65,78,.06);
            transition: all .3s
        }

        .main-panel {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
            background-color: var(--background-color);
        }

        .container {
            margin-top:10px !important; 
            background: var(--card-background);
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 25px;
            max-width: 95%;
            margin: 0 auto;
        }

        .header {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--background-color);
        }

        .header h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-color);
        }

        .btn-add-item {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-add-item:hover {
            background: var(--hover-color);
            transform: translateY(-2px);
        }

        .search-container {
            margin-bottom: 25px;
        }

        .search-form {
            display: flex;
            max-width: 600px;
            margin: 0 auto;
        }

        .form-control {
            flex: 1;
            padding: 12px 15px;
            border: 2px solid var(--background-color);
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            margin-left: 10px;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--hover-color);
        }

        .nav-tabs {
            border-bottom: 2px solid var(--background-color);
            margin-bottom: 20px;
        }

        .nav-link {
            color: var(--text-color);
            padding: 12px 20px;
            border-radius: 8px 8px 0 0;
            transition: all 0.3s ease;
        }

        .nav-link.active {
            background: var(--primary-color);
            color: white;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .table th {
            background: var(--primary-color);
            color: white;
            padding: 15px;
            text-align: center;
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
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .action-buttons button {
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: var(--primary-color);
        }

        .btn-delete {
            background: #e74c3c;
        }

        .btn-edit:hover {
            background: var(--hover-color);
        }

        .btn-delete:hover {
            background: #c0392b;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            list-style: none;
            padding: 10px 0;
            margin: 0;
            gap: 8px;
        }

        .page-item {
            list-style: none;
        }

        .page-link {
            display: inline-block;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: 500;
            color: #3498db;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background-color: #3498db;
            color: #ffffff;
            border-color: #3498db;
        }

        .page-item.active .page-link {
            background-color: #3498db;
            color: #ffffff;
            border-color: #3498db;
        }

        .page-item.disabled .page-link {
            background-color: #f8f9fa;
            color: #6c757d;
            border-color: #ddd;
            pointer-events: none;
        }

        .pagination .page-link svg {
            width: 16px !important; /* Đặt kích thước mong muốn */
            height: 16px !important; /* Đặt kích thước mong muốn */
            flex-shrink: 0; /* Đảm bảo SVG không bị co kéo */
            display: inline-block; /* Hiển thị SVG giống một phần tử nội dung */
        }
        svg.w-5.h-5 {
            width: 16px !important; /* Ghi đè kích thước quá lớn */
            height: 16px !important; /* Ghi đè kích thước quá lớn */
        }



        .modal-content {
            border-radius: 12px;
        }

        .alert {
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background-color: rgba(46, 204, 113, 0.1);
            border: 1px solid var(--secondary-color);
            color: var(--secondary-color);
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
                <div class="alert alert-success" style="display: none;">
                    <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <div id="successMessage"></div>
                </div>

                <div class="header">
                    <h1>Quản lý Nhân Sự</h1>
                    <div class="header-buttons">
                        <button onclick="onEditClick()" class="btn-add-item" data-bs-toggle="modal" data-bs-target="#addStaffModal">+ Thêm Nhân Sự</button>
                    </div>         
                </div>
               
                <div class="search-container">
                    <form class="search-form">
                        <input type="text" class="form-control" placeholder="Tìm kiếm tên nhân viên, bác sĩ..." name="search" value="{{ request('search') }}">
                        <button type="submit" class="btn-primary">Tìm kiếm</button>
                    </form>
                </div>
                <!-- Add Staff Modal -->
                <div class="modal fade" id="addStaffModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Thêm Nhân Sự</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addStaffForm">
                                    <div id="typeSelector" class="mb-3">
                                        <label for="staffType" class="form-label">Chọn loại:</label>
                                        <select id="staffType" class="form-select" onchange="handleStaffTypeChange()">
                                            <option value="">-- Chọn --</option>
                                            <option value="bacsi">Bác Sĩ</option>
                                            <option value="nhanvien">Nhân Viên</option>
                                        </select>
                                    </div>

                                    <div id="bacsiFields" style="display: none;">
                                        <div class="mb-3">
                                            <label class="form-label">Họ Tên:</label>
                                            <input type="text" class="form-control" name="HoTen">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Chuyên Môn:</label>
                                            <input type="text" class="form-control" name="ChuyenMon">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Ngày Sinh:</label>
                                            <input type="date" class="form-control" name="NgaySinh">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Giới Tính:</label>
                                            <select class="form-select" name="GioiTinh">
                                                <option value="Nam">Nam</option>
                                                <option value="Nữ">Nữ</option>
                                                <option value="Khác">Khác</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Số Điện Thoại:</label>
                                            <input type="tel" class="form-control" name="SDT" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email:</label>
                                            <input type="email" class="form-control" name="Email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Lương Theo Giờ:</label>
                                            <input type="number" class="form-control" name="LuongTheoGio" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tài Khoản:</label>
                                            <input type="text" class="form-control" name="bsTaiKhoan" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Mật Khẩu:</label>
                                            <input type="password" class="form-control" name="bsMatKhau" required>
                                        </div>
                                    </div>

                                    <div id="nhanvienFields" style="display: none;">
                                        <div class="mb-3">
                                            <label class="form-label">Tên Nhân Viên:</label>
                                            <input type="text" class="form-control" name="TenNhanVien">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Chức Vụ:</label>
                                            <input type="text" class="form-control" name="ChucVu">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Số Điện Thoại:</label>
                                            <input type="tel" class="form-control" name="nhanvien_SDT" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email:</label>
                                            <input type="email" class="form-control" name="nhanvien_Email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Lương Theo Giờ:</label>
                                            <input type="number" class="form-control" name="nhanvien_LuongTheoGio" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tài Khoản:</label>
                                            <input type="text" class="form-control" name="nvTaiKhoan" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Mật Khẩu:</label>
                                            <input type="password" class="form-control" name="nvMatKhau" required>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="button" class="btn btn-primary" onclick="submitStaffForm()">Lưu</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs -->
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link {{ $activeTab == 'bacsi' ? 'active' : '' }}" href="{{ route('staff.index', ['tab' => 'bacsi', 'search' => request('search')]) }}">Bác Sĩ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $activeTab == 'nhanvien' ? 'active' : '' }}" href="{{ route('staff.index', ['tab' => 'nhanvien', 'search' => request('search')]) }}">Nhân Viên</a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- Bác Sĩ Tab -->
                    <div class="tab-pane fade {{ $activeTab == 'bacsi' ? 'show active' : '' }}" id="bacsi">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Họ Tên</th>
                                    <th>Chuyên Môn</th>
                                    <th>Số Điện Thoại</th>
                                    <th>Email</th>
                                    <th>Lương Theo Giờ</th>
                                    <th>Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bacSis as $bacSi)
                                <tr>
                                    <td>{{ $bacSi->HoTen }}</td>
                                    <td>{{ $bacSi->ChuyenMon }}</td>
                                    <td>{{ $bacSi->SDT }}</td>
                                    <td>{{ $bacSi->Email }}</td>
                                    <td>{{ number_format($bacSi->LuongTheoGio) }}đ</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button 
                                            onclick="openEditModal('{{ $activeTab }}', {{ $bacSi->MaBacSi  }})" 
                                            class="btn btn-primary">
                                            Sửa
                                        </button>
                                        <button onclick="deleteStaff('bacsi', {{ $bacSi->MaBacSi }})" class="btn-trash">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $bacSis->appends(['tab' => 'bacsi', 'nhanvien_page' => request('nhanvien_page')])->links() }}
                    </div>

                    <!-- Nhân Viên Tab -->
                    <div class="tab-pane fade {{ $activeTab == 'nhanvien' ? 'show active' : '' }}" id="nhanvien">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tên Nhân Viên</th>
                                    <th>Chức Vụ</th>
                                    <th>Số Điện Thoại</th>
                                    <th>Email</th>
                                    <th>Lương Theo Giờ</th>
                                    <th>Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nhanViens as $nhanVien)
                                <tr>
                                    <td>{{ $nhanVien->TenNhanVien }}</td>
                                    <td>{{ $nhanVien->ChucVu }}</td>
                                    <td>{{ $nhanVien->SDT }}</td>
                                    <td>{{ $nhanVien->Email }}</td>
                                    <td>{{ number_format($nhanVien->LuongTheoGio) }}đ</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button 
                                            onclick="openEditModal('{{ $activeTab }}', {{  $nhanVien->MaNhanVien }})" 
                                            class="btn btn-primary">
                                            Sửa
                                        </button>
                                        <button onclick="deleteStaff('nhanvien', {{ $nhanVien->MaNhanVien }})" class="btn-trash">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $nhanViens->appends(['tab' => 'nhanvien', 'bacsi_page' => request('bacsi_page')])->links() }}
                    </div>
                </div>
            </div>
        </div>

      
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('admin/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/bootstrap.min.js') }}"></script>
    <script>
        let edit=false;
        let idstaff;
        function submitStaffForm() {
            const form = document.getElementById("addStaffForm");
            const staffType = document.getElementById("staffType").value;

            const formData = new FormData();
            formData.append("staffType", staffType);

            // Thêm các trường vào FormData
            if (staffType === 'bacsi') {
                formData.append("HoTen", form.querySelector('[name="HoTen"]').value);
                formData.append("ChuyenMon", form.querySelector('[name="ChuyenMon"]').value);
                formData.append("NgaySinh", form.querySelector('[name="NgaySinh"]').value);
                formData.append("GioiTinh", form.querySelector('[name="GioiTinh"]').value);
                formData.append("SDT", form.querySelector('[name="SDT"]').value);
                formData.append("Email", form.querySelector('[name="Email"]').value);
                formData.append("LuongTheoGio", form.querySelector('[name="LuongTheoGio"]').value);
                formData.append("TaiKhoan", form.querySelector('[name="bsTaiKhoan"]').value);
                formData.append("MatKhau", form.querySelector('[name="bsMatKhau"]').value);
            } else if (staffType === 'nhanvien') {
                formData.append("TenNhanVien", form.querySelector('[name="TenNhanVien"]').value);
                formData.append("ChucVu", form.querySelector('[name="ChucVu"]').value);
                formData.append("SDT", form.querySelector('[name="nhanvien_SDT"]').value);
                formData.append("Email", form.querySelector('[name="nhanvien_Email"]').value);
                formData.append("LuongTheoGio", form.querySelector('[name="nhanvien_LuongTheoGio"]').value);
                formData.append("TaiKhoan", form.querySelector('[name="nvTaiKhoan"]').value);
                formData.append("MatKhau", form.querySelector('[name="nvMatKhau"]').value);
            }

            // Thêm ID nếu đang chỉnh sửa
            if (edit) {
                formData.append("id", idstaff);
            }

            const url = edit ? '/staff/update' : '/staff/store';
            const method = 'POST';

            fetch(url, {
                method: method,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(edit ? 'Cập nhật nhân sự thành công!' : 'Thêm nhân sự thành công!');
                    window.location.reload();
                } else {
                    alert('Có lỗi xảy ra: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi gửi dữ liệu!');
            });
        }




        function handleStaffTypeChange() {
            const staffType = document.getElementById("staffType").value;
            const bacsiFields = document.getElementById("bacsiFields");
            const nhanvienFields = document.getElementById("nhanvienFields");

            if (staffType === 'bacsi') {
                bacsiFields.style.display = 'block';
                nhanvienFields.style.display = 'none';
            } else if (staffType === 'nhanvien') {
                bacsiFields.style.display = 'none';
                nhanvienFields.style.display = 'block';
            } else {
                bacsiFields.style.display = 'none';
                nhanvienFields.style.display = 'none';
            }
        }

        function deleteStaff(staffType, id) {
            if (confirm('Bạn có chắc chắn muốn xóa nhân sự này?')) {
                fetch('/staff/destroy', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        staffType: staffType,
                        id: id
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Xóa thất bại');
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        // Tab initialization
        document.addEventListener('DOMContentLoaded', function() {
            const tabLinks = document.querySelectorAll('.nav-link');
            tabLinks.forEach(link => {
                link.addEventListener('click', function() {
                    tabLinks.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
        function openEditModal(staffType, id) {
            idstaff=id;
            console.log(staffType,id);
            toggleEditMode(true);
            fetch(`/staff/detail?staffType=${staffType}&id=${id}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const staff = data.data;
                    const form = document.getElementById("addStaffForm");

                    // Điền dữ liệu tùy thuộc loại nhân sự
                    document.getElementById("staffType").value = staffType;
                    handleStaffTypeChange();

                    if (staffType === 'bacsi') {
                        form.querySelector('[name="HoTen"]').value = staff.HoTen;
                        form.querySelector('[name="ChuyenMon"]').value = staff.ChuyenMon;
                        form.querySelector('[name="NgaySinh"]').value = staff.NgaySinh;
                        form.querySelector('[name="GioiTinh"]').value = staff.GioiTinh;
                        form.querySelector('[name="SDT"]').value = staff.SDT;
                        form.querySelector('[name="Email"]').value = staff.Email;
                        form.querySelector('[name="LuongTheoGio"]').value = staff.LuongTheoGio;
                        form.querySelector('[name="bsTaiKhoan"]').value = staff.TaiKhoan;
                        form.querySelector('[name="bsMatKhau"]').value = "";

                    } else if (staffType === 'nhanvien') {
                        form.querySelector('[name="TenNhanVien"]').value = staff.TenNhanVien;
                        form.querySelector('[name="ChucVu"]').value = staff.ChucVu;
                        form.querySelector('[name="nhanvien_SDT"]').value = staff.SDT;
                        form.querySelector('[name="nhanvien_Email"]').value = staff.Email;
                        form.querySelector('[name="nhanvien_LuongTheoGio"]').value = staff.LuongTheoGio;
                        form.querySelector('[name="nvTaiKhoan"]').value = staff.TaiKhoan;
                        form.querySelector('[name="nvMatKhau"]').value = "";
                    }

                    // Hiển thị modal
                    new bootstrap.Modal(document.getElementById('addStaffModal')).show();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Lỗi khi tải thông tin nhân sự.');
            });
        }
        function toggleEditMode(isEdit) {
            edit = isEdit;

            const typeSelector = document.getElementById("typeSelector"); // Dropdown chọn loại nhân viên
            if (edit) {
                typeSelector.style.display = "none"; // Ẩn dropdown khi sửa
            } else {
                typeSelector.style.display = "block"; // Hiện dropdown khi thêm mới
            }

            // Xóa hoặc giữ lại các giá trị của form tùy thuộc vào trạng thái
            const form = document.getElementById("addStaffForm");
            if (!edit) {
                form.reset(); // Reset form khi ở chế độ thêm mới
            }
        }

        function onEditClick() {
            toggleEditMode(false);
        }
    </script>

</body>
</html>