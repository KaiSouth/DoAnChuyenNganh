<div class="container">
    <h2 class="mb-4">Hồ sơ thú cưng</h2>
    <button type="button" class="btn btn-primary mt-3" onclick="loadCreatePetForm()">Thêm thú cưng</button>
    <ul class="list-group">
        @foreach ($thucungs as $thucung)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $thucung->TenThuCung }}
                <button class="btn btn-info btn-sm" onclick="window.loadPetDetails({{ $thucung->MaThuCung }})">Chi
                    tiết</button>
            </li>
        @endforeach
    </ul>
</div>

<script>
    function loadPetDetails(id) {
        fetch(`/userdashboard/pet/${id}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('dashboard-content').innerHTML = html;
            })
            .catch(error => console.error('Error loading pet details:', error));
    }
</script>
