<!--moje vykazy-->
<?php
    // Pole typů projektů
    $typProjektu[0] = __("Obecný projekt");
    $typProjektu[1] = __("Bakalářská práce");
    $typProjektu[2] = __("Diplomová práce");
    $typProjektu[3] = __("Disertační práce");
    $typProjektu[4] = __("Obecný projekt a BP");
    $typProjektu[5] = __("Obecný projekt a DP");

    function vypisZoznamVykazov($vykaz, $projekt){
        $tyzden = $vykaz->cislo_tydne . "(" . $vykaz->pondeli . " - " . $vykaz->nedele . ")";
        $projekt = $projekt->nazev;
        $hodin1 = intdiv($vykaz->odpracovano, 60);
        $minut1 = $vykaz->odpracovano % 60;
        $zaokruhleneMinuty1 = sprintf("%02d", $minut1);
        $odpracovane = $hodin1 . ":" . $zaokruhleneMinuty1;
        $suhrn = $vykaz->souhrn;
        $problemy = $vykaz->problemy;
        $plan = $vykaz->plan;
        $omluva = $vykaz->omluvy;
        $datum = $vykaz->datum;
        $hodin2 = intdiv($vykaz->minut, 60);
        $minut2 = $vykaz->minut % 60;
        $zaokruhleneMinuty2 = sprintf("%02d", $minut2);
        $hodiny = $hodin2 . ":" . $zaokruhleneMinuty2;
        $od = $vykaz->cas_od;
        $do = $vykaz->cas_do;
        $cinnost = $vykaz->cinnost;
        $ssp = $vykaz->nesouvisi_sp;
        if ($ssp == 0){
            $suvisi = 'A';
        }
        else{
            $suvisi = 'N';
        }

        $vysledek = '';
        $vysledek = '<tr style="height:60px;border:black solid 2px"><td style="width:250px;border:black solid 2px;border-left: black solid 4px;text-align:center;padding:5px">'.$tyzden.'</td><td style="width:400px;text-align:center;border:black solid 2px;padding:5px"><a href="#">'.$projekt.'</a></td><td style="width:60px;text-align:center;border:black solid 2px;padding:5px">'.$odpracovane.'</td><td style="width:250px;border:black solid 2px;padding:5px">'.$suhrn.'</td><td style="width:110px;text-align:center;border:black solid 2px;padding:5px"><a href="#" onclick="editInput(this);return false;"><img src="'.asset('detail.gif').'" style="width:35px;margin-right:5px" title="TODO" alt="Edit"/></a></td><td style="width:300px;border:black solid 2px;padding:5px">'.$problemy.'</td><td style="width:250px;border:black solid 2px;padding:5px">'.$plan.'</td><td style="width:250px;border:black solid 2px;padding:5px">'.$omluva.'</td><td style="width:120px;text-align:center;border:black solid 2px;padding:5px">'.$datum.'</td><td style="width:80px;text-align:center;border:black solid 2px;padding:5px">'.$hodiny.'</td><td style="width:80px;text-align:center;border:black solid 2px;padding:5px">'.$od.'</td><td style="width:80px;text-align:center;border:black solid 2px;padding:5px">'.$do.'</td><td style="width:350px;border:black solid 2px;padding:5px">'.$cinnost.'</td><td style="width:60px;text-align:center;border:black solid 2px;padding:5px">'.$suvisi.'</td><td style="width:110px;border:black solid 2px;border-right:black solid 4px;text-align:center;padding:5px" ><a href="#" onclick="editInput(this);return false;"><img src="'.asset('detail.gif').'" style="width:35px;margin-right:5px" title="TODO" alt="Edit"/></a></td></tr>';// TODO nejde "{__('todo')}" v title + a href na projekt
        return $vysledek;
    } 
?>

<link rel="stylesheet" type="text/css" href="{{asset('https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css')}}">
<script type="text/javascript" charset="utf8" src="{{asset('https://code.jquery.com/jquery-3.6.0.min.js')}}"></script>
<script type="text/javascript" charset="utf8" src="{{asset('https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js')}}"></script>
<!-- JavaScript code for DataTables -->
<script>
    $(document).ready(function () {
        var table = $('#moje-vykazy-tabulka').DataTable({
            dom: 'Blfrtip',
            lengthMenu: [10, 25, 50, 100],
            language: {
                lengthMenu: '{{ __("Zobrazit _MENU_ položek") }}',
                info: '{{__("Zobrazuje se _START_ až _END_ z _TOTAL_ záznamů")}}',
                paginate: {
                    previous: "<",
                    next: ">"
                }
            },
            //order: []
            ordering: false // Question - radenie riadkov?
        });
    });
</script>
@extends('dashboard')
@section('content')
    <div class="pracovne-vykazy-osoby">
        <div class="pracovne-vykazy-osoby-l">
            <h1>{{__('Moje výkazy')}}</h1>
            <hr>
            <div class="udaje_o_projekte">
                <h3>{{__('Údaje o projektu')}}:</h3>
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
                        <div class="osobne_info_item_span" style="width:150px">{{__('Zkratka')}}</div>
                        {{$projekt->zkratka}}
                    </div> 
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span" style="width:150px">{{__('Název')}}</div>
                        {{$projekt->nazev}}
                    </div> 
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span" style="width:150px">URL</div>
                        <a href="{{$projekt->url}}" target="_blank" style="margin:0">{{$projekt->url}}</a>
                    </div> 
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span" style="width:150px">{{__('Poznámka')}}</div>
                        {{$projekt->poznamka}}
                    </div> 
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span" style="width:150px">{{__('Skupina')}}</div>
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
                        <th class="moje-vykazy-table-thead-th" style="width:400px">{{__('Osoba')}}</th>
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
                    <?php foreach ($vykazy as $vykaz): ?>
                        <div class="vypis-vykazov"><?php echo vypisZoznamVykazov($vykaz, $projekt); ?></div>
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