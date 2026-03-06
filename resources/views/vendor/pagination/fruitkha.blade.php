{{-- Kiểm tra xem có cần hiển thị phân trang hay không --}}
@if ($paginator->hasPages() || $paginator->total() > 0)
    <nav>
        {{-- THAY THẾ class="pagination" bằng class="pagination-wrap" --}}
        <ul class="pagination-wrap">
            {{-- Nút Previous --}}
            @if ($paginator->onFirstPage())
                {{-- Vô hiệu hóa nút Prev --}}
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span aria-hidden="true">Prev</span>
                </li>
            @else
                {{-- Cho phép bấm nút Prev --}}
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">Prev</a>
                </li>
            @endif

            {{-- Các nút số trang --}}
            @foreach ($elements as $element)
                {{-- "Dấu ba chấm" --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array of links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            {{-- Trang hiện tại: thêm class active --}}
                            <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                        @else
                            {{-- Các trang khác --}}
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Nút Next --}}
            @if ($paginator->hasMorePages())
                {{-- Cho phép bấm nút Next --}}
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Next</a>
                </li>
            @else
                {{-- Vô hiệu hóa nút Next --}}
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span aria-hidden="true">Next</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
