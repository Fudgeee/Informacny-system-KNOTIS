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

class PracovneVykazyController extends Controller
{
    public function pracovneVykazy(){
        $data = array();
        $projektNazov = array();
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
                $projekty = DB::table('projekt')
                ->select('projekt.id as id', 'projekt.typ as typ', 'projekt.nazev as nazev', 'projekt.vedouci as vedouci', 'resi.aktivita as aktivita', 'projekt.url as url', 'projekt.zkratka as zkratka', 'prostredek.cesta as adr_proj', DB::raw('DATE_FORMAT(resi.posledni_zm_adr,"%d.%m.%Y %H:%i") as posledni_zm_adr'))
                ->join('resi', 'projekt.id', '=', 'resi.id_projektu')
                ->leftJoin('prostr_proj', 'projekt.id', '=', 'prostr_proj.id_projektu')
                ->leftJoin('prostredek', 'prostredek.id', '=', 'prostr_proj.id_prostredku')
                ->where(function($query) {
                    $query->whereNull('prostr_proj.typ_vyuziti')
                          ->orWhere('prostr_proj.typ_vyuziti', '=', '1');
                })
                ->where('resi.id_osoby', '=', $data['id'])
                ->get();

                for ($i=0; $i<count($projekty); $i++){
                    $projektNazov[$i] = $projekty[$i]->id . '. ' . $projekty[$i]->nazev;
                }
                $tyzden = DB::table('tyden')
                    ->select('id', 'cislo', 
                        DB::raw('DATE_FORMAT(tyden.pondeli, "%d.%m.%Y") as pondeli'),
                        DB::raw('DATE_FORMAT(tyden.nedele, "%d.%m.%Y") as nedele'),
                        'tyden.pondeli as pondeli_pd',
                        'tyden.nedele as nedele_pd'
                    )->get();
                for ($j=0; $j<count($tyzden); $j++){
                    $tyzdne[$j] = $tyzden[$j]->cislo . '. (' . $tyzden[$j]->pondeli . ' - ' . $tyzden[$j]->nedele . ')'; 
                }
                $aktualnyTyzden = DB::table('tyden')
                ->selectRaw('id - 1 as id')
                ->where('pondeli', '<=', DB::raw('NOW()'))
                ->where('nedele', '>=', DB::raw('NOW()'))
                ->value('id');
        }
        return view('pracovne_vykazy', compact('data', 'projekty', 'projektNazov', 'tyzdne', 'aktualnyTyzden'));
    }

    public function updatePracovneVykazyProjekt(Request $request){
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
            $projektNazov = array();
            $projekty = DB::table('projekt')
                    ->select('projekt.id as id', 'projekt.typ as typ', 'projekt.nazev as nazev', 'projekt.vedouci as vedouci', 'resi.aktivita as aktivita', 'projekt.url as url', 'projekt.zkratka as zkratka', 'prostredek.cesta as adr_proj', DB::raw('DATE_FORMAT(resi.posledni_zm_adr,"%d.%m.%Y %H:%i") as posledni_zm_adr'))
                    ->join('resi', 'projekt.id', '=', 'resi.id_projektu')
                    ->leftJoin('prostr_proj', 'projekt.id', '=', 'prostr_proj.id_projektu')
                    ->leftJoin('prostredek', 'prostredek.id', '=', 'prostr_proj.id_prostredku')
                    ->where(function($query) {
                        $query->whereNull('prostr_proj.typ_vyuziti')
                            ->orWhere('prostr_proj.typ_vyuziti', '=', '1');
                    })
                    ->where('resi.id_osoby', '=', $data['id'])
                    ->get();

            for ($i=0; $i<count($projekty); $i++){
                $projektNazov[$i] = $projekty[$i]->id . '. ' . $projekty[$i]->nazev;
            }
        }
        return view('pracovne_vykazy', compact('projekty', 'projektNazov', 'data'));
    }

    public function updatePracovneVykazyTyzden(Request $request){
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
            $tyzden = DB::table('tyden')
                ->select('id', 'cislo', 
                    DB::raw('DATE_FORMAT(tyden.pondeli, "%d.%m.%Y") as pondeli'),
                    DB::raw('DATE_FORMAT(tyden.nedele, "%d.%m.%Y") as nedele'),
                    'tyden.pondeli as pondeli_pd',
                    'tyden.nedele as nedele_pd'
                )->get();
            for ($j=0; $j<count($tyzden); $j++){
                $tyzdne[$j] = $tyzden[$j]->cislo . '. (' . $tyzden[$j]->pondeli . ' - ' . $tyzden[$j]->nedele . ')'; 
            }
            $aktualnyTyzden = DB::table('tyden')
            ->selectRaw('id - 1 as id')
            ->where('pondeli', '<=', DB::raw('NOW()'))
            ->where('nedele', '>=', DB::raw('NOW()'))
            ->value('id');

            if ($request->has('nastavTydenTlacPredminuly')) {
                $aktualnyTyzden = $aktualnyTyzden - 2;
            }
            elseif ($request->has('nastavTydenTlacMinuly')) {
                $aktualnyTyzden = $aktualnyTyzden - 1;
            }
        }
        return view('pracovne_vykazy', compact('aktualnyTyzden', 'tyzdne', 'data'));
    }
    public function updatePracovneVykazyDenny(Request $request){
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
            $projekt_id = array();
            $tyzden_id = array();
            $castiP = null;
            $castiT = null;
            $pocetMinut = null;

            $validator = Validator::make($request->all(), [
                'datumVykazu'=>'required',
                'upravHodin'=>'required',
                'upravMin'=>'required',
                'upravCinnost'=> 'required'
            ]);
            if ($validator->fails()){
                return back()->with('fail1',__('Prosím vyplňte všechna povinná pole'));
            }
            else{
                $castiP = explode('.', $request->vybranyProjekt);
                $projekt_id = $castiP[0];
                $castiT = explode('.', $request->vybranyTyzden);
                $tyzden_id = $castiT[0];

                $pocetMinut = ((($request->upravHodin)*60) + $request->upravMin);

                $upravNesouvisiSP = $request->has('upravNesouvisiSP');
                
                $dennyVykaz = DB::table('vykaz')->insert([
                    'id_osoby' => $data['id'],
                    'datum' => $request->datumVykazu,
                    'id_projektu' => $projekt_id,
                    'minut' => $pocetMinut,
                    'cas_od' => $request->casVykazuOd,
                    'cas_do' => $request->casVykazuDo,
                    'cinnost' => $request->upravCinnost,
                    'nesouvisi_sp' => $upravNesouvisiSP,
                    'id_tydne' => $request->idTyzdna
                ]);

            }    
            return back()->with('success1',__('Denní výkaz byl úspěšně uložen'));      
        }
    }

    public function updatePracovneVykazyTyzdenny(Request $request){  
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
            $projekt_id = array();
            $tyzden_id1 = array();
            $castiPT = null;
            $castiTV = null;

            $validator = Validator::make($request->all(), [
                'upravSouhrn'=>'required',
                'upravPlan'=>'required'
            ]);
            if ($validator->fails()){
                return back()->with('fail2',__('Prosím vyplňte všechna povinná pole'));
            }
            else{
                $castiPT = explode('.', $request->vybranyProjektText);
                $projekt_id1 = $castiPT[0];
                $castiTV = explode('.', $request->vybranyTyzdenText);
                $tyzden_id1 = $castiTV[0];

                $upravTVykaz = $request->has('upravTVykaz');
                $odesliProblemy = $request->has('odesliProblemy');

                $tyzdennyVykaz = DB::table('tydenni_v')->insert([
                    'id_osoby' => $data['id'],
                    'id_tydne' => $tyzden_id1,
                    'id_projektu' => $projekt_id1,
                    'souhrn' => $request->upravSouhrn,
                    'plan' => $request->upravPlan,
                    'problemy' => $request->upravProblemy,
                    'omluvy' => $request->upravOmluvy,
                    'odeslano' => $upravTVykaz,
                    'problemy_odeslany' => $odesliProblemy
                ]);

            // TODO KONTROLA ULOZENIA JEDNEHO VYKAZU VIACKRAT  

            }    
            return back()->with('success2',__('Změny v týdenním výkazu byly úspěšně uloženy'));      
        }
    }

    public function updatePracovneVykazyTyzdennySHodinami(Request $request){
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
            // $projekt_id = array();
            // $tyzden_id = array();
            // $castiP = null;
            // $castiT = null;
            // $pocetMinut = null;

            // $validator = Validator::make($request->all(), [
            //     'datumVykazu'=>'required',
            //     'upravHodin'=>'required',
            //     'upravMin'=>'required',
            //     'upravCinnost'=> 'required'
            // ]);
            // if ($validator->fails()){
            //     return back()->with('fail2',__('Prosím vyplňte všechna povinná pole'));
            // }
            // else{
            //     $castiP = explode('.', $request->vybranyProjekt);
            //     $projekt_id = $castiP[0];
            //     $castiT = explode('.', $request->vybranyTyzden);
            //     $tyzden_id = $castiT[0];

            //     $pocetMinut = ((($request->upravHodin)*60) + $request->upravMin);

            //     $upravNesouvisiSP = $request->has('upravNesouvisiSP');
                
            //     $dennyVykaz = DB::table('vykaz')->insert([
            //         'id_osoby' => $data['id'],
            //         'datum' => $request->datumVykazu,
            //         'id_projektu' => $projekt_id,
            //         'minut' => $pocetMinut,
            //         'cas_od' => $request->casVykazuOd,
            //         'cas_do' => $request->casVykazuDo,
            //         'cinnost' => $request->upravCinnost,
            //         'nesouvisi_sp' => $upravNesouvisiSP,
            //         'id_tydne' => $request->idTyzdna
            //     ]);

            // }    
            // return back()->with('success2',__('Změny v týdenním výkazu byly úspěšně uloženy'));      
        }
    }
}