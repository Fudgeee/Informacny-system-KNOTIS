<!--KONTAKTNE UDAJE-->
@extends('dashboard')
@section('content')
<script>
    function toggleOtherContact() {
        let menu = document.querySelector(".kontakt_info_hidden");
        menu.classList.toggle("toggleContact");
    }
    function toggleDppInfo() {
        let menu = document.querySelector(".kontakt_info_hidden_dpp");
        menu.classList.toggle("toggleDpp");
    }
    function toggleStipInfo() {
        let menu = document.querySelector(".kontakt_info_hidden_stip");
        menu.classList.toggle("toggleStip");
    }
</script>
    <div class="kontaktne_udaje">
        <form action="{{route('update_kontaktne_info')}}" method="post">
            @if(Session::has('success1'))
                <div class="alert alert-success">{{Session::get('success1')}}</div>
            @endif
            @if(Session::has('fail1'))
                <div class="alert alert-danger">{{Session::get('fail1')}}</div>
            @endif
            @csrf
            <div class="kontakt_info_l">
                <div class="kontakt_info_h1">
                    <h2>Kontaktní Údaje</h2>
                </div>
                <div class="kontakt_info_item_gdpr">
                    Poskytnuté kontaktní informace (telefon, e-mail apod.) budou využity výhradně za účelem komunikace v rámci výzkumné skupiny ohledně smluvené práce a souvisejících problémů po dobu aktivity účtu v KNOTIS. Poskytnuté podklady pro DPP/stipendia (osobní údaje) budou využity výhradně za účelem administrace vyplacení finančních prostředků a budou skladovány po dobu nezbytně nutnou, danou zejména zákony souvisejícími s účetnictvím. V KNOTIS budou kontaktní informace i osobní údaje automaticky vymazány do 3 měsíců od vypršení aktivity účtu a zjištění zániku účtu na serveru merlin (ukončení studia) - pak již aktivitu účtu nelze znovu obnovit.
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Jméno:</div>                   
                    <input type="text" size="25" maxlength="63" name="jmeno" title="Jméno" value="{{$data->jmeno}}"> 
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Příjmení:</div>                   
                    <input type="text" size="25" maxlength="63" name="prijmeni" title="Příjmení" value="{{$data->prijmeni}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Telefon:</div>
                    <input type="text" size="25" maxlength="21"  name="telefon" title="Váš kontaktní telefon" value="{{$data->telefon}}">               
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Mail:</div>                   
                    <input type="text" size="25" maxlength="255" name="gmail" title="Váš Gmail účet nebo školní e-mail" value="{{$data->gmail}}">
                </div>
                <div class="kontakt_info_item">                  
                    <a href="#" onclick="toggleOtherContact()">Přidat jiný kontakt</a> <!--TODO-->
                </div>
                <div class=" kontakt_info_hidden">
                    <div class="kontakt_info_item">
                        <div class="kontakt_info_item_span">Facebook:</div>
                        <input type="text" size="25" maxlength="255" name="facebook" title="Váš kontaktní Facebook účet" value="{{$data->facebook}}">
                    </div>
                    <div class="kontakt_info_item">
                        <div class="kontakt_info_item_span">Discord:</div>                   
                        <input type="text" size="25" maxlength="255" name="discord" title="Váš kontaktní Discord účet" value="{{$data->discord}}">
                    </div>
                    <div class="kontakt_info_item">
                        <div class="kontakt_info_item_span">Skype:</div>      
                        <input type="text" size="25" maxlength="127" name="skype" title="Váš kontaktní Skype účet" value="{{$data->skype}}">             
                    </div>
                    <div class="kontakt_info_item">
                        <div class="kontakt_info_item_span">ICQ:</div>  
                        <input type="text" size="25" maxlength="15" name="icq" title="Váše kontaktní ICQ" value="{{$data->icq}}">                 
                    </div>
                    <div class="kontakt_info_item">
                        <div class="kontakt_info_item_span">Jabber:</div>                   
                        <input type="text" size="25" maxlength="127" name="jabber" title="Váš kontaktní jabber účet" value="{{$data->jabber}}">
                    </div>
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_button">
                        <button type="submit" class="btn btn-block btn-primary">Uložit</button>
                    </div> 
                </div>
            </div>                                                    
        </form> 
    </div>  
    <div class="podklady">
        <div class="podklady_l">
            <!--$dppUdajeKompletni = plneVyplnenDPP($udajeOs['id'], 0); #2078
                $stipendiumUdajeKompletni = plneVyplnenDPP($udajeOs['id'], 2); #2079-->
                <div class="kontakt_info_item">Podklady pro DPP: &nbsp <!--TODO-->
                @if ($data)<!--$dppUdajeKompletni)-->
                    <span style="color:green">Vyplněny</span>
                @else
                    <span style="color:red">Nevyplněny</span>
                @endif
                <a href="#" onclick="toggleDppInfo()">
                    <div class="kontakt_info_item_span_add">Podklady pro DPP</div>
                </a> <!--TODO-->          
            </div>
            <div class="kontakt_info_item">Podklady pro Stip: &nbsp <!--TODO-->
                @if ($data)<!--$stipendiumUdajeKompletni)-->
                    <span style="color:green">Vyplněny</span>
                @else
                    <span style="color:red">Nevyplněny</span>
                @endif
                <a href="#" onclick="toggleStipInfo()">
                    <div class="kontakt_info_item_span_add" style="margin-left:17px">Podklady pro Stipendium</div>
                </a> <!--TODO-->        
            </div>
        </div>
    </div>                                           
    <div class="kontakt_info_hidden_dpp">
        <form action="{{route('update_dpp_info')}}" method="post">
            @if(Session::has('success2'))
                <div class="alert alert-success">{{Session::get('success2')}}</div>
            @endif
            @if(Session::has('fail2'))
                <div class="alert alert-danger">{{Session::get('fail2')}}</div>
            @endif
            @csrf
            <div class="kontakt_info_l" style="padding-top:20px">              
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Titul před jménem:</div>
                    <input type="text" size="25" maxlength="31" name="titul_pred" title="Titul před jménem" value="{{$data->titul_pred}}">(Volitelný)               
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Titul za jménem:</div>
                    <input type="text" size="25" maxlength="31" name="titul_za" title="Titul za jménem" value="{{$data->titul_za}}">(Volitelný)
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Jméno:</div>                   
                    <input type="text" size="25" maxlength="63" name="jmeno" title="Jméno" value="{{$data->jmeno}}"> 
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Příjmení:</div>                   
                    <input type="text" size="25" maxlength="63" name="prijmeni" title="Příjmení" value="{{$data->prijmeni}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Rodné příjmení:</div>                   
                    <input type="text" size="25" maxlength="63" name="rodne_prijmeni" title="Rodné příjmení" value="{{$data->rodne_prijmeni}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Místo narození:</div>                   
                    <input type="text" size="25" maxlength="63" name="misto_narozeni" title="Místo narození" value="{{$data->misto_narozeni}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Datum narození:</div>                   
                    <input type="text" size="25" maxlength="31" name="datum_narozeni" title="Datum narození" value="{{$data->datum_narozeni}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Rodné číslo:</div>                   
                    <input type="text" size="25" maxlength="15" name="rodne_cislo" title="Rodné číslo" value="{{$data->rodne_cislo}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Číslo OP:</div>                   
                    <input type="text" size="25" maxlength="15" name="cislo_op" title="Číslo občanského průkazu" value="{{$data->cislo_op}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Státní příslušnost (stát):</div>                   
                    <input type="text" size="25" maxlength="63" name="statni_prislusnost" title="Státní příslušnost (v DPP se uvádí do adresy, např. Česká republika)" value="{{$data->statni_prislusnost}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Rodinný stav:</div>                   
                    <select id="upravDppRodinnyStav" name="upravDppRodinnyStav" title="Rodinný stav">
                        <!--generujPolozkyVyberuSId($rodinnyStav, false, $udajeDPP['rodinny_stav'])-->
                    </select>(Volitelný)
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Ulice:</div>                   
                    <input type="text" size="25" maxlength="63" name="ulice" title="Adresa - ulice (u vesnice bez ulic je doporučeno zadat název vesnice - jako na dopisu)" value="{{$data->ulice}}">(Volitelný)
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Číslo popisné:</div>                   
                    <input type="text" size="25" maxlength="15" name="cislo_popisne" title="Adresa - číslo popisné" value="{{$data->cislo_popisne}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Město:</div>                   
                    <input type="text" size="25" maxlength="63" name="mesto" title="Adresa - město" value="{{$data->mesto}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">PSČ:</div>                   
                    <input type="text" size="25" maxlength="15" name="psc" title="" value="{{$data->psc}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Zdravotní pojišťovna:</div>                   
                    <input type="text" size="25" maxlength="63" name="zdravotni_pojistovna" title="Název zdravotní pojišťovny (např. VZP)" value="{{$data->zdravotni_pojistovna}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Číslo pasu:</div>                   
                    <input type="text" size="25" maxlength="15" name="cislo_pasu" title="Číslo pasu (určeno pro cizince)" value="{{$data->cislo_pasu}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">DIČ:</div>                   
                    <input type="text" size="25" maxlength="15" name="dic" title="=Daňové identifikační číslo (určeno pro cizince)=" value="{{$data->dic}}">(Volitelný)
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Bankovní účet:</div>                   
                    <input type="text" size="25" maxlength="63" name="bankovni_ucet" title="Číslo bankovního účtu, kde si přejete zasílat peníze" value="{{$data->bankovni_ucet}}">
                </div>             
                <div class="kontakt_info_item">
                    <div class="kontakt_info_button">
                        <button type="submit" class="btn btn-block btn-primary">Uložit</button>
                    </div> 
                </div>  
            </div> 
        </form>
    </div> 
    <div class="kontakt_info_hidden_stip">
        <form action="{{route('update_stip_info')}}" method="post">
            @if(Session::has('success3'))
                <div class="alert alert-success">{{Session::get('success3')}}</div>
            @endif
            @if(Session::has('fail3'))
                <div class="alert alert-danger">{{Session::get('fail3')}}</div>
            @endif
            @csrf 
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Titul před jménem:</div>
                    <input type="text" size="25" maxlength="31" name="titul_pred" title="Titul před jménem" value="{{$data->titul_pred}}">(Volitelný)               
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Titul za jménem:</div>
                    <input type="text" size="25" maxlength="31" name="titul_za" title="Titul za jménem" value="{{$data->titul_za}}">(Volitelný)
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Osobní číslo VUT:</div>                   
                    <input type="text" size="25" maxlength="15" name="cdb_id" title="Osobní číslo VUT / Person ID / CDB ID (na průkazu)" value="{{$data->cdb_id}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Místo narození:</div>                   
                    <input type="text" size="25" maxlength="63" name="misto_narozeni" title="Místo narození" value="{{$data->misto_narozeni}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Datum narození:</div>                   
                    <input type="text" size="25" maxlength="31" name="datum_narozeni" title="Datum narození" value="{{$data->datum_narozeni}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Rodné číslo:</div>                   
                    <input type="text" size="25" maxlength="15" name="rodne_cislo" title="Rodné číslo" value="{{$data->rodne_cislo}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Rodinný stav:</div>                   
                    <select id="upravDppRodinnyStav" name="upravDppRodinnyStav" title="Rodinný stav">
                        <!--generujPolozkyVyberuSId($rodinnyStav, false, $udajeDPP['rodinny_stav'])-->
                    </select>(Volitelný)
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Ulice:</div>                   
                    <input type="text" size="25" maxlength="63" name="ulice" title="Adresa - ulice (u vesnice bez ulic je doporučeno zadat název vesnice - jako na dopisu)" value="{{$data->ulice}}">(Volitelný)
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Číslo popisné:</div>                   
                    <input type="text" size="25" maxlength="15" name="cislo_popisne" title="Adresa - číslo popisné" value="{{$data->cislo_popisne}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Město:</div>                   
                    <input type="text" size="25" maxlength="63" name="mesto" title="Adresa - město" value="{{$data->mesto}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">PSČ:</div>                   
                    <input type="text" size="25" maxlength="15" name="psc" title="" value="{{$data->psc}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">DIČ:</div>                   
                    <input type="text" size="25" maxlength="15" name="dic" title="=Daňové identifikační číslo (určeno pro cizince)=" value="{{$data->dic}}">(Volitelný)
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Bankovní účet:</div>                   
                    <input type="text" size="25" maxlength="63" name="bankovni_ucet" title="Číslo bankovního účtu, kde si přejete zasílat peníze" value="{{$data->bankovni_ucet}}">

                </div>           
                <div class="kontakt_info_item">
                    <div class="kontakt_info_button">
                        <button type="submit" class="btn btn-block btn-primary">Uložit</button>
                    </div> 
                </div>   
            </div>                                                    
        </form>
    </div>
@endsection