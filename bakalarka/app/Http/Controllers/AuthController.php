<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
//use Hash;
use Session;

class AuthController extends Controller
{
    public function login(){
        return view("auth.login");
    }
    public function loginUser(Request $request){
        $request->validate([
            'name'=>'required',
            'password'=>'required|max:30'
        ]);
        $user =  User::where('name','=',$request->name)->first();
        if($user){
            if(/*Hash::check($request->heslo,$user->heslo)*/User::where('password','=',$request->password)->first()){
                $request->session()->put('loginId',$user->id);
                return redirect('dashboard');
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
            $data = User::where('id','=',Session::get('loginId'))->first();
        }
        return view('dashboard', compact('data'));
    }
    public function logout(){
        if(Session::has('loginId')){
            Session::pull('loginId');
            return redirect('login');
        }
    }
}
