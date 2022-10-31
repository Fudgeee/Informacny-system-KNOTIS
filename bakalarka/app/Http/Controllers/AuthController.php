<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Osoba;
use Hash;
use Session;

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
            if(Hash::check($request->password,$osoba->heslo)){ //|| Osoba::where('heslo','=',md5($request->password))){
                $request->session()->put('loginId',$osoba->id);
                if($osoba->zmena_hesla == 0){
                    return redirect('change_password');
                }
                else{
                    return redirect('dashboard');
                }
            }
            else{
                return back()->with('fail','nespravne heslo');
            }
        }
        else{
            return back()->with('fail','uzivatel neexistuje');
        }
    }
    
    public function dashboard(){
        $data = array();
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
        }
        return view('dashboard', compact('data'));
    }

    public function changePassword(){
        $data = array();
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
        }
        return view('change_password', compact('data'));
    }

    public function updatePassword(Request $request){
        $request->validate([
            'old_password'=>'required',
            'new_password'=>'required|confirmed|min:5|max:30'
        ]);
        $osoba= Osoba::where('id','=',Session::get('loginId'))->first();
        if (Hash::check($request->old_password,$osoba->heslo)){
            Osoba::where('id','=',Session::get('loginId'))->update([
                'heslo' => Hash::make($request->new_password),//hash('sha256',$request->new_password),
                'zmena_hesla' => '1'
            ]);
            return back()->with('success','Heslo bolo zmenene');
        }
        else{
            return back()->with('fail','Aktuálne heslo se nezhoduje');
        }
    }

    public function logout(){
        if(Session::has('loginId')){
            Session::pull('loginId');
            return redirect('login');
        }
    }
}
