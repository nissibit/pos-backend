@if ($paginator->hasPages())
    <div class="w3-bar">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="w3-bar-item w3-button w3-circle disabled"><span class="page-link">&laquo;</span></li>
        @else
            <li class="w3-button"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="w3-bar-item w3-button w3-circle disabled"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="w3-bar-item w3-button w3-circle active "><span class="page-link bg-primary text-light">{{ $page }}</span></li>
                    @else
                        <li class="w3-button w3-circle"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="w3-button"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="w3-bar-item w3-button w3-circle disabled"><span class="page-link">&raquo;</span></li>
        @endif
</div>
@endif
