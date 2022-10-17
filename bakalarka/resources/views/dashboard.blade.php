<!--DASHBOARD-->
@extends('master')
@section('content')
    <div>
        <header>
            <a href="/login"><img class="main-logo" src="logo_vut.png" alt="logo"></a>
            
        </header>
        <hr style="clear:both">
        <div class=dashboard>
            {{$data->name}}
            &nbsp
            <a href="logout">Logout</a>
        </div>
    </div>
@endsection