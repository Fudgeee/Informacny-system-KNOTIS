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


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function Help(){
        $data = array();
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
        }
        return view('help', compact('data'));
    }

    public function kontaktneUdaje(){
        $data = array();
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
        }
        return view('kontaktne_udaje', compact('data'));
    }

    public function osobneInformacie(){
        $data = array();
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
        }
        return view('osobne_informacie', compact('data'));
    }

    public function Konfiguracia(){
        $data = array();
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
        }
        return view('konfiguracia', compact('data'));
    }

    public function updatePersonalInfo(Request $request){
        $validator = Validator::make($request->all(), [
            'zpozdeni_vykazu'=>'required|max:2'   
        ]);
        if ($validator->fails()){
            return back()->with('fail',__('Nastala chyba ve změně osobních údajů'));
        }
        else{
            $osoba= Osoba::where('id','=',Session::get('loginId'))->update([
                'zpozdeni_vykazu' => $request->zpozdeni_vykazu
            ]);
            return back()->with('success',__('Osobní údaje byly změněny'));
        }
    }
    
    public function updateKontaktneInfo(Request $request){
        $validator = Validator::make($request->all(), [
            'jmeno'=>'required',
            'prijmeni'=>'required',
            'telefon'=>'required',
            'gmail'=>'required'
        ]);
        if ($validator->fails()){
            return back()->with('fail1',__('Prosím vyplňte všechna povinná pole'));
        }
        else{
            $osoba= Osoba::where('id','=',Session::get('loginId'))->update([
                'jmeno' => $request->jmeno,
                'prijmeni' => $request->prijmeni,
                'telefon' => $request->telefon,
                'gmail' => $request->gmail,
                'facebook' => $request->facebook,
                'discord' => $request->discord,
                'skype' => $request->skype,
                'icq' => $request->icq,
                'jabber' => $request->jabber
            ]);
            return back()->with('success1',__('Kontaktní údaje byly změněny'));
        }
    }

    public function updateDppInfo(Request $request){
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
                'rodne_prijmeni' => $request->rodne_prijmeni,
                'misto_narozeni' => $request->misto_narozeni,
                'datum_narozeni' => $request->datum_narozeni,
                'rodne_cislo' => $request->rodne_cislo,
                'cislo_op' => $request->cislo_op,
                'cdb_id' => $request->cdb_id,
                'statni_prislusnost' => $request->statni_prislusnost,
                'rodinny_stav' => $request->rodinny_stav,
                'ulice' => $request->ulice,
                'cislo_popisne' => $request->cislo_popisne,
                'mesto' => $request->mesto,
                'psc' => $request->psc,
                'zdravotni_pojistovna' => $request->zdravotni_pojistovna,
                'cislo_pasu' => $request->cislo_pasu,
                'dic' => $request->dic,
                'bankovni_ucet' => $request->bankovni_ucet
            ]);
            return back()->with('success2',__('Údaje byly úspěšně změněny'));
        }
    }

    public function updateKonfiguracia(Request $request){
        $validator = Validator::make($request->all(), [
            'zpozdeni_vykazu'=>'required',
            'zasilat_kopie'=>'required',
            'str_po_prihlaseni'=>'required',
            'vychozi_ulozeni_sezeni'=>'required',
            'hlidani_wiki_ukolu' =>'required'
        ]);
        if ($validator->fails()){
            return back()->with('fail',__('Prosím vyplňte všechna povinná pole'));
        }
        else{
            $osoba= Osoba::where('id','=',Session::get('loginId'))->update([
                'zpozdeni_vykazu' => $request->zpozdeni_vykazu,
                'zasilat_kopie' => $request->zasilat_kopie,
                'str_po_prihlaseni' => $request->str_po_prihlaseni,
                'vychozi_ulozeni_sezeni' => $request->vychozi_ulozeni_sezeni,
                'hlidani_wiki_ukolu' => $request->hlidani_wiki_ukolu,
            ]);
            return back()->with('success',__('Konfigurace byla úspěšně změněna'));
        }
    }
}
