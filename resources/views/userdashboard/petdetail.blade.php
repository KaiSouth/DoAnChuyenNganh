<style>
    .pet-details-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 0rem 2rem 1rem;
    }
    .pet-details-card {
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    .pet-details-card:hover {
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }
    .form-control-plaintext {
        background-color: transparent;
        border: 1px solid transparent;
        transition: all 0.3s ease;
    }
    .form-control-plaintext.form-control-editable {
        background-color: #f8f9fa;
        border-color: #ced4da;
    }
    .icon-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        font-size: 1.5rem;
        color: #6c757d;
    }
    @media (max-width: 576px) {
        .pet-details-container {
            padding: 1rem;
        }
        .btn-group-responsive {
            flex-direction: column;
        }
        .btn-group-responsive > * {
            margin-bottom: 0.5rem;
            width: 100%;
        }
    }
</style>
@extends('userdashboard')

@section('content')
<div class="container pet-details-container">
    <div class="card pet-details-card position-relative">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Chi Tiết Thú Cưng</h4>
            <i class="bi bi-info-circle icon-badge"></i>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('userdashboard.updatePet', ['id' => $pet->MaThuCung]) }}" id="petForm">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="TenThuCung" class="form-label">Tên Thú Cưng</label>
                        <input type="text" class="form-control form-control-plaintext" id="TenThuCung" name="TenThuCung" 
                               value="{{ $pet->TenThuCung }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="GiongLoai" class="form-label">Giống Loài</label>
                        <input type="text" class="form-control form-control-plaintext" id="GiongLoai" name="GiongLoai" 
                               value="{{ $pet->TenGiongLoai }}" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="GioiTinh" class="form-label">Giới Tính</label>
                        <input type="text" class="form-control form-control-plaintext" id="GioiTinh" name="GioiTinh" 
                               value="{{ $pet->GioiTinh }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="Tuoi" class="form-label">Tuổi</label>
                        <input type="number" class="form-control form-control-plaintext" id="Tuoi" name="Tuoi" 
                               value="{{ $pet->Tuoi }}" readonly>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="GhiChu" class="form-label">Ghi Chú</label>
                    <textarea class="form-control form-control-plaintext" id="GhiChu" name="GhiChu" 
                              rows="3" readonly>{{ $pet->GhiChu }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="NgayDangKi" class="form-label">Ngày Đăng Ký</label>
                    <input type="text" class="form-control form-control-plaintext" id="NgayDangKi" 
                           value="{{ $pet->ngaydangki }}" readonly>
                </div>

                <div class="d-flex btn-group-responsive">
                    <button type="button" id="editBtn" class="btn btn-primary me-2">
                        <i class="bi bi-pencil me-1"></i>Cập Nhật
                    </button>
                    <button type="button" id="cancelBtn" class="btn btn-secondary me-2 d-none">
                        <i class="bi bi-x-circle me-1"></i>Hủy
                    </button>
                    <button type="submit" id="saveBtn" class="btn btn-success d-none">
                        <i class="bi bi-save me-1"></i>Lưu
                    </button>
                    <a href="{{ route('userdashboard.pets') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Quay Lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Bootstrap JS and Dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.getElementById('editBtn').addEventListener('click', function () {
        const form = document.getElementById('petForm');
        const inputs = form.querySelectorAll('input, textarea');
        
        inputs.forEach(field => {
            field.removeAttribute('readonly');
            field.classList.add('form-control-editable');
        });

        document.getElementById('editBtn').classList.add('d-none');
        document.getElementById('saveBtn').classList.remove('d-none');
        document.getElementById('cancelBtn').classList.remove('d-none');
    });

    document.getElementById('cancelBtn').addEventListener('click', function () {
        window.location.reload();
    });
</script>
@endsection
