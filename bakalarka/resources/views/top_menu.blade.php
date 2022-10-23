<!--TOP MENU-->
@extends('master')
@section('content')
    <div class="dashboard">
        <header>
            <div class="top-menu">
                <a href=""><i class="fa-solid fa-user-gear"></i>{{$data->jmeno. " " .$data->prijmeni}}</a>
                <a href=""><i class="fa-solid fa-question"></i>Nápověda</a>
                <a href=""><img src="cs.gif" title="cs" alt="cs" class="ikonkaJazyka"></a>
                <a href="logout" class="log-out"><i class="fa-solid fa-power-off"></i>Logout</a>
            </div>
        </header>
        <div class=dashboard>
            
        </div>
    </div>
@endsection