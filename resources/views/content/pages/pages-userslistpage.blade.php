@php $configData = Helper::appClasses(); @endphp

@extends('layouts.layoutMaster')

@section('title', 'User List')

@section('content')
<div class="container">
  <h4>User List</h4>
  <form method="get" action="{{ route('user.index') }}">
    <div class="row mb-3">
      <div class="col-md-3">
        <div class="form-group">
          <label for="group">Group:</label>
          <select class="form-control" name="groups[]" multiple>
            @foreach ($groupOptions as $groupKey => $groupValue)
            <option value="{{ $groupKey }}" {{ in_array($groupKey, $groups) ? 'selected' : '' }}>
              {{ $groupValue }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="status">Status:</label>
          <select class="form-control" name="statuses[]" multiple>
            @foreach ($statusOptions as $statusKey => $statusValue)
            <option value="{{ $statusKey }}" {{ in_array($statusKey, $statuses) ? 'selected' : '' }}>
              {{ $statusValue }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="currency">Currency:</label>
          <select class="form-control" name="currencies[]" multiple>
            @foreach ($currencyOptions as $currency)
            <option value="{{ $currency }}" {{ in_array($currency, $selectedCurrencies) ? 'selected' : '' }}>
              {{ $currency }}
            </option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="d-flex flex-column">
          <button type="submit" class="btn btn-primary mt-4">Apply Filter</button>
          <a href="{{ route('user.index') }}" class="btn btn-secondary mt-4">Reset Filters</a>
        </div>
      </div>
    </div>
  </form>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th class="{{ $sortBy == 'id' ? 'text-decoration-underline' : '' }}">
          <a
            href="{{ route('user.index', ['sortBy' => 'id', 'sortOrder' => $sortOrder == 'asc' ? 'desc' : 'asc', 'page' => $users->currentPage()]) }}">ID</a>
        </th>
        <th class="{{ $sortBy == 'login' ? 'text-decoration-underline' : '' }}">
          <a
            href="{{ route('user.index', ['sortBy' => 'login', 'sortOrder' => $sortOrder == 'asc' ? 'desc' : 'asc', 'page' => $users->currentPage()]) }}">Login</a>
        </th>
        <th class="{{ $sortBy == 'group' ? 'text-decoration-underline' : '' }}">
          <a
            href="{{ route('user.index', ['sortBy' => 'group', 'sortOrder' => $sortOrder == 'asc' ? 'desc' : 'asc', 'page' => $users->currentPage()]) }}">Group</a>
        </th>
        <th class="{{ $sortBy == 'status' ? 'text-decoration-underline' : '' }}">
          <a
            href="{{ route('user.index', ['sortBy' => 'status', 'sortOrder' => $sortOrder == 'asc' ? 'desc' : 'asc', 'page' => $users->currentPage()]) }}">Status</a>
        </th>
        <th class="{{ $sortBy == 'currency' ? 'text-decoration-underline' : '' }}">
          <a
            href="{{ route('user.index', ['sortBy' => 'currency', 'sortOrder' => $sortOrder == 'asc' ? 'desc' : 'asc', 'page' => $users->currentPage()]) }}">Currency</a>
        </th>
        <th class="{{ $sortBy == 'balance' ? 'text-decoration-underline' : '' }}">
          <a
            href="{{ route('user.index', ['sortBy' => 'balance', 'sortOrder' => $sortOrder == 'asc' ? 'desc' : 'asc', 'page' => $users->currentPage()]) }}">Balance</a>
        </th>
        <th class="{{ $sortBy == 'bonus_balance' ? 'text-decoration-underline' : '' }}">
          <a
            href="{{ route('user.index', ['sortBy' => 'bonus_balance', 'sortOrder' => 'asc', 'page' => $users->currentPage()]) }}">Bonus
            Balance</a>
        </th>
        <th class="{{ $sortBy == 'date_reg' ? 'text-decoration-underline' : '' }}">
          <a
            href="{{ route('user.index', ['sortBy' => 'date_reg', 'sortOrder' => 'asc', 'page' => $users->currentPage()]) }}">Registration
            Date</a>
        </th>
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
          <span aria-hidden="true">&raquo;</span></a>
      </li>
  </ul>
</nav>
@endsection
