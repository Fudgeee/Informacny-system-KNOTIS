<!--KONFIGURACIA-->
<?php
    $uvodniStr = Array();
    $uvodniStr[0] = __("Úvodní stránka");
    if ($data['opravneni'][2] == 'A')
    {  // pokud má uživatel oprávnění k výpisu osob
    $uvodniStr[2001] = __("Osoby");
    }
    if ($data['opravneni'][3] == 'A')
    {  // pokud má uživatel oprávnění k výpisu projektů
    $uvodniStr[5] = __("Projekty");
    $uvodniStr[14] = __("Prostředky");
    }
    if ($data['opravneni'][7] == 'A')
    {  // pokud má uživatel oprávnění k výpisu pracovních výkazů ostatních
    $uvodniStr[23] = __("Denní výkazy");
    $uvodniStr[24] = __("Týdenní výkazy");
    }
    $uvodniStr[8] = __("Pracovní výkazy");
    $uvodniStr[11] = __("Plán práce");
    $uvodniStr[12] = __("Řešené projekty");
    if ($data['opravneni'][9] == 'A' && $data['opravneni'][13] == 'A')
    {  // pokud má uživatel oprávnění ke spouštění skriptů
    $uvodniStr[20] = __("Skript pro oprávnění");
    }
    if ($data['opravneni'][9] == 'A')
    {  // pokud má uživatel oprávnění k údržbě systému
    $uvodniStr[10] = __("Údržba");
    }
    if ($data['opravneni'][17] == 'A')
    {  // pokud má uživatel oprávnění k prohlížení odeslaných e-mailů
    $uvodniStr[27] = __("Odeslané e-maily");
    }
    $uvodniStr[48] = __("Import výkazů ze souboru");
    if ($data['opravneni'][20] == 'A')
    {  // pokud má uživatel oprávnění k prohlížení DPP
    $uvodniStr[77] = __("Dohody o provedení práce");
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

    $po_odhlaseni_ulozenoR[0]='Z posledního nastavení systému';
    $po_odhlaseni_ulozenoR[1]='Z odhlašovaného panelu';

    $hlidani_wiki_ukolu[0] = "Nic";
    $hlidani_wiki_ukolu[1] = "Přiřazení projektů";
    $hlidani_wiki_ukolu[2] = "Aktivitu osob";
    $hlidani_wiki_ukolu[3] = "Přiřazení projektů a aktivitu osob";

    function vypisZoznamServerov($server, $data){
        $vysledek = '';
        $maOpravneni = __('Ne');
        $maSudo = "";
        $id = $server['id_server'];
        if (isset($data['opravneniKS'][$id])){
            $maOpravneni = __('Ano');
        }
        if ((isset($data['sudoKS'][$id])) && (($data['sudoKS'][$id]) > 0)){    
            $maSudo = " + sudo";
        }       
        $vysledek = '<span class="serverNazov">'.$server['nazev'].'</span>'.' '.$maOpravneni.' '.$maSudo;
        return $vysledek;
    }

    function vypisZoznamIpAdries($host){
        $vysledek = '';
        $vysledek = '<tr><td><input type="text" size="40" maxlength="63" name="upravIp[]" value="'.$host->ip.'"><input type="text" class="hidden" name="ipId[]" id="ipId" value="'.$host->id.'"></td>';
        $vysledek .= '<td><a href="#" onclick="deleteInputFromDB(); deleteInput(this);return false;"><img src="red-x.gif" style="width:20px"/></a></td></tr>';
        return $vysledek;
    }  
?>

<script>
    var mainNodeNameSkupiny = "TR";    
    function deleteInput(obj){
        while(obj.nodeName != mainNodeNameSkupiny){
            obj = obj.parentNode;
        }
        obj.parentNode.removeChild(obj);
    }

    function deleteInputFromDB(){
        //$zoznam .= $host_id;
        // $element = document.getElementById('ipId').value;
        // console.log($element);
        // TODO 
    }

    function addInput(idSkupiny, nameInputu){
        var html = "";
        var row	= document.getElementById(idSkupiny).insertRow(-1);       
        html += '<td><input type="text" size="40" maxlength="63" title="IP adresy" name="'+nameInputu+'[]" value=""></td>';
        html +=	'<td><a href="#" onclick="deleteInput(this);return false;"><img src="red-x.gif" style="width:20px" title="Smazat přiřazení ve skupině" alt="Smazat přiřazení ve skupině"/></a></td>';
        // vlozeni HTML kodu do znacky
        row.innerHTML = html;
    }  
</script>
@extends('dashboard')
@section('content')
    <div class="konfiguracia">
        <div class="konfiguracia_l">
            <form action="{{route('update_konfiguracia')}}" method="post">
                @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif
                @if(Session::has('fail'))
                    <div class="alert alert-danger">{{Session::get('fail')}}</div>
                @endif
                @csrf
                <div class="osobne_info_l">
                    <div class="osobne_info_h1">
                        <h1>{{__('Konfigurace')}}</h1>
                    </div>
                </div>
                <hr class="hr-konfiguracia">
                <div class="osobne_info_l">
                    <div class="konfiguracia_item">
                            <a href="#" class="btn btn-block btn-primary">{{__('Změnit zabezpečení sezení')}}</a>
                    </div> 
                    <div class="osobne_info_item">
                        <div class="konfiguracia_item_span">{{__('Opožděné vykazování')}}:</div>
                        <input type="text" size="29" style="height:29px" maxlength="2" name="zpozdeni_vykazu" title="{{__('Zde si můžete nastavit, do kolika hodin v pondělí budete mít ještě předvolený minulý týden pro vykazování výkazů z předešlého týdne. Maximální hodnota je 24 hodin.')}}" value="{{$data->zpozdeni_vykazu}}">
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>    
                </div>
                                                                             
                <div class="preferencie">
                    <div class="osobne_info_item">
                        <div class="konfiguracia_item_span">{{__('Kopie výkazů')}}:</div>
                        <select name="zasilat_kopie" title="{{__('Zasílat kopie výkazů e-mailem?')}}" size="1">
                            @if ($data['zasilat_kopie'] == 1)
                                    <option value="1" selected>{{__('Ano')}}</option>
                                    <option value="0">{{__('Ne')}}</option>
                            @else
                                <option value="1">{{__('Ano')}}</option>
                                <option value="0" selected>{{__('Ne')}}</option>
                            @endif
                        </select>
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="osobne_info_item">
                        <div class="konfiguracia_item_span">{{__('Úvodní stránka')}}:</div>
                        <select name="str_po_prihlaseni" title="{{__('Stránka, která se zobrazí po přihlášení')}}" size="1">
                            <?php echo generujPolozkyVyberuSId($uvodniStr,false,$data['str_po_prihlaseni']);?>
                        </select>
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="osobne_info_item">
                        <div class="konfiguracia_item_span">{{__('Uložení nastavení systému')}}:</div>
                        <select name="vychozi_ulozeni_sezeni" title="{{__('Jaké nastavení systému se uloží')}}" size="1">
                            <?php echo generujPolozkyVyberuSId($po_odhlaseni_ulozenoR,false,$data['vychozi_ulozeni_sezeni']);?>
                        </select>
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="osobne_info_item">
                        <div class="konfiguracia_item_span">{{__('U wiki úkolů hlídat')}}:</div>
                        <select name="hlidani_wiki_ukolu" title="{{__('Jak si přejete hlídat wiki úkoly')}}" size="1">'
                            <?php echo generujPolozkyVyberuSId($hlidani_wiki_ukolu,false,$data['hlidani_wiki_ukolu']);?>
                        </select>
                        <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                    </div>
                    <div class="osobne_info_item1">
                        <div class="konfiguracia_item_span">{{__('IP adresy')}}:</div>
                        <table id="ipAdresy">
                            <tr>
                                <td>
                                    <a href="javascript:void(0)" onclick="addInput('ipAdresy', 'upravIp');" class="btn btn-primary ip-adresy">{{__('Přidat')}} +</a>
                                </td>
                                <td></td>
                            </tr>
                            <?php foreach ($ipAdresy as $host): ?>
                                <div class="td-server"><?php echo vypisZoznamIpAdries($host); ?></div>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <div class="osobne_info_item_textarea">
                        <label for="upravHosts" class="popisVstupu konfiguracia_item_span">Hosts allow:</label>
                        <textarea id="upravHosts" class="field_hosts" name="hosts_allow">{{$data["hosts_allow"]}}</textarea>
                    </div> 
                    <div class="osobne_info_item_textarea">
                        <label for="upravIp4Tables" class="popisVstupu konfiguracia_item_span">IPv4 Tables:</label>
                        <textarea id="upravIp4Tables" class="field_hosts" name="ip4_tables">{{$data["ip4_tables"]}}</textarea>
                    </div> 
                    <div class="osobne_info_item_textarea">
                        <label for="upravIp6Tables" class="popisVstupu konfiguracia_item_span">IPv6 Tables:</label>
                        <textarea id="upravIp6Tables" class="field_hosts" name="ip6_tables">{{$data["ip6_tables"]}}</textarea>
                    </div>
                    <div class="konfiguracia_button">
                        <button type="submit" class="btn btn-block btn-primary">{{__('Uložit')}}</button>
                    </div> 
                </div>               
            </form>
        </div>
        <div class="medzera"></div>
        <div class="opravnenia_k_serverom">
            <div class="opravnenia">
                <h1>{{__('Oprávnění k serverům')}}</h1>
            </div>
            <hr class="hr-konfiguracia">
            <div class="opravnenia">
                <div class="osobne_info_item">
                    <div class="pristup_redmine_item_span">{{__('Přístup k Redmine')}}:</div>
                    @if($data->pristup_k_redmine === 0)
                        <span class="nevyplnene-udaje">{{__('Ne')}}</span>
                    @else
                        <span class="vyplnene-udaje">{{__('Ano')}} &nbsp</span><a href="https://knot.fit.vutbr.cz/redmine" title="{{__('Odkaz na Redmine')}}" target="_blank">https://knot.fit.vutbr.cz/redmine</a>
                    @endif
                </div>
                <div class="osobne_info_items">
                    <?php foreach ($servery as $id => $server): ?>
                        <div class="td-server"><?php echo vypisZoznamServerov($server, $data); ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="medzera"></div>
    </div>
@endsection