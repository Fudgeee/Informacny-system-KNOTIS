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
    $stavProjektu[0] = 'Nezadaný';
    $stavProjektu[1] = 'Řešený';
    $stavProjektu[2] = 'Ukončený';
    $stavProjektu[3] = 'K rozhodnutí';

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

    function vypisZoznamProstriedkov($prostriedok, $nazovServeru){
        $nazov = $prostriedok->nazev;
        $cesta = $prostriedok->cesta;
        $server = $nazovServeru->nazev;
        $opravnenie = vypisOpravneni($prostriedok->opravneni);
        $adresar = "TODO";
        
        $vysledek = '';
        $vysledek = '<tr style="border:black solid 2px"><td style="width:200px;border:black solid 2px;border-left: black solid 4px;text-align:center;padding:5px">'.$nazov.'</td><td style="width:350px;border:black solid 2px;padding:5px">'.$cesta.'</td><td style="width:150px;text-align:center;border:black solid 2px;padding:5px">'.$server.'</td><td style="width:150px;border:black solid 2px;text-align:center;padding:5px">'.$opravnenie.'</td><td style="width:350px;text-align:center;border:black solid 2px;padding:5px;border-right: black solid 4px">'.$adresar.'</td></tr>';
        return $vysledek;
    }

?>
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
                    <a href="#"><img src="{{asset('detail.gif')}}" style="width:35px;margin-right:5px" title="{{__('Detaily')}}" alt="Detaily"/></a>
                    <a href="#"><img src="{{asset('edit.gif')}}" style="width:35px;margin-left:5px" title="{{__('Upravit')}}" alt="Upravit"/></a>
                    <a href="#"><img src="{{asset('vykazy.gif')}}" style="width:35px;margin-right:5px" title="{{__('Pracovní výkazy')}}" alt="Vykazy"/></a>
                    <a href="#"><img src="{{asset('prostredky.gif')}}" style="width:35px;margin-left:5px" title="{{__('Prostředky')}}" alt="Prostředky"/></a>
                    <a href="#"><img src="{{asset('resitele.gif')}}" style="width:35px;margin-right:5px" title="{{__('Řešitelé')}}" alt="Řešitelé"/></a>
                    <a href="#"><img src="{{asset('sleduji.gif')}}" style="width:35px;margin-left:5px" title="{{__('Příjemci zpráv')}}" alt="Příjemci_zpráv"/></a>
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
                    {{$projekt->zadan}}
                </div>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span" style="width:220px">{{__('Stav')}}:</div>
                    {{$stavProjektu[$projekt->stav]}}
                </div>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span" style="width:220px">{{__('Vedoucí')}}:</div>
                    {{ $veduci->prijmeni . " " . $veduci->jmeno . ", " . $veduci->titul_pred . ", " . $veduci->titul_za . "(" . $veduci->login . ")" }}
                </div>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span" style="width:220px">{{__('Zahájení a ukončení')}}:</div>
                    {{"TODO"}}
                </div>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span" style="width:220px">{{__('Přístup k prostředkům do')}}:</div>
                    {{"TODO"}}
                </div>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span" style="width:220px">{{__('Aktivní')}}:</div>
                    {{"TODO"}}
                </div>
                <div class="medzera"></div>
            </div>
            <hr>
            <div>
                <h3>{{__('Úkoly')}}:</h3>
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

                                echo vypisZoznamProstriedkov($prostriedok, $nazovServeru);
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
            <hr>
            <div>
                <h3>{{__('Úkoly')}}:</h3>
            </div>
        </div>
        <div class="medzera"></div>
    </div>
@endsection