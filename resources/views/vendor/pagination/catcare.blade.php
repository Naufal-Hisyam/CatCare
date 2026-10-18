@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="Navigasi halaman">
        <span class="pagination-info">
            {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }}
        </span>

        <div class="pagination-links">
            @if ($paginator->onFirstPage())
                <span class="page-item disabled">&laquo; Sebelumnya</span>
            @else
                <a class="page-item" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo; Sebelumnya</a>
            @endif

            <span class="page-item current">Hal. {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</span>

            @if ($paginator->hasMorePages())
                <a class="page-item" href="{{ $paginator->nextPageUrl() }}" rel="next">Berikutnya &raquo;</a>
            @else
                <span class="page-item disabled">Berikutnya &raquo;</span>
            @endif
        </div>
    </nav>
@endif
