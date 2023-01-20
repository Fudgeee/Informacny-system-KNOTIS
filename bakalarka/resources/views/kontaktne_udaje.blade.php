<!--KONTAKTNE UDAJE-->
@extends('dashboard')
@section('content')
<script>
    function toggleOtherContact() {
        let menu = document.querySelector(".kontakt_info_hidden");
        menu.classList.toggle("toggleContact");
    }

    var mainNodeNameSkupiny = "TR";    
    function deleteInput(obj){
        while(obj.nodeName != mainNodeNameSkupiny){
            obj = obj.parentNode;
        }
        obj.parentNode.removeChild(obj);
    }

    function addInputEmail(idSkupiny){
        var html = "";
        var row	= document.getElementById(idSkupiny).insertRow(-1);     
        html += '<td><input type="text" style="margin-right:5px" size="13" maxlength="255" name="typ" title="TODO" value="Mail"><input type="text" style="margin-right:5px" size="25" maxlength="255" name="hodnota" title="{{__('Váš Gmail účet nebo školní e-mail')}}" value=""><input type="text" style="margin-right:5px" size="25" maxlength="255" name="popis" title="TODO" value="" placeholder="popis"><a href="#" onclick="deleteInput(this);return false;"><img src="red-x.gif" style="width:20px" title="TODO" alt="TODO"/></a></td>';
        // vlozeni HTML kodu do znacky
        row.innerHTML = html;
    }

    function addInputTelefon(idSkupiny){
        var html = "";
        var row	= document.getElementById(idSkupiny).insertRow(-1);     
        html += '<td><input type="text" style="margin-right:5px" size="13" maxlength="255" name="typ" title="TODO" value="Telefon"><input type="text" style="margin-right:5px" size="25" maxlength="255" name="hodnota" title="{{__('Váš kontaktní telefon')}}" value=""><input type="text" style="margin-right:5px" size="25" maxlength="255" name="popis" title="TODO" value="" placeholder="popis"><a href="#" onclick="deleteInput(this);return false;"><img src="red-x.gif" style="width:20px" title="TODO" alt="TODO"/></a></td>';
        // vlozeni HTML kodu do znacky
        row.innerHTML = html;
    }

    function addInputOther(idSkupiny){
        var html = "";
        var row	= document.getElementById(idSkupiny).insertRow(-1);     
        html += '<td><input type="text" style="margin-right:5px" size="13" maxlength="255" name="typ" title="TODO" value="" placeholder="typ kontaktu"><input type="text" style="margin-right:5px" size="25" maxlength="255" name="hodnota" title="TODO" value=""><input type="text" style="margin-right:5px" size="25" maxlength="255" name="popis" title="TODO" value="" placeholder="popis"><a href="#" onclick="deleteInput(this);return false;"><img src="red-x.gif" style="width:20px" title="TODO" alt="TODO"/></a></td>';
        // vlozeni HTML kodu do znacky
        row.innerHTML = html;
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
            </div>
            <hr class="hr-kontaktne-udaje">
            <div class="kontakt_info_l">
                <table id="emaily">
                    <tr>
                        <td>
                            <div class="kontakt_info_item_span1">                
                                <span>Mail:</span>
                                <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                            </div>              
                            <input type="text" size="25" maxlength="255" name="mail" title="{{__('Váš Gmail účet nebo školní e-mail')}}" value="{{$data->gmail}}">
                            <input type="text" size="25" maxlength="255" name="mail-popis" title="TODO" value="" placeholder="popis">
                            <a href="javascript:void(0)" onclick="addInputEmail('emaily');"><img src="green-plus.gif" style="width:20px" title="TODO" alt="TODO"/></a>
                        </td>
                    </tr>
                </table>
                <table id="telefony">
                    <tr>
                        <td>
                            <div class="kontakt_info_item_span1">                
                                <span>{{__('Telefon')}}:</span>
                                <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                            </div>              
                            <input type="text" size="25" maxlength="255" name="telefon" title="{{__('Váš kontaktní telefon')}}" value="{{$data->telefon}}">
                            <input type="text" size="25" maxlength="255" name="telefon-popis" title="TODO" value="" placeholder="popis">
                            <a href="javascript:void(0)" onclick="addInputTelefon('telefony');"><img src="green-plus.gif" style="width:20px" title="TODO" alt="TODO"/></a>
                        </td>
                    </tr>
                </table>
                <table id="other">
                    <tr>
                        <td>
                            <div class="kontakt_info_button_add">
                                <a href="#" onclick="addInputOther('other');" class="btn btn-primary">{{__('Přidat jiný kontakt')}}</a>
                            </div>    
                        </td>
                    </tr>
                </table>
                <div class="medzera"></div>
                <div class="kontakt_info_item">
                    <div class="kontakt_info_button">
                        <button type="submit" class="btn btn-block btn-primary">{{__('Uložit')}}</button>
                    </div> 
                </div>
                <div class="kontakt_info_item_gdpr">
                    {{__('Poskytnuté kontaktní informace (telefon, e-mail apod.) budou využity výhradně za účelem komunikace v rámci výzkumné skupiny ohledně smluvené práce a souvisejících problémů po dobu aktivity účtu v KNOTIS. V KNOTIS budou kontaktní informace automaticky vymazány do 3 měsíců od vypršení aktivity účtu a zjištění zániku účtu na serveru merlin (ukončení studia) - pak již aktivitu účtu nelze znovu obnovit.')}}
                </div>
            </div>                                                    
        </form> 
    </div>
@endsection