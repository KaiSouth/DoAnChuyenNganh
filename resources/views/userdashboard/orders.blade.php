<style>
    .container-flex {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .status-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: flex-start;
    }

    .status-btn {
        font-size: 14px;
        padding: 8px 15px;
        min-width: 100px;
        text-align: center;
    }

    .order-card {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .order-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .order-card-body {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }

    .order-card-footer {
    display: flex;
    justify-content: flex-start;
    gap: 10px; /* Khoảng cách đều giữa các nút */
    margin-top: 10px;
    width: 100%; /* Đảm bảo nút chiếm hết không gian */
}

.action-buttons {
    display: flex;
    gap: 10px; /* Khoảng cách giữa hai nút */
    align-items: center;
    width: 100%; /* Đảm bảo các nút chia đều không gian */
}

.action-buttons .btn {
    font-size: 14px;
    padding: 8px 20px; /* Padding đều cho các nút */
    text-align: center;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    min-width: 120px; /* Đảm bảo kích thước nút không thay đổi */
    border-radius: 4px; /* Góc bo tròn cho nút */
}

.action-buttons .btn i {
    margin-right: 5px; /* Khoảng cách giữa icon và text */
}

.order-card-footer form {
    display: inline-block;
    margin: 0; /* Đảm bảo form không có khoảng cách lạ */
}


    @media (max-width: 767px) {
        .order-card-body {
            grid-template-columns: 1fr;
        }
    }
</style>
@extends('userdashboard')


@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Danh Sách Hóa Đơn</h3>

    <div class="container-flex">
        <!-- Thanh mục trạng thái -->
        <div class="status-container">
            <a href="{{ route('userdashboard.orders', ['status' => 'all']) }}"
               class="btn btn-outline-primary status-btn">Tất Cả</a>
            <a href="{{ route('userdashboard.orders', ['status' => 'Chờ xác nhận']) }}"
               class="btn btn-outline-warning status-btn">Chờ Xác Nhận</a>
            <a href="{{ route('userdashboard.orders', ['status' => 'Đã xác nhận']) }}"
               class="btn btn-outline-info status-btn">Đã Xác Nhận</a>
            <a href="{{ route('userdashboard.orders', ['status' => 'Xử Lý ']) }}"
               class="btn btn-outline-primary status-btn">Đang Xử Lý</a>
            <a href="{{ route('userdashboard.orders', ['status' => 'Hoàn thành']) }}"
               class="btn btn-outline-dark status-btn">Hoàn Thành</a>
            <a href="{{ route('userdashboard.orders', ['status' => 'Từ Chối Đơn Hàng']) }}"
               class="btn btn-outline-danger status-btn">Từ Chối</a>
        </div>

        <!-- Danh sách hóa đơn -->
        @if ($orders->isEmpty())
            <p>Bạn chưa có hóa đơn nào.</p>
        @else
            @foreach ($orders as $order)
                <div class="order-card">
                    <div class="order-card-header">
                        <h5 class="mb-0">Mã Hóa Đơn: {{ $order->MaHoaDon }}</h5>
                        <span class="badge bg-{{ $order->TrangThai == 'Chờ xác nhận' ? 'warning' : ($order->TrangThai == 'Đã xác nhận' ? 'info' : ($order->TrangThai == 'Xử Lý ' ? 'primary' : ($order->TrangThai == 'Hoàn thành' ? 'dark' : 'danger'))) }}">{{ $order->TrangThai }}</span>
                    </div>
                    <div class="order-card-body">
                        <div>
                            <strong>Ngày Xuất:</strong>
                            <p>{{ $order->NgayXuatHoaDon }}</p>
                        </div>
                        <div>
                            <strong>Tổng Tiền:</strong>
                            <p>{{ number_format($order->TongTien, 0, ',', '.') }} VNĐ</p>
                        </div>
                        <div>
                            <div class="order-card-footer">
                                <div class="action-buttons">
                                    <a href="{{ route('userdashboard.orderDetail', $order->MaHoaDon) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-info-circle me-1"></i>Chi Tiết
                                    </a>
                                    @if ($order->TrangThai == 'Chờ xác nhận')
                                        <form action="{{ route('order.cancel', $order->MaHoaDon) }}" method="POST"
                                              onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-x-circle me-1"></i>Hủy
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
