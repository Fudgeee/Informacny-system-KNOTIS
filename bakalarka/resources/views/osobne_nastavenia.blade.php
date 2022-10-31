<!--OSOBNE NASTAVENIA-->
@extends('dashboard')
@section('content')
    <div class="osobne_nastavenia">
        <div>
            <form action="{{route('update_personal_info')}}" method="post">
                @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif
                @if(Session::has('fail'))
                    <div class="alert alert-danger">{{Session::get('fail')}}</div>
                @endif
                @csrf
                <table>
                    <tbody>
                        <tr>
                            <th colspan="4" style="padding-top:15px"><h1>{{$data->jmeno. " " .$data->prijmeni}}</h1></th>
                        </tr>
                        <tr>
                            <td>Číslo</td>
                            <td>{{$data->id}}</td>
                            <td>Práce</td>
                            <?php $vypisOdpDo = $data->odpracovat_do;?>
                            @if ($data->odpracovat_do === "")
                                @php $vypisOdpDo = &infin;;
                            @endif
                            <td>
                                {{$data->odpracovat_od.' - '.$vypisOdpDo}}
                            </td>
                        </tr>
                        <tr>
                            <td>Login</td>
                            <td>{{$data->login}}</td>
                            <td>Opožděné vykazování</td>
                            <td>
                                <input type="text" size="20" maxlength="2" name="zpozdeni_vykazu" title="Zde si můžete nastavit, do kolika hodin v pondělí budete mít ještě předvolený minulý týden pro vykazování výkazů z předešlého týdne. Maximální hodnota je 24 hodin." value="{{$data->zpozdeni_vykazu}}">
                            </td>
                        </tr>
                        <tr>
                            <td>Aktivní</td>
                            <td>                                
                                {{$data->aktivni_od. " - " .$data->aktivni_do}}
                            </td>
                            <td>Telefon</td>
                            <td>
                                <input type="text" size="20" maxlength="21"  name="telefon" title="Váš kontaktní telefon" value="{{$data->telefon}}">
                            </td>
                        </tr>
                        <tr>
                            <td>Přístup k Redmine</td>
                            <td>
                                @if($data->pristup_k_redmine === 0)
                                    Nie
                                @else
                                    Ano <!--TODO redmine URL-->
                                @endif
                            </td>
                            <td>Mail</td>
                            <td>
                                <input type="text" size="20" maxlength="255" name="gmail" title="Váš Gmail účet nebo školní e-mail" value="{{$data->gmail}}">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" rowspan="2" style="text-align:center">
                                <button>Změnit zabezpečení sezení</button> <!--TODO-->
                            </td>
                            <td>Facebook</td>
                            <td>
                                <input type="text" size="20" maxlength="255" name="upravFacebook" title="Váš kontaktní facebook účet" value="{{$data->facebook}}">
                            </td>
                        </tr>
                        <tr>
                            <td>Discord</td>
                            <td>
                                <input type="text" size="20" maxlength="255" name="upravDiscord" title="Váš kontaktní Discord účet" value="{{$data->discord}}">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align:center; padding-bottom:25px; padding-top:25px">
                                <button type="submit" class="btn btn-block btn-primary">Uložit</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <div class="medzera"></div>
            <form action="{{route('update_dpp_info')}}" method="post">
                @if(Session::has('success1'))
                    <div class="alert alert-success">{{Session::get('success1')}}</div>
                @endif
                @if(Session::has('fail1'))
                    <div class="alert alert-danger">{{Session::get('fail1')}}</div>
                @endif
                @csrf
                <table>
                    <tbody>
                        <tr>
                            <th colspan="4" style="padding-top:15px"><h1>Podklady pro DPP či pro vyplacení stipendia</h1></th>
                        </tr>
                        <tr>
                            <td>Podklady pro DPP</td>
                            <td>1</td><!--TODO-->
                            <td>Osobní číslo VUT</td>
                            <td>
                                <input type="text" size="20" maxlength="15" name="cdb_id" title="Osobní číslo VUT / Person ID / CDB ID (na průkazu)" value="{{$data->cdb_id}}">
                            </td>
                        </tr>
                        <tr>
                            <td>Podklady pro Stip</td>                           
                            <td>2</td><!--TODO-->
                            <td>Státní příslušnost (stát)</td>
                            <td>
                                <input type="text" size="20" maxlength="63" name="statni_prislusnost" title="Státní příslušnost (v DPP se uvádí do adresy, např. Česká republika)" value="{{$data->statni_prislusnost}}">
                            </td>
                        </tr>
                        <tr>
                            <td>Titul před jménem</td>
                            <td>
                                <input type="text" size="20" maxlength="31" name="titul_pred" title="Titul před jménem" value="{{$data->titul_pred}}">
                            </td>
                            <td>Rodinný stav</td>
                            <td>
                                <select name="rodinny_stav" title="Rodinný stav">{{$data->rodinny_stav}}</select>
                            </td>
                        </tr>
                        <tr>
                            <td>Titul za jménem</td>
                            <td>
                                <input type="text" size="20" maxlength="31" name="titul_za" title="Titul za jménem" value="{{$data->titul_za}}">
                            </td>
                            <td>Ulice</td>
                            <td>
                                <input type="text" size="20" maxlength="63" name="ulice" title="Adresa - ulice (u vesnice bez ulic je doporučeno zadat název vesnice - jako na dopisu)" value="{{$data->ulice}}">
                            </td>
                        </tr>
                        <tr>
                            <td>Jméno</td>
                            <td>
                                <input type="text" size="20" maxlength="63" name="jmeno" title="Jméno" value="{{$data->jmeno}}"> 
                            </td>
                            <td>Číslo popisné</td>
                            <td>
                                <input type="text" size="20" maxlength="15" name="cislo_popisne" title="Adresa - číslo popisné" value="{{$data->cislo_popisne}}">
                            </td>
                        </tr>
                        <tr>
                            <td>Příjmení</td>
                            <td>
                            <input type="text" size="20" maxlength="63" name="prijmeni" title="Příjmení" value="{{$data->prijmeni}}">
                            </td>
                            <td>Město</td>
                            <td>
                                <input type="text" size="20" maxlength="63" name="mesto" title="Adresa - město" value="{{$data->mesto}}">
                            </td>
                        </tr>
                        <tr>
                            <td>Rodné příjmení</td>
                            <td>
                            <input type="text" size="20" maxlength="63" name="rodne_prijmeni" title="Rodné příjmení" value="{{$data->rodne_prijmeni}}">
                            </td>
                            <td>PSČ</td>
                            <td>
                                <input type="text" size="20" maxlength="15" name="psc" title="" value="{{$data->psc}}">
                            </td>
                        </tr>
                        <tr>
                            <td>Místo narození</td>
                            <td>
                                <input type="text" size="20" maxlength="63" name="misto_narozeni" title="Místo narození" value="{{$data->misto_narozeni}}">
                            </td>
                            <td>Zdravotní pojišťovna</td>
                            <td>
                                <input type="text" size="20" maxlength="63" name="zdravotni_pojistovna" title="Název zdravotní pojišťovny (např. VZP)" value="{{$data->zdravotni_pojistovna}}">
                            </td>
                        </tr>
                        <tr>
                            <td>Datum narození</td>
                            <td><input type="text" size="20" maxlength="31" name="datum_narozeni" title="Datum narození" value="{{$data->datum_narozeni}}"></td>
                            <td>Číslo pasu</td>
                            <td>
                                <input type="text" size="20" maxlength="15" name="cislo_pasu" title="Číslo pasu (určeno pro cizince)" value="{{$data->cislo_pasu}}">
                            </td>
                        </tr>
                        <tr>
                            <td>Rodné číslo</td>
                            <td>
                                <input type="text" size="20" maxlength="15" name="rodne_cislo" title="Rodné číslo" value="{{$data->rodne_cislo}}">
                            </td>
                            <td>DIČ</td>
                            <td>
                                <input type="text" size="20" maxlength="15" name="dic" title="=Daňové identifikační číslo (určeno pro cizince)=" value="{{$data->dic}}">
                            </td>
                        </tr>
                        <tr>
                            <td>Číslo OP</td>
                            <td>
                                <input type="text" size="20" maxlength="15" name="cislo_op" title="Číslo občanského průkazu" value="{{$data->cislo_op}}">
                            </td>
                            <td>Bankovní účet</td>
                            <td>
                                <input type="text" size="20" maxlength="63" name="bankovni_ucet" title="Číslo bankovního účtu, kde si přejete zasílat peníze" value="{{$data->bankovni_ucet}}">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align:center; padding-bottom:25px; padding-top:25px">
                                <button type="submit" class="btn btn-block btn-primary">Uložit</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <div class="medzera"></div>
        </div>
    </div>
@endsection