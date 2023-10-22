<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomEducationController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HistoryGameController;
use App\Http\Controllers\LoginGoogleController;

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
  
});

Route::group(['middleware' => ['web']], function () {
  Route::get('login-google', [LoginGoogleController::class, 'redirect']);
  Route::get('auth/google-callback', [LoginGoogleController::class, 'callback']);
});

Route::middleware('auth:sanctum')->group(function(){

  Route::post('game/getAll', [GameController::class, 'getAll']);
  Route::post('game/getOne', [GameController::class, 'getOne']);
  Route::post('game/save', [GameController::class, 'save']);
  Route::post('game/delete', [GameController::class, 'delete']);

  Route::post('contact-us/getAll', [ContactController::class, 'getAll']);
  Route::post('contact-us/getOne', [ContactController::class, 'getOne']);
  Route::post('contact-us/save', [ContactController::class, 'save']);
  Route::post('contact-us/delete', [ContactController::class, 'delete']);

  Route::post('custom-education/getAll', [CustomEducationController::class, 'getAll']); 
  Route::post('custom-education/getOne', [CustomEducationController::class, 'getOne']); 
  Route::post('custom-education/save', [CustomEducationController::class, 'save']); 
  Route::post('custom-education/delete', [CustomEducationController::class, 'delete']); 

  Route::post('history-game/getAll', [HistoryGameController::class, 'getAll']);
  Route::post('history-game/getOne', [HistoryGameController::class, 'getOne']);
  Route::post('history-game/save', [HistoryGameController::class, 'save']);
  Route::post('history-game/delete', [HistoryGameController::class, 'delete']);

  Route::post('auth/logout', [AuthController::class, 'logout']);

});