<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class UserController extends Controller
{

  /**
   * @param id
   * @return view
   */
  public function profile(Request $request)
  {
    return view('user.profile');
  }
}
