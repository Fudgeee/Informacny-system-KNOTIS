<!--pracovne vykazy-->
<?php
    function generujPolozkyVyberuProjektu($moznosti,$zvolena){
        $vysledek = '';
        
        foreach ($moznosti as $idMoznosti => $moznost){  // přidávání jednotlivých položek
            if ($zvolena == $idMoznosti)
            {  // pokud má být tato možnost zvolená
            $vysledek .= "<option value=\"$idMoznosti\" selected>$moznost</option>";
            }
            else
            {  // pokud tato možnost nemá být zvolená
            $vysledek .= "<option value=\"$idMoznosti\">$moznost</option>";
            }
        }  // přidávání jednotlivých položektyzden
        return $vysledek;
    }

    $tyzdneVypis = array_unique($tyzdne);
    function generujTyzdne($moznosti,$zvolena){
        $vysledek = '';
        foreach ($moznosti as $idMoznosti => $moznost){  // přidávání jednotlivých položek
            if ($zvolena == $idMoznosti)
            {  // pokud má být tato možnost zvolená
            $vysledek .= "<option value=\"$idMoznosti\" selected>$moznost</option>";
            }
            else
            {  // pokud tato možnost nemá být zvolená
            $vysledek .= "<option value=\"$idMoznosti\">$moznost</option>";
            }
        }  // přidávání jednotlivých položek
        return $vysledek;
    }

?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectProjekt = document.getElementById('nastavProjekt');
        const vybranyProjekt = document.getElementById('vybranyProjekt');
        const vybranyProjektText = document.getElementById('vybranyProjektText');
        const vybranaMoznost = selectProjekt.options[selectProjekt.selectedIndex];
        vybranyProjekt.value = vybranaMoznost.textContent;
        vybranyProjektText.value = vybranaMoznost.textContent;
        vybranyProjekt.style.width = (vybranyProjekt.value.length + 2) + 'ch';
        vybranyProjektText.style.width = (vybranyProjektText.value.length + 2) + 'ch';

            selectProjekt.addEventListener('change', function() {
                const vybranaMoznost = selectProjekt.options[selectProjekt.selectedIndex];
                vybranyProjekt.value = vybranaMoznost.textContent;
                vybranyProjektText.value = vybranaMoznost.textContent;
                vybranyProjekt.style.width = (vybranyProjekt.value.length + 2) + 'ch';
                vybranyProjektText.style.width = (vybranyProjektText.value.length + 2) + 'ch';
            });




        const aktualnyTyzden = {{ $aktualnyTyzden }};
        const selectTyzden = document.getElementById('nastavTyzden'); 
        const predminulyButton = document.getElementById("nastavTydenTlacPredminuly");
        const minulyButton = document.getElementById("nastavTydenTlacMinuly");
        const soucasnyButton = document.getElementById("nastavTydenTlacSoucasny");
        const vybranyTyzden = document.getElementById('vybranyTyzden');
        const vybranyTyzdenText = document.getElementById('vybranyTyzdenText');
        const idTyzdna = document.getElementById('idTyzdna');

        const updateVybranyTyzden = () => {
            const vybranaMoznost1 = selectTyzden.options[selectTyzden.selectedIndex];
            idTyzdna.value = selectTyzden.selectedIndex + 1;
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



        //



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



        
});






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
                        <label for="zoznam_projektov" style="width:70px">{{__('Projekt')}}:</label>
                        <select name="zoznam_projektov" id="nastavProjekt" title="{{__('Projekt, na kterém byla práce odpracována')}}" size="1">
                            <?php echo generujPolozkyVyberuProjektu($projektNazov,$projektNazov[0]);?>
                        </select>
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                </div>
            </form>
            <form action="{{route('update_pracovne_vykazy_tyzden')}}" method="post">
                @csrf
                <div class="osobne_info_l">
                    <div class="pracovne-vykazy-item">
                        <label for="zoznam_tyzdnov" style="width:70px">{{__('Týden')}}:</label>
                        <select name="zoznam_tyzdnov" id="nastavTyzden" title="{{__('Projekt, na kterém byla práce odpracována')}}" size="1">
                            <?php echo generujTyzdne($tyzdneVypis,$aktualnyTyzden);?>
                        </select>
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                        <input type="submit" id="nastavTydenTlacPredminuly" class="denny_vykaz_btns" name="nastavTydenTlacPredminuly" title="{{ __('Nastavit předminulý týden a zvolený projekt') }}" value="{{ __('předminulý') }}">
                        <input type="submit" id="nastavTydenTlacMinuly" class="denny_vykaz_btns" name="nastavTydenTlacMinuly" title="{{ __('Nastavit minulý týden a zvolený projekt') }}" value="{{ __('minulý') }}">
                        <input type="submit" id="nastavTydenTlacSoucasny" class="denny_vykaz_btns" name="nastavTydenTlacSoucasny" title="{{ __('Nastavit současný týden a zvolený projekt') }}" value="{{ __('současný') }}">
                    </div>
                </div>
            </form>
            <div class="medzera"></div>
            <hr class="hr-pracovne-vykazy">
            <form action="{{route('update_pracovne_vykazy_denny')}}" method="post">
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
                    </div>
                    <div class="pracovne-vykazy-item">
                        <label for="datumVykazu" style="width:70px">{{__('Datum')}}:</label>
                        <input type="datetime-local" id="datumVykazu" name="datumVykazu" value="{{ \Carbon\Carbon::now('Europe/Prague')->format('Y-m-d\TH:i') }}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="pracovne-vykazy-item">
                        <label for="casVykazuOd" style="width:70px">{{__('Čas: od')}}:</label>
                        <input type="time" id="casVykazuOd" name="casVykazuOd" style="margin-right:8px">
                        <label for="casVykazuDo">{{__('do')}}:</label>
                        <input type="time" id="casVykazuDo" name="casVykazuDo" value="{{ \Carbon\Carbon::now('Europe/Prague')->format('H:i') }}" style="margin-right:8px">
                        <label for="upravHodin">{{__('Odpracováno')}}:</label>
                        <input type="text" size="2" maxlength="10" id="upravHodin" name="upravHodin" title="{{ __('Počet odpracovaných hodin')}}">
                        <span>:</span>
                        <input type="text" size="2" maxlength="10" id="upravMin" name="upravMin" title="{{ __('Počet odpracovaných minut')}}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="pracovne-vykazy-item">
                        <label for="upravCinnost" style="width:70px" class="pracovne-vykazy-item-cinnost">{{__('Činnost')}}:</label>
                        <textarea name="upravCinnost" id="upravCinnost" title="{{__('Činnost')}}" cols="77" rows="7"></textarea>
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="pracovne-vykazy-item">
                        <label for="upravNesouvisiSP" class="pracovne-vykazy-item-cinnost">{{__('Činnost nesouvisí přímo s projektem')}}:</label>
                        <input type="checkbox" name="upravNesouvisiSP" id="upravNesouvisiSP" title="{{__('Činnost nesouvisí přímo s projektem')}}">
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
                        <input type="text" id="vybranyProjektText" name="vybranyProjektText" readonly>
                    </div>
                    <div class="pracovne-vykazy-item">
                        <input type="text" id="vybranyTyzdenText" name="vybranyTyzdenText" readonly>
                    </div>
                    <div class="pracovne-vykazy-item">
                        <label for="upravSouhrn" style="width:100px;float:left" class="pracovne-vykazy-item-cinnost">{{__('Souhrn')}}:</label>
                        <textarea name="upravSouhrn" id="upravSouhrn" title="{{__('Souhrn')}}" cols="75" rows="10"></textarea>
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="pracovne-vykazy-item">
                        <label for="upravPlan" style="width:100px;float:left" class="pracovne-vykazy-item-cinnost">{{__('Plán')}}:</label>
                        <textarea name="upravPlan" id="upravPlan" title="{{__('Plán na příští týden')}}" cols="75" rows="3"></textarea>
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="pracovne-vykazy-item">
                        <label for="upravProblemy" class="pracovne-vykazy-item-cinnost" style="float:left;width:100px">{{__('Problémy a nejasnosti')}}:</label>
                        <textarea name="upravProblemy" id="upravProblemy" style="float:left;margin-right:5px" title="{{__('Problémy a nejasnosti')}}" cols="50" rows="4"></textarea>
                        <span class="pracovne-vykazy-item-cinnost" style="display:inline-block;width:200px">{{__('(nemáte-li problémy, ponechte prázdné)')}}</span>
                        <input type="submit" id="odeslatProblemyTlac" name="odesliProblemy" title="{{__('Uložit a odeslat problémy (pokud problémy brání v pokračování v práci)')}}" value="{{__('Odeslat problémy')}}" class="btn btn-block btn-primary">
                    </div>
                    <div class="pracovne-vykazy-item" style="clear:both">
                        <label for="upravOmluvy" class="pracovne-vykazy-item-cinnost" style="width:95px">{{__('Omluvy a výmluvy')}}:</label>
                        <textarea name="upravOmluvy" id="upravOmluvy" title="{{__('Omluvy a výmluvy')}}" cols="75" rows="3"></textarea>
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
                        <a href="" class="btn btn-block btn-primary" style="width:250px" >{{__('Import výkazů ze souboru')}}</a> <!-- TODO FUNKCIONALITA-->
                        <button type="submit" id="odeslatTVTlac" name="odesliTVykaz" style="width:140px; display:inline-block; margin:0; margin-left:30px" class="btn btn-block btn-primary" title="{{__('Odeslat výkaz (výkaz za tento týden dokončen, pokud výkaz neodešlete do pondělí následujícího týdne, bude v úterý zaslán automaticky)')}}">{{__('Odeslat výkaz')}}</button> <!-- TODO odoslat automaticky X hodin po termine podla konfiguracie-->
                    </div>
                </div>
                <div class="medzera"></div>
                <div class="medzera"></div> 
                <hr class="hr-pracovne-vykazy">
                <div class="osobne_info_l">
                    <h2>{{__('Pracovní výkazy')}}:</h2>
                    <div class="medzera"></div>
                    <div class="pracovne-vykazy-item">
                        <!-- TODO TABULKA-->
                    </div>
                </div>
            </form>
        </div>
        <div class="medzera"></div>
    </div><!-- TODO sirka textov kontrola pri ANJ vsade -->
@endsection