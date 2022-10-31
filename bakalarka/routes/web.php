<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;

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
// login
Route::get('/login', [AuthController::class,'login'])->middleware('alreadyLoggedIn');
Route::post('/login-user', [AuthController::class,'loginUser'])->name('login-user');
Route::get('/logout', [AuthController::class,'logout']);
// change password
Route::get('/change_password', [AuthController::class,'changePassword'])->name('change_password');
Route::post('/change_password', [AuthController::class,'updatePassword'])->name('update_password');
// dashboard
Route::get('/dashboard', [AuthController::class,'dashboard'])->middleware('isLoggedIn');
// napoveda
Route::get('/help', [Controller::class,'Help']);
// opravnenia k serverom
Route::get('/opravnenia_k_serverom', [Controller::class,'opravneniaKServerom']);
// osobne nastavenia
Route::get('/osobne_nastavenia', [Controller::class,'osobneNastavenia'])->name('osobne_nastavenia');
Route::post('/osobne_nastavenia', [Controller::class,'updatePersonalInfo'])->name('update_personal_info');
Route::post('/osobne_nastavenia/dpp', [Controller::class,'updateDppInfo'])->name('update_dpp_info');

// zmena jazyka
Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => '\App\Http\Controllers\LanguageController@switchLang']);

Route::get('/languageDemo', [Controller::class,'languageDemo']);