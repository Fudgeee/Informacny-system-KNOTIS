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

class RieseneProjektyTmp2Controller extends Controller
{
    public function rieseneProjektyTmp2(Request $request){
        $data = array();
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
            $query = DB::table('projekt')
                ->join('resi', 'projekt.id', '=', 'resi.id_projektu')
                ->where('resi.id_osoby', '=', $data['id']);
    
            // Triedenie
            $column = $request->input('column', 'id'); // Predvolený stĺpec triedenia je 'id'
            $order = $request->input('order', 'asc'); // Predvolené poradie triedenia je 'asc'
            $query->orderBy($column, $order);
    
            $projekty = $query->get();
    
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
    
            return view('riesene_projekty', compact('data', 'projekty', 'ciselnikVedoucich'));
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }
}