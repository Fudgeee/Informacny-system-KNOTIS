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
    // function zobrazenieStlpov($stlpce){

    // }

    function vygenerujZahlavieTabulky($columns) {
        echo '<thead><tr>';
        
        foreach ($columns as $column) {
            //$sirka = isset($column->width) ? $column->width : '';
            echo '<th class="projekty-table-thead-th" style="width:'.$column->width.'px">'.$column->name.'</th>';
        }
        
        echo '</tr>';
        
        // Vložte riadok s filtrom pod každým stĺpcom
        echo '<tr>';
        foreach ($columns as $index =>$column) {
            echo '<td>';
            
            // Vykreslite filter na základe typu filtra
            switch ($column->filter) {
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
    

    function vygenerujTeloTabulky($columns, $obsah){
        echo '<tbody class="projekty-table-td">';

        foreach($obsah as $riadok){
            echo '<tr>';
        
            foreach($columns as $column){
                // Overenie, či objekt má vlastnosť, pred jej použitím
                if(property_exists($riadok, $column->row)) {
                    // Získanie hodnoty zarovnania pre aktuálny stĺpec
                    $zarovnanie = isset($column->alignment) ? $column->alignment : 'l';
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
                    echo '">'. $riadok->{$column->row} .'</td>';
                } else {
                    // Ak vlastnosť neexistuje, vytvorte prázdny stĺpec
                    echo '<td></td>';
                }
                
            }
            echo '</tr>';
        }

        echo '</tbody>';
    }

    function vygenerujTabulku($id_tabulky, $columns, $obsah){
        echo '<table id="'.$id_tabulky.'" style="border:2px solid black">';

        vygenerujZahlavieTabulky($columns);
        vygenerujTeloTabulky($columns, $obsah);

        echo '</table>';
    }