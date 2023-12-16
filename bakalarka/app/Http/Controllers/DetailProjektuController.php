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
class DetailProjektuController extends Controller
{
    public function detailProjektu($id_projektu){
        $data = array();
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
            $projekt = DB::table('projekt')->where('id', $id_projektu)->first();
            $veduci = DB::table('osoba')->select('id', 'login', 'jmeno', 'prijmeni', 'titul_pred', 'titul_za', 'email')
            ->where('id', $projekt->vedouci)
            ->first();
            $prostriedky = DB::table('prostr_proj')
            ->select('prostredek.id', 'nazev', 'cesta', 'vlastnik', 'server', 'prostr_proj.*')
            ->leftJoin('prostredek', 'prostr_proj.id_prostredku', '=', 'prostredek.id')
            ->where('prostr_proj.vyuzivan', '>', 0)
            ->where('prostredek.stav', '<', 1)
            ->where('prostr_proj.id_projektu', $id_projektu)
            ->get();
            $riesenie = DB::table('resi')
            ->select(
                'resi.id_osoby as id_osoby',
                'resi.id_projektu as id_projektu',
                DB::raw('DATE_FORMAT(resi.resi_od, "%d.%m.%Y %H:%i") as resi_od'),
                DB::raw('DATE_FORMAT(resi.resi_do, "%d.%m.%Y %H:%i") as resi_do'),
                DB::raw('DATE_FORMAT(resi.pristup_do, "%d.%m.%Y %H:%i") as pristup_do'),
                'resi.aktivita as aktivita'
            )
            ->where([
                ['id_projektu', '=', $id_projektu],
                ['id_osoby', '=', $data['id']]
            ])->first();

            $ulohy = DB::table('ukoly')
                ->select('ukoly.*', 'stavy_ukolu.*')
                ->leftJoin('stavy_ukolu', function ($join) {
                    $join->on('stavy_ukolu.ukol', '=', 'ukoly.id')
                        ->whereRaw('stavy_ukolu.id = (SELECT MAX(id) FROM stavy_ukolu WHERE stavy_ukolu.ukol = ukoly.id)');
                })
                ->whereIn('ukoly.id', function ($query) use ($id_projektu, $data) {
                    $query->select(DB::raw('MAX(id)'))
                        ->from('ukoly')
                        ->where('projekt', $id_projektu)
                        ->where('resitel', $data['id'])
                        ->groupBy('poradi');
                })
                ->orderBy('poradi', 'asc')
                ->get();

            $ulohy1 = DB::table('ukoly')
                ->whereIn('ukoly.id', function ($query) use ($id_projektu, $data) {
                    $query->select(DB::raw('MAX(id)'))
                        ->from('ukoly')
                        ->where('projekt', $id_projektu)
                        ->where('resitel', $data['id'])
                        ->groupBy('poradi');
                })
                ->groupBy('poradi')
                ->orderBy('poradi', 'asc')
                ->get();

            return view('detail_projektu', compact('data', 'projekt', 'veduci', 'prostriedky', 'riesenie', 'ulohy', 'ulohy1'));
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }
}
