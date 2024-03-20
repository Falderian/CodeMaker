<?php

namespace App\Http\Controllers\pages;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersListPage extends Controller
{
  public function index(Request $request)
  {
    if (!session('authenticated')) {
      return redirect()->route('auth-login-basic');
    }

    $columns = [
      [
        'name' => 'ID',
        'sortBy' => 'id',
      ],
      [
        'name' => 'Login',
        'sortBy' => 'login',
      ],
      [
        'name' => 'Group',
        'sortBy' => 'group',
      ],
      [
        'name' => 'Status',
        'sortBy' => 'status',
      ],
      [
        'name' => 'Currency',
        'sortBy' => 'currency',
      ],
      [
        'name' => 'Balance',
        'sortBy' => 'balance',
      ],
      [
        'name' => 'Bonus Balance',
        'sortBy' => 'bonus_balance',
      ],
      [
        'name' => 'Registration Date',
        'sortBy' => 'date_reg',
      ],
    ];

    $db = $this->getConnection();

    $groups = $request->input('groups', []);
    $statuses = $request->input('statuses', []);
    $selectedCurrencies = $request->input('currencies', []);

    $this->storeSessionParameters($request, $groups, $statuses, $selectedCurrencies);

    $sortBy = session('sortBy', 'id');
    $sortOrder = session('sortOrder', 'desc');

    $query = $this->buildQuery($db, $groups, $statuses, $selectedCurrencies, $sortBy, $sortOrder);

    $users = $query->paginate(10)->appends([
      'groups' => $groups,
      'statuses' => $statuses,
      'currencies' => $selectedCurrencies,
      'sortBy' => $sortBy,
      'sortOrder' => $sortOrder,
    ]);

    $currencyOptions = $this->getCurrencyOptions($db);
    $groupOptions = $this->getGroupOptions();
    $statusOptions = $this->getStatusOptions();

    $hasResults = $users->isNotEmpty();

    return view(
      'content.pages.pages-userslistpage',
      compact(
        'users',
        'groups',
        'statuses',
        'groupOptions',
        'statusOptions',
        'currencyOptions',
        'sortBy',
        'sortOrder',
        'selectedCurrencies',
        'hasResults',
        'columns',
      )
    );
  }

  private function getConnection()
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

    return DB::connection('mysql_dynamic');
  }

  private function storeSessionParameters($request, $groups, $statuses, $selectedCurrencies)
  {
    session([
      'groups' => $groups,
      'statuses' => $statuses,
      'selectedCurrencies' => $selectedCurrencies,
      'sortBy' => $request->input('sortBy', 'id'),
      'sortOrder' => $request->input('sortOrder', 'desc'),
    ]);
  }

  private function buildQuery($db, $groups, $statuses, $selectedCurrencies, $sortBy, $sortOrder)
  {
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

    return $query;
  }

  private function getCurrencyOptions($db)
  {
    $currencyOptionsJson = $db->table('settings')->where('id', 'currencies')->value('value');
    return json_decode($currencyOptionsJson) ?? [];
  }

  private function getGroupOptions()
  {
    return [
      0 => 'Guest',
      1 => 'Player',
      2 => 'Admin',
      3 => 'Supervisor',
      4 => 'TestPlayer',
    ];
  }

  private function getStatusOptions()
  {
    return [
      0 => 'Inactive',
      1 => 'Active',
      2 => 'Blocked',
      3 => 'Deleted',
    ];
  }
}
