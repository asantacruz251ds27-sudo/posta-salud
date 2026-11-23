@if ($paginator->hasPages())
    <nav>
        <ul>
            @if ($paginator->onFirstPage())
                <li><span>{!! __('pagination.previous') !!}</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">{!! __('pagination.previous') !!}</a></li>
            @endif

            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">{!! __('pagination.next') !!}</a></li>
            @else
                <li><span>{!! __('pagination.next') !!}</span></li>
            @endif
        </ul>
    </nav>
@endif