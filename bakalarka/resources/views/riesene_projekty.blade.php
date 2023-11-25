<!--riesene projekty-->
<?php
    // Pole typů projektů
    $typProjektu[0] = __("Obecný projekt");
    $typProjektu[1] = __("Bakalářská práce");
    $typProjektu[2] = __("Diplomová práce");
    $typProjektu[3] = __("Disertační práce");
    $typProjektu[4] = __("Obecný projekt a BP");
    $typProjektu[5] = __("Obecný projekt a DP");

    // Pole stavů projektů
    $stavProjektu[0] = 'Nezadaný';
    $stavProjektu[1] = 'Řešený';
    $stavProjektu[2] = 'Ukončený';
    $stavProjektu[3] = 'K rozhodnutí';

    function vypisZoznamProjektov($projekt, $ciselnikVedoucich, $typProjektu, $stavProjektu){
        $idProjektu = $projekt->id;
        $aktivni = $projekt->rok_zadani; //TODO
        $zkratka = $projekt->zkratka;
        $nazov = $projekt->nazev;
        $terminUkoncenia = $projekt->resi_do; //TODO
        $typ = $typProjektu[$projekt->typ] ?? __("Neznámý");
        $url = $projekt->url;
        $stav = $stavProjektu[$projekt->stav] ?? __("Neznámý");
        $veduci = $ciselnikVedoucich[$projekt->vedouci] ?? __("Neznámý");
        $kod = $projekt->kod;
        $projektZadany = $projekt->zadan;
        $riesenieZahajene = $projekt->resi_od;
        $poznamka = $projekt->poznamka;
        $vysledek = '';
        $vysledek = '<tr style="height:60px;border:black solid 2px"><td style="width:40px;border:black solid 2px;border-left: black solid 4px;text-align:center;padding:5px">'.$idProjektu.'</td><td style="width:50px;text-align:center;border:black solid 2px;padding:5px">'.$aktivni.'</td><td style="width:90px;text-align:center;border:black solid 2px;padding:5px"><a href="#">'.$zkratka.'</a></td><td style="width:300px;border:black solid 2px;padding:5px"><a href="#">'.$nazov.'</a></td><td style="width:160px;text-align:center;border:black solid 2px;padding:5px">'.$terminUkoncenia.'</td><td style="width:80px;text-align:center;border:black solid 2px;padding:5px"><a href="#" onclick="editInput(this);return false;"><img src="detail.gif" style="width:35px;margin-right:5px" title="TODO" alt="Edit"/></a><a href="moje_vykazy"><img src="vykazy.gif" style="width:35px;margin-left:5px" title="TODO" alt=""/></a></td><td style="width:140px;text-align:center;border:black solid 2px;padding:5px">'.$typ.'</td><td style="width:250px;border:black solid 2px;padding:5px"><a href="'.$url.'" target="_blank">'.$url.'</a></td><td style="width:90px;text-align:center;border:black solid 2px;padding:5px">'.$stav.'</td><td style="width:90px;text-align:center;border:black solid 2px;padding:5px">'.$veduci.'</td><td style="width:70px;text-align:center;border:black solid 2px;padding:5px">'.$kod.'</td><td style="width:160px;text-align:center;border:black solid 2px;padding:5px">'.$projektZadany.'</td><td style="width:160px;text-align:center;border:black solid 2px;padding:5px">'.$riesenieZahajene.'</td><td style="width:300px;border:black solid 2px;border-right:black solid 4px;text-align:center;padding:5px">'.$poznamka.'</td></tr>';// TODO nejde "{__('todo')}" v title + a href skratky a nazvu
        return $vysledek;
    }
?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>

<!-- JavaScript code for DataTables -->
<script>
    $(document).ready(function () {
        var table = $('#riesene-projekty-tabulka').DataTable({
            dom: 'Blfrtip',
            lengthMenu: [5, 10, 25, 50, 100],
            language: {
                lengthMenu: '{{ __("Zobrazit _MENU_ položek") }}',
                info: '{{__("Zobrazuje se _START_ až _END_ z _TOTAL_ záznamů")}}',
                paginate: {
                    previous: "<",
                    next: ">"
                }
            },
        });

        var sortingState = []; // Uchováva stav triedenia pre každý stĺpec

        $('#riesene-projekty-tabulka thead th').on('click', function () {
            var columnIndex = $(this).index();
            var column = table.column(columnIndex);
            
            // Ak neexistuje stav triedenia pre daný stĺpec, inicializujte ho na vzostupné triedenie
            if (!sortingState[columnIndex]) {
                sortingState[columnIndex] = 'asc';
            }

            // Získajte aktuálny stav triedenia
            var currentOrder = sortingState[columnIndex];

            // Prepíšte stav triedenia (asc -> desc -> asc -> ...)
            sortingState[columnIndex] = currentOrder === 'asc' ? 'desc' : 'asc';

            // Odstráňte všetky existujúce triedenia na iných stĺpcoch
            table.columns().every(function () {
                if (this.index() !== columnIndex) {
                    this.order([]);
                }
            });

            // Nastavte nové poradie triedenia pre aktuálny stĺpec
            column.order(sortingState[columnIndex]).draw();
        });
    });
</script>

@extends('dashboard')
@section('content')
    <div class="riesene-projekty">
        <div class="riesene-projekty-l">
            <h2>{{__('Řešené projekty')}}</h2>
            <div class="medzera"></div>
            <table id="riesene-projekty-tabulka">
                <thead>
                    <tr style="border: black solid 4px;border-bottom:black solid 2px">
                        <th class="projekty-table-thead-th" style="width:40px">{{__('Číslo')}}</th>
                       <th class="projekty-table-thead-th" style="width:50px">{{__('Aktivní')}}</th>  <!-- TODO zistit podla coho sa urcuje aktivita -->
                        <th class="projekty-table-thead-th" style="width:90px">{{__('Zkratka')}}</th>
                        <th class="projekty-table-thead-th" style="width:300px">{{__('Název')}}</th>
                        <th class="projekty-table-thead-th" style="width:160px">{{__('Termín ukončení')}}</th>
                        <th class="projekty-table-thead-th" style="width:80px">{{__('Operace')}}</th>
                        <th class="projekty-table-thead-th" style="width:140px" title="{{__('Činnost souvisí přímo s projektem')}}">{{__('Typ')}}</th>
                        <th class="projekty-table-thead-th" style="width:250px" title="{{__('Činnost souvisí přímo s projektem')}}">URL</th>
                        <th class="projekty-table-thead-th" style="width:90px" title="{{__('Činnost souvisí přímo s projektem')}}">{{__('Stav')}}</th>
                        <th class="projekty-table-thead-th" style="width:90px" title="{{__('Činnost souvisí přímo s projektem')}}">{{__('Vedoucí')}}</th>
                        <th class="projekty-table-thead-th" style="width:70px" title="{{__('Činnost souvisí přímo s projektem')}}">{{__('Kód')}}</th>
                        <th class="projekty-table-thead-th" style="width:160px" title="{{__('Činnost souvisí přímo s projektem')}}">{{__('Projekt zadán')}}</th>
                        <th class="projekty-table-thead-th" style="width:160px" title="{{__('Činnost souvisí přímo s projektem')}}">{{__('Zahájení řešení')}}</th>
                        <th class="projekty-table-thead-th" style="width:300px" title="{{__('Činnost souvisí přímo s projektem')}}">{{__('Poznámka')}}</th>
                    </tr>
                    <!-- <tr>
                        <th class="projekty-table-thead-th" style="border-left:black solid 4px"><input type="text"></th>
                        <th class="projekty-table-thead-th"><select name="" id=""></select></th>
                        <th class="projekty-table-thead-th"><input type="text"></th>
                        <th class="projekty-table-thead-th"><input type="text"></th>
                        <th class="projekty-table-thead-th"><input type="text"></th>
                        <th class="projekty-table-thead-th">-</th>
                        <th class="projekty-table-thead-th"><select name="" id=""></select></th>
                        <th class="projekty-table-thead-th"><input type="text"></th>
                        <th class="projekty-table-thead-th"><select name="" id=""></select></th>
                        <th class="projekty-table-thead-th"><select name="" id=""></select></th>
                        <th class="projekty-table-thead-th"><input type="text"></th>
                        <th class="projekty-table-thead-th"><input type="text"></th>
                        <th class="projekty-table-thead-th"><input type="text"></th>
                        <th class="projekty-table-thead-th" style="border-right:black solid 4px"><input type="text"></th>
                    </tr> -->
                </thead>
                <tbody>
                    <?php foreach ($projekty as $projekt): ?>
                        <div class="vypis-projektov"><?php echo vypisZoznamProjektov($projekt, $ciselnikVedoucich, $typProjektu, $stavProjektu); ?></div>
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