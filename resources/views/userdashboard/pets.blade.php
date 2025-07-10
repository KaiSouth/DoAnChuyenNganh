<style>
    .pet-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .pet-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .pet-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 300px;
        text-align: center;
    }
</style>
@extends('userdashboard')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Danh Sách Thú Cưng</h3>
            <a href="{{ route('userdashboard.addPet') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-2"></i>Thêm Thú Cưng
            </a>
        </div>

        @if ($pets->isEmpty())
            <div class="empty-state bg-light rounded-3 p-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-box-seam text-muted mb-3" viewBox="0 0 16 16">
                    <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 4.635a.5.5 0 0 0-.185.707c.25.41.701.573.976.288.066-.061.127-.159.126-.286V3.602a.5.5 0 0 1 .5-.5 2.5 2.5 0 1 1 5 0v1.214a.5.5 0 0 1 .5.5v4.272a.5.5 0 0 1-1 0V5.436a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4.272a.5.5 0 0 0 .186.432l6.851 4.14a.5.5 0 0 0 .505 0l6.784-4.092a.5.5 0 0 0 .2-.432v-4.261c0-.365-.15-.715-.406-.967l-2.165-2.014a.5.5 0 0 1-.177-.375V3.603a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1.221a.5.5 0 0 1-.186.432l-6.968 4.212z"/>
                </svg>
                <p class="text-muted">Bạn chưa đăng ký thú cưng nào.</p>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="petCardContainer">
                @foreach ($pets as $pet)
                    <div class="col" id="petCard-{{ $pet->MaThuCung }}">
                        <div class="card pet-card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $pet->TenThuCung }}</h5>
                                <p class="card-text text-muted">
                                    <strong>Giống Loài:</strong> {{ $pet->TenGiongLoai }}
                                </p>
                                <div class="pet-actions">
                                    <a href="{{ route('userdashboard.petDetail', ['id' => $pet->MaThuCung]) }}" 
                                    class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-info-circle me-1"></i>Chi tiết
                                    </a>
                                    <button class="btn btn-outline-danger btn-sm" 
                                            onclick="deletePet({{ $pet->MaThuCung }})">
                                        <i class="bi bi-trash me-1"></i>Xóa
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function deletePet(petId) {
    if (confirm("Bạn có chắc muốn xóa thú cưng này không?")) {
        fetch(`/userdashboard/pet/${petId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Only remove the pet card if the server confirms the delete
                    const petCard = document.getElementById(`petCard-${petId}`);
                    if (petCard) {
                        petCard.remove();
                    }
                    alert("Thú cưng đã được xóa.");
                } else {
                    alert("Đã xảy ra lỗi khi xóa thú cưng.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Đã xảy ra lỗi khi xóa thú cưng.");
            });
    }
}

</script>
