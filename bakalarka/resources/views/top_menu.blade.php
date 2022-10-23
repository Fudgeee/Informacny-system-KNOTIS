<!--TOP MENU-->
<script>
    function toggleClass() {
        let menu = document.querySelector(".top-hamburger");
        menu.classList.toggle("toggleCls");
    }
</script>

<div class="menu1">
    <div class="top-menu">
        <ul>
            <li>
                <a href="#" onclick="toggleClass()"><i class="fa-solid fa-user-gear"></i>{{$data->jmeno. " " .$data->prijmeni}}</a>
                <ul class="top-hamburger">
                    <li>
                        <a href="#">Změna hesla</a>
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
                <a href=""><i class="fa-solid fa-question"></i>Nápověda</a>
            </li>
            <li>
                <a href="logout" class="log-out"><i class="fa-solid fa-power-off"></i>Odhlásit se</a>
            </li>
            <li>
                <a href=""><img src="cs.gif" title="cs" alt="cs" class="ikonkaJazyka"></a>
            </li>
        </ul>
    </div>
</div>