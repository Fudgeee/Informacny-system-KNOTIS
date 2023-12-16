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

class MojeVykazyController extends Controller     // TODO kliknutim na moje vykazy pre dany projekt v riesenych projektoch treba zmenit a href aby som ziskal request s ID projektu
{
    public function mojeVykazy($id_projektu){
        $data = array();
    
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
            $projekt = DB::table('projekt')
            ->select(
                'projekt.id as id',
                'projekt.typ as typ',
                'projekt.kod as kod',
                'projekt.stav as stav',
                'projekt.nazev as nazev',
                'projekt.zkratka as zkratka',
                'projekt.url as url',
                DB::raw('DATE_FORMAT(projekt.zadan,"%d.%m.%Y %H:%i") as zadan'),
                'projekt.vedouci as vedouci',
                'projekt.poznamka as poznamka',
                'projekt.adr_dle_zkratky as adr_dle_zkratky',
                'projekt.url_dle_zkratky as url_dle_zkratky'
            )
            ->join('resi', 'projekt.id', '=', 'resi.id_projektu')
            ->where('projekt.id', $id_projektu)
            ->where('id_osoby', $data['id'])
            ->first();
            $skupina = DB::table('skupina_proj')
            ->select('nazev')
            ->leftJoin('projekt_skupina', 'skupina_proj.id', '=', 'projekt_skupina.id_skupina')
            ->where('projekt_skupina.id_projekt', $id_projektu)
            ->first();
    
            $vykazyT = DB::table('tydenni_v')
            ->select(
                'tyden.cislo as cislo_tydne', 
                'tydenni_v.id_osoby as id_osoby', 
                'tydenni_v.id_projektu as id_projektu',
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
            ->where('tydenni_v.id_projektu', '=', $id_projektu)
            ->where('tydenni_v.id_osoby', '=', $data['id'])
            ->orderBy('tyden.id', 'DESC')
            ->paginate(10);

            //dd($vykazyT);
            return view('moje_vykazy', compact('data', 'projekt', 'skupina', 'vykazyT'));
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }
}