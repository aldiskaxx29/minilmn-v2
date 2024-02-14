<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthLoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomEducationController;
use App\Http\Controllers\EBookController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HistoryGameController;
use App\Http\Controllers\LoginGoogleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('auth')->group(function () {
  Route::post('login', [AuthController::class, 'login'])->name('login');
  Route::post('register', [AuthController::class, 'register']);
  Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
  Route::post('check-code', [AuthController::class, 'checkCode']);
  Route::post('updatePassword', [AuthController::class, 'updatePassword']);
});

Route::get('auth/login/google', [AuthLoginController::class, 'redirectUser']);
// Route::get('auth/google-callback', [AuthLoginController::class, 'handleAuthCallback']);
Route::get('auth/google-callback', [LoginGoogleController::class, 'callback']);

// Route::group(['middleware' => ['web']], function () {
//   Route::get('login-google', [LoginGoogleController::class, 'redirect']);
//   Route::get('auth/google-callback', [LoginGoogleController::class, 'callback']);
// });

Route::middleware(['auth:sanctum','check.token'])->group(function(){

  Route::get('game/getAll', [GameController::class, 'getAll']);
  Route::get('game/getOne', [GameController::class, 'getOne']);
  Route::post('game/save', [GameController::class, 'save']);
  Route::post('game/delete', [GameController::class, 'delete']);

  Route::get('contact-us/getAll', [ContactController::class, 'getAll']);
  Route::get('contact-us/getOne', [ContactController::class, 'getOne']);
  Route::post('contact-us/save', [ContactController::class, 'save']);
  Route::post('contact-us/delete', [ContactController::class, 'delete']);

  Route::get('custom-education/getAll', [CustomEducationController::class, 'getAll']); 
  Route::get('custom-education/getOne', [CustomEducationController::class, 'getOne']); 
  Route::post('custom-education/save', [CustomEducationController::class, 'save']); 
  Route::post('custom-education/delete', [CustomEducationController::class, 'delete']); 

  Route::get('history-game/getAll', [HistoryGameController::class, 'getAll']);
  Route::get('history-game/getOne', [HistoryGameController::class, 'getOne']);
  Route::post('history-game/save', [HistoryGameController::class, 'save']);
  Route::post('history-game/delete', [HistoryGameController::class, 'delete']);

  Route::get('history-game/daily', [HistoryGameController::class, 'historyDaily']);
  Route::get('history-game/weekly', [HistoryGameController::class, 'historyWeekly']);
  Route::get('history-game/monthly', [HistoryGameController::class, 'historyMonthly']);

  Route::get('ebook/getAll', [EBookController::class, 'getAll']);
  Route::get('ebook/getOne', [EBookController::class, 'getOne']);
  Route::post('ebook/save ', [EBookController::class, 'save ']);
  Route::post('ebook/delete ', [EBookController::class, 'delete ']);

  Route::get('user/getAll', [UserController::class, 'getAll']);
  Route::get('user/getOne', [UserController::class, 'getOne']);
  Route::post('user/save', [UserController::class, 'save']);
  Route::post('user/delete', [UserController::class, 'delete']);

  Route::post('auth/logout', [AuthController::class, 'logout']);
});