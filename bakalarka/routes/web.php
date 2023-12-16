<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\KontaktneUdajeController;
use App\Http\Controllers\KonfiguraciaController;
use App\Http\Controllers\NapovedaController;
use App\Http\Controllers\OsobneInformacieController;
use App\Http\Controllers\PracovneVykazyController;
use App\Http\Controllers\PlanPraceController;
use App\Http\Controllers\ImportVykazovController;
use App\Http\Controllers\RieseneProjektyController;
use App\Http\Controllers\PracovneVykazyOsobyController;
use App\Http\Controllers\MojeVykazyController;
use App\Http\Controllers\DetailProjektuController;

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

// pracovne vykazy
Route::get('/pracovne_vykazy', [PracovneVykazyController::class,'pracovneVykazy'])->name('pracovneVykazy');
Route::post('/pracovne_vykazy_projekt', [PracovneVykazyController::class,'updatePracovneVykazyProjekt'])->name('update_pracovne_vykazy_projekt');
Route::post('/pracovne_vykazy_tyzden', [PracovneVykazyController::class,'updatePracovneVykazyTyzden'])->name('update_pracovne_vykazy_tyzden');
Route::post('/pracovne_vykazy_denny', [PracovneVykazyController::class,'updatePracovneVykazyDenny'])->name('update_pracovne_vykazy_denny');
Route::post('/pracovne_vykazy_tyzdenny', [PracovneVykazyController::class,'updatePracovneVykazyTyzdenny'])->name('update_pracovne_vykazy_tyzdenny');
Route::post('/pracovne_vykazy_tyzdenny_s_hodinami', [PracovneVykazyController::class,'updatePracovneVykazyTyzdennySHodinami'])->name('update_pracovne_vykazy_tyzdenny_s_hodinami');
Route::post('/delete-vykaz', [PracovneVykazyController::class, 'deleteVykaz']);

// pracovne vykazy osoby
Route::get('/pracovne_vykazy_osoby', [PracovneVykazyOsobyController::class,'pracovneVykazy']);

// moje pracovne vykazy
Route::get('/moje_vykazy/{id_projektu}', [MojeVykazyController::class,'mojeVykazy']);

// import pracovnych vykazov zo suboru
Route::get('/import_vykazov', [ImportVykazovController::class,'importVykazov']);
Route::post('/import_vykazov', [ImportVykazovController::class,'uploadAndSendEmail'])->name('import_vykazov');

//detail projektu
Route::get('/detail_projektu/{id_projektu}', [DetailProjektuController::class,'detailProjektu']);
Route::post('/aktualizovat-ukol', [DetailProjektuController::class, 'aktualizovatUkol']);


// plan prace
Route::get('/plan_prace', [PlanPraceController::class,'planPrace']);

// riesene projekty
Route::get('/riesene_projekty', [RieseneProjektyController::class,'rieseneProjekty']);

// zmena zabezpecenia sezeni
Route::get('/zmena_sezeni', [Controller::class,'zmenaSezeni']);