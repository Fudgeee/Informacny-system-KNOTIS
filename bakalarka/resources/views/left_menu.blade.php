<!--LEFT MENU-->
<div class="menu2">
    <div class="left-menu">
        <div class="left-menu-item">
            <a href="/pracovne_vykazy">{{__('Pracovní výkazy')}}</a>
        </div>
        <div class="left-menu-item">
            <a href="/plan_prace">{{__('Plán práce')}}</a>
        </div>
        <div class="left-menu-item">
            <a href="/riesene_projekty">{{__('Řešené projekty')}}</a>
        </div>
        
        <div class="medzera"></div>
        <form action="//localhost/knotis/index2.php" target="_blank" method="post">
            <input type="text" class="form-control hidden" placeholder="{{__('Zadajte Login')}}" name="login" value="{{$data->login}}">           
            <input type="password" class="form-control hidden" placeholder="{{__('Zadajte Heslo')}}" name="heslo" value="admin">          
            <button type="submit" class="btn btn-primary old-link">OLD KNOTIS</button>
        </form>
        <div class="left-menu-item">
            <a href="/riesene_projekty_tmp">tmp</a>
        </div>
        <div class="left-menu-item">
            <a href="/riesene_projekty_tmp2">tmp2</a>
        </div>
    </div>
</div>