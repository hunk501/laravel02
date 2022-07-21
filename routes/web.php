<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LoginController::class, 'login']);
Route::post('/validate', [LoginController::class, 'validateForm'])->name('login.validate');

Route::get('/register', [RegisterController::class, 'show']);
Route::post('/validate-form', [RegisterController::class, 'validateForm'])->name('register.validate');

Route::get('/user/{id}', [UserController::class, 'show']);