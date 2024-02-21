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

class RieseneProjektyTmpController extends Controller
{
    public function rieseneProjektyTmp(Request $request){
        $data = array();
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
            $query = DB::table('projekt')
                ->join('resi', 'projekt.id', '=', 'resi.id_projektu')
                ->where('resi.id_osoby', '=', $data['id']);
    
            $projekty = $query->get();
    
            $projekty = $projekty->map(function ($projekt) {
                // Formátujeme datum a čas ve formátu "den.mesiac.rok hodiny:minuty"
                if ($projekt->resi_od != null || $projekt->resi_od != ''){
                    $projekt->resi_od = \Carbon\Carbon::parse($projekt->resi_od)->format('d.m.Y H:i');
                }
                else{
                    $projekt->resi_od = '';
                }
                if ($projekt->resi_do != null || $projekt->resi_do != ''){
                    $projekt->resi_do = \Carbon\Carbon::parse($projekt->resi_do)->format('d.m.Y H:i');
                }
                else{
                    $projekt->resi_do = '';
                }
                if ($projekt->zadan != null || $projekt->zadan != ''){
                    $projekt->zadan = \Carbon\Carbon::parse($projekt->zadan)->format('d.m.Y H:i');
                }
                else{
                    $projekt->zadan = '';
                }
                
                return $projekt;
            });

            for ($i=0; $i<count($projekty); $i++){
                $projektNazov[$i] = $projekty[$i]->id . '. ' . $projekty[$i]->nazev;
            }

            // ciselnik veducich
            $ciselnikVedoucich = Osoba::join('projekt', 'osoba.id', '=', 'projekt.vedouci')
            ->select('osoba.id', 'osoba.login')
            ->distinct()
            ->orderByRaw('osoba.typ IN (2,3,5) DESC, osoba.typ IN (5) DESC, osoba.prijmeni ASC, osoba.jmeno ASC')
            ->pluck('osoba.login', 'osoba.id')
            ->toArray();
    
            return view('riesene_projekty_tmp', compact('data', 'projekty', 'ciselnikVedoucich'));
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }
}