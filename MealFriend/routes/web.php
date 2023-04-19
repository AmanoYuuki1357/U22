<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () { return view('welcome'); });

Auth::routes();

Route::get('/', function () { return view('index'); });
Route::get('/cart', function () { return view('cart.index'); });
Route::get('/user', function () { return view('user.index'); });

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
