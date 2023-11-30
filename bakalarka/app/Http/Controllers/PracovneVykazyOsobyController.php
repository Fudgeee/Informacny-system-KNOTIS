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

class PracovneVykazyOsobyController extends Controller
{
    public function pracovneVykazy(){
        $data = array();
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
            $vykazyT = DB::table('tydenni_v')
            ->select(
                'tyden.cislo as cislo_tydne', 
                'tydenni_v.id_osoby as id_osoby', 
                'tydenni_v.id_projektu as id_projektu',
                'projekt.nazev as nazev', 
                'projekt.url as url',
                DB::raw('(SELECT SUM(minut) FROM vykaz WHERE id_tydne=tydenni_v.id_tydne AND id_osoby=tydenni_v.id_osoby AND id_projektu=tydenni_v.id_projektu) as odpracovano'), 
                'tydenni_v.souhrn as souhrn',
                'tydenni_v.plan as plan', 
                'tydenni_v.problemy as problemy',
                'tydenni_v.omluvy as omluvy', 
                DB::raw('DATE_FORMAT(tyden.pondeli,"%d.%m.%Y") as pondeli'),
                DB::raw('DATE_FORMAT(tyden.nedele,"%d.%m.%Y") as nedele'),
                'tydenni_v.id_tydne as id_tydne', 
                'tydenni_v.id_vykazu as id_vykazu'
            )
            ->leftJoin('projekt', 'tydenni_v.id_projektu', '=', 'projekt.id')
            ->join('tyden', 'tydenni_v.id_tydne', '=', 'tyden.id')
            ->where('tydenni_v.id_osoby', '=', $data['id'])
            ->orderByDesc('tyden.id')
            ->get();

            // dd($vykazyT);
        }
        return view('pracovne_vykazy_osoby', compact('data', 'vykazyT'));
    }
}