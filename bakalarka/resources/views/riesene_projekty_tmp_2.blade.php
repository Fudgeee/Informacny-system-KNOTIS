<!--riesene projekty-->
<?php
    $typProjektuTmp = config('nastavenia.typProjektu');
    $typProjektu = [];
    foreach ($typProjektuTmp as $key => $value) {
        $typProjektu[$key] = __($value);
    }

    $stavProjektuTmp = config('nastavenia.stavProjektu');
    $stavProjektu = [];
    foreach ($stavProjektuTmp as $key => $value) {
        $stavProjektu[$key] = __($value);
    }

    $aktivitaResiteleTmp = config('nastavenia.aktivitaResitele');
    $aktivitaResitele = [];
    foreach ($aktivitaResiteleTmp as $key => $value) {
        $aktivitaResitele[$key] = __($value);
    }

    function vypisZoznamProjektov($projekt, $ciselnikVedoucich, $typProjektu, $stavProjektu, $aktivitaResitele){
        $idProjektu = $projekt->id;

        if ($projekt->aktivita == 0){
            $aktivni = '<span class="nevyplnene-udaje">' . $aktivitaResitele[$projekt->aktivita] . '</span>';
        }
        elseif ($projekt->aktivita == 5){
            $aktivni = '<span class="vyplnene-udaje">' . $aktivitaResitele[$projekt->aktivita] . '</span>';
        }
        $zkratka = $projekt->zkratka;
        $nazov = $projekt->nazev;
        $terminUkoncenia = $projekt->resi_do;
        $typ = $typProjektu[$projekt->typ] ?? __("Neznámý");
        $url = $projekt->url;
        $stav = $stavProjektu[$projekt->stav] ?? __("Neznámý");
        $veduci = $ciselnikVedoucich[$projekt->vedouci] ?? __("Neznámý");
        $kod = $projekt->kod;
        $projektZadany = $projekt->zadan;
        $riesenieZahajene = $projekt->resi_od;
        $poznamka = $projekt->poznamka;
        $mojeVykazy = "moje_vykazy";
        $detailProjektu = "detail_projektu";
        $vysledek = '';
        $vysledek = '<td class="tac w60">'.$idProjektu.'</td>';
        $vysledek .= '<td class="tac w60">'.$aktivni.'</td>';
        $vysledek .= '<td class="tac w140"><a href="' . url($detailProjektu, ['id_projektu' => $idProjektu]) . '">'.$zkratka.'</a></td>';
        $vysledek .= '<td class="w320"><a href="' . url($detailProjektu, ['id_projektu' => $idProjektu]) . '">'.$nazov.'</a></td>';
        $vysledek .= '<td class="tac w160">'.$terminUkoncenia.'</td>';
        $vysledek .= '<td class="tac w100"><a href="' . url($detailProjektu, ['id_projektu' => $idProjektu]) . '"><img src="detail.gif" style="width:35px;margin-right:5px" title="' . __('Detaily') . '" alt="Edit"/></a><a href="' . url($mojeVykazy, ['id_projektu' => $idProjektu]) . '"><img src="vykazy.gif" style="width:35px;margin-left:5px" title="' . __('Moje výkazy') . '" alt=""/></a></td>';
        $vysledek .= '<td class="tac w140">'.$typ.'</td>';
        $vysledek .= '<td class="tac w250"><a href="'.$url.'" target="_blank">'.$url.'</a></td>';
        $vysledek .= '<td class="tac w100">'.$stav.'</td>';
        $vysledek .= '<td class="tac w100">'.$veduci.'</td>';
        $vysledek .='<td class="tac w80">'.$kod.'</td>';
        $vysledek .='<td class="tac w140">'.$projektZadany.'</td>';
        $vysledek .='<td class="tac w140">'.$riesenieZahajene.'</td>';
        $vysledek .='<td class="tac w400">'.$poznamka.'</td>';
        return $vysledek;
    }
?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/colreorder/1.5.5/js/dataTables.colReorder.min.js"></script>

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
            colReorder: true,
            // columnDefs: [{ 
            //     orderable: false, // Nastavení, že sloupec nebude řaditelný
            //     targets: 5 // Index třetího sloupce (počítání od 0)
            // }]
        });

        var sortingState = []; // Uchováva stav triedenia pre každý stĺpec

        $('#riesene-projekty-tabulka thead th').on('click', function () {
            var columnIndex = $(this).index();
            var column = table.column(columnIndex);
            
            // Ak neexistuje stav triedenia pre daný stĺpec, inicializujte ho na vzostupné triedenie
            if (!sortingState[columnIndex]) {
                sortingState[columnIndex] = 'asc';
            } else if (sortingState[columnIndex] === 'asc') {
                sortingState[columnIndex] = 'desc'; // Prepíšte stav triedenia na zostupné
            } else {
                sortingState[columnIndex] = ''; // Vypnite radenie (odstráňte stav triedenia)
            }

            // Získajte aktuálny stav triedenia
            var currentOrder = sortingState[columnIndex];

            // Ak je stav triedenia neprázdny, nastavte nové poradie triedenia pre aktuálny stĺpec
            if (currentOrder !== '') {
                column.order(currentOrder).draw();
            } else {
                // Inak použite predvolený stĺpec na triedenie
                var defaultOrderIndex = 0; // Index predvoleného stĺpca (prvého stĺpca)
                var defaultOrderColumn = table.column(defaultOrderIndex);
                defaultOrderColumn.order('asc').draw();
            }

            // Odstráňte všetky existujúce triedenia na iných stĺpcoch
            table.columns().every(function () {
                if (this.index() !== columnIndex) {
                    this.order([]);
                }
            });
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
                    <tr>
                        <th class="projekty-table-thead-th">{{__('Číslo')}}</th>
                        <th class="projekty-table-thead-th">{{__('Aktivní')}}</th>
                        <th class="projekty-table-thead-th">{{__('Zkratka')}}</th>
                        <th class="projekty-table-thead-th">{{__('Název')}}</th>
                        <th class="projekty-table-thead-th">{{__('Termín ukončení')}}</th>
                        <th class="projekty-table-thead-th">{{__('Operace')}}</th>
                        <th class="projekty-table-thead-th">{{__('Typ')}}</th>
                        <th class="projekty-table-thead-th">URL</th>
                        <th class="projekty-table-thead-th">{{__('Stav')}}</th>
                        <th class="projekty-table-thead-th">{{__('Vedoucí')}}</th>
                        <th class="projekty-table-thead-th">{{__('Kód')}}</th>
                        <th class="projekty-table-thead-th">{{__('Projekt zadán')}}</th>
                        <th class="projekty-table-thead-th">{{__('Zahájení řešení')}}</th>
                        <th class="projekty-table-thead-th">{{__('Poznámka')}}</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projekty as $projekt): ?>
                        <tr>
                            <?php echo vypisZoznamProjektov($projekt, $ciselnikVedoucich, $typProjektu, $stavProjektu, $aktivitaResitele); ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div> 
    </div>
@endsection