<!-- detail projektu -->
<?php
    // Pole typů projektů
    $typProjektu[0] = __("Obecný projekt");
    $typProjektu[1] = __("Bakalářská práce");
    $typProjektu[2] = __("Diplomová práce");
    $typProjektu[3] = __("Disertační práce");
    $typProjektu[4] = __("Obecný projekt a BP");
    $typProjektu[5] = __("Obecný projekt a DP");

    // Pole stavů projektů
    $stavProjektu[0] = __("Nezadaný");
    $stavProjektu[1] = __("Řešený");
    $stavProjektu[2] = __("Ukončený");
    $stavProjektu[3] = __("K rozhodnutí");

    // Pole aktivit řešitelů
    $aktivitaResitele[0] = __("Ne");
    $aktivitaResitele[5] = __("Ano");

    // Pole stavy ukolu
    $stavyUkolu[0] = __("Smazaný");
    $stavyUkolu[1] = __("Nezadaný");
    $stavyUkolu[2] = __("Zadaný");
    $stavyUkolu[3] = __("Řešený");
    $stavyUkolu[4] = __("Vyřešený");
    $stavyUkolu[5] = __("Akceptovaný");
    $stavyUkolu[6] = __("Vrácený");
    $stavyUkolu[7] = __("Nejasný");
    $stavyUkolu[8] = __("Zodpovězený");

    function vypisOpravneni($opravneni)
    {
        if ($opravneni == 1)
        {  // pokud je oprávnění nedefinované
            return '???';
        }
        if ($opravneni == 2)
        {  // pokud je oprávnění pro čtení
            return __('Čtení');
        }
        else if ($opravneni == 3)
        {  // pokud je oprávnění pro zápis
            return __('Zápis');
        }
        else
        {  // pokud nemá být žádné oprávnění
            return '---';
        }
    }

    function vypisZoznamUloh($uloha, $stavyUkolu, $index){
        //dd($uloha->ukol);
        $poradie = $uloha->poradi;
        $zadanie = nl2br($uloha->zadani);
        $ukoncenie = Carbon\Carbon::parse($uloha->termin)->format('d.m.Y');
        $hotovo = $uloha->procenta;
        $komentar = $uloha->komentar;
        $vysledek = '';
        $vysledek = '<tr><td style="display:none"><input type="hidden" name="uloha_id['.$index.']" value="'.$uloha->id.'"></td><td style="display:none"><input type="hidden" name="uloha_ukol['.$index.']" value="'.$uloha->ukol.'"></td><td style="width:50px;padding:5px">'.$poradie.'</td><td style="width:900px;padding:5px">'.$zadanie.'</td><td style="width:180px;text-align:center;padding:5px">'.$ukoncenie.'</td><td style="width:120px;text-align:center;padding:5px">
        <select name="stav['.$index.']" class="stav-select">
        <option value="2" '.($uloha->stav == 2 ? 'selected' : '').'>'.__("Zadaný").'</option>
        <option value="3" '.($uloha->stav == 3 ? 'selected' : '').'>'.__("Řešený").'</option>
        <option value="4" '.($uloha->stav == 4 ? 'selected' : '').'>'.__("Vyřešený").'</option>
        </select>
        </td><td style="width:60px;text-align:center;padding:5px">
        <select name="hotovo['.$index.']" class="hotovo-select">';
        for ($i = 0; $i <= 100; $i++) {
            $vysledek .= '<option value="'.$i.'" '.($hotovo == $i ? 'selected' : '').'>'.$i.'</option>';
        }
        $vysledek .= '</select></td><td style="width:120px;text-align:center;padding:5px"><textarea name="komentar['.$index.']" style="margin:0px;margin-top:7px">'.$komentar.'</textarea></td></tr>';
        return $vysledek;
    }

    function vypisZoznamProstriedkov($prostriedok, $nazovServeru, $adresar_projektu){
        if ($prostriedok->typ_vyuziti == 0){
            $nazov = $prostriedok->nazev;
        }
        else{
            $nazov = '<span class="bold-red">' . $prostriedok->nazev . ' *</span>';
        }
        $cesta = $prostriedok->cesta;
        $server = $nazovServeru->nazev;
        $opravnenie = vypisOpravneni($prostriedok->opravneni);

        if (!empty($adresar_projektu)) {
            $adresar = $adresar_projektu[0]->nazev;
            $url = '<a href="'.$adresar_projektu[0]->url.'" target="_blank" title="URL: '.$adresar_projektu[0]->url.'"><img src="'.asset('wiki.gif').'" style="width:20px;margin-right:5px" alt="URL"/></a>';
        } else {
            
            $adresar = '';
            $url = '';
        }

        $vysledek = '';
        $vysledek = '<tr style="border:black solid 2px"><td style="width:200px;border:black solid 2px;border-left: black solid 4px;padding:5px">'.$nazov.'</td><td style="width:350px;border:black solid 2px;padding:5px">'.$cesta.'</td><td style="width:150px;text-align:center;border:black solid 2px;padding:5px">'.$server.'</td><td style="width:150px;border:black solid 2px;text-align:center;padding:5px">'.$opravnenie.'</td><td style="width:350px;border:black solid 2px;padding:5px;border-right: black solid 4px">'.$url .$adresar.'</td></tr>';
        return $vysledek;
    }

    function vypisUlohy($uloha1, $stavyUloh1, $stavyUkolu){
        $zadanie_ulohy = nl2br($uloha1->zadani);
        $odoslanie = Carbon\Carbon::parse($uloha1->termin)->format('d.m.Y');
        $zadanie_ulohy .= ' (' . $odoslanie .')';
        $vysledek = '';
        $vysledek = '<li>'.$zadanie_ulohy.'<ul>';
        $vysledek .= '<br>';
        foreach ($stavyUloh1 as $stavy) {
            $terminDateTime = new DateTime($stavy->odeslano);
            $formattedDateTime = $terminDateTime->format('d.m.Y H:i');
            $stavUlohy1 = $stavyUkolu[$stavy->stav];
            if ($stavy->stav == 3){
                $percenta = '['.$stavy->procenta.'%]';
            }
            else{
                $percenta = '';
            }

            $vysledek .= '<li class="vypis-uloh-li">'. $formattedDateTime .' - '. $stavUlohy1 .' '. $percenta .'</li>';
        }  
        $vysledek .='</ul></li>';
        return $vysledek;
    }

?>
<!-- TODO ukladanie stavu_uloh -->
@extends('dashboard')
@section('content')
    <div class="detail-projektu">
        <div class="detail-projektu-l">
            <h2>{{__('Detail projektu')}}</h2>
            <div class="medzera"></div>
            <hr>
            <div class="udaje_o_projekte">
                <h3>{{__('Informace o projektu')}}</h3>
                <div class="medzera"></div>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span" style="width:220px">{{__('Číslo')}}:</div>
                    {{$projekt->id}}
                </div>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span" style="width:220px">{{__('Typ')}}:</div>
                    {{$typProjektu[$projekt->typ]}}
                </div>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span" style="width:220px">{{__('Název')}}:</div>
                    {{$projekt->nazev}}
                </div>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span" style="width:220px">URL:</div>
                    <a href="{{$projekt->url}}" target="_blank" style="margin:0">{{$projekt->url}}</a>
                </div>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span" style="width:220px">{{__('Poznámka')}}:</div>
                    {{$projekt->poznamka}}
                </div>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span" style="width:220px">{{__('Zadán dne')}}:</div>
                    {{Carbon\Carbon::parse($projekt->zadan)->format('d.m.Y H:i');}}
                </div>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span" style="width:220px">{{__('Stav')}}:</div>
                    {{$stavProjektu[$projekt->stav]}}
                </div>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span" style="width:220px">{{__('Vedoucí')}}:</div>
                    {{ $veduci->prijmeni . " " . $veduci->jmeno . ", " . $veduci->titul_pred . ", " . $veduci->titul_za . " (" . $veduci->login . ")" }}
                </div>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span" style="width:220px">{{__('Zahájení a ukončení')}}:</div>
                    {{ $riesenie->resi_od . " - " . $riesenie->resi_do }}
                </div>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span" style="width:220px">{{__('Přístup k prostředkům do')}}:</div>
                    {{ $riesenie->resi_do }}
                </div>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span" style="width:220px">{{__('Aktivní')}}:</div>
                    @if ($riesenie->aktivita == 0)
                        <span class="nevyplnene-udaje">{{ $aktivitaResitele[$riesenie->aktivita] }}</span>
                    @elseif ($riesenie->aktivita == 5)
                        <span class="vyplnene-udaje">{{ $aktivitaResitele[$riesenie->aktivita] }}</span>
                    @endif
                </div>
                <div>
                    <form id="zoznam-uloh" action="{{route('update_ulohy_k_projektu')}}" method="post">
                        @if(Session::has('success1'))
                            <div class="alert alert-success">{{Session::get('success1')}}</div>
                        @endif
                        @if(Session::has('fail1'))
                            <div class="alert alert-danger">{{Session::get('fail1')}}</div>
                        @endif
                        @csrf 
                        <div class="osobne_info_item_span" style="width:60px">{{__('Úkoly')}}:</div>
                        <table id="ulohy-tabulka">
                            <thead>
                                <tr>
                                    <th class="projekty-table-thead-th" style="width:50px" title="{{__('číslo úkolu')}}">{{__('č.ú.')}}</th>
                                    <th class="projekty-table-thead-th" style="width:900px">{{__('Zadání úkolu')}}</th>
                                    <th class="projekty-table-thead-th" style="width:180px">{{__('Termín ukončení')}}</th>
                                    <th class="projekty-table-thead-th" style="width:120px">{{__('Stav úkolu')}}</th>
                                    <th class="projekty-table-thead-th" style="width:60px">{{__('Hotovo')}}</th>
                                    <th class="projekty-table-thead-th" style="width:120px">{{__('Komentář')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ulohy as $index => $uloha): ?>
                                    <?php                             
                                        echo vypisZoznamUloh($uloha, $stavyUkolu, $index);
                                    ?>
                                <?php endforeach; ?>                            
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6">
                                        <div style="margin-left:40%;margin-bottom:20px">
                                            <button type="submit" class="btn btn-block btn-primary">{{__('Uložit')}}</button>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            </div>
            <hr>
            <div>
                <h3>{{__('Prostředky')}}:</h3>
                <table id="riesene-projekty-tabulka">
                    <thead>
                        <tr style="border: black solid 4px;border-bottom:black solid 2px">
                            <th class="projekty-table-thead-th" style="width:200px">{{__('Název')}}</th>
                            <th class="projekty-table-thead-th" style="width:350px">{{__('Cesta')}}</th>
                            <th class="projekty-table-thead-th" style="width:150px">{{__('Server')}}</th>
                            <th class="projekty-table-thead-th" style="width:150px">{{__('Oprávnění')}}</th>
                            <th class="projekty-table-thead-th" style="width:350px">{{__('Prostředek je adresářem projektu')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($prostriedky as $prostriedok): ?>
                            <div class="vypis-prostriedkov">
                                <?php 
                                    $nazovServeru = DB::table('server')
                                        ->select('id_server', 'nazev')
                                        ->where('id_server', $prostriedok->server)
                                        ->first();
                                    $dotaz = DB::table('prostr_proj')
                                        ->select('prostredek.id', 'projekt.nazev', 'projekt.url')    
                                        ->join('projekt', 'prostr_proj.id_projektu', '=', 'projekt.id')
                                        ->join('prostredek', 'prostr_proj.id_prostredku', '=', 'prostredek.id')
                                        ->where('prostr_proj.vyuzivan', '>', 0)
                                        ->where('prostr_proj.typ_vyuziti', '=', '1')
                                        ->orderBy('projekt.nazev')
                                        ->get();
                                    $adresar_projektu = [];
                                    foreach ($dotaz as $trojice) {
                                        if ($trojice->id == $prostriedok->id) {
                                            $adresar_projektu[] = $trojice;
                                        }
                                    }
                                    
                                    //dd($adresar_projektu[0]);
                                    echo vypisZoznamProstriedkov($prostriedok, $nazovServeru, $adresar_projektu);
                                ?>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr style="border: black solid 4px;border-bottom:black solid 2px">
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div class="medzera"></div>
            <hr>
            <div>
                <h3>{{__('Úkoly')}}:</h3>
                <ol class="vypis-prostriedkov" style="margin-left:25px">
                    <?php foreach ($ulohy1 as $uloha1): ?>
                        <?php 
                            $stavyUloh1 = DB::table('stavy_ukolu')
                                ->where('ukol', $uloha1->id)
                                ->orderBy('id', 'asc')
                                ->get();    
                            echo vypisUlohy($uloha1, $stavyUloh1, $stavyUkolu);
                        ?> 
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
        <div class="medzera"></div>
    </div>
@endsection