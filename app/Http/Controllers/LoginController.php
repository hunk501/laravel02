<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

// Models
use App\Models\Users;

class LoginController extends Controller
{

  /**
   * @param id
   * @return view
   */
  public function login(Request $request)
  { 
    return view('common.login');
  }

  public function validateForm(Request $request)
  {
    try {
      $user = Users::where([
        'username' => $request->username,
        'password' => $request->password
      ])->first();
      
      // check if user exists
      if(!$user) throw new Exception("Username or Password did not match", 1);
      
      // Redirect to user profile
      return redirect("/profile");

    } catch (Exception $ex) {
      Log::error($ex->getMessage());
      return redirect('/')->withErrors($ex->getMessage());
    }
  }
}
