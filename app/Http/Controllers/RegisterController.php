<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// Models
use App\Models\Users;

class RegisterController extends Controller
{

  /**
   * @param id
   * @return view
   */
  public function show(Request $request)
  {

    return view('common.register');
  }

  public function validateForm(Request $request)
  {
    // Check if username already exists
    $validator = Validator::make($request->all(), [
      'name' => 'required|unique:users|max:255',
      'username' => 'required|unique:users|max:255',
      'password' => 'required|max:255',
    ]);

    if($validator->fails())
    {
      return redirect('/register')->withErrors($validator)->withInput();
    }
    else
    {
      // Save user details
      $user = new Users;
      $user->name = $request->name;
      $user->username = $request->username;
      $user->password = $request->password;
      $user->save();

      return redirect('/register')->with('status', 'Profile has been saved!');
    } 
  }
}
