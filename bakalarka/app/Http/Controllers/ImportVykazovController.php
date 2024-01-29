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
use Illuminate\Support\Facades\Mail;
use App\Mail\VykazImported;

class ImportVykazovController extends Controller
{
    public function importVykazov(){
        $data = array();
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
            $osoby = DB::table('osoba')
                ->select(DB::raw("CONCAT(
                    IFNULL(jmeno, ''), ' ', 
                    IFNULL(prijmeni, ''), ', ', 
                    IFNULL(titul_pred, ''), ' ', 
                    IFNULL(titul_za, ''), ' (', 
                    IFNULL(login, ''), ')') AS cele_meno"))
                ->get();

            foreach ($osoby as $osoba) {
                $celeMeno = $osoba->cele_meno;
            }
            // dd($osoby);
            return view('import_vykazov', compact('data', 'osoby'));
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }

    public function uploadAndSendEmail(Request $request){
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
            $request->validate([
                'file' => 'required',
                'osoba' => 'required',
                'login' => 'required'
            ]);

            $file = $request->file('file');
            $osoba = $request->input('osoba');
            $login = $request->input('login');

            // Odoslanie emailu s prílohou
            Mail::to($data->gmail)->send(new VykazImported($file, $osoba, $login));

            // Odpoveď alebo presmerovanie
            return back()->with('success', 'Súbor odoslaný úspešne!');
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }

}
