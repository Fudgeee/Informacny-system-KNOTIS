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
    function key_compare_func($a, $b){
        if ($a === $b) {
            return 0;
        }
        return ($a > $b)? 1:-1;
    }

    public function kontaktneUdaje(){
        $data = array();
        $kontakt_data_mail = array();
        $kontakt_data_telefon = array();
        $kontakt_data_other = array();
        $kontakt_other = array();
        $kontaktTyp = array();
        $kontaktPopis = array();
        if(Session::has('loginId')){
            $osobaId = Session::get('loginId');
            $kontakt_data_mail = DB::table('kontakt')->where([
                ['id_osoby','=',$osobaId],
                ['typ','=','Mail']
            ])->get();
            $kontakt_data_telefon = DB::table('kontakt')->where([
                ['id_osoby','=',$osobaId],
                ['typ','=','Telefon']
            ])->get();
            $kontakt_data_other = DB::table('kontakt')->where([
                ['id_osoby','=',$osobaId],
                ['typ', '!=', 'Mail'],
                ['typ', '!=', 'Telefon']
            ])->get();
            $data= Osoba::where('id','=',$osobaId)->first();
            $kontakt_other = DB::table('kontakt')->where([
                ['typ', '!=', 'Mail'],
                ['typ', '!=', 'Telefon']
            ])->get();
            if (count(is_countable($kontakt_other) ? $kontakt_other : []) > 0){
                foreach($kontakt_other as $typ1 => $t1){
                    $kontaktTyp[$typ1] = $t1->typ;
                    $kontaktPopis[$typ1] = $t1->popis;
                }
            }
            return view('kontaktne_udaje', compact('data', 'kontakt_data_mail', 'kontakt_data_telefon', 'kontakt_data_other', 'kontaktTyp', 'kontaktPopis'));
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }

    public function updateKontaktneInfo(Request $request){
        if(Session::has('loginId')){
            $tmp = null;
            $kontaktId = array();
            $kontakt_id = array();
            $kontakt_hodnota = array();
            $kontakt_data = array();
            $kontakt_data_all = array();
            $osobaId = Session::get('loginId');
            $validator = Validator::make($request->all(), [
                'telefon'=>'required',
                'mail'=>'required'
            ]);
            if ($validator->fails()){
                return back()->with('fail1',__('Prosím vyplňte všechna povinná pole'));
            }
            else{
                $data = DB::table('osoba')->where('id','=',Session::get('loginId'))->update([
                    'telefon' => $request->telefon,
                    'gmail' => $request->mail,
                    'telefon_popis' => (!is_null($request->telefon_popis) ? $request->telefon_popis : ""),
                    'gmail_popis' => (!is_null($request->mail_popis) ? $request->mail_popis : "")
                ]);
                $kontakt_id = $request->id;
                $kontakt_hodnota = $request->hodnota;
                $kontakt_data_all = DB::table('kontakt')->where('id_osoby','=',Session::get('loginId'))->get('id')->toArray();
                if (count(is_countable($kontakt_data_all) ? $kontakt_data_all : []) > 0){
                    foreach($kontakt_data_all as $id1 => $kontakt1){
                        $kontaktId[$id1] = $kontakt1->id;
                    }
                } 
                if (count(is_countable($kontakt_hodnota) ? $kontakt_hodnota : []) > 0){
                    foreach($kontakt_hodnota as $id => $hodn){
                        $kontakt_data = [
                            'typ' => $request->typ[$id],
                            'hodnota' => $request->hodnota[$id],
                            'popis' => (!is_null($request->popis[$id]) ? $request->popis[$id] : "")
                        ];
                        if ($request->id[$id] == null || $request->id[$id] == ''){
                            DB::table('kontakt')->insert([
                                'id_osoby' => $osobaId,
                                'typ' => $request->typ[$id],
                                'hodnota' => $request->hodnota[$id],
                                'popis' => (!is_null($request->popis[$id]) ? $request->popis[$id] : "")
                            ]);
                        }
                        else{
                            DB::table('kontakt')->where([
                                ['id', '=', $request->id[$id]],
                                ['id_osoby', '=', $osobaId]
                            ])->update([
                                'typ' => $request->typ[$id],
                                'hodnota' => $request->hodnota[$id],
                                'popis' => (!is_null($request->popis[$id]) ? $request->popis[$id] : "")
                            ]);
                        }
                    }
                }
                if ($kontakt_hodnota == null || $kontakt_hodnota == ''){
                    DB::table('kontakt')->where('id_osoby', '=', $osobaId)->delete();
                    
                }
                else{
                    if ($kontaktId != null){
                        $tmp = array_diff($kontaktId, $kontakt_id);
                        DB::table('kontakt')->where('id_osoby', '=', $osobaId)->whereIn('id', $tmp)->delete();
                    }
                }
                
                return back()->with('success1',__('Kontaktní údaje byly změněny'));      
            }
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }
}
