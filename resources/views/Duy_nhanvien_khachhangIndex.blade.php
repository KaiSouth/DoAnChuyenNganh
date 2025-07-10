<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quản lý khách hàng</title>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}" />

<!-- Fonts and icons -->
<script src="{{ asset('admin/assets/js/plugin/webfont/webfont.min.js') }}"></script>
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
            urls: ["{{ asset('admin/assets/css/fonts.min.css') }}"],
        },
        active: function () {
            sessionStorage.fonts = true;
        },
    });
</script>
    <style>
        :root {
            --sidebar-width: 250px;
            --header-height: 60px;
            --primary-color: #4e73df;
            --secondary-color: #858796;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
        }




        .menu-item {
            padding: 0.8rem 1.5rem;
            color: rgba(255,255,255,0.8);
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s;
        }

        .menu-item:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }

        .menu-item i {
            width: 1.5rem;
            margin-right: 0.5rem;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 1.5rem;
        }

        .content-header {
            margin-bottom: 1.5rem;
            background: white;
            padding: 1rem;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .search-box {
            background: white;
            padding: 1.5rem;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 1.5rem;
        }

        .table-container {
            background: white;
            padding: 1.5rem;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .table {
            margin-bottom: 0;
        }

        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            margin: 0 0.2rem;
        }

        .pagination {
            margin: 1rem 0 0 0;
            justify-content: center;
        }

        /* Custom Button Styles */
        .btn-custom-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .btn-custom-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
            color: white;
        }

        /* Table Hover Effect */
        .table tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
        }

        /* Status Badge */
        .badge-active {
            background-color: #1cc88a;
            color: white;
            padding: 0.5em 0.8em;
            border-radius: 0.35rem;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->

    <div class="sidebar">
        @include('partials.sidebar')
    </div>


    <!-- Main Content -->
    <div class="main-content">

        <!-- Content Header -->
        <div class="content-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="fas fa-users me-2"></i>
                Quản lý khách hàng
            </h4>
        </div>

        <!-- Search Box -->
        <div class="search-box">
            <form action="{{ route('customers.index') }}" method="GET">
                <div class="input-group">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Tìm kiếm theo tên, email hoặc SĐT..."
                           value="{{ $search ?? '' }}">
                    <button class="btn btn-custom-primary" type="submit">
                        <i class="fas fa-search me-1"></i>
                        Tìm kiếm
                    </button>
                </div>
            </form>
        </div>

        <!-- Table Container -->
        <div class="table-container">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag me-1"></i>ID</th>
                        <th><i class="fas fa-user me-1"></i>Họ Tên</th>
                        <th><i class="fas fa-envelope me-1"></i>Email</th>
                        <th><i class="fas fa-phone me-1"></i>SĐT</th>
                        <th><i class="fas fa-map-marker-alt me-1"></i>Địa Chỉ</th>
                        <th><i class="fas fa-calendar-alt me-1"></i>Ngày Đăng Ký</th>
                        <th><i class="fas fa-cog me-1"></i>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                    <tr>
                        <td>{{ $customer->MaKhachHang }}</td>
                        <td>
                            <i class="fas fa-user-circle me-1"></i>
                            {{ $customer->HoTen }}
                        </td>
                        <td>{{ $customer->Email }}</td>
                        <td>{{ $customer->SDT }}</td>
                        <td>{{ $customer->DiaChi }}</td>
                        <td>{{ $customer->NgayDangKi }}</td>
                        <td>
                            <button class="btn btn-info btn-action"
                                onclick="window.location.href='{{ route('customers.details', ['id' => $customer->MaKhachHang]) }}'"                            <i class="fas fa-eye"></i>
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-danger btn-action"
                                    onclick="deleteCustomer({{ $customer->MaKhachHang }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Hiển thị {{ $customers->firstItem() }} đến {{ $customers->lastItem() }}
                    của {{ $customers->total() }} khách hàng
                </div>
                {{ $customers->links() }}
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function deleteCustomer(id) {
        Swal.fire({
            title: 'Xác nhận xóa?',
            text: "Bạn có chắc muốn xóa khách hàng này?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xác nhận',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/customers/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            'Đã xóa!',
                            data.message,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Lỗi!',
                            data.message,
                            'error'
                        );
                    }
                })
                .catch(error => {
                    Swal.fire(
                        'Lỗi!',
                        'Có lỗi xảy ra khi xóa khách hàng',
                        'error'
                    );
                });
            }
        });
    }
    </script>
</body>
</html>
