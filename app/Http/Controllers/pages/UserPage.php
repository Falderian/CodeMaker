<?php
namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserPage extends Controller
{
  public function show($id)
  {
    $user = User::findOrFail($id);
    return view(
      'user.show',
      compact('user')
    );
  }
}
