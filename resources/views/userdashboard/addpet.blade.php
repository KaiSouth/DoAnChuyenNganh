<style>
    /* Custom Styles for Add Pet Page */

/* Form Container */
form {
    background-color: #f9f9f9;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Header */
h3 {
    font-size: 1.8rem;
    font-weight: bold;
    color: #007bff;
}

/* Success and Error Messages */
.alert {
    font-size: 1.1rem;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Form Labels */
.form-label {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
}

/* Form Inputs */
.form-control {
    font-size: 1rem;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    transition: all 0.3s ease;
}

/* Form Input Focus Effect */
.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
}

/* Form Select */
.form-select {
    font-size: 1rem;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

/* Buttons */
.btn {
    font-size: 1.1rem;
    font-weight: 600;
    padding: 12px;
    border-radius: 10px;
    transition: background-color 0.3s ease;
}

/* Button Hover Effect */
.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.btn-secondary:hover {
    background-color: #5a6268;
    border-color: #5a6268;
}

/* Button Padding */
.btn-primary, .btn-secondary {
    padding: 12px 20px;
}

/* Responsive Design */
@media (max-width: 768px) {
    form {
        padding: 20px;
    }

    .btn {
        padding: 10px 15px;
    }
}

</style>
@extends('userdashboard')

@section('content')
<div class="container ">
    <h3 class="mb-4 text-center text-primary">Thêm Thú Cưng</h3>

    <!-- Success and Error Messages -->
    @if (session('success'))
        <div class="alert alert-success shadow-sm rounded-3">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger shadow-sm rounded-3">{{ session('error') }}</div>
    @endif

    <!-- Form to Add Pet -->
    <form method="POST" action="{{ route('userdashboard.storePet') }}" class="bg-light p-4 shadow-lg rounded-3">
        @csrf
        <div class="mb-3">
            <label for="TenThuCung" class="form-label">Tên Thú Cưng</label>
            <input type="text" class="form-control" id="TenThuCung" name="TenThuCung" placeholder="Nhập tên thú cưng" required>
        </div>
        <div class="mb-3">
            <label for="GioiTinh" class="form-label">Giới Tính</label>
            <select class="form-select" id="GioiTinh" name="GioiTinh" required>
                <option value="" disabled selected>Chọn giới tính</option>
                <option value="Đực">Đực</option>
                <option value="Cái">Cái</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="Tuoi" class="form-label">Tuổi</label>
            <input type="number" class="form-control" id="Tuoi" name="Tuoi" placeholder="Nhập tuổi thú cưng" required>
        </div>
        <div class="mb-3">
            <label for="GiongLoai" class="form-label">Giống Loài</label>
            <select class="form-select" id="GiongLoai" name="GiongLoai" required>
                <option value="" disabled selected>Chọn giống loài</option>
                @foreach ($giongLoais as $giongLoai)
                    <option value="{{ $giongLoai->TenGiongLoai }}">{{ $giongLoai->TenGiongLoai }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="GhiChu" class="form-label">Ghi Chú</label>
            <textarea class="form-control" id="GhiChu" name="GhiChu" rows="3" placeholder="Nhập ghi chú về thú cưng"></textarea>
        </div>
        <div class="mb-3" style="display: none">
            <label for="NgayDangKy" class="form-label">Ngày Đăng Ký</label>
            <input type="date" class="form-control" id="NgayDangKy" name="NgayDangKy" value="{{ now()->format('Y-m-d') }}" required readonly>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between">
            <a href="{{ route('userdashboard.pets') }}" class="btn btn-secondary px-4 py-2 rounded-3">Quay Lại</a>
            <button type="submit" class="btn btn-primary px-4 py-2 rounded-3">Thêm</button>
        </div>
    </form>
</div>
@endsection
