@if ($paginator->hasPages())
    @php
        if (!function_exists('en2bn')) {
            function en2bn($number) {
                $en = ['0','1','2','3','4','5','6','7','8','9'];
                $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
                return str_replace($en, $bn, (string)$number);
            }
        }
    @endphp
    <div class="custom-event-pagination-container">
        <ul class="custom-event-pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">আগের</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">আগের</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ en2bn($page) }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ en2bn($page) }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">পরের</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">পরের</span>
                </li>
            @endif
        </ul>
    </div>
@endif
