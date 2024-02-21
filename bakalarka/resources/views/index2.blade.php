<!-- uvodna stranka -->
<?php 
    $aktivitaResiteleTmp = config('nastavenia.aktivitaResitele');
    $aktivitaResitele = [];
    foreach ($aktivitaResiteleTmp as $key => $value) {
        $aktivitaResitele[$key] = __($value);
    }
    
    $aktivitaOsobyTmp = config('nastavenia.aktivitaOsoby');
    $aktivitaOsoby = [];
    foreach ($aktivitaOsobyTmp as $key => $value) {
        $aktivitaOsoby[$key] = __($value);
    }
?>
@extends('dashboard')
@section('content')
    <div class="uvodna-stranka">
        <div class="uvodna-stranka-l">
            <?php //dd($data);
                if (empty($data['heslo_crypted'])) {
                    echo '<span class="cervene-bold">' . __('Nemáte nastaven hash pro přístup k serverům. Dokud si nezměníte heslo, nebudete moct pracovat se servery.') . '</span><br>';
                }

                if (empty($data['heslo_hashed_auth'])) {
                    echo '<span class="cervene-bold">' . __('Nemáte nastaven hash pro přístup k wiki. Dokud si znovu nenastavíte heslo, nebudete moct pracovat s wiki.') . '</span><br>';
                }

                if (empty($hesla['heslo_crypted']) || empty($hesla['heslo_hashed_auth'])) {
                    echo '<span class="cervene-bold">' . __('Nastavte prosím znovu své heslo na stránce ').'<a href="/change_password">'.__('změna hesla.').'</a>'.__(' Změna hesla se na serverech projeví do 24 hodin.').'</span><br><br>';
                }

                if ($osoby_k_deaktivaci > 0) {
                    echo '<span class="cervene">' . __('Mezi Vámi vedenými osobami se nachází ') . $osoby_k_deaktivaci . ' ' . trans_choice('osob', $osoby_k_deaktivaci) . trans_choice(', která je', $osoby_k_deaktivaci) . __(' k deaktivaci, ale řeší projekt s \'přístup do\' v nekonečnu ') . '</span><a href="#">('.__('viz. výpis').')</a><br><br>'; // TODO a-href link
                }
                
                

            ?>
        </div>
    </div>
@endsection