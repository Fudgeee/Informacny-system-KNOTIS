<!--pracovne vykazy-->
<?php
    function generujPolozkyVyberuProjektu($moznosti,$zvolena,$vybranyProjektNazov){
        $vysledek = '';
        
        foreach ($moznosti as $idMoznosti => $moznost){  // přidávání jednotlivých položek
            if ($vybranyProjektNazov != null ) {
                //$tmp = explode('. ', $moznost, 2);
                if ($vybranyProjektNazov == $moznost) {
                    $vysledek .= "<option value=\"$idMoznosti\" selected>$moznost</option>";
                }
                else {  // pokud tato možnost nemá být zvolená
                    $vysledek .= "<option value=\"$idMoznosti\">$moznost</option>";
                }
            }
            else {
                if($zvolena == $idMoznosti) {  // pokud má být tato možnost zvolená
                    $vysledek .= "<option value=\"$idMoznosti\" selected>$moznost</option>";
                }
                else {  // pokud tato možnost nemá být zvolená
                    $vysledek .= "<option value=\"$idMoznosti\">$moznost</option>";
                }
            }
        }  // přidávání jednotlivých položektyzden
        return $vysledek;
    }

    $tyzdneVypis = array_unique($tyzdne);
    function generujTyzdne($moznosti,$zvolena,$vybranyTyzdenNazov){
        $vysledek = '';
        foreach ($moznosti as $idMoznosti => $moznost){  // přidávání jednotlivých položek
            if ($vybranyTyzdenNazov != null ) {
                if ($vybranyTyzdenNazov == $moznost) {
                    $vysledek .= "<option value=\"$idMoznosti\" selected>$moznost</option>";
                }
                else {  // pokud tato možnost nemá být zvolená
                    $vysledek .= "<option value=\"$idMoznosti\">$moznost</option>";
                }
            }
            else {
                if ($zvolena == $idMoznosti) {  // pokud má být tato možnost zvolená
                $vysledek .= "<option value=\"$idMoznosti\" selected>$moznost</option>";
                }
                else {  // pokud tato možnost nemá být zvolená
                $vysledek .= "<option value=\"$idMoznosti\">$moznost</option>";
                }
            }
        }  // přidávání jednotlivých položek
        return $vysledek;
    }

    function vypisZoznamVykazov($denny){
        $idVykazu = $denny->id_vykazu;
        $datumCarbon = \Carbon\Carbon::parse($denny->datum); // prevod na Carbon objekt
        $datumUpraveny = $datumCarbon->isoFormat('D.M.Y');
        $casOdUpraveny = \Carbon\Carbon::parse($denny->cas_od)->format('H:i');
        $casDoUpraveny = \Carbon\Carbon::parse($denny->cas_do)->format('H:i');
        $hodiny = intdiv($denny->minut, 60);
        $minuty = ($denny->minut % 60);
        $zaokruhleneMinuty = sprintf("%02d", $minuty);
        $tmp = $denny->nesouvisi_sp;
        if ($tmp == 0){
            $suvisi = 'A';
        }
        else{
            $suvisi = 'N';
        }
        $vysledek = '';
        $vysledek = '<tr data-record-id="'.$idVykazu.'"><td style="border-left: black solid 3px;width:150px">'.$datumUpraveny.'</td><td style="width:65px;text-align:center">'.$hodiny.':'.$zaokruhleneMinuty.'</td><td style="width:60px">'.$casOdUpraveny.'</td><td style="width:60px">'.$casDoUpraveny.'</td><td style="width:400px">'.$denny->cinnost.'</td><td style="width:150px;text-align:center"><a href="#" onclick="editInput(this);return false;" data-record-id="'.$idVykazu.'"><img src="edit.gif" style="width:23px;margin-right:5px" title="' . __('Upravit') . '" alt="Upravit"/></a><a href="#" class="vymazVykaz" data-record-id="'.$idVykazu.'"><img src="red-x.gif" style="width:20px;margin-left:5px" title="' . __('Vymazat') . '" alt="Vymazat"/></a></td><td style="width:50px;border-right:black solid 3px;text-align:center">'.$suvisi.'</td></tr>';
        return $vysledek;
    }
?>

<script src="{{asset('https://code.jquery.com/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('https://code.jquery.com/ui/1.13.0/jquery-ui.min.js')}}"></script>
<!-- TODO aktulaizovat obsah stranky po zmene projektu/tyzdna -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectProjekt = document.getElementById('nastavProjekt');
        const vybranyProjekt = document.getElementById('vybranyProjekt');
        const vybranyProjektText = document.getElementById('vybranyProjektText');
        const vybranaMoznost = selectProjekt.options[selectProjekt.selectedIndex];

        //const vybranyProjekt1 = document.getElementById('vybranyProjekt1');

        // const upravSouhrn = document.getElementById('upravSouhrn');

        vybranyProjekt.value = vybranaMoznost.textContent;
        vybranyProjektText.value = vybranaMoznost.textContent;
        //vybranyProjekt1.value = vybranaMoznost.textContent;
        vybranyProjekt.style.width = (vybranyProjekt.value.length + 2) + 'ch';
        //vybranyProjekt1.style.width = (vybranyProjekt1.value.length + 2) + 'ch';
        vybranyProjektText.style.width = (vybranyProjektText.value.length + 2) + 'ch';

            selectProjekt.addEventListener('change', function() {
                const vybranaMoznost = selectProjekt.options[selectProjekt.selectedIndex];
                vybranyProjekt.value = vybranaMoznost.textContent;
                //vybranyProjekt1.value = vybranaMoznost.textContent;
                vybranyProjektText.value = vybranaMoznost.textContent;
                vybranyProjekt.style.width = (vybranyProjekt.value.length + 2) + 'ch';
                //vybranyProjekt1.style.width = (vybranyProjekt1.value.length + 2) + 'ch';
                vybranyProjektText.style.width = (vybranyProjektText.value.length + 2) + 'ch';


                // const cislo = vybranyProjekt.value.split('.')[0];
                // upravSouhrn.value = cislo;
                // console.log(vybranyProjekt.value);
            });




        const aktualnyTyzden = {{ $aktualnyTyzden }};
        const selectTyzden = document.getElementById('nastavTyzden'); 
        const predminulyButton = document.getElementById("nastavTydenTlacPredminuly");
        const minulyButton = document.getElementById("nastavTydenTlacMinuly");
        const soucasnyButton = document.getElementById("nastavTydenTlacSoucasny");
        const vybranyTyzden = document.getElementById('vybranyTyzden');
        const vybranyTyzdenText = document.getElementById('vybranyTyzdenText');
        const idTyzdna = document.getElementById('idTyzdna');
        const idTyzdna1 = document.getElementById('idTyzdna1');


        const updateVybranyTyzden = () => {
            const vybranaMoznost1 = selectTyzden.options[selectTyzden.selectedIndex];
            idTyzdna.value = selectTyzden.selectedIndex + 1;
            idTyzdna1.value = selectTyzden.selectedIndex + 1;
            vybranyTyzden.value = vybranaMoznost1.textContent;
            vybranyTyzdenText.value = vybranaMoznost1.textContent;
            vybranyTyzden.style.width = (vybranyTyzden.value.length + 2) + 'ch';
            vybranyTyzdenText.style.width = (vybranyTyzdenText.value.length + 2) + 'ch';
            };

        predminulyButton.addEventListener("click", function(event) {
            event.preventDefault(); // Prevent form submission
            selectTyzden.value = aktualnyTyzden - 2;
            updateVybranyTyzden();
        });

        minulyButton.addEventListener("click", function(event) {
            event.preventDefault(); // Prevent form submission
            selectTyzden.value = aktualnyTyzden - 1;
            updateVybranyTyzden();
        });

        soucasnyButton.addEventListener("click", function(event) {
            event.preventDefault(); // Prevent form submission
            selectTyzden.value = aktualnyTyzden; // Replace with your actual value
            updateVybranyTyzden();
        });

        selectTyzden.addEventListener('change', updateVybranyTyzden);
                // Initial update when the page loads
        updateVybranyTyzden();

      

        // vypocet odpracovanych hodin a minut
        const casVykazuOd = document.getElementById('casVykazuOd');
        const casVykazuDo = document.getElementById('casVykazuDo');
        const upravHodin = document.getElementById('upravHodin');
        const upravMin = document.getElementById('upravMin');
        
        // Přidej posluchače událostí pro casVykazuOd a casVykazuDo
        if(casVykazuOd !== null && casVykazuOd !== undefined){
            casVykazuOd.addEventListener('change', vypocetDoby);
        }
        if(casVykazuDo !== null && casVykazuDo !== undefined){
            casVykazuDo.addEventListener('change', vypocetDoby);
        }
        function vypocetDoby() {
            const casOd = casVykazuOd.value.split(':');
            const casDo = casVykazuDo.value.split(':');
            const hodinyOd = parseInt(casOd[0], 10);
            const minutyOd = parseInt(casOd[1], 10);
            const hodinyDo = parseInt(casDo[0], 10);
            const minutyDo = parseInt(casDo[1], 10);

            let rozdilHodin = hodinyDo - hodinyOd;
            let rozdilMinut = minutyDo - minutyOd;

            if (rozdilMinut < 0) {
                rozdilHodin--;
                rozdilMinut += 60;
            }

            // Ošetření pro přesun přes půlnoc
            if (rozdilHodin < 0) {
                rozdilHodin += 24;
            }

            upravHodin.value = rozdilHodin;
            upravMin.value = rozdilMinut;
            const CelkovoMinut = (rozdilHodin*60) + rozdilMinut;
        };
        


        // aktualizovanie hodnoty casu v datume denneho vykazu
        const datumVykazu = document.getElementById('datumVykazu');

        casVykazuDo.addEventListener('change', function() {
            const casVykazuDoValue = casVykazuDo.value;
            const aktualniDatum = new Date();
            const rok = aktualniDatum.getFullYear();
            const mesic = (aktualniDatum.getMonth() + 1).toString().padStart(2, '0');
            const den = aktualniDatum.getDate().toString().padStart(2, '0');
            const aktualniCas = `${rok}-${mesic}-${den}T${casVykazuDoValue}`;
            datumVykazu.value = aktualniCas;
        });



        // Funkcia na výpočet celkových hodín v pracovných výkazoch

        function spocitajCelkoveHodiny() {
        let sumaMinut = 0;

        const tbody = document.querySelector("#vykazy-tabulka tbody");
        const riadky = tbody.querySelectorAll("tr");

        for (let i = 0; i < riadky.length; i++) {
            const riadok = riadky[i];
            const hodinyStlpec = riadok.querySelector("td:nth-child(2)");
            const hodinyMinuty = hodinyStlpec.textContent.split(':');

            const hodiny1 = parseInt(hodinyMinuty[0], 10);
            const minuty = parseInt(hodinyMinuty[1], 10);
            

            if (!isNaN(hodiny1)) {
            sumaMinut += hodiny1 * 60;
            }

            if (!isNaN(minuty)) {
            sumaMinut += minuty;
            }
            
        }

        const celkoveHodinyInput = document.getElementById("celkoveHodiny");
        
        // Vypočítame celkové hodiny a minúty získané z celkového počtu minút
        const sumaHodin = Math.floor(sumaMinut / 60);
        const zostavajuceMinuty = sumaMinut % 60;
        let zaokruhleneZostavajuceMinuty = String(zostavajuceMinuty).padStart(2, '0');

        celkoveHodinyInput.value = `${sumaHodin}:${zaokruhleneZostavajuceMinuty}`;

        celkoveHodinyInput.setAttribute("readonly", true);
        }

        window.addEventListener("load", spocitajCelkoveHodiny);
        document.querySelector("#vykazy-tabulka").addEventListener("input", spocitajCelkoveHodiny);


        // Vymazanie pracovneho vykazu z tabulky
        document.querySelectorAll('.vymazVykaz').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const recordId = this.getAttribute('data-record-id');
                const confirmed = confirm('{{__("Opravdu chcete smazat tento výkaz?")}}');

                if (confirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '/delete-vykaz',
                        data: {
                            id: recordId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (data) {
                            const removedRow = $(`tr[data-record-id=${recordId}]`);
                            removedRow.remove();
                            spocitajCelkoveHodiny();
                            //alert('Výkaz bol úspešne vymazaný.');
                        },
                        error: function (error) {
                            console.error('{{__("Chyba při mazání výkazu:")}}', error);
                            alert('{{__("Chyba při mazání výkazu")}}');
                        }
                    });
                }
            });
        });
        


        
});
    // Uprava denneho vykazu
    function editInput(element) {
        const recordId1 = element.getAttribute('data-record-id');
        // Získame informácie o dennom výkaze zo značky <tr>
        const row = element.closest('tr');
        const datum = row.cells[0].innerText;
        const hodin = row.cells[1].innerText;
        const od = row.cells[2].innerText;
        const doo = row.cells[3].innerText;
        const datumParts = datum.split('.');
        const timeParts1 = doo.split(':');
        const timeParts2 = od.split(':');
        let formattedDatum = `${datumParts[2]}-${datumParts[1].padStart(2, '0')}-${datumParts[0].padStart(2, '0')}T${timeParts1[0].padStart(2, '0')}:${timeParts1[1].padStart(2, '0')}`;
        const cinnost = row.cells[4].innerText;
        let nesouvisiSP = row.cells[6].innerText === 'A' ? 0 : 1;
    
        const time1 = parseInt(timeParts1[0].padStart(2, '0')) * 60 + parseInt(timeParts1[1].padStart(2, '0'));
        const time2 = parseInt(timeParts2[0].padStart(2, '0')) * 60 + parseInt(timeParts2[1].padStart(2, '0'));
        let rozdiel1 = Math.floor((time1 - time2) / 60); // hodiny
        let rozdiel2 = (time1 - time2) % 60; // minuty

        if (rozdiel2 < 0) {
            rozdiel2 += 60;
            rozdiel1 --;
        }
        if (rozdiel1 < 0) {
            rozdiel1 += 24;
        }
    
        // Nastavíme hodnoty do formulára
        document.getElementById('datumVykazu').value = formattedDatum;
        document.getElementById('casVykazuOd').value = od;
        document.getElementById('casVykazuDo').value = doo;
        document.getElementById('upravHodin').value = rozdiel1;
        document.getElementById('upravMin').value = rozdiel2;
        document.getElementById('upravCinnost').value = cinnost;
        document.getElementById('upravNesouvisiSP').checked = nesouvisiSP === 1;
        document.getElementById('vykazId').value = recordId1;  
        
        //document.getElementById('formular-denny').scrollIntoView({ behavior: 'smooth' });
        const formularElement = document.getElementById('formular-denny');
        const formularTop = formularElement.getBoundingClientRect().top + window.scrollY;

        // Nastavit scrollTop tak, aby posunul formulář o 100 pixelů výše
        window.scrollTo({
            top: formularTop - 100,
            behavior: 'smooth'
        });

    }

    
        // AJAX pre zmenu projektu
        // $('#nastavProjekt').change(function() {
        //     var vybranyProjekt = $(this).val();

        //     $.ajax({
        //         url: '/pracovne_vykazy_projekt',
        //         method: 'POST',
        //         data: { vybranyProjekt: vybranyProjekt,
        //              _token: '{{ csrf_token() }}' },
        //         success: function(response) {
        //             // Spracujte odpoveď a aktualizujte údaje vo formulári

        //             // Príklad: aktualizujte hodnoty v poliach vo formulári
        //             $('#vybranyProjektText').val(response.udaje.nazevProjektu);
        //             // Ďalšie aktualizácie podľa potreby
        //         },
        //         error: function(error) {
        //             console.error('Chyba pri AJAX požiadavke:', error);
        //         }
        //     });
        // });
    
        // AJAX pre zmenu týždňa
        // $('#nastavTyzden').change(function() {
        //     var vybranyTyzden = $(this).val();

        //     $.ajax({
        //         url: '/aktualizovat-udaje-tyzden',
        //         method: 'POST',
        //         data: { vybranyTyzden: vybranyTyzden, _token: '{{ csrf_token() }}' },
        //         success: function(response) {
        //             // Spracujte odpoveď a aktualizujte údaje vo formulári

        //             // Príklad: aktualizujte hodnoty v poliach vo formulári
        //             $('#vybranyTyzdenText').val(response.udaje.nazevTyzdne);
        //             // Ďalšie aktualizácie podľa potreby
        //         },
        //         error: function(error) {
        //             console.error('Chyba pri AJAX požiadavke:', error);
        //         }
        //     });
        // });
    
</script>

@extends('dashboard')
@section('content')
    <div class="pracovne_vykazy">
        <div class="pracovne_vykazy_l">
            <form action="{{route('update_pracovne_vykazy_projekt')}}" method="post">
                @csrf
                <div class="osobne_info_l">
                    <div class="pracovne-vykazy-h1">
                        <h1>{{__('Pracovní výkazy')}}</h1>
                    </div>
                </div>
                <hr class="hr-pracovne-vykazy">
                <div class="osobne_info_l">
                    <div class="pracovne-vykazy-item">
                        <!--input type="text" id="vybranyProjekt1" name="vybranyProjekt1" readonly-->
                        <label for="nastavProjekt" style="width:70px">{{__('Projekt')}}:</label>
                        <select name="zoznam_projektov" id="nastavProjekt" title="{{__('Projekt, na kterém byla práce odpracována')}}" size="1">
                            <?php echo generujPolozkyVyberuProjektu($projektNazov,$projektNazov[0],$vybranyProjektNazov);?>
                        </select>
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                </div>
            </form>
            <form action="{{route('update_pracovne_vykazy_tyzden')}}" method="post">
                @csrf
                <div class="osobne_info_l">
                    <div class="pracovne-vykazy-item">
                        <label for="nastavTyzden" style="width:70px">{{__('Týden')}}:</label>
                        <select name="zoznam_tyzdnov" id="nastavTyzden" title="{{__('Projekt, na kterém byla práce odpracována')}}" size="1">
                            <?php echo generujTyzdne($tyzdneVypis,$aktualnyTyzden,$vybranyTyzdenNazov);?>
                        </select>
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                        <input type="submit" id="nastavTydenTlacPredminuly" class="denny_vykaz_btns" name="nastavTydenTlacPredminuly" title="{{ __('Nastavit předminulý týden a zvolený projekt') }}" value="{{ __('předminulý') }}">
                        <input type="submit" id="nastavTydenTlacMinuly" class="denny_vykaz_btns" name="nastavTydenTlacMinuly" title="{{ __('Nastavit minulý týden a zvolený projekt') }}" value="{{ __('minulý') }}">
                        <input type="submit" id="nastavTydenTlacSoucasny" class="denny_vykaz_btns" name="nastavTydenTlacSoucasny" title="{{ __('Nastavit současný týden a zvolený projekt') }}" value="{{ __('současný') }}"> <!-- TODO  ked je zakliknute jedno z nich zvyraznit-->
                    </div>
                </div>
            </form>
            <div class="medzera"></div>
            <hr class="hr-pracovne-vykazy">
            <form action="{{route('update_pracovne_vykazy_denny')}}" method="post" id="formular-denny">
                @if(Session::has('success1'))
                    <div class="alert alert-success">{{Session::get('success1')}}</div>
                @endif
                @if(Session::has('fail1'))
                    <div class="alert alert-danger">{{Session::get('fail1')}}</div>
                @endif
                @csrf
                <div class="osobne_info_l">
                    <h2>{{__('Denní výkaz')}}:</h2>
                    <div class="medzera"></div>
                    <div class="pracovne-vykazy-item">
                        <input type="text" id="vybranyProjekt" name="vybranyProjekt" readonly>
                        <input type="text" id="vybranyTyzden" name="vybranyTyzden" readonly>
                        <input type="text" id="idTyzdna" name="idTyzdna" readonly>
                        <input type="hidden" id="vykazId" name="vykazId">
                    </div>
                    <div class="pracovne-vykazy-item">
                        <label for="datumVykazu" style="width:70px">{{__('Datum')}}:</label>
                        <input type="datetime-local" id="datumVykazu" name="datumVykazu" value="{{ $zvolenyDennyVykaz ? $zvolenyDennyVykaz->datum : \Carbon\Carbon::now('Europe/Prague')->format('Y-m-d\TH:i') }}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span> <!-- zmena formatu na iba datum a poradie den.mesiac.rok bez hodin -->
                    </div>
                    <div class="pracovne-vykazy-item">
                        <label for="casVykazuOd" style="width:70px">{{__('Čas: od')}}:</label>
                        <input type="time" id="casVykazuOd" name="casVykazuOd" style="margin-right:8px" value="{{ $zvolenyDennyVykaz ? $zvolenyDennyVykaz->cas_od : '' }}">
                        <label for="casVykazuDo">{{__('do')}}:</label>
                        <input type="time" id="casVykazuDo" name="casVykazuDo" value="{{ $zvolenyDennyVykaz ? $zvolenyDennyVykaz->cas_do : \Carbon\Carbon::now('Europe/Prague')->format('H:i') }}" style="margin-right:8px">
                        <label for="upravHodin" style="margin-left:32px">{{__('Odpracováno')}}:</label>
                        @php
                            $minutes = $zvolenyDennyVykaz ? $zvolenyDennyVykaz->minut : 0;
                            $hours = floor($minutes / 60);
                            $zvysokMinut = $minutes % 60;
                        @endphp
                        <input type="text" size="2" maxlength="10" id="upravHodin" name="upravHodin" title="{{ __('Počet odpracovaných hodin')}}" value="{{ $zvolenyDennyVykaz ? $hours : '' }}">
                        <span>:</span>
                        <input type="text" size="2" maxlength="10" id="upravMin" name="upravMin" title="{{ __('Počet odpracovaných minut')}}" value="{{ $zvolenyDennyVykaz ? $zvysokMinut : '' }}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="pracovne-vykazy-item">
                        <label for="upravCinnost" style="width:70px" class="pracovne-vykazy-item-cinnost">{{__('Činnost')}}:</label>
                        <textarea name="upravCinnost" id="upravCinnost" title="{{__('Činnost')}}" cols="77" rows="7">@if ($zvolenyDennyVykaz != null){{ $zvolenyDennyVykaz->cinnost }}@endif</textarea>
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="pracovne-vykazy-item">
                        <label for="upravNesouvisiSP" class="pracovne-vykazy-item-cinnost">{{__('Činnost nesouvisí přímo s projektem')}}:</label>
                        <input type="checkbox" name="upravNesouvisiSP" id="upravNesouvisiSP" title="{{__('Činnost nesouvisí přímo s projektem')}}" @if ($zvolenyDennyVykaz && $zvolenyDennyVykaz->nesouvisi_sp == 1) checked @endif>
                    </div>
                    <div class="pracovne-vykazy-item">
                        <button type="submit" class="btn btn-block btn-primary">{{__('Uložit')}}</button>
                    </div>
                </div>
            </form>
            <div class="medzera"></div>
            <hr class="hr-pracovne-vykazy">
            <form id="tyzdenny-vykaz" action="{{route('update_pracovne_vykazy_tyzdenny')}}" method="post">
                @if(Session::has('success2'))
                    <div class="alert alert-success">{{Session::get('success2')}}</div>
                @endif
                @if(Session::has('fail2'))
                    <div class="alert alert-danger">{{Session::get('fail2')}}</div>
                @endif
                @csrf           
                <div class="osobne_info_l">
                    <h2>{{__('Týdenní výkaz')}}:</h2>
                    <div class="medzera"></div>
                    <div class="pracovne-vykazy-item">
                        <input type="text" id="vybranyProjektText" name="vybranyProjektText" readonly style="display:block">
                        <input type="text" id="vybranyTyzdenText" name="vybranyTyzdenText" readonly>
                        <input type="text" id="idTyzdna1" name="idTyzdna1" readonly>
                    </div>
                    <div class="pracovne-vykazy-item">
                        <label for="upravSouhrn" style="width:100px;float:left" class="pracovne-vykazy-item-cinnost">{{__('Souhrn')}}:</label>
                        <textarea name="upravSouhrn" id="upravSouhrn" title="{{__('Souhrn')}}" cols="75" rows="10">@if ($tyzdenny_vykaz_db != null){{ $tyzdenny_vykaz_db->souhrn }}@endif</textarea>
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div><!-- TODO - update textov pri zmene tyzdna alebo projektu -->
                    <div class="pracovne-vykazy-item">
                        <label for="upravPlan" style="width:100px;float:left" class="pracovne-vykazy-item-cinnost">{{__('Plán')}}:</label>
                        <textarea name="upravPlan" id="upravPlan" title="{{__('Plán na příští týden')}}" cols="75" rows="3">@if ($tyzdenny_vykaz_db != null){{ $tyzdenny_vykaz_db->plan }}@endif</textarea>
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="pracovne-vykazy-item">
                        <label for="upravProblemy" class="pracovne-vykazy-item-cinnost" style="float:left;width:100px">{{__('Problémy a nejasnosti')}}:</label>
                        <textarea name="upravProblemy" id="upravProblemy" style="float:left;margin-right:5px" title="{{__('Problémy a nejasnosti')}}" cols="50" rows="4">@if ($tyzdenny_vykaz_db != null){{ $tyzdenny_vykaz_db->problemy }}@endif</textarea>
                        <span class="pracovne-vykazy-item-cinnost" style="display:inline-block;width:200px">{{__('(nemáte-li problémy, ponechte prázdné)')}}</span>
                        <input type="submit" id="odeslatProblemyTlac" name="odesliProblemy" title="{{__('Uložit a odeslat problémy (pokud problémy brání v pokračování v práci)')}}" value="{{__('Odeslat problémy')}}" class="btn btn-block btn-primary"><!-- QUESTION - funkcionalita odoslania problemov -->
                    </div>
                    <div class="pracovne-vykazy-item" style="clear:both">
                        <label for="upravOmluvy" class="pracovne-vykazy-item-cinnost" style="width:95px">{{__('Omluvy a výmluvy')}}:</label>
                        <textarea name="upravOmluvy" id="upravOmluvy" title="{{__('Omluvy a výmluvy')}}" cols="75" rows="3">@if ($tyzdenny_vykaz_db != null){{ $tyzdenny_vykaz_db->omluvy }}@endif</textarea>
                    </div>
                    <div class="pracovne-vykazy-item">
                        <button type="submit" id="ulozitTVTlac" name="upravTVykaz" class="btn btn-block btn-primary" style="width:300px; margin-left:10%" title="{{__('Uložit změny v týdenním výkazu (neuloží denní výkaz)')}}">{{__('Uložit pouze týdenní výkaz (bez hodin)')}}</button>
                    </div>
                    <div class="medzera"></div>
                </div>
                <div class="medzera"></div>
                <hr class="hr-pracovne-vykazy">
                <div class="osobne_info_l">
                    <h2>{{__('Odeslání týdenního výkazu')}}:</h2>
                    <div class="medzera"></div>
                    <div class="pracovne-vykazy-item">
                        <a href="/import_vykazov" class="btn btn-block btn-primary" style="width:250px" >{{__('Import výkazů ze souboru')}}</a> <!-- TODO FUNKCIONALITA-->
                        <button type="submit" id="odeslatTVTlac" name="odesliTVykaz" style="width:140px; display:inline-block; margin:0; margin-left:30px" class="btn btn-block btn-primary" title="{{__('Odeslat výkaz (výkaz za tento týden dokončen, pokud výkaz neodešlete do pondělí následujícího týdne, bude v úterý zaslán automaticky)')}}">{{__('Odeslat výkaz')}}</button> <!-- TODO odoslat automaticky X hodin po termine podla konfiguracie--><!-- QUESTION - funkcionalita odoslania TVykazu -->
                    </div>
                </div>
                <div class="medzera"></div>
                <div class="medzera"></div> 
                <hr class="hr-pracovne-vykazy">
                <div class="osobne_info_l">
                    <h2>{{__('Pracovní výkazy')}}:</h2>
                    <div class="medzera"></div>
                    <!-- @if(Session::has('success4'))
                        <div class="alert alert-success">{{Session::get('success4')}}</div>
                    @endif -->
                    <div class="pracovne-vykazy-item">
                        <table id="vykazy-tabulka">
                            <thead>
                                <tr style="border: black solid 3px;border-bottom:black solid 2px">
                                    <th style="width:150px">{{__('Datum')}}</th>
                                    <th style="width:65px">{{__('Hodin')}}</th>
                                    <th style="width:60px">{{__('Od')}}</th>
                                    <th style="width:60px">{{__('Do')}}</th>
                                    <th style="width:400px">{{__('Činnost')}}</th>
                                    <th style="width:150px;text-align:center">{{__('Operace')}}</th>
                                    <th style="width:50px;text-align:center" title="{{__('Činnost souvisí přímo s projektem')}}">{{__('SSP')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($denny_vykaz as $denny): ?>
                                    <?php echo vypisZoznamVykazov($denny); ?><!-- <div class="vykaz-den"></div>  TODO zrusit vsetky divy vo foreach cykloch -->
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr style="border: black solid 3px;border-top:black solid 2px">
                                    <th>Celkem</th>
                                    <td><input type="text" id="celkoveHodiny" name="celkoveHodiny" style="width:100%;text-align:center" readonly></td><!-- vypocet celkovych hodin v danom tyzdni -->
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </form>
        </div>
        <div class="medzera"></div><!-- TODO oznacovanie readonly INPUTOV po kliknuti na ne -->
    </div><!-- TODO sirka textov kontrola pri ANJ vsade -->
@endsection