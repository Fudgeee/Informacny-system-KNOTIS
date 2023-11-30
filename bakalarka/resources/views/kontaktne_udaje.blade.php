<!--KONTAKTNE UDAJE-->
@extends('dashboard')
@section('content')
<?php 
    function vypisZoznamMailov($mail){
        $vysledek = '';
        $vysledek = '<tr><td><input type="text" size="1" name="id[]" class="hidden" value="'.$mail->id.'"><input type="text" style="outline:none; cursor:default; font-weight:500; background:none; border:none; padding:0px; width:160px" size="13" maxlength="255" name="typ[]" value="'.$mail->typ.':" readonly><input type="text" style="margin-right:4px" size="25" maxlength="255" name="hodnota[]" title="' . __('Vaše e-mailová adresa') . '" value="'.$mail->hodnota.'"><input type="text" class="autocomplete-input-popis" style="margin-right:5px" size="25" maxlength="255" name="popis[]" title="' . __('Popis') . '" value="'.$mail->popis.'" placeholder="popis"><a href="#" onclick="deleteInput(this);return false;"><img src="red-x.gif" style="width:20px" title="' . __('Vymazat') . '" alt="Vymazat"/></a></td></tr>';
        return $vysledek;
    }  

    function vypisZoznamTelefonov($tel){
        $vysledek = '';
        $vysledek = '<tr><td><input type="text" size="1" name="id[]" class="hidden" value="'.$tel->id.'"><input type="text" style="outline:none; cursor:default; font-weight:500; background:none; border:none; padding:0px; width:160px" size="13" maxlength="255" name="typ[]" value="'.$tel->typ.':" readonly><input type="text" style="margin-right:4px" size="25" maxlength="255" name="hodnota[]" title="' . __('Váš kontaktní telefon') . '" value="'.$tel->hodnota.'"><input type="text" class="autocomplete-input-popis" style="margin-right:5px" size="25" maxlength="255" name="popis[]" title="' . __('Popis') . '" value="'.$tel->popis.'" placeholder="popis"><a href="#" onclick="deleteInput(this);return false;"><img src="red-x.gif" style="width:20px" title="' . __('Vymazat') . '" alt="Vymazat"/></a></td></tr>';
        return $vysledek;
    }  

    function vypisZoznamKontaktnychUdajov($kontakt){
        $vysledek = '';
        $vysledek = '<tr><td><input type="text" size="1" name="id[]" class="hidden" value="'.$kontakt->id.'"><input type="text" class="autocomplete-input" style="margin-right:5px" size="13" maxlength="255" name="typ[]" id="typ" title="' . __('Typ kontaktu') . '" value="'.$kontakt->typ.'" placeholder="typ kontaktu"><div id="typList"></div><input type="text" style="margin-right:4px" size="25" maxlength="255" name="hodnota[]" title="' . __('Kontakt') . '" value="'.$kontakt->hodnota.'"><input type="text" class="autocomplete-input-popis" style="margin-right:5px" size="25" maxlength="255" name="popis[]" title="' . __('Popis') . '" value="'.$kontakt->popis.'" placeholder="popis"><a href="#" onclick="deleteInput(this);return false;"><img src="red-x.gif" style="width:20px" title="' . __('Vymazat') . '" alt="Vymazat"/></a></td></tr>';
        return $vysledek;
    }

    $typyKontaktov = array_unique($kontaktTyp);
    $jsonTypyKontaktov = json_encode($typyKontaktov);
    $popisyKontaktov1 = ["práce", "domů"];
    $kontaktPopisy = array_merge($kontaktPopis, $popisyKontaktov1);
    $popisyKontaktov = array_unique($kontaktPopisy);
    $jsonPopisyKontaktov = json_encode($popisyKontaktov);
?>
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
        html += '<td><input type="text" size="1" name="id[]" class="hidden" value=""><input type="text" style="outline:none; cursor:default; font-weight:500; background:none; border:none; padding:0px; width:160px" size="13" maxlength="255" name="typ[]" value="Mail" readonly><input type="text" style="margin-right:4px" size="25" maxlength="255" name="hodnota[]" title="{{__('Vaše e-mailová adresa')}}" value=""><input type="text" class="autocomplete-input-popis" style="margin-right:5px" size="25" maxlength="255" name="popis[]" title="{{__('Popis')}}" value="" placeholder="popis"><a href="#" onclick="deleteInput(this);return false;"><img src="red-x.gif" style="width:20px" title="{{__('Vymazat')}}" alt="Vymazat"/></a></td>';
        // vlozeni HTML kodu do znacky
        row.innerHTML = html;
        initAutocompleteInputs();
    }

    function addInputTelefon(idSkupiny){
        var html = "";
        var row	= document.getElementById(idSkupiny).insertRow(-1);     
        html += '<td><input type="text" size="1" name="id[]" class="hidden" value=""><input type="text" style="outline:none; cursor:default; font-weight:500; background:none; border:none; padding:0px; width:160px" size="13" maxlength="255" name="typ[]" value="Telefon" readonly><input type="text" style="margin-right:4px" size="25" maxlength="255" name="hodnota[]" title="{{__('Váš kontaktní telefon')}}" value=""><input type="text" class="autocomplete-input-popis" style="margin-right:5px" size="25" maxlength="255" name="popis[]" title="{{__('Popis')}}" value="" placeholder="popis"><a href="#" onclick="deleteInput(this);return false;"><img src="red-x.gif" style="width:20px" title="{{__('Vymazat')}}" alt="Vymazat"/></a></td>';
        // vlozeni HTML kodu do znacky
        row.innerHTML = html;
        initAutocompleteInputs();
    }

    function addInputOther(idSkupiny){
        var html = "";
        var row	= document.getElementById(idSkupiny).insertRow(-1);     
        html += '<td><input type="text" size="1" name="id[]" class="hidden" value=""><input type="text" class="autocomplete-input" style="margin-right:5px" size="13" maxlength="255" name="typ[]" id="typ" title="{{__('Typ kontaktu')}}" value="" placeholder="typ kontaktu"><div id="typList"></div><input type="text" style="margin-right:4px" size="25" maxlength="255" name="hodnota[]" title="{{__('Kontakt')}}" value=""><input type="text" class="autocomplete-input-popis" style="margin-right:5px" size="25" maxlength="255" name="popis[]" title="{{__('Popis')}}" value="" placeholder="popis"><a href="#" onclick="deleteInput(this);return false;"><img src="red-x.gif" style="width:20px" title="{{__('Vymazat')}}" alt="Vymazat"/></a></td>';
        // vlozeni HTML kodu do znacky
        row.innerHTML = html;
        initAutocompleteInputs();
    }

    function initAutocompleteInputs() {
        var typyKontaktov = <?php echo $jsonTypyKontaktov; ?>;
        var popisyKontaktov = <?php echo $jsonPopisyKontaktov; ?>;

        $(".autocomplete-input").autocomplete({
            source: typyKontaktov
        });

        $(".autocomplete-input-popis").autocomplete({
            source: popisyKontaktov
        });
    }

    var typyKontaktov = <?php echo $jsonTypyKontaktov; ?>;
    $(function() {
      $(".autocomplete-input").autocomplete({
        source: typyKontaktov
      });
    });

    var popisyKontaktov = <?php echo $jsonPopisyKontaktov; ?>;
    $(function() {
      $(".autocomplete-input-popis").autocomplete({
        source: popisyKontaktov
      });
    }); 
</script>
<script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
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
                            <input type="text" class="autocomplete-input-popis" size="25" maxlength="255" name="mail_popis" title="{{__('Popis')}}" value="{{$data->gmail_popis}}" placeholder="popis">
                            <a href="javascript:void(0)" onclick="addInputEmail('emaily');"><img src="green-plus.gif" style="width:20px" title="{{__('Přidat')}}" alt="Přidat"/></a>
                        </td>
                    </tr>
                    <?php foreach ($kontakt_data_mail as $mail): ?>
                        <div class="mail-kontakt"><?php echo vypisZoznamMailov($mail); ?></div>
                    <?php endforeach; ?>
                </table>
                <table id="telefony">
                    <tr>
                        <td>
                            <div class="kontakt_info_item_span1">                
                                <span>{{__('Telefon')}}:</span>
                                <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                            </div>              
                            <input type="text" size="25" maxlength="255" name="telefon" title="{{__('Váš kontaktní telefon')}}" value="{{$data->telefon}}">
                            <input type="text" class="autocomplete-input-popis" size="25" maxlength="255" name="telefon_popis" title="{{__('Popis')}}" value="{{$data->telefon_popis}}" placeholder="popis">
                            <a href="javascript:void(0)" onclick="addInputTelefon('telefony');"><img src="green-plus.gif" style="width:20px" title="{{__('Přidat')}}" alt="Přidat"/></a>
                        </td>
                    </tr>
                    <?php foreach ($kontakt_data_telefon as $tel): ?>
                        <div class="telefon-kontakt"><?php echo vypisZoznamTelefonov($tel); ?></div>
                    <?php endforeach; ?>
                </table>
                <table id="other">
                    <tr>
                        <td>
                            <div class="kontakt_info_button_add">
                                <a href="#" onclick="addInputOther('other');" class="btn btn-primary">{{__('Přidat jiný kontakt')}}</a>
                            </div>    
                        </td>
                    </tr>
                    <?php foreach ($kontakt_data_other as $kontakt): ?>
                        <div class="other-kontakt"><?php echo vypisZoznamKontaktnychUdajov($kontakt); ?></div>
                    <?php endforeach; ?>
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