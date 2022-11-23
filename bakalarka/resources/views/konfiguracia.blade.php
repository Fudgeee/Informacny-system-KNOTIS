<!--KONFIGURACIA-->
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
                    <div class="osobne_info_item">
                            <a href="#" class="btn btn-block btn-secondary">{{__('Změnit zabezpečení sezení')}}</a>
                    </div> 
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span" style="margin-top:5.5px">{{__('Opožděné vykazování')}}:</div>
                        <input type="text" size="20" style="height:38px" maxlength="2" name="zpozdeni_vykazu" title="{{__('Zde si můžete nastavit, do kolika hodin v pondělí budete mít ještě předvolený minulý týden pro vykazování výkazů z předešlého týdne. Maximální hodnota je 24 hodin.')}}" value="{{$data->zpozdeni_vykazu}}">
                    </div>    
                </div>                                                                 
                <div class="preferencie">
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span">{{__('Kopie výkazů')}}:</div>
                        <select name="upravKopie" title="{{__('Zasílat kopie výkazů e-mailem?')}}" size="1">
                        @if ($data['zasilat_kopie'] == 1)
                                <option value="1" selected>{{__('Ano')}}</option>
                                <option value="0">{{__('Ne')}}</option>
                        @else
                            <option value="1">{{__('Ano')}}</option>
                            <option value="0" selected>{{__('Ne')}}</option>
                        @endif
                        </select>
                    </div>
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span">{{__('Úvodní stránka')}}:</div>
                        <select name="upravUvodni" id="upravUvodni" title="{{__('Stránka, která se zobrazí po přihlášení')}}" size="1">
                            <!--generujPolozkyVyberuSId($uvodniStr,false,$data['str_po_prihlaseni']) TODO -->
                        </select>
                    </div>
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span">{{__('Uložení nastavení systému')}}:</div>
                        <select name="uprav_ukladani_sezeni" title="{{__('Jaké nastavení systému se uloží')}}" size="1">
                            <!--generujPolozkyVyberuSId($po_odhlaseni_ulozenoR,false,$data['vychozi_ulozeni_sezeni']) TODO -->
                        </select>
                    </div>
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span">{{__('U wiki úkolů hlídat')}}:</div>
                        <select name="uprav_hlidani_wiki_ukolu" title="{{__('Jak si přejete hlídat wiki úkoly')}}" size="1">'
                            <!--generujPolozkyVyberuSId($hlidani_wiki_ukolu,false,$data['hlidani_wiki_ukolu'] TODO -->
                        </select>
                    </div>
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span">{{__('IP adresy')}}:</div>
                        <a href="#" onclick="addInput()">{{__('Přidat')}} +</a> <!--TODO-->
                    </div>
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span">Hosts allow:</div>

                    </div> 
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span">IPv4 Tables:</div>

                    </div> 
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span">IPv6 Tables:</div>

                    </div>
                    <div class="osobne_info_item">
                        <div class="osobne_info_button">
                            <button type="submit" class="btn btn-block btn-primary">{{__('Uložit')}}</button>
                        </div> 
                    </div> 
                </div>               
            </form>
        </div>
        <div class="medzera"></div>
        <div class="opravnenia_k_serverom">
            <div class="opravnenia">
                <h1>{{__('Oprávnění k serverům')}}</h1>
                <div class="osobne_info_item">
                    <div class="osobne_info_item_span">{{__('Přístup k Redmine')}}:</div>
                    @if($data->pristup_k_redmine === 0)
                        {{__('Ne')}}
                    @else
                        {{__('Ano')}} &nbsp (<a href="https://knot.fit.vutbr.cz/redmine" title="{{__('Odkaz na Redmine')}}" target="_blank">https://knot.fit.vutbr.cz/redmine</a>)
                    @endif
                </div>
                
            </div>
        </div>
    </div>
@endsection