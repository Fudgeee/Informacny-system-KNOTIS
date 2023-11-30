<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Osoba;
use Session;
use Illuminate\Http\Request;
use Validator;
use DB;
class DetailProjektuController extends Controller
{
    public function detailProjektu($id_projektu){
        $data = array();
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
            $projekt = DB::table('projekt')->where('id', $id_projektu)->first();
            $veduci = DB::table('osoba')->select('id', 'login', 'jmeno', 'prijmeni', 'titul_pred', 'titul_za', 'email')
            ->where('id', $projekt->vedouci)
            ->first();
            $prostriedky = DB::table('prostr_proj')
            ->select('prostredek.id', 'nazev', 'cesta', 'vlastnik', 'server', 'prostr_proj.*')
            ->leftJoin('prostredek', 'prostr_proj.id_prostredku', '=', 'prostredek.id')
            ->where('prostr_proj.vyuzivan', '>', 0)
            ->where('prostredek.stav', '<', 1)
            ->where('prostr_proj.id_projektu', $id_projektu)
            ->get();
        }

        return view('detail_projektu', compact('data', 'projekt', 'veduci', 'prostriedky'));
    }
}
