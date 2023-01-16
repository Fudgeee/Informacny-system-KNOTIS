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

class KontaktneUdajeController extends Controller
{
    public function kontaktneUdaje(){
        $data = array();
        $kontakt_data = array();
        if(Session::has('loginId')){
            $kontakt_data = DB::table('kontakt')->where('id_osoby','=',Session::get('loginId'))->first();
            $data= Osoba::where('id','=',Session::get('loginId'))->first();
        }
        return view('kontaktne_udaje', compact('data', 'kontakt_data'));
    }

    public function updateKontaktneInfo(Request $request){
        $validator = Validator::make($request->all(), [
             'telefon'=>'required',
             'mail'=>'required'
        ]);
        if ($validator->fails()){
            return back()->with('fail1',__('Prosím vyplňte všechna povinná pole'));
        }
        else{
            //dd($request);
            // $data= DB::table('osoba')->where('id','=',Session::get('loginId'))->update([
            //     'telefon' => $request->telefon,
            //     'gmail' => $request->mail,
            // ]);
            $kontakt_data = DB::table('kontakt')->where('id_osoby','=',Session::get('loginId'))->update([
                'typ' => $request->typ,
                'hodnota' => $request->hodnota,
                'popis' => (!is_null($request->popis) ? $request->popis : "")
            ]);
            return back()->with('success1',__('Kontaktní údaje byly změněny'));
        }
    }
}
