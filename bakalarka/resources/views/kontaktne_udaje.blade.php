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
                    <h2>{{__('messages.kontaktne-udaje')}}</h2>
                </div>
                <div class="kontakt_info_item_gdpr">
                    {{__('messages.kontaktne-udaje-gdpr')}}
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.meno')}}:</div>                   
                    <input type="text" size="25" maxlength="63" name="jmeno" title="{{__('messages.meno')}}" value="{{$data->jmeno}}"> 
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.priezvisko')}}:</div>                   
                    <input type="text" size="25" maxlength="63" name="prijmeni" title="{{__('messages.priezvisko')}}" value="{{$data->prijmeni}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.telefon')}}:</div>
                    <input type="text" size="25" maxlength="21"  name="telefon" title="{{__('messages.telefon-title')}}" value="{{$data->telefon}}">               
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Mail:</div>                   
                    <input type="text" size="25" maxlength="255" name="gmail" title="{{__('messages.mail-title')}}" value="{{$data->gmail}}">
                </div>
                <div class="kontakt_info_item">                  
                    <a href="#" onclick="toggleOtherContact()">{{__('messages.add-contact')}}</a> <!--TODO-->
                </div>
                <div class=" kontakt_info_hidden">
                    <div class="kontakt_info_item">
                        <div class="kontakt_info_item_span">Facebook:</div>
                        <input type="text" size="25" maxlength="255" name="facebook" title="{{__('messages.fb-title')}}" value="{{$data->facebook}}">
                    </div>
                    <div class="kontakt_info_item">
                        <div class="kontakt_info_item_span">Discord:</div>                   
                        <input type="text" size="25" maxlength="255" name="discord" title="{{__('messages.dc-title')}}" value="{{$data->discord}}">
                    </div>
                    <div class="kontakt_info_item">
                        <div class="kontakt_info_item_span">Skype:</div>      
                        <input type="text" size="25" maxlength="127" name="skype" title="{{__('messages.skype-title')}}" value="{{$data->skype}}">             
                    </div>
                    <div class="kontakt_info_item">
                        <div class="kontakt_info_item_span">ICQ:</div>  
                        <input type="text" size="25" maxlength="15" name="icq" title="{{__('messages.icq-title')}}" value="{{$data->icq}}">                 
                    </div>
                    <div class="kontakt_info_item">
                        <div class="kontakt_info_item_span">Jabber:</div>                   
                        <input type="text" size="25" maxlength="127" name="jabber" title="{{__('messages.jabber-title')}}" value="{{$data->jabber}}">
                    </div>
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_button">
                        <button type="submit" class="btn btn-block btn-primary">{{__('messages.save-btn')}}</button>
                    </div> 
                </div>
            </div>                                                    
        </form> 
    </div>  
    <div class="podklady">
        <div class="podklady_l">
            <!--$dppUdajeKompletni = plneVyplnenDPP($udajeOs['id'], 0); #2078
                $stipendiumUdajeKompletni = plneVyplnenDPP($udajeOs['id'], 2); #2079-->
                <div class="kontakt_info_item">{{__('messages.podklady-dpp')}}: &nbsp <!--TODO-->
                @if ($data)<!--$dppUdajeKompletni)-->
                    <span style="color:green">{{__('messages.vyplnene')}}</span>
                @else
                    <span style="color:red">{{__('messages.nevyplnene')}}</span>
                @endif
                <a href="#" onclick="toggleDppInfo()">
                    <div class="kontakt_info_item_span_add">{{__('messages.podklady-dpp')}}</div>
                </a> <!--TODO-->          
            </div>
            <div class="kontakt_info_item">{{__('messages.podklady-stip')}}: &nbsp <!--TODO-->
                @if ($data)<!--$stipendiumUdajeKompletni)-->
                    <span style="color:green">{{__('messages.vyplnene')}}</span>
                @else
                    <span style="color:red">{{__('messages.nevyplnene')}}</span>
                @endif
                <a href="#" onclick="toggleStipInfo()">
                    <div class="kontakt_info_item_span_add">{{__('messages.podklady-stip')}}</div>
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
                    <div class="kontakt_info_item_span">{{__('messages.titul-pred')}}:</div>
                    <input type="text" size="25" maxlength="31" name="titul_pred" title="{{__('messages.titul-pred')}}" value="{{$data->titul_pred}}">{{__('messages.volitelne')}}               
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.titul-za')}}:</div>
                    <input type="text" size="25" maxlength="31" name="titul_za" title="{{__('messages.titul-za')}}" value="{{$data->titul_za}}">{{__('messages.volitelne')}} 
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.meno')}}:</div>                   
                    <input type="text" size="25" maxlength="63" name="jmeno" title="{{__('messages.meno')}}" value="{{$data->jmeno}}"> 
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.priezvisko')}}:</div>                   
                    <input type="text" size="25" maxlength="63" name="prijmeni" title="{{__('messages.priezvisko')}}" value="{{$data->prijmeni}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.rodne-priezvisko')}}:</div>                   
                    <input type="text" size="25" maxlength="63" name="rodne_prijmeni" title="{{__('messages.rodne-priezvisko')}}" value="{{$data->rodne_prijmeni}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.miesto-narodenia')}}:</div>                   
                    <input type="text" size="25" maxlength="63" name="misto_narozeni" title="{{__('messages.miesto-narodenia')}}" value="{{$data->misto_narozeni}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.datum-narodenia')}}:</div>                   
                    <input type="text" size="25" maxlength="31" name="datum_narozeni" title="{{__('messages.datum-narodenia')}}" value="{{$data->datum_narozeni}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.rodne-cislo')}}:</div>                   
                    <input type="text" size="25" maxlength="15" name="rodne_cislo" title="{{__('messages.rodne-cislo')}}" value="{{$data->rodne_cislo}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.cislo-op')}}:</div>                   
                    <input type="text" size="25" maxlength="15" name="cislo_op" title="{{__('messages.cislo-op-title')}}" value="{{$data->cislo_op}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.stat')}}:</div>                   
                    <input type="text" size="25" maxlength="63" name="statni_prislusnost" title="{{__('messages.stat')}}" value="{{$data->statni_prislusnost}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.rodinny-stav')}}:</div>                   
                    <select id="upravDppRodinnyStav" name="upravDppRodinnyStav" title="{{__('messages.rodinny-stav')}}">
                        <!--generujPolozkyVyberuSId($rodinnyStav, false, $udajeDPP['rodinny_stav'])-->
                    </select>{{__('messages.volitelne')}} 
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.ulica')}}:</div>                   
                    <input type="text" size="25" maxlength="63" name="ulice" title="{{__('messages.ulica-title')}}" value="{{$data->ulice}}">{{__('messages.volitelne')}} 
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.popisne-cislo')}}:</div>                   
                    <input type="text" size="25" maxlength="15" name="cislo_popisne" title="{{__('messages.popisne-cislo-title')}}" value="{{$data->cislo_popisne}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.mesto')}}:</div>                   
                    <input type="text" size="25" maxlength="63" name="mesto" title="{{__('messages.mesto-title')}}" value="{{$data->mesto}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.psc')}}:</div>                   
                    <input type="text" size="25" maxlength="15" name="psc" title="{{__('messages.psc')}}" value="{{$data->psc}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.poistovna')}}:</div>                   
                    <input type="text" size="25" maxlength="63" name="zdravotni_pojistovna" title="{{__('messages.poistovna-title')}}" value="{{$data->zdravotni_pojistovna}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.cislo-pasu')}}:</div>                   
                    <input type="text" size="25" maxlength="15" name="cislo_pasu" title="{{__('messages.cislo-pasu-title')}}" value="{{$data->cislo_pasu}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.dic')}}:</div>                   
                    <input type="text" size="25" maxlength="15" name="dic" title="{{__('messages.dic-title')}}" value="{{$data->dic}}">{{__('messages.volitelne')}} 
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.bankovy-ucet')}}:</div>                   
                    <input type="text" size="25" maxlength="63" name="bankovni_ucet" title="{{__('messages.bankovy-ucet-title')}}" value="{{$data->bankovni_ucet}}">
                </div>             
                <div class="kontakt_info_item">
                    <div class="kontakt_info_button">
                        <button type="submit" class="btn btn-block btn-primary">{{__('messages.save-btn')}}</button>
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
                    <div class="kontakt_info_item_span">{{__('messages.titul-pred')}}:</div>
                    <input type="text" size="25" maxlength="31" name="titul_pred" title="{{__('messages.titul-pred')}}" value="{{$data->titul_pred}}">{{__('messages.volitelne')}}                
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.titul-za')}}:</div>
                    <input type="text" size="25" maxlength="31" name="titul_za" title="{{__('messages.titul-za')}}" value="{{$data->titul_za}}">{{__('messages.volitelne')}} 
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.vut-cislo')}}:</div>                   
                    <input type="text" size="25" maxlength="15" name="cdb_id" title="{{__('messages.vut-cislo-title')}}" value="{{$data->cdb_id}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.miesto-narodenia')}}:</div>                   
                    <input type="text" size="25" maxlength="63" name="misto_narozeni" title="{{__('messages.miesto-narodenia')}}" value="{{$data->misto_narozeni}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.datum-narodenia')}}:</div>                   
                    <input type="text" size="25" maxlength="31" name="datum_narozeni" title="{{__('messages.datum-narodenia')}}" value="{{$data->datum_narozeni}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.rodne-cislo')}}:</div>                   
                    <input type="text" size="25" maxlength="15" name="rodne_cislo" title="{{__('messages.rodne-cislo')}}" value="{{$data->rodne_cislo}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.rodinny-stav')}}:</div>                   
                    <select id="upravDppRodinnyStav" name="upravDppRodinnyStav" title="{{__('messages.rodinny-stav')}}">
                        <!--generujPolozkyVyberuSId($rodinnyStav, false, $udajeDPP['rodinny_stav'])-->
                    </select>{{__('messages.volitelne')}} 
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.ulica')}}:</div>                   
                    <input type="text" size="25" maxlength="63" name="ulice" title="{{__('messages.ulica-title')}}" value="{{$data->ulice}}">{{__('messages.volitelne')}} 
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.popisne-cislo')}}:</div>                   
                    <input type="text" size="25" maxlength="15" name="cislo_popisne" title="{{__('messages.popisne-cislo-title')}}" value="{{$data->cislo_popisne}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.mesto')}}:</div>                   
                    <input type="text" size="25" maxlength="63" name="mesto" title="{{__('messages.mesto-title')}}" value="{{$data->mesto}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.psc')}}:</div>                   
                    <input type="text" size="25" maxlength="15" name="psc" title="{{__('messages.psc')}}" value="{{$data->psc}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.dic')}}:</div>                   
                    <input type="text" size="25" maxlength="15" name="dic" title="{{__('messages.dic-title')}}" value="{{$data->dic}}">{{__('messages.volitelne')}} 
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('messages.bankovy-ucet')}}:</div>                   
                    <input type="text" size="25" maxlength="63" name="bankovni_ucet" title="{{__('messages.bankovy-ucet-title')}}" value="{{$data->bankovni_ucet}}">

                </div>           
                <div class="kontakt_info_item">
                    <div class="kontakt_info_button">
                        <button type="submit" class="btn btn-block btn-primary">{{__('messages.save-btn')}}</button>
                    </div> 
                </div>   
            </div>                                                    
        </form>
    </div>
@endsection