<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
    return redirect("/user/1")->withSuccess('Login details are not valid');
  }
}
