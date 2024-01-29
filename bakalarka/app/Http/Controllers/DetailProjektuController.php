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
use Carbon\Carbon;
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
                ->select('prostredek.id', 'prostredek.nazev', 'prostredek.cesta', 'prostr_proj.opravneni', 'prostredek.vlastnik', 'prostr_proj.vyuzivan', 'prostr_proj.typ_vyuziti', 'prostredek.server')
                ->join('prostredek', 'prostr_proj.id_prostredku', '=', 'prostredek.id')
                ->where('prostr_proj.id_projektu', '=', $id_projektu)
                ->where('prostr_proj.vyuzivan', '>', 0)
                ->where('prostredek.stav', '<', 1)
                ->union(
                    DB::table('projekt_skupina')
                        ->select('prostredek.id', 'prostredek.nazev', 'prostredek.cesta', 'prostr_skup.opravneni', 'prostredek.vlastnik', 'prostr_skup.vyuzivan', DB::raw('0 AS typ_vyuziti'), 'prostredek.server')
                        ->join('prostr_skup', 'projekt_skupina.id_skupina', '=', 'prostr_skup.id_skupiny')
                        ->join('prostredek', 'prostr_skup.id_prostredku', '=', 'prostredek.id')
                        ->where('projekt_skupina.id_projekt', '=', $id_projektu)
                        ->where('prostr_skup.vyuzivan', '>', 0)
                        ->where('prostredek.stav', '<', 1)
                )
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
                        ->where('stavy_ukolu.aktualni', "=", 1);
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

    public function aktualizovatUkol(Request $request) {
        $jednotlive_ulohy = [];
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
            foreach ($request->uloha_id as $index => $ulohaId) {

                $stav_ulohy = DB::table('stavy_ukolu')
                    ->where('id', '=', $ulohaId)
                    ->first();

                if ($stav_ulohy != NULL) {
                    // Aktualizace existujícího záznamu
                    $comment = !is_null($request->komentar[$index]) ? $request->komentar[$index] : "";
            

                    if($stav_ulohy->stav != intval($request->stav[$index]) || $stav_ulohy->procenta != $request->hotovo[$index] || $stav_ulohy->komentar != $comment) {
                    
                        DB::table('stavy_ukolu')
                            ->where('id', $ulohaId)
                            ->update([
                                'aktualni' => 0
                            ]);
                        DB::table('stavy_ukolu')->insert([
                           'ukol' => $request->uloha_ukol[$index],
                           'stav' => $request->stav[$index],
                           'procenta' => $request->hotovo[$index],
                           'komentar' => $request->komentar[$index],
                           'vlozil' => $data['id'],
                           'odeslano' => \Carbon\Carbon::now('Europe/Prague'),
                           'aktualni' => 1
                        ]);

                        return back()->with('success1',__('Změny stavů úkolů byly úspěšně uloženy'));   
                    }
                }
            }

        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }
}
