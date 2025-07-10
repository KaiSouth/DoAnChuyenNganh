<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin thú cưng</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/kaiadmin.min.css') }}" />
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
        .pet-image {
            max-width: 200px;
            max-height: 200px;
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 8px;
        }
        .info-column {
            display: flex;
            align-items: center; /* Center items vertically */
            margin-bottom: 10px;
        }
        /* Sidebar Styles */
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
            background: #343a40;
            color: #fff;
            transition: all 0.3s;
        }
        #sidebar .sidebar-header {
            padding: 20px;
            background: #3d4148;
        }
        #sidebar ul.components {
            padding: 20px 0;
        }
        #sidebar ul p {
            color: #fff;
            padding: 10px;
        }
        #sidebar ul li a:hover {
            color: #ffffff;
            background: #575d63;
            text-decoration: none;
        }
        /* Toggle button styles */
        #content {
            width: 100%;
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s;
        }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                padding: 20px;
            }
            #content.active {
                margin-left: 250px;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark" id="sidebar">
            <div class="sidebar-header">
                <h3>Menu</h3>
                <strong>MM</strong>
            </div>
            <ul class="list-unstyled components">
                @include('partials.sidebar')
            </ul>
        </div>
        <!-- /#sidebar -->

        <!-- Page Content -->
        <div id="content">
            <!-- Toggle Button -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                        <i class="fas fa-bars"></i>
                        <span>Toggle Sidebar</span>
                    </button>
                </div>
            </nav>

            <div class="container-fluid">
                <h1>Thông tin thú cưng</h1>

                @if($pet)
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    @if($pet->HinhAnh)
                                        <img src="{{ asset('storage/' . $pet->HinhAnh) }}" alt="{{ $pet->TenThuCung }}" class="img-fluid pet-image">
                                    @else
                                        <img src="https://via.placeholder.com/200" alt="Placeholder" class="img-fluid pet-image">
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6 info-column">
                                            <strong>Tên thú cưng:</strong> {{ $pet->TenThuCung }}
                                        </div>
                                        <div class="col-md-6 info-column">
                                            <strong>Giới tính:</strong> {{ $pet->GioiTinh }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 info-column">
                                            <strong>Tuổi:</strong> {{ $pet->Tuoi }}
                                        </div>
                                        <div class="col-md-6 info-column">
                                            <strong>Ngày đăng ký:</strong> {{ date('d/m/Y', strtotime($pet->NgayDangKi)) }}
                                        </div>
                                    </div>
                                    @if($pet->khachHang)
                                        <div class="row">
                                            <div class="col-md-12 info-column">
                                                <strong>Chủ sở hữu:</strong> {{ $pet->khachHang->HoTen }} ({{ $pet->khachHang->SDT }})
                                            </div>
                                        </div>
                                    @endif
                                    @if($pet->giongLoai)
                                        <div class="row">
                                            <div class="col-md-12 info-column">
                                                <strong>Giống loài:</strong> {{ $pet->giongLoai->TenGiongLoai }}
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-12 info-column">
                                            <strong>Ghi chú:</strong> {{ $pet->GhiChu }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning">Không tìm thấy thông tin thú cưng.</div>
                @endif

                <h2 class="mt-4">Lịch sử điều trị</h2>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Ngày điều trị</th>
                                <th>Bác sĩ</th>
                                <th>Trạng thái</th>
                                <th>Chuẩn đoán điều trị</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lichKhams as $lichKham)
                                <tr>
                                    <td>{{ date('d/m/Y', strtotime($lichKham->NgayKham)) }}</td>
                                    <td>{{ $lichKham->BacSiHoTen }}</td>
                                    <td>{{ $lichKham->TrangThai }}</td>
                                    <td>{{ $lichKham->ChuanDoan }}</td>
                                    <td>
                                        @if ($lichKham->TrangThai === 'Chờ')
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#capNhatGhiChuModal" data-malichkham="{{ $lichKham->MaLichKham }}">
                                                Cập nhật
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="capNhatGhiChuModal" tabindex="-1" role="dialog" aria-labelledby="capNhatGhiChuModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="capNhatGhiChuModalLabel">Cập nhật ghi chú</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('cap-nhat-ghi-chu', ['id' => $lichKham->MaLichKham]) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="MaThuCung" value="{{ $pet->MaThuCung }}">
                                    <input type="hidden" name="MaLichKham" id="modalMaLichKham">
                                    <div class="form-group">
                                        <label for="ChuanDoan">Ghi chú:</label>
                                        <textarea class="form-control" name="ChuanDoan" id="ChuanDoan" rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Modal -->
            </div>
        </div>
        <!-- /#content -->
    </div>
    <!-- /#wrapper -->

    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('admin/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/chart-circle/circles.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/jsvectormap/world.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            // Sidebar toggle functionality
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('active');
            });

            // Modal setup
            $('#capNhatGhiChuModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var maLichKham = button.data('malichkham');
                var modal = $(this);
                var actionUrl = '{{ route("cap-nhat-ghi-chu", ":id") }}'.replace(':id', maLichKham);
                modal.find('form').attr('action', actionUrl);
                modal.find('#modalMaLichKham').val(maLichKham);
            });
        });
    </script>
</body>
</html>
