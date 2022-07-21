<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

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
    try {
      // setup validation
      $validator = Validator::make($request->all(), [
        'name' => 'required|unique:users|max:255',
        'username' => 'required|unique:users|max:255',
        'password' => 'required|max:255',
      ]);

      // check if validator fails
      if($validator->fails()) {
        return redirect('/register')->withErrors($validator);
      }
      
      // Save user details
      $user = new Users;
      $user->name = $request->name;
      $user->username = $request->username;
      $user->password = $request->password;
      $user->save();

      return redirect('/register')->with('status', 'Profile has been saved!');

    } catch (Exception $ex) {
      return redirect('/register')->withErrors($ex);
    }
  }
}
