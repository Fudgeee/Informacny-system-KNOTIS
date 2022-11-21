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
                        <div class="osobne_info_item" style="float:left">
                            <div class="osobne_info_item_span" style="margin-top:5.5px">{{__('messages.vykazovanie')}}:</div>
                            <input type="text" size="20" style="height:38px" maxlength="2" name="zpozdeni_vykazu" title="{{__('messages.vykazovanie-title')}}" value="{{$data->zpozdeni_vykazu}}">
                        </div>
                        <div class="osobne_info_button">
                            <button type="submit" class="btn btn-block btn-primary">{{__('messages.save-btn')}}</button>
                        </div>   
                        <div class="osobne_info_item" style="margin-bottom: 20px">
                                <a href="#" class="btn btn-block btn-secondary">{{__('messages.zabezpecenie-sezeni')}}</a>
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
                            <div class="osobne_info_item_span">{{__('messages.kopie-vykazov')}}:</div>
                            <select name="upravKopie" title="{{__('messages.kopie-vykazov-title')}}" size="1">
                            @if ($data['zasilat_kopie'] == 1)
                                    <option value="1" selected>{{__('messages.ano')}}</option>
                                    <option value="0">{{__('messages.nie')}}</option>
                            @else
                                <option value="1">{{__('messages.ano')}}</option>
                                <option value="0" selected>{{__('messages.nie')}}</option>
                            @endif
                            </select>
                        </div>
                        <div class="osobne_info_item">
                            <div class="osobne_info_item_span">{{__('messages.uvodna-stranka')}}:</div>
                            <select name="upravUvodni" id="upravUvodni" title="{{__('messages.uvodna-stranka-title')}}" size="1">
                                <!--generujPolozkyVyberuSId($uvodniStr,false,$data['str_po_prihlaseni']) TODO -->
                            </select>
                        </div>
                        <div class="osobne_info_item">
                            <div class="osobne_info_item_span">{{__('messages.ulozenie-nastavenia-systemu')}}:</div>
                            <select name="uprav_ukladani_sezeni" title="{{__('messages.ulozenie-nastavenia-systemu-title')}}" size="1">
                                <!--generujPolozkyVyberuSId($po_odhlaseni_ulozenoR,false,$data['vychozi_ulozeni_sezeni']) TODO -->
                            </select>
                        </div>
                        <div class="osobne_info_item">
                            <div class="osobne_info_item_span">{{__('messages.wiki-ulohy')}}:</div>
                            <select name="uprav_hlidani_wiki_ukolu" title="{{__('messages.wiki-ulohy-title')}}" size="1">'
                                <!--generujPolozkyVyberuSId($hlidani_wiki_ukolu,false,$data['hlidani_wiki_ukolu'] TODO -->
                            </select>
                        </div>
                        <div class="osobne_info_item">
                            <div class="osobne_info_item_span">{{__('messages.ip-adresy')}}:</div>
                            <a href="#" onclick="addInput()">{{__('messages.add-btn')}} +</a> <!--TODO-->
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
                                <button type="submit" class="btn btn-block btn-primary">{{__('messages.save-btn')}}</button>
                            </div> 
                        </div> 
                    </div>               
                </form>
            </div>
            <div class="medzera"></div>
            <div class="opravnenia_k_serverom">
                <div class="opravnenia">
                    <h1>{{__('messages.opravenia-ku-serverom')}}</h1>
                    <div class="osobne_info_item">
                        <div class="osobne_info_item_span">{{__('messages.pristup-redmine')}}:</div>
                        @if($data->pristup_k_redmine === 0)
                            {{__('messages.nie')}}
                        @else
                            {{__('messages.ano')}} &nbsp (<a href="https://knot.fit.vutbr.cz/redmine" title="{{__('messages.odkaz-redmine')}}" target="_blank">https://knot.fit.vutbr.cz/redmine</a>)
                        @endif
                    </div>
                    
                </div>
            </div>
        <div class="medzera"></div>
        </div>
    </div>
@endsection