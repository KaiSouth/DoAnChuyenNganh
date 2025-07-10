<div class="mt-4">
    <ul class="pagination justify-content-center">
        <!-- Nút Previous -->
        <li>
            <a href="javascript:void(0)"
               data-page="{{ $currentPage > 1 ? $currentPage - 1 : $totalPages }}"
               class="pagination-link">
                <i class="fas fa-arrow-left"></i>
            </a>
        </li>

        <!-- Số trang -->
        @for ($i = 1; $i <= $totalPages; $i++)
            <li>
                <a href="javascript:void(0)"
                   data-page="{{ $i }}"
                   class="pagination-link {{ $i == $currentPage ? 'active' : '' }}">
                    {{ $i }}
                </a>
            </li>
        @endfor

        <!-- Nút Next -->
        <li>
            <a href="javascript:void(0)"
               data-page="{{ $currentPage < $totalPages ? $currentPage + 1 : 1 }}"
               class="pagination-link">
                <i class="fas fa-arrow-right"></i>
            </a>
        </li>
    </ul>
</div>
