<!--OSOBNE INFORMACIE-->
@extends('dashboard')
@section('content')
    <div class="osobne_informacie">
        <div>
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
                        <div class="osobne_info_item">
                            <div class="osobne_info_item_span">Číslo:</div>
                            {{$data->id}}
                        </div>
                        <div class="osobne_info_item">
                            <div class="osobne_info_item_span">Login:</div>
                            {{$data->login}}
                        </div>
                        <div class="osobne_info_item">
                            <div class="osobne_info_item_span">Aktivní:</div>
                            @if (($data->aktivni_do == "0000-00-00 00:00:00") || ($data->aktivni_do == ""))
                                {{$data->aktivni_od. " - "}} &infin;
                            @else
                                {{$data->aktivni_od. " - " .$data->aktivni_do}}
                            @endif
                        </div>
                        <div class="osobne_info_item">
                            <div class="osobne_info_item_span">Práce:</div>
                            @if (($data->odpracovat_do == "0000-00-00 00:00:00") || ($data->odpracovat_do == ""))
                                {{$data->odpracovat_od. " - "}} &infin;
                            @else
                                {{$data->odpracovat_od. " - " .$data->odpracovat_do}}
                            @endif
                        </div>
                        <div class="osobne_info_item" style="float:left">
                            <div class="osobne_info_item_span" style="margin-top:5.5px">Opožděné vykazování:</div>
                            <input type="text" size="20" style="height:38px" maxlength="2" name="zpozdeni_vykazu" title="Zde si můžete nastavit, do kolika hodin v pondělí budete mít ještě předvolený minulý týden pro vykazování výkazů z předešlého týdne. Maximální hodnota je 24 hodin." value="{{$data->zpozdeni_vykazu}}">
                        </div>
                        <div class="osobne_info_button">
                            <button type="submit" class="btn btn-block btn-primary">Uložit</button>
                        </div>   
                        <div class="osobne_info_item" style="margin-bottom: 20px">
                                <a href="#" class="btn btn-block btn-secondary">Změnit zabezpečení sezení</a>
                        </div>  
                    </div>                                                    
                </form>
            </div> 
            <div class="medzera"></div>
            <div class="osobne_preferencie">
                <form action="{{route('update_personal_info2')}}" method="post">
                    @if(Session::has('success1'))
                        <div class="alert alert-success">{{Session::get('success1')}}</div>
                    @endif
                    @if(Session::has('fail1'))
                        <div class="alert alert-danger">{{Session::get('fail1')}}</div>
                    @endif
                    @csrf               
                    <div class="preferencie">
                        <div class="osobne_info_item">
                            <div class="osobne_info_item_span">Kopie výkazů:</div>
                            <select name="upravKopie" title="Zasílat kopie výkazů e-mailem?" size="1">
                            @if ($data['zasilat_kopie'] == 1)
                                    <option value="1" selected>Ano</option>
                                    <option value="0">Ne</option>
                            @else
                                <option value="1">Ano</option>
                                <option value="0" selected>Ne</option>
                            @endif
                            </select>
                        </div>
                        <div class="osobne_info_item">
                            <div class="osobne_info_item_span">Úvodní stránka:</div>
                            <select name="upravUvodni" id="upravUvodni" title="Stránka, která se zobrazí po přihlášení" size="1">
                                <!--generujPolozkyVyberuSId($uvodniStr,false,$data['str_po_prihlaseni']) TODO -->
                            </select>
                        </div>
                        <div class="osobne_info_item">
                            <div class="osobne_info_item_span">Uložení nastavení systému:</div>
                            <select name="uprav_ukladani_sezeni" title="Jaké nastavení systému se uloží" size="1">
                                <!--generujPolozkyVyberuSId($po_odhlaseni_ulozenoR,false,$data['vychozi_ulozeni_sezeni']) TODO -->
                            </select>
                        </div>
                        <div class="osobne_info_item">
                            <div class="osobne_info_item_span">U wiki úkolů hlídat:</div>
                            <select name="uprav_hlidani_wiki_ukolu" title="Jak si přejete hlídat wiki úkoly" size="1">'
                                <!--generujPolozkyVyberuSId($hlidani_wiki_ukolu,false,$data['hlidani_wiki_ukolu'] TODO -->
                            </select>
                        </div>
                        <div class="osobne_info_item">
                            <div class="osobne_info_item_span">IP adresy:</div>
                            <a href="#" onclick="addInput()">Přidat +</a> <!--TODO-->
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
                                <button type="submit" class="btn btn-block btn-primary">Uložit</button>
                            </div> 
                        </div> 
                    </div>               
                </form>
            </div>
            <div class="medzera"></div>
            <div class="opravnenia_k_serverom">
                <div class="opravnenia">
                    <h1>Oprávnění k serverům</h1>
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span">Přístup k Redmine:</div>
                        @if($data->pristup_k_redmine === 0)
                            Nie
                        @else
                            Ano &nbsp (<a href="https://knot.fit.vutbr.cz/redmine" title="Odkaz na Redmine" target="_blank">https://knot.fit.vutbr.cz/redmine</a>)
                        @endif
                    </div>
                    
                </div>
            </div>
        <div class="medzera"></div>
        </div>
    </div>
@endsection