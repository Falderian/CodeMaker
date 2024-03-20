<?php

namespace App\Http\Controllers\pages;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersListPage extends Controller
{
  public function index(Request $request)
  {
    $db_host = session('db_host');
    $db_port = session('db_port');
    $db_username = session('db_username');
    $db_password = session('db_password');
    $db_database = session('db_database');

    config([
      'database.connections.mysql_dynamic' => [
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => 3307,
        'database' => $db_database,
        'username' => $db_username,
        'password' => $db_password,
      ]
    ]);

    $db = DB::connection('mysql_dynamic');
    $groups = $request->input('groups', []);
    $statuses = $request->input('statuses', []);
    $selectedCurrencies = $request->input('currencies', []);

    $sortBy = $request->input('sortBy', 'id');
    $sortOrder = $request->input('sortOrder', 'desc');

    $query = $db->table('users');

    if (!empty ($groups)) {
      $query->whereIn('group', $groups);
    }
    if (!empty ($statuses)) {
      $query->whereIn('status', $statuses);
    }
    if (!empty ($selectedCurrencies)) {
      $query->whereIn('currency', $selectedCurrencies);
    }

    $query->orderBy($sortBy, $sortOrder);

    $users = $query->paginate(10)->appends(request()->query());

    $currencyOptionsJson = $db->table('settings')->where('id', 'currencies')->value('value');
    $currencyOptions = json_decode($currencyOptionsJson);

    if ($currencyOptions === null) {
      $currencyOptions = [];
    }

    $groupOptions = [
      0 => 'Guest',
      1 => 'Player',
      2 => 'Admin',
      3 => 'Supervisor',
      4 => 'TestPlayer',
    ];

    $statusOptions = [
      0 => 'Inactive',
      1 => 'Active',
      2 => 'Blocked',
      3 => 'Deleted',
    ];

    $selectedCurrencies = $request->input('currencies', []);

    return view('content.pages.pages-userslistpage', [
      'users' => $users,
      'groups' => $groups,
      'statuses' => $statuses,
      'groupOptions' => $groupOptions,
      'statusOptions' => $statusOptions,
      'currencyOptions' => $currencyOptions,
      'sortBy' => $sortBy,
      'sortOrder' => $sortOrder,
      'selectedCurrencies' => $selectedCurrencies,
    ]);
  }
}
