<!--OSOBNE INFORMACIE-->
@extends('dashboard')
@section('content')
<script>
    function toggleDppInfo() {
        let menu = document.querySelector(".kontakt_info_hidden_dpp");
        menu.classList.toggle("toggleDpp");
    }
    function toggleStipInfo() {
        let menu = document.querySelector(".kontakt_info_hidden_stip");
        menu.classList.toggle("toggleStip");
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
                        {{__('messages.osobne-info-gdpr')}}
                    </div>
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span">{{__('messages.id-number')}}:</div>
                        {{$data->id}}
                    </div>
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span">Login:</div>
                        {{$data->login}}
                    </div>
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span">{{__('messages.active-time')}}:</div>
                        @if (($data->aktivni_do == "0000-00-00 00:00:00") || ($data->aktivni_do == ""))
                            {{$data->aktivni_od. " - "}} &infin;
                        @else
                            {{$data->aktivni_od. " - " .$data->aktivni_do}}
                        @endif
                    </div>
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span">{{__('messages.work-time')}}:</div>
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
    </div>
@endsection