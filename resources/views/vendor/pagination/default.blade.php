@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>{{HtmlHelper::createFAIcon('chevron-left')}}</span></li>
        @else
            <li><a href="{{ preg_replace('/\?page=[1]$/', '', $paginator->previousPageUrl()) }}">{{HtmlHelper::createFAIcon('chevron-left')}}</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ preg_replace('/\?page=[1]$/', '', $url) }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}">{{HtmlHelper::createFAIcon('chevron-right')}}</a></li>
        @else
            <li class="disabled"><span>{{HtmlHelper::createFAIcon('chevron-right')}}</span></li>
        @endif
    </ul>
@endif
