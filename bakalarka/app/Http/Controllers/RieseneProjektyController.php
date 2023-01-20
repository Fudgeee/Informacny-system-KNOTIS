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
    public function rieseneProjekty(){
        $data = array();
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
        }
        return view('riesene_projekty', compact('data'));
    }
}