@extends('userdashboard')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Chi Tiết Hóa Đơn</h3>

    <div class="order-details-list">
        @foreach ($orderDetails as $detail)
            <div class="order-detail-item">
                <div class="order-detail-left">
                    <!-- Render Hình ảnh Vật Tư hoặc Dịch Vụ -->
                    <div class="order-detail-image">
                        @if ($detail->type === 'product')
                            <img src="{{  $detail->HinhAnhVT}}" alt="Vật Tư" class="img-fluid">
                        @elseif ($detail->type === 'service')
                            <img src="{{ $detail->HinhAnhDV }}" alt="Dịch Vụ" class="img-fluid">
                        @else
                            <img src="  {{ asset('Image/khambenh.jpg' ) }}" alt="Không có hình ảnh" class="img-fluid">
                        @endif
                    </div>
                </div>

                <div class="order-detail-right">
                    <div class="order-detail-title">
                        <strong>{{ $detail->Ten }}</strong>
                    </div>
                    <div class="order-detail-info">
                        <div><strong>Số lượng:</strong> {{ $detail->SoLuong }}</div>
                        <div><strong>Đơn giá:</strong> {{ number_format($detail->DonGia, 0, ',', '.') }} VNĐ</div>
                        <div><strong>Thành tiền:</strong> {{ number_format($detail->ThanhTien, 0, ',', '.') }} VNĐ</div>
                    </div>

                    <div class="action-buttons">
                        @if ($detail->type === 'product' || $detail->type === 'service')
                            <a href="{{ route('detailserviceproduct', ['id' => $detail->type === 'product' ? $detail->MaVatTu : $detail->MaDichVu]) }}?type={{ $detail->type === 'product' ? 'vat_tu' : 'dich_vu' }}" class="btn btn-info btn-sm">Xem Chi Tiết</a>
                        @elseif ($detail->type === 'appointment')
                            <a href="{{ route('userdashboard.appointmentDetail', ['id' => $detail->MaLichKham]) }}" class="btn btn-primary btn-sm">Xem Chi Tiết</a>
                        @else
                            <span>Không rõ loại</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <a href="{{ route('userdashboard.orders') }}" class="btn btn-secondary mt-3">Quay lại danh sách</a>
</div>
@endsection

<style>
    .order-details-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .order-detail-item {
        background-color: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        display: flex;
        padding: 16px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease;
    }

    .order-detail-item:hover {
        transform: scale(1.02);
    }

    .order-detail-left {
        flex-shrink: 0;
        margin-right: 20px;
    }

    .order-detail-image img {
        width: 100px;
        height: 100px;
        object-fit: contain;
        border-radius: 8px;
    }

    .order-detail-right {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .order-detail-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .order-detail-info div {
        font-size: 14px;
        margin-bottom: 8px;
    }

    .action-buttons {
        margin-top: 12px;
        display: flex;
        gap: 10px;
    }

    .action-buttons .btn {
        font-size: 14px;
        padding: 8px 16px;
    }

    /* Responsive Design */
    @media (max-width: 767px) {
        .order-detail-item {
            flex-direction: column;
            padding: 12px;
        }

        .order-detail-left {
            margin-right: 0;
            margin-bottom: 12px;
        }

        .order-detail-image img {
            max-width: 80px;
            max-height: 80px;
        }
    }
</style>
