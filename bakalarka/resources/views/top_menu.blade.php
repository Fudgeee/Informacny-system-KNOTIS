<!--TOP MENU-->
<script>
    function toggleClass() {
        let menu = document.querySelector(".top-hamburger");
        menu.classList.toggle("toggleCls");
    }
    function toggleClass2() {
        let menu = document.querySelector(".top-hamburger2");
        menu.classList.toggle("toggleCls2");
    }
</script>

<div class="menu1">
    <div class="top-menu">
        <ul>
            <li>
                <a href="#" onclick="toggleClass()">{{ $data->jmeno. " " .$data->prijmeni }}<i class="fa-sharp fa-solid fa-chevron-down"></i></a>
                <ul class="top-hamburger">
                    <li>
                        <a href="change_password"><i class="fa-solid fa-key"></i>Změna hesla</a>
                    </li>
                    <li>
                        <a href="osobne_nastavenia"><i class="fa-solid fa-user-gear"></i>Osobní Nastavení</a>
                    </li>
                    <li>
                        <a href="opravnenia_k_serverom"><i class="fa-solid fa-server"></i>Oprávnění k serverům</a>
                    </li>
                    <li>
                        <a href="logout" class="log-out"><i class="fa-solid fa-right-from-bracket"></i>Odhlásit se</a>
                    </li>            
                </ul>
            </li>
            <li>
                <a href="help"><i class="fa-solid fa-person-circle-question" style="font-size:26px"></i></a>
            </li>
            <li> <!-- TODO -->
                <a href="#" onclick="toggleClass2()">{{ Config::get('languages')[App::getLocale()] }}</a>
                <ul class="top-hamburger2">
                    @foreach (Config::get('languages') as $lang => $language)
                        @if ($lang != App::getLocale())
                            <li>
                                <a href="{{ route('lang.switch', $lang) }}">{{$language}}</a>
                            </li>
                        @endif
                    @endforeach             
                </ul>              
            </li>
        </ul>
    </div>
</div>

<!--
    composer require laravel/ui --dev  
    php artisan ui bootstrap
    php artisan ui vue
    php artisan ui react  
-->