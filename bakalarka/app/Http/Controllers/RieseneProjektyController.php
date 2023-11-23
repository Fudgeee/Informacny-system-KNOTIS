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

class RieseneProjektyController extends Controller
{
    public function rieseneProjekty(Request $request){
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
        }
    
        return view('riesene_projekty', compact('data', 'projekty'));
    }
    

}