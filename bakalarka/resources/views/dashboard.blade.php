<!--DASHBOARD-->
<!--MASTER BLADE-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <script src="bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/3addc861d7.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="main.css">
        <title>KNOTIS</title>
    </head>
    <body class="dashboard">
        <header>
            <a href="#"><img class="main-logo main-logo-m" src="logo-m.png" alt="logo_knotis"></a>
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