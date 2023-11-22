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

            $vykazy = DB::table('tydenni_v')
            ->select(
                'tyden.cislo as cislo_tydne',
                'tydenni_v.id_osoby as id_osoby',
                'tydenni_v.id_projektu as id_projektu',
                'projekt.nazev as nazev',
                'projekt.url as url',
                DB::raw('(SELECT Sum(minut) FROM vykaz WHERE id_tydne=tydenni_v.id_tydne AND id_osoby=tydenni_v.id_osoby AND id_projektu=tydenni_v.id_projektu) as odpracovano'),
                DB::raw('NULL as operace'),
                'tydenni_v.souhrn as souhrn',
                'tydenni_v.plan as plan',
                'tydenni_v.problemy as problemy',
                'tydenni_v.omluvy as omluvy',
                DB::raw('DATE_FORMAT(tyden.pondeli,"%d.%m.%Y") as pondeli'),
                DB::raw('DATE_FORMAT(tyden.nedele,"%d.%m.%Y") as nedele'),
                'tydenni_v.id_tydne as id_tydne',
                'tydenni_v.id_vykazu as id_vykazu',
                'vykaz.id_tydne as id_tydne_vykaz',
                'vykaz.id_osoby as id_osoby_vykaz',
                'vykaz.id_projektu as id_projektu_vykaz',
                'vykaz.minut as minut',
                DB::raw('TIME_FORMAT(vykaz.cas_od,"%H:%i") as cas_od'),
                DB::raw('TIME_FORMAT(vykaz.cas_do,"%H:%i") as cas_do'),
                'vykaz.cinnost as cinnost',
                'vykaz.nesouvisi_sp as nesouvisi_sp',
                'vykaz.id_vykazu as id_vykazu_vykaz',
                DB::raw('DATE_FORMAT(vykaz.datum,"%d.%m.%Y") as datum')
            )
            ->leftJoin('projekt', 'tydenni_v.id_projektu', '=', 'projekt.id')
            ->leftJoin('vykaz', function ($join) {
                $join->on('tydenni_v.id_tydne', '=', 'vykaz.id_tydne')
                    ->on('tydenni_v.id_osoby', '=', 'vykaz.id_osoby')
                    ->on('tydenni_v.id_projektu', '=', 'vykaz.id_projektu');
            })
            ->join('tyden', 'tydenni_v.id_tydne', '=', 'tyden.id')
            ->where('tydenni_v.id_osoby', $data['id'])
            ->orderByDesc('tyden.id')
            ->paginate(10);


            // dd($vykazy);
        //     $vykazy = DB::table('tyddeni_v')
        //             ->join('vykaz', 'projekt.id', '=', 'resi.id_projektu')
        //             ->where('resi.id_osoby', '=', $data['id'])
        //             ->get();
        // //dd($projekty);        
        //     for ($i=0; $i<count($projekty); $i++){
        //         $projektNazov[$i] = $projekty[$i]->id . '. ' . $projekty[$i]->nazev;
        //     }
        }
        return view('pracovne_vykazy_osoby', compact('data', 'vykazy'));
    }
}