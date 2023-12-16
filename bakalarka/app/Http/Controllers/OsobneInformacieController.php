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

class OsobneInformacieController extends Controller
{
    public function osobneInformacie(){
        $data = array();
        $dpp_udaje = array();
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
            $dppUdaje = DB::table('dpp_udaje')->where('id_osoby','=',Session::get('loginId'))->first();
            return view('osobne_informacie', compact('data', 'dppUdaje'));
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }

    public function updateDppInfo(Request $request){
        if(Session::has('loginId')){
            $validator = Validator::make($request->all(), [
                'jmeno'=>'required',
                'prijmeni'=>'required',
                'misto_narozeni'=>'required',
                'datum_narozeni'=>'required',
                'rodne_cislo'=>'required',
                'cislo_popisne'=>'required',
                'mesto'=>'required',
                'psc'=>'required',
                'bankovni_ucet'=>'required',
            ]);
            if ($validator->fails()){
                return back()->with('fail2',__('Prosím vyplňte všechna povinná pole'));
            }
            else{
                $osoba= DB::table('dpp_udaje')->where('id_osoby','=',Session::get('loginId'))->update([
                    'titul_pred' => $request->titul_pred,
                    'titul_za' => $request->titul_za,
                    'jmeno' => $request->jmeno,
                    'prijmeni' => $request->prijmeni,             
                    'rodne_prijmeni' => (!is_null($request->rodne_prijmeni) ? $request->rodne_prijmeni : ""),
                    'misto_narozeni' => $request->misto_narozeni,
                    'datum_narozeni' => $request->datum_narozeni,
                    'rodne_cislo' => $request->rodne_cislo,
                    'cislo_op' => (!is_null($request->cislo_op) ? $request->cislo_op : ""),
                    'cdb_id' => (!is_null($request->cdb_id) ? $request->cdb_id : ""),
                    'statni_prislusnost' => (!is_null($request->statni_prislusnost) ? $request->statni_prislusnost : ""),
                    'rodinny_stav' => $request->upravDppRodinnyStav,
                    'ulice' => (!is_null($request->ulice) ? $request->ulice : ""),
                    'cislo_popisne' => $request->cislo_popisne,
                    'mesto' => $request->mesto,
                    'psc' => $request->psc,
                    'zdravotni_pojistovna' => (!is_null($request->zdravotni_pojistovna) ? $request->zdravotni_pojistovna : ""),
                    'cislo_pasu' => (!is_null($request->cislo_pasu) ? $request->cislo_pasu : ""),
                    'dic' => $request->dic,
                    'bankovni_ucet' => $request->bankovni_ucet
                ]);
                return back()->with('success2',__('Údaje byly úspěšně změněny'));
            }
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }
}
