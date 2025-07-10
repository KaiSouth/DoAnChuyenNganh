<style>
    .form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    color: #333;
}

.form-control {
    border-color: #ccc;
    border-radius: 0.25rem;
    padding: 0.75rem 1rem;
}

.form-control:focus {
    border-color: #6c63ff;
    box-shadow: 0 0 0 0.2rem rgba(108, 99, 255, 0.25);
}

.btn {
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    border-radius: 0.25rem;
}

.btn-primary {
    background-color: #6c63ff;
    border-color: #6c63ff;
}

.btn-primary:hover {
    background-color: #5c52d9;
    border-color: #5c52d9;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-success:hover {
    background-color: #218838;
    border-color: #218838;
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-secondary:hover {
    background-color: #5a6268;
    border-color: #5a6268;
}
</style>
@extends('userdashboard')
@section('content')
<div class="container my-5">
    <h3 class="mb-4 text-primary">Customer Profile</h3>
    <form id="profileForm" action="{{ route('userdashboard.profile.update') }}" method="POST">
        @csrf
        @method('POST')
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="HoTen" class="form-label font-weight-bold">Full Name</label>
                    <input type="text" class="form-control" id="HoTen" name="HoTen" value="{{ $customer->HoTen }}" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Email" class="form-label font-weight-bold">Email</label>
                    <input type="email" class="form-control" id="Email" name="Email" value="{{ $customer->Email }}" readonly>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="SDT" class="form-label font-weight-bold">Phone Number</label>
                    <input type="text" class="form-control" id="SDT" name="SDT" value="{{ $customer->SDT }}" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="DiaChi" class="form-label font-weight-bold">Address</label>
                    <textarea class="form-control" id="DiaChi" name="DiaChi" rows="3" readonly>{{ $customer->DiaChi }}</textarea>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="button" id="editButton" class="btn btn-primary">Update</button>
            <button type="submit" id="saveButton" class="btn btn-success ml-3 d-none">Save</button>
            <button type="button" id="cancelButton" class="btn btn-secondary ml-3 d-none">Cancel</button>
        </div>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Lưu giá trị ban đầu của form
        const initialValues = {};
        document.querySelectorAll('#profileForm input, #profileForm textarea').forEach(el => {
            initialValues[el.id] = el.value;
        });

        // Bắt sự kiện khi nhấn nút "Cập nhật"
        document.getElementById('editButton').addEventListener('click', function () {
            document.querySelectorAll('#profileForm input, #profileForm textarea').forEach(el => el.removeAttribute('readonly'));
            document.getElementById('editButton').classList.add('d-none');
            document.getElementById('saveButton').classList.remove('d-none');
            document.getElementById('cancelButton').classList.remove('d-none');
        });

        // Bắt sự kiện khi nhấn nút "Quay lại"
        document.getElementById('cancelButton').addEventListener('click', function () {
            document.querySelectorAll('#profileForm input, #profileForm textarea').forEach(el => {
                el.setAttribute('readonly', true);
                el.value = initialValues[el.id]; // Khôi phục giá trị ban đầu
            });
            document.getElementById('editButton').classList.remove('d-none');
            document.getElementById('saveButton').classList.add('d-none');
            document.getElementById('cancelButton').classList.add('d-none');
        });
    });
</script>
@endsection