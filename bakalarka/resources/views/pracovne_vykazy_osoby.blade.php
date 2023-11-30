<!--pracovne vykazy osoby-->
<?php

    $typOsoby[0] = __("Bakalář");
    $typOsoby[1] = __("Diplomant");
    $typOsoby[2] = __("Doktorand");
    $typOsoby[3] = __("Ext. doktorand");
    $typOsoby[4] = __("Stud. spolupracovník");
    $typOsoby[5] = __("Zaměstnanec");
    $typOsoby[6] = __("Ostatní");
    $typOsoby[7] = __("Bakalář + SS");
    $typOsoby[8] = __("Diplomant + SS");
    $typOsoby[9] = __("Předmět");
    $typOsoby[10] = __("Zkušební doba");
    $typOsoby[11] = __("Nový stud. spolupracovník");
    $typOsoby[12] = __("Diplomant + Předmět"); 

    function vypisZoznamVykazov($vykazT, $vykazyD){
        $tyzden = $vykazT->cislo_tydne . "(" . $vykazT->pondeli . " - " . $vykazT->nedele . ")";
        $projekt = $vykazT->nazev;
        $hodin1 = intdiv($vykazT->odpracovano, 60);
        $minut1 = $vykazT->odpracovano % 60;
        $zaokruhleneMinuty1 = sprintf("%02d", $minut1);
        $odpracovane = $hodin1 . ":" . $zaokruhleneMinuty1;
        $suhrn = $vykazT->souhrn;
        $problemy = $vykazT->problemy;
        $plan = $vykazT->plan;
        $omluva = $vykazT->omluvy;
        $vysledek = '';
        $vysledek = '<tr style="border:black solid 2px"><td style="width:250px;border:black solid 2px;border-left: black solid 4px;text-align:center;padding:5px" rowspan="' . (count($vykazyD) + 1) . '">' . $tyzden . '</td><td style="width:80px;text-align:center;border:black solid 2px;padding:5px" rowspan="' . (count($vykazyD) + 1) . '"><a href="#">' . $projekt . '</a></td><td style="width:60px;text-align:center;border:black solid 2px;padding:5px" rowspan="' . (count($vykazyD) + 1) . '">' . $odpracovane . '</td><td style="width:250px;border:black solid 2px;padding:5px" rowspan="' . (count($vykazyD) + 1) . '">' . $suhrn . '</td><td style="width:110px;text-align:center;border:black solid 2px;padding:5px" rowspan="' . (count($vykazyD) + 1) . '"><a href="#" onclick="editInput(this);return false;"><img src="'.asset('detail.gif').'" style="width:35px;margin-right:5px" title="' . __('Upravit') . '" alt="Edit"/></a></td><td style="width:300px;border:black solid 2px;padding:5px" rowspan="' . (count($vykazyD) + 1) . '">' . $problemy . '</td><td style="width:250px;border:black solid 2px;padding:5px" rowspan="' . (count($vykazyD) + 1) . '">' . $plan . '</td><td style="width:250px;border:black solid 2px;padding:5px" rowspan="' . (count($vykazyD) + 1) . '">' . $omluva . '</td></tr>';
        // TODO  a href na projekt
        foreach ($vykazyD as $vykazD) {
            $datum = $vykazD->datum;
            $hodin2 = intdiv($vykazD->minut, 60);
            $minut2 = $vykazD->minut % 60;
            $zaokruhleneMinuty2 = sprintf("%02d", $minut2);
            $hodiny = $hodin2 . ":" . $zaokruhleneMinuty2;
            $od = $vykazD->cas_od;
            $do = $vykazD->cas_do;
            $cinnost = $vykazD->cinnost;
            $ssp = $vykazD->nesouvisi_sp;
            if ($ssp == 0){
                $suvisi = 'A';
            }
            else{
                $suvisi = 'N';
            }

            $vysledek .= '<tr><td style="width:120px;text-align:center;border:black solid 2px;padding:5px">' . $datum . '</td><td style="width:80px;text-align:center;border:black solid 2px;padding:5px">' . $hodiny . '</td><td style="width:80px;text-align:center;border:black solid 2px;padding:5px">' . $od . '</td><td style="width:80px;text-align:center;border:black solid 2px;padding:5px">' . $do . '</td><td style="width:350px;border:black solid 2px;padding:5px">' . $cinnost . '</td><td style="width:60px;text-align:center;border:black solid 2px;padding:5px">' . $suvisi . '</td><td style="width:110px;border:black solid 2px;border-right:black solid 4px;text-align:center;padding:5px" ><a href="#" onclick="editInput(this);return false;"><img src="' . asset('detail.gif') . '" style="width:35px;margin-right:5px" title="' . __('Upravit') . '" alt="Edit"/></a></td></tr>';
        }  
        return $vysledek; 
    } 
?>

@extends('dashboard')
@section('content')
    <div class="pracovne-vykazy-osoby">
        <div class="pracovne-vykazy-osoby-l">
            <h1>{{__('Pracovní výkazy osoby')}}</h1>
            <hr>
            <h3>{{__('Informace o osobě')}}:</h3>
            <div class="medzera"></div>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span" style="width:180px">{{__('Číslo, typ')}}:</div>
                    {{ $data->id . ", " . $typOsoby[$data->typ] }} <!-- TODO kde najdem typy uzivatelov -->
                </div>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span" style="width:180px">{{__('Jméno')}}:</div>
                    {{ $data->prijmeni . " " . $data->jmeno . ", " . $data->titul_pred . ", " . $data->titul_za . "(" . $data->login . ")" }}
                </div>
                @if ($data->email != "")
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span" style="width:180px">e-mail:</div>
                        <a href="mailto:$data->email">{{$data->email}}</a>
                    </div> 
                @endif
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span" style="width:180px">{{__('Aktivní')}}:</div>
                    @if (($data->aktivni_do == "0000-00-00 00:00:00") || ($data->aktivni_do == ""))
                        {{$data->aktivni_od. " - "}} &infin;
                    @else
                        {{$data->aktivni_od. " - " .$data->aktivni_do}}
                    @endif
                    ({{__('rozsah aktivity účtu')}})
                </div>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span" style="width:180px">{{__('Práce')}}:</div>
                    @if (($data->odpracovat_do == "0000-00-00 00:00:00") || ($data->odpracovat_do == ""))
                        {{$data->odpracovat_od. " - "}} &infin;
                    @else
                        {{$data->odpracovat_od. " - " .$data->odpracovat_do}}
                    @endif
                    ({{__('rozsah plánované pracovní aktivity')}})
                </div>
            <div class="medzera"></div>
            <hr>
            <h3>{{__('Pracovní výkazy')}}:</h3>
            <table id="pracovne-vykazy-osoby-tabulka">
                <thead>
                    <tr style="border: black solid 4px;border-bottom:black solid 2px">
                        <th class="pracovne-vykazy-osoby-table-thead-th" style="width:250px">{{__('Týden')}}</th>
                        <th class="pracovne-vykazy-osoby-table-thead-th" style="width:400px">{{__('Projekt')}}</th>
                        <th class="pracovne-vykazy-osoby-table-thead-th" style="width:60px">{{__('Odpracováno')}}</th>
                        <th class="pracovne-vykazy-osoby-table-thead-th" style="width:250px">{{__('Souhrn')}}</th>
                        <th class="pracovne-vykazy-osoby-table-thead-th" style="width:110px">{{__('Operace T')}}</th>
                        <th class="pracovne-vykazy-osoby-table-thead-th" style="width:300px">{{__('Problémy')}}</th>
                        <th class="pracovne-vykazy-osoby-table-thead-th" style="width:250px">{{__('Plán')}}</th>
                        <th class="pracovne-vykazy-osoby-table-thead-th" style="width:250px">{{__('Omluvy a výmluvy')}}</th>
                        <th class="pracovne-vykazy-osoby-table-thead-th" style="width:120px">{{__('Datum')}}</th>
                        <th class="pracovne-vykazy-osoby-table-thead-th" style="width:80px">{{__('Hodin')}}</th>
                        <th class="pracovne-vykazy-osoby-table-thead-th" style="width:80px">{{__('Od')}}</th>
                        <th class="pracovne-vykazy-osoby-table-thead-th" style="width:80px">{{__('Do')}}</th>
                        <th class="pracovne-vykazy-osoby-table-thead-th" style="width:350px">{{__('Činnost')}}</th>
                        <th class="pracovne-vykazy-osoby-table-thead-th" style="width:60px">{{__('SSP')}}</th>
                        <th class="pracovne-vykazy-osoby-table-thead-th" style="width:120px">{{__('Operace D')}}</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vykazyT as $vykazT): ?>
                        <?php 
                            // Dotaz pre získanie denných výkazov pre daný týždeň
                            $vykazyD = DB::table('vykaz')
                            ->select(
                                DB::raw('DATE_FORMAT(vykaz.datum,"%d.%m.%Y") as datum'),
                                'vykaz.minut as minut',
                                DB::raw('TIME_FORMAT(vykaz.cas_od,"%H:%i") as cas_od'),
                                DB::raw('TIME_FORMAT(vykaz.cas_do,"%H:%i") as cas_do'),
                                'vykaz.id_osoby as id_osoby',
                                'vykaz.id_projektu as id_projektu',
                                'vykaz.cinnost as cinnost',
                                'vykaz.nesouvisi_sp as nesouvisi_sp',
                                'vykaz.id_vykazu as id_vykazu',
                                'vykaz.id_tydne as id_tydne'
                            )
                            ->leftJoin('projekt', 'vykaz.id_projektu', '=', 'projekt.id')
                            ->where('vykaz.id_tydne', '=', $vykazT->id_tydne)
                            ->where('vykaz.id_osoby', '=', $data['id'])
                            ->orderByDesc('vykaz.datum')
                            ->get();

                            // Tabuľka pre daný týždeň    
                            echo vypisZoznamVykazov($vykazT, $vykazyD); ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div> 
    </div>
@endsection