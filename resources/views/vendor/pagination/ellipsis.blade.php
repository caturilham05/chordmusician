@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between">
        {{-- MOBILE VIEW --}}
        {{-- <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination">
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">@lang('<')</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                            @lang('<')
                        </a>
                    </li>
                @endif

                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                            @lang('>')
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">@lang('>')</span>
                    </li>
                @endif
            </ul>
        </div> --}}

        <div class="d-flex justify-content-center flex-fill d-sm-none">
            <ul class="pagination">

                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&lsaquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}">&lsaquo;</a>
                    </li>
                @endif

                {{-- First Page --}}
                <li class="page-item {{ $paginator->currentPage() == 1 ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
                </li>

                {{-- Left Ellipsis --}}
                @if ($paginator->currentPage() > 3)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif

                {{-- Middle numbers (current -1, current, current +1) --}}
                @foreach (range(max(2, $paginator->currentPage()-1), min($paginator->lastPage()-1, $paginator->currentPage()+1)) as $page)
                    <li class="page-item {{ $paginator->currentPage() == $page ? 'active' : '' }}">
                        <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                    </li>
                @endforeach

                {{-- Right Ellipsis --}}
                @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif

                {{-- Last Page --}}
                @if ($paginator->lastPage() > 1)
                    <li class="page-item {{ $paginator->currentPage() == $paginator->lastPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">
                            {{ $paginator->lastPage() }}
                        </a>
                    </li>
                @endif

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}">&rsaquo;</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">&rsaquo;</span>
                    </li>
                @endif

            </ul>
        </div>


        {{-- DESKTOP VIEW --}}
        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
            <div>
                <p class="small text-muted">
                    Showing <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                    to <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                    of <span class="fw-semibold">{{ $paginator->total() }}</span> results
                </p>
            </div>

            <div>
                <ul class="pagination">

                    {{-- Previous --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">&lsaquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}">&lsaquo;</a>
                        </li>
                    @endif

                    {{-- FIRST PAGE ALWAYS --}}
                    <li class="page-item {{ $paginator->currentPage() == 1 ? 'active' : '' }}">
                        <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
                    </li>

                    {{-- LEFT ELLIPSIS --}}
                    @if ($paginator->currentPage() > 3)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif

                    {{-- MIDDLE NUMBERS --}}
                    @foreach (range(max(2, $paginator->currentPage()-1), min($paginator->lastPage()-1, $paginator->currentPage()+1)) as $page)
                        <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    {{-- RIGHT ELLIPSIS --}}
                    @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif

                    {{-- LAST PAGE (if > 1) --}}
                    @if ($paginator->lastPage() > 1)
                        <li class="page-item {{ $paginator->currentPage() == $paginator->lastPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">
                                {{ $paginator->lastPage() }}
                            </a>
                        </li>
                    @endif

                    {{-- Next --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}">&rsaquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">&rsaquo;</span>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
    </nav>
@endif
