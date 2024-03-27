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

    $colFilterTmp = config('nastavenia.colFilter');
    $colFilter = [];
    foreach ($colFilterTmp as $key => $value) {
        $colFilter[$key] = __($value);
    }
    
    @include(public_path('tabulky.php'));

    $id_tabulky = 'riesene-projekty-tabulka';

    class TableColumn {
        public $name;
        public $width;
        public $row;
        public $alignment;
        public $filter;
    
        public function __construct($name, $width, $row, $alignment, $filter) {
            $this->name = $name;
            $this->width = $width;
            $this->row = $row;
            $this->alignment = $alignment;
            $this->filter = $filter;
        }
    }

    $columns = [
        //nazov stlca, sirka stlpca, udaj z DB, centrovanie textu v hlavicke, filtrovanie
        new TableColumn(__('Číslo'), 60, 'id', 'center', 'cislo'),
        new TableColumn(__('Aktivní'), 60, 'aktivita', 'center', 'vyber'),
        new TableColumn(__('Zkratka'), 140, 'zkratka', 'center', 'retazec'),
        new TableColumn(__('Název'), 320, 'nazev', 'left', 'retazec'),
        new TableColumn(__('Termín ukončení'), 140, 'resi_do', 'center', 'datum'),
        new TableColumn(__('Operace'), 100, '', 'center', ''),
        new TableColumn(__('Typ'), 160, 'typ', 'center', 'retazec'),
        new TableColumn('URL', 250, 'url', 'left', ''),
        new TableColumn(__('Stav'), 100, 'stav', 'center', 'vyber'),
        new TableColumn(__('Vedoucí'), 100, 'vedouci', 'center', 'retazec'),
        new TableColumn(__('Kód'), 80, 'kod', 'center', ''),
        new TableColumn(__('Projekt zadán'), 140, 'zadan', 'center', 'datum'),
        new TableColumn(__('Zahájení řešení'), 140, 'resi_od', 'center', 'datum'),
        new TableColumn(__('Poznámka'), 400, 'poznamka', 'left', ''),
    ];
    
?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/colreorder/1.5.5/js/dataTables.colReorder.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.colVis.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<script>
    $(document).ready(function () {
        var table = $('#riesene-projekty-tabulka').DataTable({
            dom: 'Blrtip',
            orderCellsTop: true,
            colReorder: true, // Povolí preťahovánie stlpcov
            lengthMenu: [5, 10, 25, 50, 100],
            language: {
                lengthMenu: '{{ __("Zobrazit _MENU_ položek") }}',
                info: '{{__("Zobrazuje se _START_ až _END_ z _TOTAL_ záznamů")}}',
                paginate: {
                    previous: "<",
                    next: ">"
                }
            },
            columnDefs: [{ 
                orderable: false, // Nastavenie, že stlpec nebude raditeľný
                targets: 5 // Index sloupce (počítání od 0)
            }],
            buttons: [
                {
                extend: 'colvis', // Zobrazenie vybranych stlpcou
                text: '{{__("výběr zobrazených sloupců")}} '
            }]
            
        
        });

        var sortingState = []; // Uchovává stav radenia pre každý stlpec

        $('#riesene-projekty-tabulka thead th').each(function (index) {
            $(this).append('<span class="sorting-status" style="float:right"></span>'); // Pridanie miesta pre popis stavu radenia
        });
        
        sortingState[0] = 'asc'; // Nastavenie predvoleného radenia pre prvý stĺpec
        $('#riesene-projekty-tabulka thead th:eq(' + 0 + ')').find('.sorting-status').html('1'); // Priradenie popisu 1 pre prvý stĺpec

        $('#riesene-projekty-tabulka thead th').on('click', function () {
            var columnIndex = $(this).index();
            var column = table.column(columnIndex);
            
            // Získanie aktuálneho stavu radenia pre tento stlpec
            var currentOrder = sortingState[columnIndex] || ''; // Pokud stav neni definovaný, použije sa prázdný reťazec

            // Nastavenie radenia pre tento stlpec
            if (currentOrder === '') {
                currentOrder = 'asc'; // Pokud je stav prázdný, nastavíme radenie na vzostupné
            } else if (currentOrder === 'asc') {
                currentOrder = 'desc'; // Pokud je stav vzostupný, nastavíme radenie na zostupné
            } else {
                currentOrder = ''; // Pokud je stav zostupný, vypneme radenie
            }

            sortingState[columnIndex] = currentOrder;

            // Aktualizácia popisu stavu radenia
            var sortingStatus = '';
            if (currentOrder === 'asc') {
                sortingStatus = '1'; // Popis pre vzostupné radenie
            } else if (currentOrder === 'desc') {
                sortingStatus = '2'; // Popis pre zostupné radenie
            } else {
                sortingStatus = ''; // Popis pre vypnuté radenie
            }
            $(this).find('.sorting-status').html(sortingStatus);


            // Vytvorenie pola s nastavením radenia pre všechny stlpce
            var orderArray = [];
            for (var i = 0; i < sortingState.length; i++) {
                if (sortingState[i]) {
                    orderArray.push([i, sortingState[i]]);
                }
            }

            // Radenie podla viacerých stlpcov
            table.order(orderArray).draw();
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
                    var tdAktivity = $(this).find('td:eq(' + indexAktivity + ')');
                    var cisloAktivity = tdAktivity.text().trim(); // Číslo aktivity
                    tdAktivity.css('font-weight', '700');

                    if (aktivitaResitele[cisloAktivity] === 'neaktivni'){
                        var textAktivity = "Ne"; // Text aktivity
                        tdAktivity.css('color', 'red'); // Červená barva textu pro hodnotu 'Ne'
                    } 
                    else if (aktivitaResitele[cisloAktivity] === 'aktivni') {
                        var textAktivity = "Ano";
                        tdAktivity.css('color', '#13bd00'); // Zelená barva textu pro ostatní hodnoty
                    }
                    tdAktivity.text(textAktivity);
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
            <?php echo vygenerujTabulku($id_tabulky, $columns, $projekty, $colFilter);?>   
        </div> 
    </div>
@endsection