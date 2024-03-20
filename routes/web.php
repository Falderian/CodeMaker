<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\admin\AdminApiController;
use App\Http\Controllers\pages\UsersListPage; // Import the UsersController if not already imported
use Illuminate\Support\Facades\Auth; // Импортируем класс Auth

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Main Page Route
Route::get('/', function () {
  if (Auth::check()) {
    return redirect()->route('user.index');
  } else {
    return redirect()->route('auth-login-basic');
  }
});

// locale
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::post('/auth/login-basic', [AdminApiController::class, 'authenticate'])->name('admin.login');
