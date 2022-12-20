<!--LEFT MENU-->
<div class="menu2">
    <div class="left-menu">
        <form action="//localhost/knotis/index2.php" target="_blank" method="post">
            <input type="text" class="form-control hidden" placeholder="{{__('Zadajte Login')}}" name="login" value="{{$data->login}}">           
            <input type="password" class="form-control hidden" placeholder="{{__('Zadajte Heslo')}}" name="heslo" value="admin">          
            <button type="submit" class="btn btn-primary old-link">OLD KNOTIS</button>
        </form>
    </div>
</div>