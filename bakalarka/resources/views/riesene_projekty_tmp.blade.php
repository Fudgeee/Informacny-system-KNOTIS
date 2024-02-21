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
        new TableColumn(__('Číslo'), 60, 'id', 'c', 's'),
        new TableColumn(__('Aktivní'), 60, 'aktivita', 'c', 'v'),
        new TableColumn(__('Zkratka'), 140, 'zkratka', 'c', 's'),
        new TableColumn(__('Název'), 320, 'nazev', 'l', 's'),
        new TableColumn(__('Termín ukončení'), 140, 'resi_do', 'c', 'd'),
        new TableColumn(__('Operace'), 100, '', 'c', ''),
        new TableColumn(__('Typ'), 160, 'typ', 'c', 's'),
        new TableColumn('URL', 250, 'url', 'l', ''),
        new TableColumn(__('Stav'), 100, 'stav', 'c', 'v'),
        new TableColumn(__('Vedoucí'), 100, 'vedouci', 'c', 's'),
        new TableColumn(__('Kód'), 80, 'kod', 'c', ''),
        new TableColumn(__('Projekt zadán'), 140, 'zadan', 'c', 'd'),
        new TableColumn(__('Zahájení řešení'), 140, 'resi_od', 'c', 'd'),
        new TableColumn(__('Poznámka'), 400, 'poznamka', 'l', ''),
    ];
    //dd($stlpce_tabulky[0]);
    // $nazvy_stlpcov = array(
    //     __('Číslo'),
    //     __('Aktivní'),
    //     __('Zkratka'),
    //     __('Název'),
    //     __('Termín ukončení'),
    //     __('Operace'),
    //     __('Typ'),
    //     'URL',
    //     __('Stav'),
    //     __('Vedoucí'),
    //     __('Kód'),
    //     __('Projekt zadán'),
    //     __('Zahájení řešení'),
    //     __('Poznámka')
    // );
    // $sirka_stlpcov = array(60,60,140,320,140,100,160,250,100,100,80,140,140,400);
    // $riadky = array('id','aktivita','zkratka','nazev','resi_do','','typ','url','stav','vedouci','kod','zadan','resi_od','poznamka');
    // $zarovnanieTela = array('c','c','c','l','c','c','c','l','c','c','c','c','c','l');
    // $filters = ['s','v','s','s','d','','s','','v','s','','d','d',''];
    //$links = array('','','detail_projektu/');
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
            colReorder: true, // Povolí přetahování sloupců
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
                orderable: false, // Nastavení, že sloupec nebude řaditelný
                targets: 5 // Index sloupce (počítání od 0)
            }],
            buttons: [
                {
                extend: 'colvis', // Zobrazenie vybranych sloupcu
                text: '{{__("výběr zobrazených sloupců")}} '
            }]
            
        
        });

        var sortingState = []; // Uchovává stav řazení pro každý sloupec

        $('#riesene-projekty-tabulka thead th').each(function (index) {
            $(this).append('<span class="sorting-status" style="float:right"></span>'); // Pridanie miesta pre popis stavu radenia
        });
        
        sortingState[0] = 'asc'; // Nastavenie predvoleného radenia pre prvý stĺpec
        $('#riesene-projekty-tabulka thead th:eq(' + 0 + ')').find('.sorting-status').html('1'); // Priradenie popisu 1 pre prvý stĺpec

        $('#riesene-projekty-tabulka thead th').on('click', function () {
            var columnIndex = $(this).index();
            var column = table.column(columnIndex);
            
            // Získání aktuálního stavu řazení pro tento sloupec
            var currentOrder = sortingState[columnIndex] || ''; // Pokud stav není definován, použije se prázdný řetězec

            // Nastavení řazení pro tento sloupec
            if (currentOrder === '') {
                currentOrder = 'asc'; // Pokud je stav prázdný, nastavíme řazení na vzestupné
            } else if (currentOrder === 'asc') {
                currentOrder = 'desc'; // Pokud je stav vzestupný, nastavíme řazení na sestupné
            } else {
                currentOrder = ''; // Pokud je stav sestupný, vypneme řazení
            }

            sortingState[columnIndex] = currentOrder;

            // Aktualizácia popisu stavu radenia
            var sortingStatus = '';
            if (currentOrder === 'asc') {
                sortingStatus = '1'; // Popis pre vzostupné radenie
            } else if (currentOrder === 'desc') {
                sortingStatus = '2'; // Popis pre zostupné radenie
            } else {
                sortingStatus = '3'; // Popis pre vypnuté radenie
            }
            $(this).find('.sorting-status').html(sortingStatus);


            // Vytvoření pole s nastavením řazení pro všechny sloupce
            var orderArray = [];
            for (var i = 0; i < sortingState.length; i++) {
                if (sortingState[i]) {
                    orderArray.push([i, sortingState[i]]);
                }
            }

            // Řazení podle více sloupců
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
            <?php echo vygenerujTabulku($id_tabulky, $columns, $projekty);?>   
        </div> 
    </div>
@endsection