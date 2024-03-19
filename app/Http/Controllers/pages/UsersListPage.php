<?php
// app/Http/Controllers/pages/UsersListPage.php

namespace App\Http\Controllers\pages;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersListPage extends Controller
{
  public function index(Request $request)
  {
    // Получаем данные подключения из сессии
    $db_host = session('db_host');
    $db_port = session('db_port');
    $db_username = session('db_username');
    $db_password = session('db_password');
    $db_database = session('db_database');

    // Временно изменяем конфигурацию базы данных
    config([
      'database.connections.mysql_dynamic' => [
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => 5433,
        'database' => $db_database,
        'username' => $db_username,
        'password' => $db_password,
      ]
    ]);

    // Создаем подключение к базе данных
    $db = DB::connection('mysql_dynamic');

    // Фильтры
    $groups = $request->input('groups', []);
    $statuses = $request->input('statuses', []);
    $currencies = $request->input('currencies', []);

    // Сортировка
    $sortBy = $request->input('sortBy', 'id');
    $sortOrder = $request->input('sortOrder', 'desc');

    // Запрос для получения пользователей
    $query = $db->table('users');

    // Применяем фильтры
    if (!empty ($groups)) {
      $query->whereIn('group', $groups);
    }
    if (!empty ($statuses)) {
      $query->whereIn('status', $statuses);
    }
    if (!empty ($currencies)) {
      $query->whereIn('currency', $currencies);
    }

    // Применяем сортировку
    $query->orderBy($sortBy, $sortOrder);

    // Получаем список пользователей из базы данных с пагинацией
    $users = $query->paginate(10);

    // Возвращаем представление с данными о пользователях
    return view('content.pages.pages-userslistpage', [
      'users' => $users,
      'groups' => $groups,
      'statuses' => $statuses,
      'currencies' => $currencies,
      'sortBy' => $sortBy,
      'sortOrder' => $sortOrder,
    ]);
  }
}
