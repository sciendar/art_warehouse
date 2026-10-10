@if($paginate->lastPage() > 1)
    @php
        $_GET['_url'] = null;
        $get = (isset($_GET) and $_GET != null) ? $get = $_GET : $get = null;
    @endphp

    <nav class="my-4 d-flex justify-content-center" aria-label="navigation">
        <ul class="pagination pagination-primary-soft rounded mb-0">
{{--            <li class="page-item mx-1" @if($paginate->currentPage() == 1) disabled @endif>--}}
{{--                <button type="button" data-page="1" class="btn btn-outline-primary page_{{ $data }}_link">--}}
{{--                    <i class="fas fa-angle-double-left"></i>--}}
{{--                </button>--}}
{{--            </li>--}}
            <li class="page-item mx-1 mr-3" @if($paginate->currentPage() == 1) disabled @endif>
                <button type="button" data-page="{{ $paginate->currentPage() - 1 }}" class="btn btn-outline-primary page_{{ $data }}_link">
                    <i class="fas fa-angle-left"></i>
                </button>
            </li>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <li class="page-item mx-1 @if($paginate->currentPage() == 1) active @endif">
                <button type="button" data-page="1" class="btn btn-outline-primary page_{{ $data }}_link @if($paginate->currentPage() == 1) active @endif">
                    1
                </button>
            </li>

            @if($paginate->lastPage() >= 2)
                <li class="page-item mx-1 @if($paginate->currentPage() == 2) active @endif">
                    <button type="button" data-page="2" class="btn btn-outline-primary page_{{ $data }}_link @if($paginate->currentPage() == 2) active @endif">
                        2
                    </button>
                </li>
            @endif
            {{--            @if($pagination->lastPage() >= 3)--}}
            {{--                <li class="pagination__item @if($pagination->currentPage() == 3) active @endif">--}}
            {{--                    <a href="{{ $pagination->appends($get)->url(3) }}">--}}
            {{--                        3--}}
            {{--                    </a>--}}
            {{--                </li>--}}
            {{--            @endif--}}

            @if($paginate->currentPage()-1 > 3)
                ...
            @endif

            @if($paginate->currentPage()-1 >= 3 and $paginate->currentPage()-1 < $paginate->lastPage()-2)
                <li class="page-item mx-1">
                    <button type="button" data-page="{{ $paginate->currentPage()-1 }}" class="btn btn-outline-primary page_{{ $data }}_link">
                        {{ $paginate->currentPage() - 1 }}
                    </button>
                </li>
            @endif
            @if($paginate->currentPage() >= 3 and $paginate->currentPage() < $paginate->lastPage()-2)
                <li class="page-item active mx-1">
                    <button type="button" data-page="{{ $paginate->currentPage() }}" class="btn btn-outline-primary page_{{ $data }}_link active">
                        {{ $paginate->currentPage() }}
                    </button>
                </li>
            @endif
            @if($paginate->currentPage()+1 >= 3 and $paginate->currentPage()+1 < $paginate->lastPage()-2)
                <li class="page-item mx-1">
                    <button type="button" data-page="{{ $paginate->currentPage() + 1 }}" class="btn btn-outline-primary page_{{ $data }}_link">
                        {{ $paginate->currentPage() + 1 }}
                    </button>
                </li>
            @endif

            @if($paginate->currentPage() + 2 < $paginate->lastPage() - 2)
                ...
            @endif

            {{--            @if($pagination->lastPage()-2 >= 3)--}}
            {{--                <li class="pagination__item @if($pagination->currentPage() == $pagination->lastPage()-2) active @endif">--}}
            {{--                    <a href="{{ $pagination->appends($get)->url($pagination->lastPage()-2) }}">--}}
            {{--                        {{ $pagination->lastPage()-2 }}--}}
            {{--                    </a>--}}
            {{--                </li>--}}
            {{--            @endif--}}
            @if($paginate->lastPage()-1 > 2)
                <li class="page-item mx-1 @if($paginate->currentPage() == $paginate->lastPage()-1) active @endif">
                    <button type="button" data-page="{{ $paginate->lastPage() - 1 }}" class="btn btn-outline-primary page_{{ $data }}_link @if($paginate->currentPage() == $paginate->lastPage()-1) active @endif">
                        {{ $paginate->lastPage()-1 }}
                    </button>
                </li>
            @endif
            @if($paginate->lastPage() > 2)
                <li class="page-item mx-1 @if($paginate->currentPage() == $paginate->lastPage()) active @endif">
                    <button type="button" data-page="{{ $paginate->lastPage() }}" class="btn btn-outline-primary page_{{ $data }}_link @if($paginate->currentPage() == $paginate->lastPage()) active @endif">
                        {{ $paginate->lastPage() }}
                    </button>
                </li>
            @endif
            &nbsp;&nbsp;&nbsp;&nbsp;
            <li class="page-item mx-1 ml-3" @if($paginate->currentPage() == $paginate->lastPage()) disabled @endif>
                <button type="button" data-page="{{ $paginate->currentPage() + 1 }}" class="btn btn-outline-primary page_{{ $data }}_link">
                    <i class="fas fa-angle-right"></i>
                </button>
            </li>
{{--            <li class="page-item mx-1" @if($paginate->currentPage() == $paginate->lastPage()) disabled @endif>--}}
{{--                <button type="button" data-page="{{ $paginate->lastPage() + 1 }}" class="btn btn-outline-primary page_{{ $data }}_link">--}}
{{--                    <i class="fas fa-angle-double-right"></i>--}}
{{--                </button>--}}
{{--            </li>--}}
        </ul>
    </nav>
@endif

