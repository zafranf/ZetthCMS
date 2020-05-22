@if ($paginator->hasPages())
  @php
    $paginate = $paginator->toArray();
  @endphp
  <nav class="pagination" role="navigation" aria-label="pagination" style="margin-top:10px;">
    {{-- <a class="pagination-previous">Previous</a>
    <a class="pagination-next">Next page</a> --}}
    <ul class="pagination-list">
      {{-- First Page Link --}}
      @if ($paginate['total'] >= app('site')->perpage * 10)
        @if ($paginator->onFirstPage())
          <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.first_page')">
            <span class="pagination-link" aria-hidden="true">&laquo;</span>
          </li>
        @else
          <li>
            <a class="pagination-link" href="{{ _url($paginate['first_page_url']) }}" rel="first" aria-label="@lang('pagination.first_page')">&laquo;</a>
          </li>
        @endif
      @endif

      {{-- Previous Page Link --}}
      @if ($paginator->onFirstPage())
        <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
          <span class="pagination-link" aria-hidden="true">&lsaquo;</span>
        </li>
      @else
        <li>
          <a class="pagination-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
        </li>
      @endif

      {{-- Pagination Elements --}}
      @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
          <li>
            <span class="pagination-ellipsis">&hellip;</span>
          </li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
          @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
              <li aria-current="page">
                <span class="pagination-link is-current has-background-danger has-border-danger">{{ $page }}</span>
              </li>
            @else
              <li>
                <a class="pagination-link" href="{{ $url }}">{{ $page }}</a>
              </li>
            @endif
          @endforeach
        @endif
      @endforeach

      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
        <li>
          <a class="pagination-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
        </li>
      @else
        <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
          <span class="pagination-link" aria-hidden="true">&rsaquo;</span>
        </li>
      @endif

      {{-- Last Page Link --}}
      @if ($paginate['total'] >= app('site')->perpage * 10)
        @if ($paginator->hasMorePages())
          <li>
            <a class="pagination-link" href="{{ _url($paginate['last_page_url']) }}" rel="last" aria-label="@lang('pagination.last_page')">&raquo;</a>
          </li>
        @else
          <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.last_page')">
            <span class="pagination-link" aria-hidden="true">&raquo;</span>
          </li>
        @endif
      @endif
    </ul>
  </nav>
@endif