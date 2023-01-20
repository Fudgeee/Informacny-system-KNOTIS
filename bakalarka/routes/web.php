<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\KontaktneUdajeController;
use App\Http\Controllers\KonfiguraciaController;
use App\Http\Controllers\NapovedaController;
use App\Http\Controllers\OsobneInformacieController;

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
Route::get('/help', [NapovedaController::class,'Help']);
// kontaktne udaje
Route::get('/kontaktne_udaje', [KontaktneUdajeController::class,'kontaktneUdaje']);
Route::post('/kontaktne_udaje', [KontaktneUdajeController::class,'updateKontaktneInfo'])->name('update_kontaktne_info');

// osobne nastavenia
Route::get('/osobne_informacie', [OsobneInformacieController::class,'osobneInformacie'])->name('osobne_informacie');
Route::post('/osobne_informacie_dpp', [OsobneInformacieController::class,'updateDppInfo'])->name('update_dpp_info');

// konfiguracia
Route::get('/konfiguracia', [KonfiguraciaController::class,'Konfiguracia'])->name('konfiguracia');
Route::post('/konfiguracia', [KonfiguraciaController::class,'updateKonfiguracia'])->name('update_konfiguracia');

// zmena jazyka
Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => '\App\Http\Controllers\LanguageController@switchLang']);