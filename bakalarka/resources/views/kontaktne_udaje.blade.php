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
@endsection