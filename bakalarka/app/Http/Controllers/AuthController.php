<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Osoba;
use Hash;
use Session;
use DB;

class AuthController extends Controller
{
    public function login(){
        return view("login");
    }
    public function loginUser(Request $request){
        $request->validate([
            'name'=>'required',
            'password'=>'required'
        ]);
        $osoba = Osoba::where('login','=',$request->name)->first();
        if($osoba){
            if ($osoba->aktivni_do != null || $osoba->aktivni_do != ''){
                $datumAktivniDo = new \DateTime($osoba->aktivni_do);
            }
            else{
                $datumAktivniDo = null;
            }
            $aktualniDatumCas = new \DateTime();
            if (($datumAktivniDo != '' || $datumAktivniDo != null) && ($datumAktivniDo < $aktualniDatumCas)) {
                return back()->with('fail',__('Váš účet není aktivní. Kontaktujte administrátora systému.'));
            }

            if(($osoba->heslo == NULL) || ($osoba->heslo == md5($request->password))){
                $request->session()->put('loginId',$osoba->id);
                
                return redirect('change_password')->with('fail',__('Je nutná změna hesla!'));
            }
            elseif(Hash::check($request->password,$osoba->heslo)){
                $request->session()->put('loginId',$osoba->id);

                // Po prihlásení získať a použiť uloženú URL
                $preLoginUrl = session('preLoginUrl', 'dashboard');
                if ($preLoginUrl == '' || strpos($preLoginUrl, '/login') !== false) {
                    return redirect('/index2');
                }
                else {
                    return redirect($preLoginUrl);
                }
            }
            else{
                return back()->with('fail',__('Nespravné Heslo'));
            }
        }
        else{
            return back()->with('fail',__('Uživatel s tímto jménem neexistuje'));
        }
    }
    
    public function dashboard(){
        $data = array();
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
        return view('dashboard', compact('data'));
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }

    public function index2(){
        $data = array();
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
            $dotaz = DB::table(DB::raw("(SELECT osoba.id FROM osoba
                                    LEFT JOIN resi ON osoba.id=resi.id_osoby
                                    LEFT JOIN projekt ON resi.id_projektu=projekt.id
                                    WHERE 1 AND resi.pristup_do IS NULL
                                      AND '".$data['id']."' IN (
                                          SELECT id
                                          FROM osoba as vedouciOs
                                          WHERE ( ( aktivni_od <= NOW() )
                                              AND ( ( aktivni_do IS NULL )
                                              OR ( aktivni_do >= NOW() ) ) )
                                      AND id IN (
                                          SELECT DISTINCT vedouci
                                          FROM projekt
                                          JOIN resi ON projekt.id=resi.id_projektu
                                          WHERE resi.aktivita > '0'
                                              AND resi.id_osoby=osoba.id))
                                              AND osoba.aktivita='1'
                                          GROUP BY osoba.id) AS osoby"))
            ->selectRaw('COUNT(*) AS pocet')
            ->first();
            $osoby_k_deaktivaci = $dotaz->pocet;                          

        return view('index2', compact('data', 'osoby_k_deaktivaci'));
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }

    public function changePassword(){
        $data = array();
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
        return view('change_password', compact('data'));
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }

    public function updatePassword(Request $request){
        if(Session::has('loginId')){
            $request->validate([
                'old_password'=>'required',
                'new_password'=>'required|confirmed|min:5|max:30'
            ]);
            $osoba= Osoba::where('id','=',Session::get('loginId'))->first();

            if (Hash::check($request->old_password,$osoba->heslo) || ($osoba->heslo == md5($request->old_password))){
                Osoba::where('id','=',Session::get('loginId'))->update([
                    'heslo' => Hash::make($request->new_password)
                ]);
                return back()->with('success',__('Heslo bylo změněno'));
            }
            else{
                return back()->with('fail',__('Aktuální heslo se neshoduje'));
            }
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }

    public function logout(){
        if(Session::has('loginId')){
            Session::pull('loginId');
            return redirect('login');
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }
}
