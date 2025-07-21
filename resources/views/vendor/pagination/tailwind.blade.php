@if ($paginator->hasPages())
  <div class="join">

    <!-- First page button -->
    <a href="{{ $paginator->url(1) }}" class="join-item btn @if ($paginator->onFirstPage()) btn-disabled @endif"
      @if ($paginator->onFirstPage()) aria-disabled="true" tabindex="-1" @endif>
      « First
    </a>

    <!-- Previous page button -->
    <a href="{{ $paginator->previousPageUrl() }}"
      class="join-item btn @if (!$paginator->previousPageUrl()) btn-disabled @endif"
      @if (!$paginator->previousPageUrl()) aria-disabled="true" tabindex="-1" @endif>
      ‹ Prev
    </a>

    @php
      $last = $paginator->lastPage();
      $current = $paginator->currentPage();
      $maxButtons = 5; // total page buttons max including first & last
      $pages = [];

      if ($last <= $maxButtons) {
          // Less than max buttons, show all pages
          $pages = range(1, $last);
      } else {
          // Always include first and last pages
          $pages[] = 1;

          $middleButtonsCount = $maxButtons - 2; // exclude first & last pages

          // Calculate sliding window start and end
          $start = max($current - floor($middleButtonsCount / 2), 2);
          $end = $start + $middleButtonsCount - 1;

          if ($end >= $last) {
              $end = $last - 1;
              $start = $end - $middleButtonsCount + 1;
          }

          // Add pages between start and end
          for ($i = $start; $i <= $end; $i++) {
              $pages[] = $i;
          }

          $pages[] = $last;
      }
    @endphp

    <!-- Render page buttons with ellipsis -->
    @foreach ($pages as $i => $page)
      @if ($i > 0 && $page - $pages[$i - 1] > 1)
        <span class="join-item btn btn-disabled cursor-default select-none">...</span>
      @endif

      <a href="{{ $paginator->url($page) }}" class="join-item btn @if ($current == $page) btn-primary @endif"
        @if ($current == $page) aria-current="page" @endif>
        {{ $page }}
      </a>
    @endforeach

    <!-- Next page button -->
    <a href="{{ $paginator->nextPageUrl() }}" class="join-item btn @if (!$paginator->hasMorePages()) btn-disabled @endif"
      @if (!$paginator->hasMorePages()) aria-disabled="true" tabindex="-1" @endif>
      Next ›
    </a>

    <!-- Last page button -->
    <a href="{{ $paginator->url($last) }}" class="join-item btn @if ($current == $last) btn-disabled @endif"
      @if ($current == $last) aria-disabled="true" tabindex="-1" @endif>
      Last »
    </a>

  </div>
@endif
