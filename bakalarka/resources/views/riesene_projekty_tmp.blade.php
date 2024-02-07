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

    @include(public_path('tabulky.php'));

    $id_tabulky = 'riesene-projekty-tabulka';
    $nazvy_stlpcov = array(
        __('Číslo'),
        __('Aktivní'),
        __('Zkratka'),
        __('Název'),
        __('Termín ukončení'),
        __('Operace'),
        __('Typ'),
        'URL',
        __('Stav'),
        __('Vedoucí'),
        __('Kód'),
        __('Projekt zadán'),
        __('Zahájení řešení'),
        __('Poznámka')
    );
    $sirka_stlpcov = array(60,60,140,320,140,100,160,250,100,100,80,140,140,400);
    $riadky = array('id','aktivita','zkratka','nazev','resi_do','','typ','url','stav','vedouci','kod','zadan','resi_od','poznamka');
    $zarovnanieTela = array('c','c','c','l','c','c','c','l','c','c','c','c','c','l');
    $filters = ['s','v','s','s','d','','s','','v','s','','d','d',''];
    $links = array('','','detail_projektu/');
?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>

<!-- JavaScript code for DataTables -->
<script>
    $(document).ready(function () {
        var table = $('#riesene-projekty-tabulka').DataTable({
            dom: 'Blfrtip',
            orderCellsTop: true,
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

$('#riesene-projekty-tabulka thead tr:first-child th').on('click', function (e) {
    // Kontrola, či je kliknuté na prvý riadok v thead
    if ($(this).closest('thead').find('tr').index($(this).closest('tr')) === 0) {
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
    }
});



        function replaceStavText() {
            var stavProjektu = {!! json_encode($stavProjektu) !!};

            $('thead tr th').filter(function() {
                return $(this).text().trim() === 'Stav'; // Nájdenie th s textom "Stav"
            }).each(function() {
                var indexStav = $(this).index(); // Index stĺpca so stavom
                $('#riesene-projekty-tabulka tbody tr').each(function() {
                    var cisloStavu = $(this).find('td:eq(' + indexStav + ')').text(); // Číslo stavu
                    var textStavu = stavProjektu[cisloStavu]; // Text stavu
                    $(this).find('td:eq(' + indexStav + ')').text(textStavu); // Nahraďte číslo stavu textovou hodnotou
                });
            });
        }

        // Zavolajte funkciu na nahradenie textu po načítaní nových údajov
        $('#riesene-projekty-tabulka').on('draw.dt', function() {
            replaceStavText();
        });

        // Počiatočné nahradenie textu
        replaceStavText();

        function replaceTypText() {
            var typProjektu = {!! json_encode($typProjektu) !!};
            // Nájdenie stĺpca podľa textu "Stav" v thead a nahradenie čísla stavu textovou hodnotou
            $('thead tr th').filter(function() {
                return $(this).text().trim() === 'Typ'; // Nájdenie th s textom "Stav"
            }).each(function() {
                var indexTyp = $(this).index(); // Index stĺpca so stavom
                $('#riesene-projekty-tabulka tbody tr').each(function() {
                    var cisloTypu = $(this).find('td:eq(' + indexTyp + ')').text(); // Číslo stavu
                    var textTypu = typProjektu[cisloTypu]; // Text stavu
                    $(this).find('td:eq(' + indexTyp + ')').text(textTypu); // Nahraďte číslo stavu textovou hodnotou
                });
            });
        }
        // Zavolajte funkciu na nahradenie textu po načítaní nových údajov
        $('#riesene-projekty-tabulka').on('draw.dt', function() {
            replaceTypText();
        });

        // Počiatočné nahradenie textu
        replaceTypText();

        function replaceAktivnyText() {
            var aktivitaResitele = {!! json_encode($aktivitaResitele) !!};

            // Nájdenie stĺpca podľa textu "Aktivní" v thead a nahradenie čísla aktivity textovou hodnotou
            $('thead tr th').filter(function() {
                return $(this).text().trim() === 'Aktivní'; // Nájdenie th s textom "Aktivní"
            }).each(function() {
                var indexAktivity = $(this).index(); // Index stĺpca s aktivitou
                $('#riesene-projekty-tabulka tbody tr').each(function() {
                    var tdAktivity = $(this).find('td:eq(' + indexAktivity + ')'); // Td s aktívnosťou
                    var cisloAktivity = tdAktivity.text().trim(); // Číslo aktivity
                    var textAktivity = aktivitaResitele[cisloAktivity]; // Text aktivity
                    tdAktivity.text(textAktivity); // Nahraďte číslo aktivity textovou hodnotou
                });
            });
        }

        // Zavolajte funkciu na nahradenie textu po načítaní nových údajov
        $('#riesene-projekty-tabulka').on('draw.dt', function() {
            replaceAktivnyText();
        });

        // Počiatočné nahradenie textu
        replaceAktivnyText();

        function replaceVeduciText() {
            var ciselnikVedoucich = {!! json_encode($ciselnikVedoucich) !!};

            // Nájdenie stĺpca podľa textu "Stav" v thead a nahradenie čísla vedúceho textovou hodnotou
            $('thead tr th').filter(function() {
                return $(this).text().trim() === 'Vedoucí'; // Nájdenie th s textom "Vedoucí"
            }).each(function() {
                var indexVeduci = $(this).index(); // Index stĺpca s vedúcim
                $('#riesene-projekty-tabulka tbody tr').each(function() {
                    var tdVeduci = $(this).find('td:eq(' + indexVeduci + ')'); // Td s vedúcim
                    var cisloVeduceho = tdVeduci.text().trim(); // Číslo vedúceho
                    var textVeduceho = ciselnikVedoucich[cisloVeduceho]; // Text vedúceho
                    tdVeduci.text(textVeduceho); // Nahraďte číslo vedúceho textovou hodnotou
                });
            });
        }

        // Zavolajte funkciu na nahradenie textu po načítaní nových údajov
        $('#riesene-projekty-tabulka').on('draw.dt', function() {
            replaceVeduciText();
        });

        // Počiatočné nahradenie textu
        replaceVeduciText();


    });
</script>

@extends('dashboard')
@section('content')
    <div class="riesene-projekty">
        <div class="riesene-projekty-l">
            <h2>{{__('Řešené projekty')}}</h2>
            <div class="medzera"></div>
            <?php echo vygenerujTabulku($id_tabulky, $nazvy_stlpcov, $sirka_stlpcov, $riadky, $zarovnanieTela, $projekty, $filters);?>   
        </div> 
    </div>
@endsection