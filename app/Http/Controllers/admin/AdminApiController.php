<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminApiController extends Controller
{
  public function authenticate(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'username' => 'required|in:admin1',
      'password' => 'required|in:111111',
    ]);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }

    try {
      $response = Http::post('http://10.110.0.2/api/admins/', [
        'method' => 'AUTH',
        'login' => $request->input('username'),
        'pass' => $request->input('password'),
        'ip' => '178.122.105.55',
        'userAgent' => $request->header('User-Agent'),
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
        'authenticated' => true
      ]);

      return redirect('/');
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }
}
