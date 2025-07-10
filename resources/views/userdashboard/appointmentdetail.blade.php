<style>
    /* Custom Styles for Appointment Detail Page */


strong {
    font-size: 1rem;
    color: #333;
    margin-bottom: 0.5rem;
}

.text-muted {
    font-size: 1rem;
    color: #666;
}

/* Button Styling */
.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    font-size: 1.1rem;
    font-weight: bold;
    padding: 12px;
    border-radius: 8px;
    transition: background-color 0.3s ease;
}

/* Button Hover Effect */
.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

/* Responsive Design */
@media (max-width: 767px) {
    .card-body {
        padding: 1rem;
    }

    .card-title {
        font-size: 1.4rem;
    }

    .btn-primary {
        font-size: 1rem;
        padding: 10px;
    }
}

/* Utility Classes */
.mt-4 {
    margin-top: 2rem;
}

.mb-4 {
    margin-bottom: 2rem;
}

</style>
@extends('userdashboard')

@section('content')
<div class="container ">
    <h3 class="mb-5 text-center text-primary">Chi tiết lịch khám</h3>
    
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body">
            <h5 class="card-title mb-4 text-uppercase font-weight-bold text-info">Thông tin lịch khám</h5>
            
            <!-- Appointment Details Section -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <strong class="text-dark">Thú cưng:</strong>
                    <p class="text-muted">{{ $appointment->TenThuCung }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <strong class="text-dark">Giới tính:</strong>
                    <p class="text-muted">{{ $appointment->GioiTinh }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <strong class="text-dark">Tuổi:</strong>
                    <p class="text-muted">{{ $appointment->Tuoi }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <strong class="text-dark">Ngày khám:</strong>
                    <p class="text-muted">{{ $appointment->NgayKham }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <strong class="text-dark">Giờ khám:</strong>
                    <p class="text-muted">{{ $appointment->GioKham }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <strong class="text-dark">Địa chỉ:</strong>
                    <p class="text-muted">{{ $appointment->DiaChi }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <strong class="text-dark">Chẩn đoán:</strong>
                    <p class="text-muted">{{ $appointment->ChuanDoan }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <strong class="text-dark">Chi phí khám:</strong>
                    <p class="text-muted">{{ number_format($appointment->ChiPhiKham, 0, ',', '.') }} VNĐ</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <a href="{{ route('userdashboard.appointments') }}" class="btn btn-primary mt-4 w-100 py-3 shadow-sm rounded-3">Quay lại danh sách</a>
</div>
@endsection
