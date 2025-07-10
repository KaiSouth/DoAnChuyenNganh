<div class="container">
    <h2 class="mb-4">Thông tin cá nhân</h2>
    <form id="profile-form">
        <div class="form-group">
            <label for="HoTen">Họ và Tên</label>
            <input type="text" class="form-control" id="HoTen" name="HoTen" value="{{ $customer->HoTen }}" readonly
                data-original="{{ $customer->HoTen }}">
        </div>
        <div class="form-group">
            <label for="Email">Email</label>
            <input type="email" class="form-control" id="Email" name="Email" value="{{ $customer->Email }}"
                readonly data-original="{{ $customer->Email }}">
        </div>
        <div class="form-group">
            <label for="SDT">Số điện thoại</label>
            <input type="text" class="form-control" id="SDT" name="SDT" value="{{ $customer->SDT }}"
                readonly data-original="{{ $customer->SDT }}">
        </div>
        <div class="form-group">
            <label for="DiaChi">Địa chỉ</label>
            <input type="text" class="form-control" id="DiaChi" name="DiaChi" value="{{ $customer->DiaChi }}"
                readonly data-original="{{ $customer->DiaChi }}">
        </div>
        <div class="mt-4">
            <button type="button" class="btn btn-primary" id="edit-button">Cập nhật</button>
            <button type="button" class="btn btn-secondary d-none" id="cancel-button">Quay lại</button>
            <button type="button" class="btn btn-success d-none" id="save-button">Lưu</button>
        </div>
    </form>
</div>
