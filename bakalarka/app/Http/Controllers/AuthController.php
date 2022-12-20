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
            if(($osoba->heslo == NULL) || ($osoba->heslo == md5($request->password))){
                $request->session()->put('loginId',$osoba->id);
                
                return redirect('change_password')->with('fail',__('Je nutná změna hesla!'));
            }
            elseif(Hash::check($request->password,$osoba->heslo)){
                $request->session()->put('loginId',$osoba->id);
                return redirect('dashboard');
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
                'heslo' => Hash::make($request->new_password)
            ]);
            return back()->with('success',__('Heslo bylo změněno'));
        }
        else{
            return back()->with('fail',__('Aktuální heslo se neshoduje'));
        }
    }

    public function logout(){
        if(Session::has('loginId')){
            Session::pull('loginId');
            return redirect('login');
        }
    }
}
