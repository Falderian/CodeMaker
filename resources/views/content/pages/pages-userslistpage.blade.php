@php $configData = Helper::appClasses(); @endphp

@extends('layouts.layoutMaster')

@section('title', 'User List')

@section('content')
<div class="container">
  <h4>User List</h4>
  <div class="table-responsive" style="height: 500px; overflow-y: auto;">
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th><a
              href="{{ $users->url(1) }}&sort=id&direction={{ $sort == 'id' && $direction == 'asc' ? 'desc' : 'asc' }}">ID</a>
          </th>
          <th>Login</th>
          <th>Group</th>
          <th>Status</th>
          <th>Currency</th>
          <th>Balance</th>
          <th>Bonus Balance</th>
          <th>Registration Date</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
        <tr>
          <td>{{ $user->id }}</td>
          <td><a href="{{ route('user.show', $user->id) }}">{{ $user->login }}</a></td>
          <td>{{ $user->group }}</td>
          <td>{{ $user->status }}</td>
          <td>{{ $user->currency }}</td>
          <td>{{ number_format($user->balance / 100, 2) }}</td>
          <td>{{ number_format($user->bonus_balance / 100, 2) }}</td>
          <td>{{ $user->date_reg }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
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


</div>
@endsection
