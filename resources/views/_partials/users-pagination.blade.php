<nav aria-label="Page navigation">
  <ul class="pagination justify-content-center">
    <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
      <a class="page-link" href="{{ $users->previousPageUrl() }}" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    @for ($page = 1; $page <= $users->lastPage(); $page++)
      <li class="page-item {{ $page == $users->currentPage() ? 'active' : '' }}">
        <a class="page-link" href="{{ $users->url($page) }}">{{ $page }}</a>
      </li>
      @endfor
      <li class="page-item {{ !$users->hasMorePages() ? 'disabled' : '' }}">
        <a class="page-link" href="{{ $users->nextPageUrl() }}" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
  </ul>
</nav>
