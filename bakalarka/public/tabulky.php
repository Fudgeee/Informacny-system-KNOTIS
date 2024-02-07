<!-- // JavaScript pre filtrovanie tabuľky -->
<script>
    $(document).ready(function() {
        $('.filter-input, .filter-select').on('input', function () { // Zmena na 'input'
            var column = parseInt($(this).data('column')); // Prevod na celé číslo
            var value = $(this).val().trim();

            // Aktualizovať zobrazenie tela tabuľky
            $('tbody tr').hide();
            $('tbody tr').filter(function () {
                var cellValue = $(this).find('td').eq(column).text().trim();
                return cellValue.indexOf(value) !== -1;
            }).show();
        });
    

    
});
</script>


<?php
    function zobrazenieStlpov($stlpce){

    }

    function vygenerujZahlavieTabulky($nazvy_stlpcov, $sirka_stlpcov, $filters) {
        echo '<thead><tr>';
        
        foreach ($nazvy_stlpcov as $index => $nazov_stlpca) {
            $sirka = isset($sirka_stlpcov[$index]) ? $sirka_stlpcov[$index] : '';
            echo '<th class="projekty-table-thead-th" style="width:'.$sirka.'px">'.$nazov_stlpca.'</th>';
        }
        
        echo '</tr>';
        
        // Vložte riadok s filtrom pod každým stĺpcom
        echo '<tr>';
        foreach ($filters as $index => $filter) {
            echo '<td>';
            
            // Vykreslite filter na základe typu filtra
            switch ($filter) {
                case 's': // Filtrovanie hodnoty v stĺpci
                    echo '<input type="text" class="filter-input" data-column="'.$index.'" placeholder="Filter">';
                    break;
                case 'v': // Filtrovanie podľa výberu možností
                    echo '<select class="filter-select" data-column="'.$index.'"><option value="">All</option><option value="value1">Value 1</option><option value="value2">Value 2</option></select>';
                    break;
                case 'd': // Filtrovanie hodnoty v stĺpci
                    echo '&lt&nbsp <input type="text" class="filter-input" style="width:86%" data-column="'.$index.'" placeholder="Filter">';
                    echo '&gt&nbsp <input type="text" class="filter-input" style="width:86%" data-column="'.$index.'" placeholder="Filter">';
                    break;
                default:
                    echo ''; // Žiadny filter
                    break;
            }
            
            echo '</td>';
        }
        echo '</tr>';
        
        echo '</thead>';
    }
    

    function vygenerujTeloTabulky($riadky, $obsah, $zarovnanieTela){
        echo '<tbody class="projekty-table-td">';

        foreach($obsah as $riadok){
            echo '<tr>';
        
            foreach($riadky as $index => $stlpec){
                // Overenie, či objekt má vlastnosť, pred jej použitím
                if(property_exists($riadok, $stlpec)) {
                    // Získanie hodnoty zarovnania pre aktuálny stĺpec
                    $zarovnanie = isset($zarovnanieTela[$index]) ? $zarovnanieTela[$index] : 'l';
                    // Nastavenie štýlu v závislosti od hodnoty zarovnania
                    echo '<td class="" style="text-align: ';
                    if($zarovnanie == 'c') {
                        echo 'center';
                    }
                    elseif($zarovnanie == 'l') {
                        echo 'left';
                    }
                    elseif($zarovnanie == 'r') {
                        echo 'right';
                    }
                    else {
                        echo 'left'; // Predvolené zarovnanie
                    }
                    echo '">'.$riadok->$stlpec.'</td>';
                } else {
                    // Ak vlastnosť neexistuje, vytvorte prázdny stĺpec
                    echo '<td></td>';
                }
                
            }
            echo '</tr>';
        }

        echo '</tbody>';
    }

    function vygenerujTabulku($id_tabulky, $nazvy_stlpcov, $sirka_stlpcov, $riadky, $zarovnanieTela, $obsah, $filters){
        echo '<table id="'.$id_tabulky.'" style="border:2px solid black">';

        vygenerujZahlavieTabulky($nazvy_stlpcov, $sirka_stlpcov, $filters);
        vygenerujTeloTabulky($riadky, $obsah, $zarovnanieTela);

        echo '</table>';
    }