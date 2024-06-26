<!--OSOBNE INFORMACIE-->
<?php 
    $rodinnyStavTmp = config('nastavenia.rodinnyStav');
    $rodinnyStav = [];
    foreach ($rodinnyStavTmp as $key => $value) {
        $rodinnyStav[$key] = __($value);
    }

    function generujPolozkyVyberuSId($moznosti,$zadna,$zvolena){
        $vysledek = '';
        if ($zadna)
        {  // pokud má být i možnost '-'
            if ($zvolena == '-')
            {  // pokud má být tato možnost zvolená
            $vysledek .= '<option value="-" selected>-</option>';
            }
            else
            {  // pokud tato možnost nemá být zvolená
            $vysledek .= '<option value="-">-</option>';
            }
        }  // pokud má být i možnost '-'
    
        foreach ($moznosti as $idMoznosti => $moznost){  // přidávání jednotlivých položek
            if ($zvolena == $idMoznosti && $zvolena != '-')
            {  // pokud má být tato možnost zvolená
            $vysledek .= "<option value=\"$idMoznosti\" selected>$moznost</option>";
            }
            else
            {  // pokud tato možnost nemá být zvolená
            $vysledek .= "<option value=\"$idMoznosti\">$moznost</option>";
            }
        }  // přidávání jednotlivých položek
        return $vysledek;
    }  // generujPolozkyVyberuSId()

    function plneVyplnenDPP($dppUdaje){
        if($dppUdaje->jmeno == NULL){
            return false;
        }
        if($dppUdaje->prijmeni == NULL){
            return false;
        }
        if($dppUdaje->rodne_prijmeni == NULL){
            return false;
        }
        if($dppUdaje->misto_narozeni == NULL){
            return false;
        }
        if($dppUdaje->datum_narozeni == NULL){
            return false;
        }
        if($dppUdaje->rodne_cislo == NULL){
            return false;
        }
        if(($dppUdaje->cislo_op == NULL) && ($dppUdaje->cislo_pasu == NULL)){
            return false;
        }
        if($dppUdaje->statni_prislusnost == NULL){
            return false;
        }
        if($dppUdaje->cislo_popisne == NULL){
            return false;
        }
        if($dppUdaje->mesto == NULL){
            return false;
        }
        if($dppUdaje->psc == NULL){
            return false;
        }
        if($dppUdaje->zdravotni_pojistovna == NULL){
            return false;
        }
        if($dppUdaje->bankovni_ucet == NULL){
            return false;
        }
        return true;
    }

    function plneVyplnenStip($dppUdaje){
        if($dppUdaje->jmeno == NULL){
            return false;
        }
        if($dppUdaje->prijmeni == NULL){
            return false;
        }
        if($dppUdaje->misto_narozeni == NULL){
            return false;
        }
        if($dppUdaje->datum_narozeni == NULL){
            return false;
        }
        if($dppUdaje->rodne_cislo == NULL){
            return false;
        }
        if($dppUdaje->cislo_popisne == NULL){
            return false;
        }
        if($dppUdaje->mesto == NULL){
            return false;
        }
        if($dppUdaje->psc == NULL){
            return false;
        }
        if($dppUdaje->bankovni_ucet == NULL){
            return false;
        }
        return true;
    }
?>
@extends('dashboard')
@section('content')
<script>
    function toggleDppInfo() {
        let menu = document.querySelectorAll(".osobne_info_hidden_dpp");
        for (i=0; i<menu.length; i++){
            menu[i].classList.toggle("toggleDpp");
        }
    }
    function toggleStipInfo() {
        let menu = document.querySelectorAll(".osobne_info_hidden_stip");
        for (i=0; i<menu.length; i++){
            menu[i].classList.toggle("toggleStip");
        }
    }
    function toggleVolInfo() {
        let menu = document.querySelectorAll(".osobne_info_hidden_vol");
        for (i=0; i<menu.length; i++){
            menu[i].classList.toggle("toggleVol");
        }
    }
    function toggleBtnDpp(){
        let menu = document.querySelectorAll(".kontakt_info_item_span_add");
        for (i=0; i<menu.length; i++){
            menu[i].classList.toggle("toggleBtn");
        }
    }
    function toggleBtnStip(){
        let menu = document.querySelectorAll(".kontakt_info_item_span_add1");
        for (i=0; i<menu.length; i++){
            menu[i].classList.toggle("toggleBtn");
        }
    }
    function toggleBtnVol(){
        let menu = document.querySelectorAll(".kontakt_info_item_span_add2");
        for (i=0; i<menu.length; i++){
            menu[i].classList.toggle("toggleBtn");
        }
    }
</script>
    <div class="osobne_informacie">
        <div class="osobne_info">
            <div class="osobne_info_l">
                <div class="osobne_info_h1">
                    <h1>{{$data->jmeno. " " .$data->prijmeni}}</h1>
                </div>
            </div>
            <hr class="hr-osobne-info">
            <div class="osobne_info_l">
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span">{{__('Číslo')}}:</div>
                    {{$data->id}}
                </div>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span">Login:</div>
                    {{$data->login}}
                </div>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span">{{__('Aktivní')}}:</div>
                    @if (($data->aktivni_do == "0000-00-00 00:00:00") || ($data->aktivni_do == ""))
                        {{$data->aktivni_od. " - "}} &infin;
                    @else
                        {{$data->aktivni_od. " - " .$data->aktivni_do}}
                    @endif
                </div>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span">{{__('Práce')}}:</div>
                    @if (($data->odpracovat_do == "0000-00-00 00:00:00") || ($data->odpracovat_do == ""))
                        {{$data->odpracovat_od. " - "}} &infin;
                    @else
                        {{$data->odpracovat_od. " - " .$data->odpracovat_do}}
                    @endif
                    <a href="pracovne_vykazy_osoby">{{__('Pracovní výkazy')}}</a>
                </div> 
            </div>                                                    
        </div>
        <div class="medzera"></div>                                           
        <div class="osobne_info">
            <div class="podklady_l">
                <?php if ($dppUdaje !== null) {
                        $dppUdajeKompletni = plneVyplnenDPP($dppUdaje);
                        $stipUdajeKompletni = plneVyplnenStip($dppUdaje);
                    }
                    else {
                        $dppUdajeKompletni = null;
                        $stipUdajeKompletni = null;
                    }?>
                    <div class="kontakt_info_item">{{__('Podklady pro DPP')}}: &nbsp
                    @if ($dppUdajeKompletni)
                        <span class="vyplnene-udaje">{{__('Vyplněny')}}</span>
                    @else
                    <span class="nevyplnene-udaje">{{__('Nevyplněny')}}</span>
                    @endif      
                </div>
                <div class="kontakt_info_item">{{__('Podklady pro Stip')}}: &nbsp
                    @if ($stipUdajeKompletni)
                        <span class="vyplnene-udaje">{{__('Vyplněny')}}</span>
                    @else
                        <span class="vyplnene-udaje">{{__('Nevyplněny')}}</span>
                    @endif      
                </div>
            </div>
            <hr class="hr2-osobne-info">
            <form action="{{route('update_dpp_info')}}" method="post">
                @if(Session::has('success2'))
                    <div class="alert alert-success">{{Session::get('success2')}}</div>
                @endif
                @if(Session::has('fail2'))
                    <div class="alert alert-danger">{{Session::get('fail2')}}</div>
                @endif
                @csrf
                <div class="osobne-info-btns">
                    <a href="#" onclick="toggleDppInfo(); toggleBtnDpp();">
                        <div class="kontakt_info_item_span_add">{{__('Podklady pro DPP')}}</div>
                    </a>
                    <a href="#" onclick="toggleStipInfo(); toggleBtnStip();">
                        <div class="kontakt_info_item_span_add1">{{__('Podklady pro Stip')}}</div>
                    </a>
                    <a href="#" onclick="toggleVolInfo(); toggleBtnVol();">
                        <div class="kontakt_info_item_span_add2">{{__('Volitelné údaje')}}</div>
                    </a>
                </div>
                <div class="kontakt_info_l">              
                    <div class="kontakt_info_item osobne_info_hidden_vol">
                        <div class="kontakt_info_item_span">{{__('Titul před jménem')}}:</div>
                        <input type="text" size="29" maxlength="31" name="titul_pred" title="{{__('Titul před jménem')}}" value="{{ $dppUdaje ? $dppUdaje->titul_pred : '' }}">
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_vol">
                        <div class="kontakt_info_item_span">{{__('Titul za jménem')}}:</div>
                        <input type="text" size="29" maxlength="31" name="titul_za" title="{{__('Titul za jménem')}}" value="{{ $dppUdaje ? $dppUdaje->titul_za : '' }}">
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp osobne_info_hidden_stip">
                        <div class="kontakt_info_item_span">{{__('Jméno')}}:</div>                   
                        <input type="text" size="29" maxlength="63" name="jmeno" title="{{__('Jméno')}}" value="{{ $dppUdaje ? $dppUdaje->jmeno : '' }}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp osobne_info_hidden_stip">
                        <div class="kontakt_info_item_span">{{__('Příjmení')}}:</div>                   
                        <input type="text" size="29" maxlength="63" name="prijmeni" title="{{__('Příjmení')}}" value="{{ $dppUdaje ? $dppUdaje->prijmeni : '' }}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka pro DPP')}}">*</span>
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp">
                        <div class="kontakt_info_item_span">{{__('Rodné příjmení')}}:</div>                   
                        <input type="text" size="29" maxlength="63" name="rodne_prijmeni" title="{{__('Rodné příjmení')}}" value="{{ $dppUdaje ? $dppUdaje->rodne_prijmeni : '' }}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp osobne_info_hidden_stip">
                        <div class="kontakt_info_item_span">{{__('Místo narození')}}:</div>                   
                        <input type="text" size="29" maxlength="63" name="misto_narozeni" title="{{__('Místo narození')}}" value="{{ $dppUdaje ? $dppUdaje->misto_narozeni : '' }}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp osobne_info_hidden_stip">
                        <div class="kontakt_info_item_span">{{__('Datum narození')}}:</div>                   
                        <input type="text" size="29" maxlength="31" name="datum_narozeni" title="{{__('Datum narození')}}" value="{{ $dppUdaje ? $dppUdaje->datum_narozeni : '' }}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp osobne_info_hidden_stip">
                        <div class="kontakt_info_item_span">{{__('Rodné číslo')}}:</div>                   
                        <input type="text" size="29" maxlength="15" name="rodne_cislo" title="{{__('Rodné číslo')}}" value="{{ $dppUdaje ? $dppUdaje->rodne_cislo : '' }}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp">
                        <div class="kontakt_info_item_span">{{__('Číslo OP')}}:</div>                   
                        <input type="text" size="29" maxlength="15" name="cislo_op" title="{{__('Číslo občanského průkazu')}}" value="{{ $dppUdaje ? $dppUdaje->cislo_op : '' }}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka pro DPP - zadejte číslo OP nebo číslo pasu (alespoň jedno z nich)')}}">**</span>
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_stip">
                        <div class="kontakt_info_item_span">{{__('Osobní číslo VUT')}}:</div>                   
                        <input type="text" size="29" maxlength="15" name="cdb_id" title="{{__('Osobní číslo VUT / Person ID / CDB ID (na průkazu)')}}" value="{{ $dppUdaje ? $dppUdaje->cdb_id : '' }}">
                        <span class="vyrazneCervene sipka" title="{{__('Jste-li student(ka), povinná položka')}}">**</span>
                    </div> 
                    <div class="kontakt_info_item osobne_info_hidden_dpp">
                        <div class="kontakt_info_item_span">{{__('Státní příslušnost (stát)')}}:</div>                   
                        <input type="text" size="29" maxlength="63" name="statni_prislusnost" title="{{__('Státní příslušnost (stát)')}}" value="{{ $dppUdaje ? $dppUdaje->statni_prislusnost : '' }}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka pro DPP')}}">*</span>
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_vol">
                        <div class="kontakt_info_item_span">{{__('Rodinný stav')}}:</div>                   
                        <select id="upravDppRodinnyStav" name="upravDppRodinnyStav" title="{{__('Rodinný stav')}}">
                            <?php echo generujPolozkyVyberuSId($rodinnyStav, false, $dppUdaje->rodinny_stav ?? 0);?>
                        </select>
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_vol">
                        <div class="kontakt_info_item_span">{{__('Ulice')}}:</div>                   
                        <input type="text" size="29" maxlength="63" name="ulice" title="{{__('Adresa - ulice (u vesnice bez ulic je doporučeno zadat název vesnice - jako na dopisu)')}}" value="{{ $dppUdaje ? $dppUdaje->ulice : '' }}">
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp osobne_info_hidden_stip">
                        <div class="kontakt_info_item_span">{{__('Číslo popisné')}}:</div>                   
                        <input type="text" size="29" maxlength="15" name="cislo_popisne" title="{{__('Adresa - číslo popisné')}}" value="{{ $dppUdaje ? $dppUdaje->cislo_popisne : '' }}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp osobne_info_hidden_stip">
                        <div class="kontakt_info_item_span">{{__('Město')}}:</div>                   
                        <input type="text" size="29" maxlength="63" name="mesto" title="{{__('Adresa - město')}}" value="{{ $dppUdaje ? $dppUdaje->mesto : '' }}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp osobne_info_hidden_stip">
                        <div class="kontakt_info_item_span">{{__('PSČ')}}:</div>                   
                        <input type="text" size="29" maxlength="15" name="psc" title="{{__('PSČ')}}" value="{{ $dppUdaje ? $dppUdaje->psc : '' }}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp">
                        <div class="kontakt_info_item_span">{{__('Zdravotní pojišťovna')}}:</div>                   
                        <input type="text" size="29" maxlength="63" name="zdravotni_pojistovna" title="{{__('Název zdravotní pojišťovny (např. VZP)')}}" value="{{ $dppUdaje ? $dppUdaje->zdravotni_pojistovna : '' }}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka pro DPP')}}">*</span>
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp">
                        <div class="kontakt_info_item_span">{{__('Číslo pasu')}}:</div>                   
                        <input type="text" size="29" maxlength="15" name="cislo_pasu" title="{{__('Číslo pasu (určeno pro cizince)')}}" value="{{ $dppUdaje ? $dppUdaje->cislo_pasu : '' }}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka pro DPP - zadejte číslo OP nebo číslo pasu (alespoň jedno z nich)')}}">**</span>
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_vol">
                        <div class="kontakt_info_item_span">{{__('DIČ')}}:</div>                   
                        <input type="text" size="29" maxlength="15" name="dic" title="{{__('Daňové identifikační číslo (určeno pro cizince)')}}" value="{{ $dppUdaje ? $dppUdaje->dic : '' }}">
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp osobne_info_hidden_stip">
                        <div class="kontakt_info_item_span">{{__('Bankovní účet')}}:</div>                   
                        <input type="text" size="29" maxlength="63" name="bankovni_ucet" title="{{__('Číslo bankovního účtu, kde si přejete zasílat peníze')}}" value="{{ $dppUdaje ? $dppUdaje->bankovni_ucet : '' }}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>             
                    <div class="kontakt_info_item osobne_info_hidden_vol osobne_info_hidden_dpp osobne_info_hidden_stip">
                        <div class="kontakt_info_button">
                            <button type="submit" class="btn btn-block btn-primary" style="margin-top:20px">{{__('Uložit')}}</button>
                        </div> 
                    </div>  
                
                    <div class="kontakt_info_item_gdpr">
                    {{__('Poskytnuté podklady pro DPP/stipendia (osobní údaje) budou využity výhradně za účelem administrace vyplacení finančních prostředků a budou skladovány po dobu nezbytně nutnou, danou zejména zákony souvisejícími s účetnictvím. V KNOTIS budou osobní údaje automaticky vymazány do 3 měsíců od vypršení aktivity účtu a zjištění zániku účtu na serveru merlin (ukončení studia) - pak již aktivitu účtu nelze znovu obnovit.')}}
                    </div>
                </div> 
            </form>  
        </div>    
        <div class="medzera"></div>                                                    
    </div>
@endsection