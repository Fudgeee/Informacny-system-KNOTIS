<!--OSOBNE INFORMACIE-->
<?php 
    $rodinnyStav[0] = "---";
    $rodinnyStav[1] = "svobodný/svobodná";
    $rodinnyStav[2] = "ženatý/vdaná";
    $rodinnyStav[3] = "rozvedený/á";
    $rodinnyStav[4] = "vdovec/vdova";
    $rodinnyStav[5] = "partnertsví";
    $rodinnyStav[6] = "mrtev/mrtvá";
    $rodinnyStav[7] = "zaniklé partnerství rozhodnutím";
    $rodinnyStav[8] = "zaniklé partnerství smrtí";

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
</script>
    <div class="osobne_informacie">
        <div class="osobne_info">
            <form action="{{route('update_personal_info')}}" method="post">
                @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif
                @if(Session::has('fail'))
                    <div class="alert alert-danger">{{Session::get('fail')}}</div>
                @endif
                @csrf
                <div class="osobne_info_l">
                    <div class="osobne_info_h1">
                        <h1>{{$data->jmeno. " " .$data->prijmeni}}</h1>
                    </div>
                    <div class="kontakt_info_item_gdpr">
                        {{__('Poskytnuté podklady pro DPP/stipendia (osobní údaje) budou využity výhradně za účelem administrace vyplacení finančních prostředků a budou skladovány po dobu nezbytně nutnou, danou zejména zákony souvisejícími s účetnictvím. V KNOTIS budou osobní údaje automaticky vymazány do 3 měsíců od vypršení aktivity účtu a zjištění zániku účtu na serveru merlin (ukončení studia) - pak již aktivitu účtu nelze znovu obnovit.')}}
                    </div>
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
                    </div> 
                </div>                                                    
            </form>
        </div>
        <div class="podklady">
            <div class="podklady_l">
                <!--$dppUdajeKompletni = plneVyplnenDPP($udajeOs['id'], 0); #2078
                    $stipendiumUdajeKompletni = plneVyplnenDPP($udajeOs['id'], 2); #2079-->
                    <div class="kontakt_info_item">{{__('Podklady pro DPP')}}: &nbsp <!--TODO-->
                    @if ($data)<!--$dppUdajeKompletni)-->
                        <span style="color:green">{{__('Vyplněny')}}</span>
                    @else
                        <span style="color:red">{{__('Nevyplněny')}}</span>
                    @endif
                    <a href="#" onclick="toggleDppInfo()">
                        <div class="kontakt_info_item_span_add">{{__('Podklady pro DPP')}}</div>
                    </a> <!--TODO-->          
                </div>
                <div class="kontakt_info_item">{{__('Podklady pro Stip')}}: &nbsp <!--TODO-->
                    @if ($data)<!--$stipendiumUdajeKompletni)-->
                        <span style="color:green">{{__('Vyplněny')}}</span>
                    @else
                        <span style="color:red">{{__('Nevyplněny')}}</span>
                    @endif
                    <a href="#" onclick="toggleStipInfo()">
                        <div class="kontakt_info_item_span_add">{{__('Podklady pro Stip')}}</div>
                    </a> <!--TODO-->        
                </div>
            </div>
        </div>                                           
        <div class="osobne_info">
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
                        <div class="kontakt_info_item_span">{{__('Titul před jménem')}}:</div>
                        <input type="text" size="25" maxlength="31" name="titul_pred" title="{{__('Titul před jménem')}}" value="{{$data->titul_pred}}">
                    </div>
                    <div class="kontakt_info_item">
                        <div class="kontakt_info_item_span">{{__('Titul za jménem')}}:</div>
                        <input type="text" size="25" maxlength="31" name="titul_za" title="{{__('Titul za jménem')}}" value="{{$data->titul_za}}">
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp osobne_info_hidden_stip">
                        <div class="kontakt_info_item_span">{{__('Jméno')}}:</div>                   
                        <input type="text" size="25" maxlength="63" name="jmeno" title="{{__('Jméno')}}" value="{{$data->jmeno}}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp osobne_info_hidden_stip">
                        <div class="kontakt_info_item_span">{{__('Příjmení')}}:</div>                   
                        <input type="text" size="25" maxlength="63" name="prijmeni" title="{{__('Příjmení')}}" value="{{$data->prijmeni}}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp">
                        <div class="kontakt_info_item_span">{{__('Rodné příjmení')}}:</div>                   
                        <input type="text" size="25" maxlength="63" name="rodne_prijmeni" title="{{__('Rodné příjmení')}}" value="{{$data->rodne_prijmeni}}">
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp osobne_info_hidden_stip">
                        <div class="kontakt_info_item_span">{{__('Místo narození')}}:</div>                   
                        <input type="text" size="25" maxlength="63" name="misto_narozeni" title="{{__('Místo narození')}}" value="{{$data->misto_narozeni}}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp osobne_info_hidden_stip">
                        <div class="kontakt_info_item_span">{{__('Datum narození')}}:</div>                   
                        <input type="text" size="25" maxlength="31" name="datum_narozeni" title="{{__('Datum narození')}}" value="{{$data->datum_narozeni}}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp osobne_info_hidden_stip">
                        <div class="kontakt_info_item_span">{{__('Rodné číslo')}}:</div>                   
                        <input type="text" size="25" maxlength="15" name="rodne_cislo" title="{{__('Rodné číslo')}}" value="{{$data->rodne_cislo}}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp">
                        <div class="kontakt_info_item_span">{{__('Číslo OP')}}:</div>                   
                        <input type="text" size="25" maxlength="15" name="cislo_op" title="{{__('Číslo občanského průkazu')}}" value="{{$data->cislo_op}}">
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_stip">
                        <div class="kontakt_info_item_span">{{__('Osobní číslo VUT')}}:</div>                   
                        <input type="text" size="25" maxlength="15" name="cdb_id" title="{{__('Osobní číslo VUT / Person ID / CDB ID (na průkazu)')}}" value="{{$data->cdb_id}}">
                    </div> 
                    <div class="kontakt_info_item osobne_info_hidden_dpp">
                        <div class="kontakt_info_item_span">{{__('Státní příslušnost (stát)')}}:</div>                   
                        <input type="text" size="25" maxlength="63" name="statni_prislusnost" title="{{__('Státní příslušnost (stát)')}}" value="{{$data->statni_prislusnost}}">
                    </div>
                    <div class="kontakt_info_item">
                        <div class="kontakt_info_item_span">{{__('Rodinný stav')}}:</div>                   
                        <select id="upravDppRodinnyStav" name="upravDppRodinnyStav" title="{{__('Rodinný stav')}}">
                            <?php echo generujPolozkyVyberuSId($rodinnyStav, false, $data['rodinny_stav']);?>
                        </select>
                    </div>
                    <div class="kontakt_info_item">
                        <div class="kontakt_info_item_span">{{__('Ulice')}}:</div>                   
                        <input type="text" size="25" maxlength="63" name="ulice" title="{{__('Adresa - ulice (u vesnice bez ulic je doporučeno zadat název vesnice - jako na dopisu)')}}" value="{{$data->ulice}}">
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp osobne_info_hidden_stip">
                        <div class="kontakt_info_item_span">{{__('Číslo popisné')}}:</div>                   
                        <input type="text" size="25" maxlength="15" name="cislo_popisne" title="{{__('Adresa - číslo popisné')}}" value="{{$data->cislo_popisne}}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp osobne_info_hidden_stip">
                        <div class="kontakt_info_item_span">{{__('Město')}}:</div>                   
                        <input type="text" size="25" maxlength="63" name="mesto" title="{{__('Adresa - město')}}" value="{{$data->mesto}}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp osobne_info_hidden_stip">
                        <div class="kontakt_info_item_span">{{__('PSČ')}}:</div>                   
                        <input type="text" size="25" maxlength="15" name="psc" title="{{__('PSČ')}}" value="{{$data->psc}}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp">
                        <div class="kontakt_info_item_span">{{__('Zdravotní pojišťovna')}}:</div>                   
                        <input type="text" size="25" maxlength="63" name="zdravotni_pojistovna" title="{{__('Název zdravotní pojišťovny (např. VZP)')}}" value="{{$data->zdravotni_pojistovna}}">
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp">
                        <div class="kontakt_info_item_span">{{__('Číslo pasu')}}:</div>                   
                        <input type="text" size="25" maxlength="15" name="cislo_pasu" title="{{__('Číslo pasu (určeno pro cizince)')}}" value="{{$data->cislo_pasu}}">
                    </div>
                    <div class="kontakt_info_item">
                        <div class="kontakt_info_item_span">{{__('DIČ')}}:</div>                   
                        <input type="text" size="25" maxlength="15" name="dic" title="{{__('Daňové identifikační číslo (určeno pro cizince)')}}" value="{{$data->dic}}">
                    </div>
                    <div class="kontakt_info_item osobne_info_hidden_dpp osobne_info_hidden_stip">
                        <div class="kontakt_info_item_span">{{__('Bankovní účet')}}:</div>                   
                        <input type="text" size="25" maxlength="63" name="bankovni_ucet" title="{{__('Číslo bankovního účtu, kde si přejete zasílat peníze')}}" value="{{$data->bankovni_ucet}}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>             
                    <div class="kontakt_info_item">
                        <div class="kontakt_info_button">
                            <button type="submit" class="btn btn-block btn-primary">{{__('Uložit')}}</button>
                        </div> 
                    </div>  
                </div> 
            </form>
        </div>                                                       
    </div>
@endsection