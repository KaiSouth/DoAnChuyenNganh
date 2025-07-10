<div class="container">
    <h2 class="mb-4">Thông tin chi tiết của thú cưng</h2>
    <div class="form-group">
        <label>Tên thú cưng:</label>
        <p>{{ $pet->TenThuCung }}</p>
    </div>
    <div class="form-group">
        <label>Giới tính:</label>
        <p>{{ $pet->GioiTinh }}</p>
    </div>
    <div class="form-group">
        <label>Tuổi:</label>
        <p>{{ $pet->Tuoi }}</p>
    </div>
    <div class="form-group">
        <label>Ghi chú:</label>
        <p>{{ $pet->GhiChu }}</p>
    </div>
    <button class="btn btn-secondary" onclick="window.goBack()">Quay lại</button>
</div>

<script>
    function goBack() {
        loadContent('{{ route('user.pets') }}');
    }
</script>
