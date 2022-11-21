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
                        <a href="change_password"><i class="fa-solid fa-key"></i>{{__('messages.change-pw')}}</a>
                    </li>
                    <li>
                        <a href="osobne_informacie"><i class="fa-solid fa-user-gear"></i>{{__('messages.osobne-info')}}</a>
                    </li>
                    <li>
                        <a href="kontaktne_udaje"><i class="fa-solid fa-server"></i>{{__('messages.kontaktne-udaje')}}</a>
                    </li>
                    <li>
                        <a href="logout" class="log-out"><i class="fa-solid fa-right-from-bracket"></i>{{__('messages.log-out')}}</a>
                    </li>            
                </ul>
            </li>
            <li>
                <a href="help"><i class="fa-solid fa-person-circle-question" style="font-size:26px"></i></a>
            </li>
            <li>
                <a href="#" onclick="toggleClass2()"><img src="flag-icon-{{Config::get('languages')[App::getLocale()]['flag-icon']}}.svg" class="flag-icon"></a>
                <ul class="top-hamburger2">
                    @foreach (Config::get('languages') as $lang => $language)
                        @if ($lang != App::getLocale())
                            <li>
                                <a href="{{ route('lang.switch', $lang) }}"><img src="flag-icon-{{$language['flag-icon']}}.svg" class="flag-icon">&nbsp{{$language['display']}}</a>
                            </li>
                        @endif
                    @endforeach             
                </ul>              
            </li>

        </ul>
    </div>
</div>
<!--npm install flag-icon-css-->