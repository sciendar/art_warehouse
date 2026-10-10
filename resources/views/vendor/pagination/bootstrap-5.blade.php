@if ($paginator->hasPages())
    @php
        $class = 'page-link bg-primary-50 text-secondary-light fw-medium radius-8 border-0 px-20 py-10 d-flex align-items-center justify-content-center h-48-px w-48-px';
        $is_top = $is_top ?? false;
        $is_first = $paginator->onFirstPage();
        $is_last = !$paginator->hasMorePages();
        $last_page = $paginator->lastPage();
        $current_page = $paginator->currentPage();
        $items_count = $paginator->count();

        $get = $_GET;
        unset($get['page'])
    @endphp

    @if ($is_top || $items_count > 10)
        <nav aria-label="Page navigation example">
            <ul class="pagination round-pagination align-items-center justify-content-center">
                <li class="page-item {{ $is_first ? 'disabled' : null }}">
                    <a class="page-link" href="{{ !$is_first ? $paginator->appends($get)->url(1) : null }}">
                        <i class="bi bi-chevron-double-left"></i>
                    </a>
                </li>
                <li class="page-item {{ $is_first ? 'disabled' : null }}">
                    <a class="page-link" href="{{ !$is_first ? $paginator->appends($get)->previousPageUrl() : null }}">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                </li>

                <li class="page-item">
                    <span class="mx-1"></span>
                </li>

                @foreach ($elements as $element)
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if (($page == 3 && $page < ($current_page - 1)) || ($page == ($last_page - 2) && $page > ($current_page + 1)))
                                <li class="page-item">
                                    <span class="mx-3 mt-3">...</span>
                                </li>
                            @elseif (($page > 3 && $page < ($current_page - 1)) || ($page < ($last_page - 2) && $page > ($current_page + 1)))

                            @else
                                @if ($page == $current_page)
                                    <li class="page-item active">
                                        <a class="page-link" href="">{{ $page }}</a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $paginator->appends($get)->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endif
                        @endforeach
                    @else
                        <li class="page-item">
                            <span class="mx-3 mt-3">...</span>
                        </li>
                    @endif
                @endforeach

                <li class="page-item">
                    <span class="mx-1"></span>
                </li>
                <li class="page-item {{ $is_last ? 'disabled' : null }}">
                    <a class="page-link" href="{{ !$is_last ? $paginator->appends($get)->nextPageUrl() : null }}">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li class="page-item {{ $is_last ? 'disabled' : null }}">
                    <a class="page-link" href="{{ !$is_last ? $paginator->appends($get)->url($last_page) : null }}">
                        <i class="bi bi-chevron-double-right"></i>
                    </a>
                </li>
            </ul>
        </nav>

        @once('paginate_info')
            <p class="small text-muted">
                {{--                {!! __('Showing') !!}--}}
                <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                -
                {{--                {!! __('to') !!}--}}
                <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                из
                {{--                {!! __('of') !!}--}}
                <span class="fw-semibold">{{ $paginator->total() }}</span>
                {{--                {!! __('results') !!}--}}
            </p>
        @endonce
    @endif
@endif
