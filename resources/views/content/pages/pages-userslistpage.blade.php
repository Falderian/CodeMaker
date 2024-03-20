@php $configData = Helper::appClasses(); @endphp

@extends('layouts.layoutMaster')

@section('title', 'User List')

@section('content')
<div class="container">
  <h4>User List</h4>
  @include('_partials.users-filters')
  @if ($hasResults)
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        @foreach ($columns as $column)
        <th class="{{ $sortBy == $column['sortBy'] ? 'text-decoration-underline' : '' }}">
          <a
            href="{{ route('user.index', ['sortBy' => $column['sortBy'], 'sortOrder' => $sortOrder == 'asc' ? 'desc' : 'asc', 'groups' => $groups, 'statuses' => $statuses, 'currencies' => $selectedCurrencies]) }}">
            {{ $column['name'] }}
          </a>
        </th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
      <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->login }}</td>
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
  @else
  <p>No results found.</p>
  @endif
</div>

@if ($hasResults)
@include('_partials.users-pagination')
@endif

@endsection
