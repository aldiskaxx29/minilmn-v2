<?php

use App\Http\Controllers\LoginGoogleController;
use App\Http\Controllers\TestingController;
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

Route::get('/', function () {
    return view('welcome');
});

// Route::group(['middleware' => ['web']], function () {
    Route::get('auth/google-callback', [LoginGoogleController::class, 'callback']);
// });

Route::get('testing', [TestingController::class, 'index']);