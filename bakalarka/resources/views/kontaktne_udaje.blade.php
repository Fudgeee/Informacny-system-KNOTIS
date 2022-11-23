<!--KONTAKTNE UDAJE-->
@extends('dashboard')
@section('content')
<script>
    function toggleOtherContact() {
        let menu = document.querySelector(".kontakt_info_hidden");
        menu.classList.toggle("toggleContact");
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
                    <h2>{{__('Kontaktní Údaje')}}</h2>
                </div>
                <div class="kontakt_info_item_gdpr">
                    {{__('Poskytnuté kontaktní informace (telefon, e-mail apod.) budou využity výhradně za účelem komunikace v rámci výzkumné skupiny ohledně smluvené práce a souvisejících problémů po dobu aktivity účtu v KNOTIS. V KNOTIS budou kontaktní informace automaticky vymazány do 3 měsíců od vypršení aktivity účtu a zjištění zániku účtu na serveru merlin (ukončení studia) - pak již aktivitu účtu nelze znovu obnovit.')}}
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('Jméno')}}:</div>                   
                    <input type="text" size="25" maxlength="63" name="jmeno" title="{{__('Jméno')}}" value="{{$data->jmeno}}"> 
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('Příjmení')}}:</div>                   
                    <input type="text" size="25" maxlength="63" name="prijmeni" title="{{__('Příjmení')}}" value="{{$data->prijmeni}}">
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">{{__('Telefon')}}:</div>
                    <input type="text" size="25" maxlength="21"  name="telefon" title="{{__('Váš kontaktní telefon')}}" value="{{$data->telefon}}">               
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_item_span">Mail:</div>                   
                    <input type="text" size="25" maxlength="255" name="gmail" title="{{__('Váš Gmail účet nebo školní e-mail')}}" value="{{$data->gmail}}">
                </div>
                <div class="kontakt_info_item">                  
                    <a href="#" onclick="toggleOtherContact()">{{__('Přidat jiný kontakt')}}</a> <!--TODO-->
                </div>
                <div class=" kontakt_info_hidden">
                    <div class="kontakt_info_item">
                        <div class="kontakt_info_item_span">Facebook:</div>
                        <input type="text" size="25" maxlength="255" name="facebook" title="{{__('Váš kontaktní Facebook účet')}}" value="{{$data->facebook}}">
                    </div>
                    <div class="kontakt_info_item">
                        <div class="kontakt_info_item_span">Discord:</div>                   
                        <input type="text" size="25" maxlength="255" name="discord" title="{{__('Váš kontaktní Discord účet')}}" value="{{$data->discord}}">
                    </div>
                    <div class="kontakt_info_item">
                        <div class="kontakt_info_item_span">Skype:</div>      
                        <input type="text" size="25" maxlength="127" name="skype" title="{{__('Váš kontaktní Skype účet')}}" value="{{$data->skype}}">             
                    </div>
                    <div class="kontakt_info_item">
                        <div class="kontakt_info_item_span">ICQ:</div>  
                        <input type="text" size="25" maxlength="15" name="icq" title="{{__('Váše kontaktní ICQ')}}" value="{{$data->icq}}">                 
                    </div>
                    <div class="kontakt_info_item">
                        <div class="kontakt_info_item_span">Jabber:</div>                   
                        <input type="text" size="25" maxlength="127" name="jabber" title="{{__('Váš kontaktní jabber účet')}}" value="{{$data->jabber}}">
                    </div>
                </div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_button">
                        <button type="submit" class="btn btn-block btn-primary">{{__('Uložit')}}</button>
                    </div> 
                </div>
            </div>                                                    
        </form> 
    </div>
@endsection