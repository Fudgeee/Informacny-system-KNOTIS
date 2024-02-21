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

class KonfiguraciaController extends Controller
{
    public function Konfiguracia(){
        $data = array();
        $server = array();
        $servery = array();
        $ipAdresy = array();
        if(Session::has('loginId')){
            $data = Osoba::where('id','=',Session::get('loginId'))->first();
            $ipAdresy = DB::table('osoba_hosts_ip')->get();
            $PDO = DB::connection('mysql')->getPdo();
            $server = $PDO->prepare(" SELECT      tmp.*
            FROM 
            (
            (
                SELECT      server.id_server,
                            server.nazev,
                            osoba_server.sudo
                FROM        server
                LEFT JOIN   osoba_server ON osoba_server.id_serveru = server.id_server
                LEFT JOIN   osoba ON osoba.id = osoba_server.id_osoby
                WHERE       osoba.id = $data->id
            )
            UNION
            (
                SELECT      server.id_server,
                            server.nazev,
                            osoba_server.sudo
                FROM        server
                LEFT JOIN   projekt_server ON projekt_server.id_serveru = server.id_server
                LEFT JOIN   projekt ON projekt.id = projekt_server.id_projektu
                LEFT JOIN   osoba ON osoba.id = projekt.vedouci
                LEFT JOIN   osoba_server ON osoba_server.id_osoby = osoba.id AND osoba_server.id_serveru = server.id_server
                WHERE       osoba.id = $data->id
            )
            UNION
            (
                SELECT      server.id_server,
                            server.nazev,
                            osoba_server.sudo
                FROM        server
                LEFT JOIN   projekt_server ON projekt_server.id_serveru = server.id_server
                LEFT JOIN   projekt ON projekt.id = projekt_server.id_projektu
                LEFT JOIN   projekt_skupina ON projekt.id = projekt_skupina.id_projekt
                LEFT JOIN   skupina_proj ON skupina_proj.id = projekt_skupina.id_skupina
                LEFT JOIN   osoba ON osoba.id = skupina_proj.vedouci
                LEFT JOIN   osoba_server ON osoba_server.id_osoby = osoba.id AND osoba_server.id_serveru = server.id_server
                WHERE       osoba.id = $data->id
            )
            UNION
            (
                SELECT      server.id_server,
                            server.nazev,
                            osoba_server.sudo
                FROM        server
                LEFT JOIN   skupina_proj_server ON skupina_proj_server.id_serveru = server.id_server
                LEFT JOIN   skupina_proj ON skupina_proj.id = skupina_proj_server.id_skupiny
                LEFT JOIN   projekt_skupina ON skupina_proj.id = projekt_skupina.id_skupina
                LEFT JOIN   projekt ON projekt_skupina.id_projekt = projekt.id
                LEFT JOIN   osoba ON osoba.id = projekt.vedouci
                LEFT JOIN   osoba_server ON osoba_server.id_osoby = osoba.id AND osoba_server.id_serveru = server.id_server
                WHERE       osoba.id = $data->id
            )
            UNION
            (
                SELECT      server.id_server,
                            server.nazev,
                            osoba_server.sudo
                FROM        server
                LEFT JOIN   projekt_server ON projekt_server.id_serveru = server.id_server
                LEFT JOIN   projekt ON projekt.id = projekt_server.id_projektu
                LEFT JOIN   resi ON resi.id_projektu = projekt.id
                LEFT JOIN   osoba ON osoba.id = resi.id_osoby
                LEFT JOIN   osoba_server ON osoba_server.id_osoby = osoba.id AND osoba_server.id_serveru = server.id_server
                WHERE       osoba.id = $data->id
            )
            UNION
            (
                SELECT      server.id_server,
                            server.nazev,
                            osoba_server.sudo
                FROM        server
                LEFT JOIN   skupina_proj_server ON skupina_proj_server.id_serveru = server.id_server
                LEFT JOIN   skupina_proj ON skupina_proj.id = skupina_proj_server.id_skupiny
                LEFT JOIN   projekt_skupina ON skupina_proj.id = projekt_skupina.id_skupina
                LEFT JOIN   projekt ON projekt_skupina.id_projekt = projekt.id
                LEFT JOIN   resi ON resi.id_projektu = projekt.id
                LEFT JOIN   osoba ON osoba.id = resi.id_osoby
                LEFT JOIN   osoba_server ON osoba_server.id_osoby = osoba.id AND osoba_server.id_serveru = server.id_server
                WHERE       osoba.id = $data->id
            )
            UNION
            (
                SELECT      server.id_server,
                            server.nazev,
                            osoba_server.sudo
                FROM        server
                LEFT JOIN   projekt_server ON projekt_server.id_serveru = server.id_server
                LEFT JOIN   projekt ON projekt.id = projekt_server.id_projektu
                LEFT JOIN   sleduje ON sleduje.id_projektu = projekt.id
                LEFT JOIN   osoba ON osoba.id = sleduje.id_osoby
                LEFT JOIN   osoba_server ON osoba_server.id_osoby = osoba.id AND osoba_server.id_serveru = server.id_server
                WHERE       osoba.id = $data->id
            )
            UNION
            (
                SELECT      server.id_server,
                            server.nazev,
                            osoba_server.sudo
                FROM        server
                LEFT JOIN   skupina_proj_server ON skupina_proj_server.id_serveru = server.id_server
                LEFT JOIN   skupina_proj ON skupina_proj.id = skupina_proj_server.id_skupiny
                LEFT JOIN   projekt_skupina ON skupina_proj.id = projekt_skupina.id_skupina
                LEFT JOIN   projekt ON projekt_skupina.id_projekt = projekt.id
                LEFT JOIN   sleduje ON sleduje.id_projektu = projekt.id
                LEFT JOIN   osoba ON osoba.id = sleduje.id_osoby
                LEFT JOIN   osoba_server ON osoba_server.id_osoby = osoba.id AND osoba_server.id_serveru = server.id_server
                WHERE       osoba.id = $data->id
            )
            UNION
            (
                SELECT      server.id_server,
                            server.nazev,
                            osoba_server.sudo
                FROM        server
                LEFT JOIN   skupina_proj_server ON skupina_proj_server.id_serveru = server.id_server
                LEFT JOIN   skupina_proj ON skupina_proj.id = skupina_proj_server.id_skupiny
                LEFT JOIN   osoba ON osoba.id = skupina_proj.vedouci
                LEFT JOIN   osoba_server ON osoba_server.id_osoby = osoba.id AND osoba_server.id_serveru = server.id_server
                WHERE       osoba.id = $data->id
            )
            UNION
            (
                SELECT      server.id_server,
                            server.nazev,
                            osoba_server.sudo
                FROM        server
                LEFT JOIN   skupina_proj_server ON skupina_proj_server.id_serveru = server.id_server
                LEFT JOIN   skupina_proj ON skupina_proj.id = skupina_proj_server.id_skupiny
                LEFT JOIN   projekt_skupina ON skupina_proj.id = projekt_skupina.id_skupina
                LEFT JOIN   projekt ON projekt_skupina.id_projekt = projekt.id
                LEFT JOIN   resi ON resi.id_projektu = projekt.id
                LEFT JOIN   osoba ON osoba.id = resi.id_osoby
                LEFT JOIN   osoba_server ON osoba_server.id_osoby = osoba.id AND osoba_server.id_serveru = server.id_server
                WHERE       osoba.id = $data->id
            )
            UNION
            (
                SELECT      server.id_server,
                            server.nazev,
                            osoba_server.sudo
                FROM        server
                LEFT JOIN   projekt_server ON projekt_server.id_serveru = server.id_server
                LEFT JOIN   projekt ON projekt.id = projekt_server.id_projektu
                LEFT JOIN   projekt_skupina ON projekt.id = projekt_skupina.id_projekt
                LEFT JOIN   sled_skup ON sled_skup.id_skupiny = projekt_skupina.id_skupina
                LEFT JOIN   osoba ON osoba.id = sled_skup.id_osoby
                LEFT JOIN   osoba_server ON osoba_server.id_osoby = osoba.id AND osoba_server.id_serveru = server.id_server
                WHERE       osoba.id = $data->id
            )
            UNION
            (
                SELECT      server.id_server,
                            server.nazev,
                            osoba_server.sudo
                FROM        server
                LEFT JOIN   skupina_proj_server ON skupina_proj_server.id_serveru = server.id_server
                LEFT JOIN   sled_skup ON sled_skup.id_skupiny = skupina_proj_server.id_skupiny
                LEFT JOIN   osoba ON osoba.id = sled_skup.id_osoby
                LEFT JOIN   osoba_server ON osoba_server.id_osoby = osoba.id AND osoba_server.id_serveru = server.id_server
                WHERE       osoba.id = $data->id
            )
            ) AS tmp
            GROUP BY tmp.id_server
            ORDER BY tmp.nazev
            ");
            $server->execute();
            while ($row = $server->fetch((\PDO::FETCH_ASSOC)))
            {
                array_push($servery,$row);
                $tmp = $data["opravneniKS"];
                $tmp[$row["id_server"]] = $row["id_server"];
                $data["opravneniKS"] = $tmp;
                
                // Kontrola, či $data["sudoKS"] existuje a je polem
                if (!isset($data["sudoKS"]) || !is_array($data["sudoKS"])) {
                    // Ak nie je, inicializujeme ju ako prázdne pole
                    $data["sudoKS"] = array();
                }

                $tmp1 = $data["sudoKS"];
                $tmp1[$row["id_server"]] = $row["sudo"];
                $data["sudoKS"] = $tmp1;

            }
            return view('konfiguracia', compact('data', 'servery', 'ipAdresy'));
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }

    public function updateKonfiguracia(Request $request){
        if(Session::has('loginId')){
            $tmp = array();
            $ipAll = array();
            $ipAdresy = array();
            $ipAdresyAll = array();
            $validator = Validator::make($request->all(), [
                'zpozdeni_vykazu'=>'required',
                'zasilat_kopie'=>'required',
                'str_po_prihlaseni'=>'required',
                'vychozi_ulozeni_sezeni'=>'required',
                'hlidani_wiki_ukolu' =>'required',
            ]);
            if ($validator->fails()){
                return back()->with('fail',__('Prosím vyplňte všechna povinná pole'));
            }
            else{
                $osoba = Osoba::where('id','=',Session::get('loginId'))->update([
                    'zpozdeni_vykazu' => $request->zpozdeni_vykazu,
                    'zasilat_kopie' => $request->zasilat_kopie,
                    'str_po_prihlaseni' => $request->str_po_prihlaseni,
                    'vychozi_ulozeni_sezeni' => $request->vychozi_ulozeni_sezeni,
                    'hlidani_wiki_ukolu' => $request->hlidani_wiki_ukolu,
                    'hosts_allow' => (!is_null($request->hosts_allow) ? $request->hosts_allow : ""),
                    'ip4_tables' => (!is_null($request->ip4_tables) ? $request->ip4_tables : ""),
                    'ip6_tables' => (!is_null($request->ip6_tables) ? $request->ip6_tables : "")
                ]);
                $ipAdresy = $request->upravIp;
                $osobaId = Session::get('loginId');
                $ipAdresyAll = DB::table('osoba_hosts_ip')->where('id_osoby', '=', $osobaId)->get('ip');
                if (count(is_countable($ipAdresyAll) ? $ipAdresyAll : []) > 0){
                    foreach($ipAdresyAll as $id1 => $host1){
                        $ipAll[$id1] = $host1->ip;
                    }
                }
                if (count(is_countable($ipAdresy) ? $ipAdresy : []) > 0){
                    foreach($ipAdresy as $id => $host){
                        $data = null;
                        if (isset($ipAdresy[$id])){
                            $data = DB::table('osoba_hosts_ip')->where([
                                ['id_osoby', '=', $osobaId],
                                ['ip', '=', $ipAdresy[$id]]
                            ])->first();
                        }
                        if ($data == null || $data == ''){
                            $data = DB::table('osoba_hosts_ip')->insert([
                                'id_osoby' => $osobaId,
                                'ip' => $host
                            ]);
                        }
                        else{
                            $data = DB::table('osoba_hosts_ip')->where([
                                ['id_osoby', '=', $osobaId],
                                ['ip', '=', $ipAdresy[$id]]
                            ])->update([
                                'ip' => $host
                            ]);
                        }
                    }
                }
                if ($ipAdresy == null || $ipAdresy == ''){
                    DB::table('osoba_hosts_ip')->where('id_osoby', '=', $osobaId)->delete();
                }
                else{
                    if ($ipAll != null){
                        $tmp = array_diff($ipAll, $ipAdresy);
                        DB::table('osoba_hosts_ip')->where('id_osoby', '=', $osobaId)->whereIn('ip', $tmp)->delete();
                    }
                } 
                return back()->with('success',__('Konfigurace byla úspěšně změněna'));
            }
        }
        else {
            session(['preLoginUrl' => url()->previous()]);
            return redirect('/login')->with('fail', __('Vaše přihlášení vypršelo. Přihlašte se prosím znovu.'));
        }
    }
}
