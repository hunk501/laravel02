<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{

  /**
   * @param id
   * @return view
   */
  public function show(Request $request)
  {
    
    return view('user.profile', [
      'userId' => $request->id
    ]);
  }
}
