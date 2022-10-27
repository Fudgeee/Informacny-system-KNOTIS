<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
    return view('/login');
});

Route::get('/login', [AuthController::class,'login'])->middleware('alreadyLoggedIn');
Route::post('/login-user', [AuthController::class,'loginUser'])->name('login-user');
Route::get('/dashboard', [AuthController::class,'dashboard'])->middleware('isLoggedIn');
Route::get('/logout', [AuthController::class,'logout']);
Route::get('/change_password', [AuthController::class,'changePassword'])->name('change_password');
Route::post('/change_password', [AuthController::class,'updatePassword'])->name('update_password');
Route::get('/help', [AuthController::class,'Help'])->name('help');

Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => '\App\Http\Controllers\LanguageController@switchLang']);

Route::get('/languageDemo', 'App\Http\Controllers\AuthController@languageDemo');