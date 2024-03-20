<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminApiController extends Controller
{
  public function authenticate(Request $request)
  {
    try {
      $response = Http::post('http://165.232.95.157/api/admins/', [
        'method' => 'AUTH',
        'login' => 'admin1',
        'pass' => '111111',
        'ip' => '178.122.105.55',
        'userAgent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36',
      ]);

      $data = $response->json();

      $hostAndPort = explode(':', $data['db']['host']);
      $host = $hostAndPort[0];
      $port = $hostAndPort[1];

      Session::put([
        'db_host' => $host,
        'db_port' => $port,
        'db_username' => $data['db']['username'],
        'db_password' => $data['db']['pass'],
        'db_database' => $data['db']['database'],
        'user_id' => $data['user']['id'],
        'user_group' => $data['user']['group'],
        'user_login' => $data['user']['login'],
      ]);

      return redirect('/');
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }
}
