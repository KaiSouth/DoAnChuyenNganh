<div class="mb-3">
    <div class="form-check">
        @foreach ($dichvus as $dichvu)
            <div>
                <input type="checkbox" name="MaDichVu[]" value="{{ $dichvu->MaDichVu }}" class="form-check-input"
                    id="dichvu_{{ $dichvu->MaDichVu }}"
                    {{ in_array($dichvu->MaDichVu, $selectedServices) ? 'checked' : '' }}>
                <label class="form-check-label" for="dichvu_{{ $dichvu->MaDichVu }}">
                    {{ $dichvu->TenDichVu }} - {{ number_format($dichvu->DonGia, 0, ',', '.') }} VND
                </label>
            </div>
        @endforeach
    </div>
</div>
