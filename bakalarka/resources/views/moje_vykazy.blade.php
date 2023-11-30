<!--moje vykazy-->
<?php
    // Pole typů projektů
    $typProjektu[0] = __("Obecný projekt");
    $typProjektu[1] = __("Bakalářská práce");
    $typProjektu[2] = __("Diplomová práce");
    $typProjektu[3] = __("Disertační práce");
    $typProjektu[4] = __("Obecný projekt a BP");
    $typProjektu[5] = __("Obecný projekt a DP");

    function vypisZoznamVykazov($vykazT, $projekt, $vykazyD, $osoba){
        $tyzden = $vykazT->cislo_tydne . "(" . $vykazT->pondeli . " - " . $vykazT->nedele . ")";
        $hodin1 = intdiv($vykazT->odpracovano, 60);
        $minut1 = $vykazT->odpracovano % 60;
        $zaokruhleneMinuty1 = sprintf("%02d", $minut1);
        $odpracovane = $hodin1 . ":" . $zaokruhleneMinuty1;
        $suhrn = $vykazT->souhrn;
        $problemy = $vykazT->problemy;
        $plan = $vykazT->plan;
        $omluva = $vykazT->omluvy;

        $vysledek = '';
        $vysledek = '<tr style="border:black solid 2px"><td style="width:250px;border:black solid 2px;border-left: black solid 4px;text-align:center;padding:5px" rowspan="' . (count($vykazyD) + 1) . '">' . $tyzden . '</td><td style="width:80px;text-align:center;border:black solid 2px;padding:5px" rowspan="' . (count($vykazyD) + 1) . '">' . $osoba . '</td><td style="width:60px;text-align:center;border:black solid 2px;padding:5px" rowspan="' . (count($vykazyD) + 1) . '">' . $odpracovane . '</td><td style="width:250px;border:black solid 2px;padding:5px" rowspan="' . (count($vykazyD) + 1) . '">' . $suhrn . '</td><td style="width:110px;text-align:center;border:black solid 2px;padding:5px" rowspan="' . (count($vykazyD) + 1) . '"><a href="#" onclick="editInput(this);return false;"><img src="'.asset('detail.gif').'" style="width:35px;margin-right:5px" title="' . __('Upravit') . '" alt="Edit"/></a></td><td style="width:300px;border:black solid 2px;padding:5px" rowspan="' . (count($vykazyD) + 1) . '">' . $problemy . '</td><td style="width:250px;border:black solid 2px;padding:5px" rowspan="' . (count($vykazyD) + 1) . '">' . $plan . '</td><td style="width:250px;border:black solid 2px;padding:5px" rowspan="' . (count($vykazyD) + 1) . '">' . $omluva . '</td></tr>';
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
    <div class="moje-vykazy">
        <div class="moje-vykazy-l">
            <h1>{{__('Moje výkazy')}}</h1>
            <hr>
            <div class="udaje_o_projekte">
                <h3>{{__('Informace o projektu')}}:</h3>
                <div class="medzera"></div>
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span" style="width:150px">{{__('Číslo')}}:</div>
                        {{$projekt->id}}
                    </div>
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span" style="width:150px">{{__('Typ')}}:</div>
                        {{$typProjektu[$projekt->typ]}}
                    </div>
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span" style="width:150px">{{__('Zkratka')}}:</div>
                        {{$projekt->zkratka}}
                    </div> 
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span" style="width:150px">{{__('Název')}}:</div>
                        {{$projekt->nazev}}
                    </div> 
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span" style="width:150px">URL:</div>
                        <a href="{{$projekt->url}}" target="_blank" style="margin:0">{{$projekt->url}}</a>
                    </div> 
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span" style="width:150px">{{__('Poznámka')}}:</div>
                        {{$projekt->poznamka}}
                    </div> 
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span" style="width:150px">{{__('Skupina')}}:</div>
                        {{$skupina->nazev}}
                    </div> 
                <div class="medzera"></div>
            </div>
            <hr>
            <h3>{{__('Pracovní výkazy')}}:</h3>
            <table id="moje-vykazy-tabulka">
                <thead>
                    <tr style="border: black solid 4px;border-bottom:black solid 2px">
                        <th class="moje-vykazy-table-thead-th" style="width:250px">{{__('Týden')}}</th>
                        <th class="moje-vykazy-table-thead-th" style="width:80px">{{__('Osoba')}}</th>
                        <th class="moje-vykazy-table-thead-th" style="width:60px">{{__('Odpracováno')}}</th>
                        <th class="moje-vykazy-table-thead-th" style="width:250px">{{__('Souhrn')}}</th>
                        <th class="moje-vykazy-table-thead-th" style="width:110px">{{__('Operace T')}}</th>
                        <th class="moje-vykazy-table-thead-th" style="width:300px">{{__('Problémy')}}</th>
                        <th class="moje-vykazy-table-thead-th" style="width:250px">{{__('Plán')}}</th>
                        <th class="moje-vykazy-table-thead-th" style="width:250px">{{__('Omluvy a výmluvy')}}</th>
                        <th class="moje-vykazy-table-thead-th" style="width:120px">{{__('Datum')}}</th>
                        <th class="moje-vykazy-table-thead-th" style="width:80px">{{__('Hodin')}}</th>
                        <th class="moje-vykazy-table-thead-th" style="width:80px">{{__('Od')}}</th>
                        <th class="moje-vykazy-table-thead-th" style="width:80px">{{__('Do')}}</th>
                        <th class="moje-vykazy-table-thead-th" style="width:350px">{{__('Činnost')}}</th>
                        <th class="moje-vykazy-table-thead-th" style="width:60px">{{__('SSP')}}</th>
                        <th class="moje-vykazy-table-thead-th" style="width:110px">{{__('Operace D')}}</th>
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
                            ->where('vykaz.id_projektu', '=', $projekt->id)
                            ->where('vykaz.id_tydne', '=', $vykazT->id_tydne)
                            ->where('vykaz.id_osoby', '=', $data['id'])
                            ->orderByDesc('vykaz.datum')
                            ->get();

                            // Tabuľka pre daný týždeň
                            echo vypisZoznamVykazov($vykazT, $projekt, $vykazyD, $data->login); ?>
                    <?php endforeach; ?>            
                </tbody>
                <tfoot>
                <tr style="border: black solid 4px;border-bottom:black solid 2px">
                </tr>
                </tfoot>
            </table>
        </div> 
    </div>
@endsection