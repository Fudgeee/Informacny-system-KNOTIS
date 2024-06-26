<!--DASHBOARD-->
<!--MASTER BLADE-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{asset('bootstrap.min.css')}}" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <script src="{{asset('bootstrap.bundle.min.js')}}" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <script src="{{asset('https://kit.fontawesome.com/3addc861d7.js')}}" crossorigin="anonymous"></script>
        <script src="{{asset('jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{asset('https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css')}}">
        <script type="text/javascript" charset="utf8" src="{{asset('https://code.jquery.com/jquery-3.6.0.min.js')}}"></script>
        <script type="text/javascript" charset="utf8" src="{{asset('https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js')}}"></script>
        <script src="{{asset('https://cdn.datatables.net/colreorder/1.5.5/js/dataTables.colReorder.min.js')}}"></script>
        <script src="{{asset('https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('https://cdn.datatables.net/buttons/2.0.0/js/buttons.colVis.min.js')}}"></script>
        <link rel="stylesheet" href="{{asset('https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css')}}">

        <link rel="stylesheet" href="{{asset('main.css')}}">
        <title>KNOTIS</title>
    </head>
    <body class="dashboard">
        <header>
            <a href="/index2"><img class="main-logo main-logo-m" src="{{asset('logo-m.png')}}" alt="logo_knotis"></a>
            @include('top_menu')
            @include('left_menu')
        </header>
        <main>   
            <div class="main-content">
                @yield('content')
            </div>
        </main>
    </body>
</html>