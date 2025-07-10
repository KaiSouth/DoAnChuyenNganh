<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Nhà Cung Cấp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/kaiadmin.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #34495e;
            --bg-light: #f4f6f9;
            --text-dark: #2c3e50;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
        }

        .wrapper {
            display: flex;
            flex-direction: row;
        }



        .main-panel {
            margin-left: 250px;
            flex-grow: 1;
            padding: 30px;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }


        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 15px;
        }

        .header h1 {
            color: var(--primary-color);
            font-weight: 600;
            margin: 0;
        }

        .btn-add-item {
            background-color: var(--primary-color);
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-add-item:hover {
            background-color: #357abd;
            transform: translateY(-2px);
        }

        .search-container {
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: separate;
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
            cursor: pointer; 

        }

        .btn-action {
            margin: 0 5px;
            padding: 6px 12px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background-color: #28a745;
            color: white;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .modal-header {
            background-color: var(--bg-light);
            border-bottom: 1px solid #e9ecef;
        }

        .modal-title {
            color: var(--primary-color);
            font-weight: 600;
        }

        .pagination {
            justify-content: center;
            margin-top: 20px;
        }

        .alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            border-radius: 8px;
        }

        .alert-icon {
            width: 24px;
            height: 24px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        @include('partials.sidebar')

        <div class="main-panel">
            <div class="container-fluid">
                @if(session('success'))
                <div class="alert alert-success">
                    <svg class="alert-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="alert-message">{{ session('success') }}</div>
                </div>
                @endif

                <div class="header">
                    <h1><i class="fas fa-truck"></i> Quản lý Nhà Cung Cấp</h1>
                    <button class="btn btn-add-item" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                        <i class="fas fa-plus"></i> Thêm Nhà Cung Cấp
                    </button>
                </div>

                <div class="search-container">
                    <form id="searchForm" class="d-flex">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm nhà cung cấp..." name="search" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover" style="
                    overflow: hidden;
                ">
                        <thead>
                            <tr>
                                <th>Tên Nhà Cung Cấp</th>
                                <th>Số Điện Thoại</th>
                                <th>Email</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $supplier)
                            <tr>
                                <td>{{ $supplier->TenNhaCungCap }}</td>
                                <td>{{ $supplier->SDT }}</td>
                                <td>{{ $supplier->Email }}</td>
                                <td>
                                    <button class="btn btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#editSupplierModal" onclick="editSupplier({{ $supplier->MaNhaCungCap }})">
                                        <i class="fas fa-edit"></i> Sửa
                                    </button>
                                    <button class="btn btn-action btn-delete" onclick="deleteSupplier({{ $supplier->MaNhaCungCap }})">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    {{ $suppliers->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>

                <!-- Add Supplier Modal -->
                <div class="modal fade" id="addSupplierModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="fas fa-plus"></i> Thêm Nhà Cung Cấp</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addSupplierForm">
                                    <div class="mb-3">
                                        <label for="TenNhaCungCap" class="form-label">Tên Nhà Cung Cấp</label>
                                        <input type="text" class="form-control" id="TenNhaCungCap" name="TenNhaCungCap" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="SDT" class="form-label">Số Điện Thoại</label>
                                        <input type="text" class="form-control" id="SDT" name="SDT" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="Email" name="Email" required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="button" class="btn btn-primary" onclick="addSupplier()">Lưu</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Supplier Modal -->
                <div class="modal fade" id="editSupplierModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="fas fa-edit"></i> Sửa Nhà Cung Cấp</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editSupplierForm">
                                    <input type="hidden" id="editSupplierId">
                                    <div class="mb-3">
                                        <label for="editTenNhaCungCap" class="form-label">Tên Nhà Cung Cấp</label>
                                        <input type="text" class="form-control" id="editTenNhaCungCap" name="TenNhaCungCap" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editSDT" class="form-label">Số Điện Thoại</label>
                                        <input type="text" class="form-control" id="editSDT" name="SDT" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="editEmail" name="Email" required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="button" class="btn btn-primary" onclick="updateSupplier()">Lưu</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function addSupplier() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const formData = new FormData(document.getElementById("addSupplierForm"));
            
            fetch('{{ route('suppliers.store') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: data.message,
                        confirmButtonColor: '#4a90e2'
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: data.message || 'Thêm nhà cung cấp thất bại',
                        confirmButtonColor: '#dc3545'
                    });
                }
            })
            .catch(error => {
                console.error('Detailed Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Có lỗi xảy ra khi thêm nhà cung cấp',
                    confirmButtonColor: '#dc3545'
                });
            });
        }

        function editSupplier(id) {
            fetch(`/suppliers/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const supplier = data.supplier;
                        document.getElementById("editSupplierId").value = supplier.MaNhaCungCap;
                        document.getElementById("editTenNhaCungCap").value = supplier.TenNhaCungCap;
                        document.getElementById("editSDT").value = supplier.SDT;
                        document.getElementById("editEmail").value = supplier.Email;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: data.message,
                            confirmButtonColor: '#dc3545'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: 'Có lỗi xảy ra khi lấy thông tin nhà cung cấp',
                        confirmButtonColor: '#dc3545'
                    });
                });
        }

        function updateSupplier() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const formData = new FormData(document.getElementById("editSupplierForm"));
            const supplierId = document.getElementById("editSupplierId").value;
            
            fetch(`/suppliers/update/${supplierId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: data.message,
                        confirmButtonColor: '#4a90e2'
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: data.message,
                        confirmButtonColor: '#dc3545'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Có lỗi xảy ra khi cập nhật nhà cung cấp',
                    confirmButtonColor: '#dc3545'
                });
            });
        }

        function deleteSupplier(id) {
            Swal.fire({
                title: 'Xác nhận xóa?',
                text: 'Bạn có chắc chắn muốn xóa nhà cung cấp này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                    fetch(`/suppliers/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: data.message,
                                confirmButtonColor: '#4a90e2'
                            }).then(() => location.reload());
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: data.message,
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Có lỗi xảy ra khi xóa nhà cung cấp',
                            confirmButtonColor: '#dc3545'
                        });
                    });
                }
            });
        }

        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const searchTerm = document.getElementById('searchInput').value;
            window.location.href = '{{ route('suppliers.index') }}?search=' + encodeURIComponent(searchTerm);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>