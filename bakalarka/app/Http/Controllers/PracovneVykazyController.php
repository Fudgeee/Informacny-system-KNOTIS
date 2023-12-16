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
{   // IF je platna session.... pridat ELSE a hodit ma dopice
    public function pracovneVykazy(Request $request){

        $vybranyProjekt = (!is_null($request->query('vybranyProjekt')) ? $request->query('vybranyProjekt') : '');
        $vybranyTyzden = (!is_null($request->query('vybranyTyzden')) ? $request->query('vybranyTyzden') : '');
        $vybranyDennyVykaz = (!is_null($request->query('vybranyDennyVykaz')) ? $request->query('vybranyDennyVykaz') : '');


        $data = array();
        $tmp = array();
        $vybranyProjektNazov = '';
        $vybranyTyzdenNazov = '';
        $zvolenyDennyVykaz = '';
        $tyzdenny_vykaz_db = array();
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
                
                if (($vybranyProjekt != null || $vybranyProjekt != '') && ($vybranyTyzden != null || $vybranyTyzden != '')) {
                    $tmp = DB::table('tydenni_v')->where([
                        ['id_osoby','=',Session::get('loginId')],
                        ['id_tydne','=',$vybranyTyzden],
                        ['id_projektu','=',$vybranyProjekt]
                    ])->get();
        
                    if (count($tmp) > 0) {
                        $tyzdenny_vykaz_db = $tmp[0];
                    }
        
                    $denny_vykaz = DB::table('vykaz')->where([
                        ['id_osoby','=',Session::get('loginId')],
                        ['id_tydne','=',$vybranyTyzden],
                        ['id_projektu','=',$vybranyProjekt]
                    ])
                    ->orderByDesc('id_vykazu')
                    ->get();
                }
                elseif (($vybranyProjekt != null || $vybranyProjekt != '') && ($vybranyTyzden == null )) {
                    $tmp = DB::table('tydenni_v')->where([
                        ['id_osoby','=',Session::get('loginId')],
                        ['id_tydne','=',$aktualnyTyzden + 1],
                        ['id_projektu','=',$vybranyProjekt]
                    ])->get();
        
                    if (count($tmp) > 0) {
                        $tyzdenny_vykaz_db = $tmp[0];
                    }
        
                    $denny_vykaz = DB::table('vykaz')->where([
                        ['id_osoby','=',Session::get('loginId')],
                        ['id_tydne','=',$aktualnyTyzden + 1],
                        ['id_projektu','=',$vybranyProjekt]
                    ])
                    ->orderByDesc('id_vykazu')
                    ->get();
                }
                elseif (($vybranyProjekt == null) && ($vybranyTyzden != null || $vybranyTyzden != '' )) {
                    $tmp = DB::table('tydenni_v')->where([
                        ['id_osoby','=',Session::get('loginId')],
                        ['id_tydne','=',$vybranyTyzden],
                        ['id_projektu','=',$projekty[0]->id]
                    ])->get();
        
                    if (count($tmp) > 0) {
                        $tyzdenny_vykaz_db = $tmp[0];
                    }
        
                    $denny_vykaz = DB::table('vykaz')->where([
                        ['id_osoby','=',Session::get('loginId')],
                        ['id_tydne','=',$vybranyTyzden],
                        ['id_projektu','=',$projekty[0]->id]
                    ])
                    ->orderByDesc('id_vykazu')
                    ->get();
                }
                else {
                    $tmp = DB::table('tydenni_v')->where([
                        ['id_osoby','=',Session::get('loginId')],
                        ['id_tydne','=',$aktualnyTyzden + 1],
                        ['id_projektu','=',$projekty[0]->id]   
                    ])->get();
                    
                    if (count($tmp) > 0) {
                        $tyzdenny_vykaz_db = $tmp[0];
                    }
                    
                    $denny_vykaz = DB::table('vykaz')->where([
                        ['id_osoby','=',Session::get('loginId')],
                        ['id_tydne','=',$aktualnyTyzden + 1],
                        ['id_projektu','=',$projekty[0]->id]
                    ])
                    ->orderByDesc('id_vykazu')
                    ->get();
                }
                foreach ($projekty as $projekt) {
                    if ($projekt->id == $vybranyProjekt) {
                        $vybranyProjektNazov = $projekt->id . '. ' . $projekt->nazev;
                        break;
                    }
                }
                foreach ($tyzdne as $i => $tyzden1) {
                    if ($vybranyTyzden == $i + 1) {
                        $vybranyTyzdenNazov = $tyzden1;
                        break;
                    }
                }
                foreach ($denny_vykaz as $den1) {
                    if ($vybranyDennyVykaz == $den1->id_vykazu) {
                        $zvolenyDennyVykaz = $den1;
                        break;
                    }
                }
            return view('pracovne_vykazy', compact('data', 'projekty', 'projektNazov', 'tyzdne', 'aktualnyTyzden', 'tyzdenny_vykaz_db', 'denny_vykaz', 'vybranyTyzdenNazov', 'vybranyProjektNazov', 'zvolenyDennyVykaz'));
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }

    public function updatePracovneVykazyProjekt(Request $request){
        $vybranyProjekt = $request->input('vybranyProjekt');
        $casti = explode('.', $vybranyProjekt);
        $id_vybraneho_projektu = $casti[0];      
        //dd($castPredZnakom);
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
            $tyzdenny_vykaz_db = DB::table('projekt')
                    ->where('.id_osoby', '=', $data['id'])
                    ->where('id', '=', $id_vybraneho_projektu)
                    ->first();
            //dd($tyzdenny_vykaz_db); // LAST TODO
            return view('pracovne_vykazy', compact('tyzdenny_vykaz_db', 'data'));
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }

    public function updatePracovneVykazyTyzden(Request $request){
        dd($request);
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
        return view('pracovne_vykazy', compact('aktualnyTyzden', 'tyzdne', 'data'));
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }
    public function updatePracovneVykazyDenny(Request $request){
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
            $projekt_id = array();
            $castiP = null;
            $pocetMinut = null;

            $validator = Validator::make($request->all(), [
                'datumVykazu'=>'required',
                'upravHodin'=>'required',
                'upravMin'=>'required',
                'upravCinnost'=> 'required'
            ]);
            if ($validator->fails()) {
                return back()->with('fail1',__('Prosím vyplňte všechna povinná pole'));
            }
            else {
                $castiP = explode('.', $request->vybranyProjekt);
                $projekt_id = $castiP[0];

                $pocetMinut = ((($request->upravHodin)*60) + $request->upravMin);

                $upravNesouvisiSP = $request->has('upravNesouvisiSP');
                
                if ($request->vykazId == null || $request->vykazId == ''){
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
                else {
                    DB::table('vykaz')->where([
                        ['id_vykazu', '=', $request->vykazId],
                        ['id_osoby', '=', $data['id']]
                    ])->update([
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
            }    
            return back()->with('success1',__('Denní výkaz byl úspěšně uložen'));      
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }

    public function updatePracovneVykazyTyzdenny(Request $request){  
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
            $projekt_id = array();
            $tyzden_id1 = array();
            $castiPT = null;
            $castiTV = null;
            $control = null;

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

                $control = DB::table('tydenni_v')->where([
                    ['id_osoby','=',Session::get('loginId')],
                    ['id_tydne','=',$request->idTyzdna1],
                    ['id_projektu','=',$projekt_id1]
                ])->get();
                
                if (count(is_countable($control) ? $control : []) == 0){
                    DB::table('tydenni_v')->insert([
                        'id_osoby' => $data['id'],
                        'id_tydne' => $request->idTyzdna1,
                        'id_projektu' => $projekt_id1,
                        'souhrn' => $request->upravSouhrn,
                        'plan' => $request->upravPlan,
                        'problemy' => (!is_null($request->upravProblemy) ? $request->upravProblemy : ""),
                        'omluvy' => (!is_null($request->upravOmluvy) ? $request->upravOmluvy : ""),
                        'odeslano' => $upravTVykaz, // QUESTION - 1 ak odoslem aj T-Vykaz bez hodin??
                        'problemy_odeslany' => $odesliProblemy // QUESTION - iba ak odoslem iba problemy, alebo aj ked poslem T-V bez problemov??
                    ]);
                }
                else{
                    DB::table('tydenni_v')->where([
                        ['id_osoby','=',Session::get('loginId')],
                        ['id_tydne','=',$request->idTyzdna1],
                        ['id_projektu','=',$projekt_id1]
                    ])->update([
                        'souhrn' => $request->upravSouhrn,
                        'plan' => $request->upravPlan,
                        'problemy' => (!is_null($request->upravProblemy) ? $request->upravProblemy : ""),
                        'omluvy' => (!is_null($request->upravOmluvy) ? $request->upravOmluvy : ""),
                        'odeslano' => $upravTVykaz, // QUESTION - 1 ak odoslem aj T-Vykaz bez hodin??
                        'problemy_odeslany' => $odesliProblemy // QUESTION - iba ak odoslem iba problemy, alebo aj ked poslem T-V bez problemov??
                    ]);
                } 
            }    
            return back()->with('success2',__('Změny v týdenním výkazu byly úspěšně uloženy'));      
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }

    public function deleteVykaz(Request $request){
        if(Session::has('loginId')){
            $tmp = DB::table('vykaz')->where([
                ['id_osoby','=',Session::get('loginId')],
                ['id_vykazu','=',$request->id]
            ])->delete();
            return back()->with('success4',__('Pracovní výkaz byl úspěšně vymazán'));      
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }


    public function updatePracovneVykazyTyzdennySHodinami(Request $request){
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
            // $projekt_id = array();
            // $castiP = null;
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

             // TODO KONTROLA ULOZENIA JEDNEHO VYKAZU VIACKRAT  
        }
        // else {
        //     session(['preLoginUrl' => url()->previous()]);
        //     return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        // }
    }
}