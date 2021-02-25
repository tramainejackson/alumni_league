@if ($paginator->hasPages())
    <ul class="pagination pagination-circle pg-blue justify-content-around">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span>&laquo;</span></li>
            <li class="page-item disabled"><a href="#" class="page-link">First</a></li>
        @else
            <li class="page-item"><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
            <li class="page-item"><a href="{{ $paginator->url(1) }}" class="page-link">First</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><a class="page-link">{{ $page }}</a></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a href="{{ $paginator->url($paginator->count()) }}" class="page-link">Last</a></li>
            <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="page-item disabled"><a href="#" class="page-link">Last</a></li>
            <li class="disabled"><span>&raquo;</span></li>
        @endif
    </ul>
@endif
