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
// kontaktne udaje
Route::get('/kontaktne_udaje', [Controller::class,'kontaktneUdaje']);
Route::post('/kontaktne_udaje', [Controller::class,'updateKontaktneInfo'])->name('update_kontaktne_info');

// osobne nastavenia
Route::get('/osobne_informacie', [Controller::class,'osobneInformacie'])->name('osobne_informacie');
Route::post('/osobne_informacie', [Controller::class,'updatePersonalInfo'])->name('update_personal_info');
Route::post('/osobne_informacie2', [Controller::class,'updatePersonalInfo2'])->name('update_personal_info2');

// zmena jazyka
Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => '\App\Http\Controllers\LanguageController@switchLang']);

Route::get('/languageDemo', [Controller::class,'languageDemo']);