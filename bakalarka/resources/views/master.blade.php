<!--MASTER BLADE-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/3addc861d7.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="main.css">
        <title>KNOTIS</title>
    </head>
    <body>
        <header>
            <a href="/"><img class="main-logo" src="logo.gif" alt="logo"></a>
        </header>
        <main>
            <div>
                @yield('content')
            </div>
        </main>
    </body>
</html>