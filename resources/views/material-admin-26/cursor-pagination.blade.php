@if ($paginator->hasPages())
    <div class="dataTables_paginate cursor-pagination mb-4">
        <!-- Previous Page Link -->
        @if ($paginator->onFirstPage())
            <a class="paginate_button previous disabled" href="#">Previous</a>
        @else
            <a class="paginate_button previous" href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a>
        @endif

        <!-- Next Page Link -->
        @if ($paginator->hasMorePages())
            <a class="paginate_button next" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
        @else
            <a class="paginate_button next disabled" href="#">Next</a>
        @endif

    </div>
@endif
