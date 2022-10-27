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
                <a href="#" onclick="toggleClass()"><i class="fa-solid fa-user-gear"></i>{{ $data->jmeno. " " .$data->prijmeni }}</a>
                <ul class="top-hamburger">
                    <li>
                        <a href="change_password">Změna hesla</a>
                    </li>
                    <li>
                        <a href="#">Osobní Nastavení</a>
                    </li>
                    <li>
                        <a href="#">Oprávnění k serverům</a>
                    </li>               
                </ul>
            </li>
            <li>
                <a href="help"><i class="fa-solid fa-question"></i>Nápověda</a>
            </li>
            <li>
                <a href="logout" class="log-out"><i class="fa-solid fa-power-off"></i>Odhlásit se</a>
            </li>
            <li>
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