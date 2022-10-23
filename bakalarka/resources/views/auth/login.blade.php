<!--LOGIN PAGE-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link rel="stylesheet" href="main.css">
        <title>KNOTIS</title>
    </head>
    <body>
        <div class="container">
            <header>
                <a href="/"><img class="main-logo" src="logo.gif" alt="logo"></a>
                <img src="cs.gif" style="margin: 12px" title="cs" alt="cs" class="ikonkaJazyka">
            </header>
            <hr style="margin-top:0px; clear:both">
            <main>
                <div class="login-form col-md-7 col-md-offset-7">
                    <h4 style="text-align:center">Přihlášení do Informačního systému KNOTIS</h4>
                    <hr>
                    <form action="{{route('login-user')}}" method="post">
                        @if(Session::has('success'))
                        <div class="alert alert-success">{{Session::get('success')}}</div>
                        @endif
                        @if(Session::has('fail'))
                        <div class="alert alert-danger">{{Session::get('fail')}}</div>
                        @endif
                        @csrf
                        <div class="form-group">
                            <label for="name">Login:</label>
                            <input type="text" class="form-control" placeholder="Zadajte Login" name="name" value="{{old('name')}}">
                            <span class="text-danger">@error('name') {{$message}} @enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="password">Heslo:</label>
                            <input type="password" class="form-control" placeholder="Zadajte Heslo" name="password" value="">
                            <span class="text-danger">@error('password') {{$message}} @enderror</span>
                        </div>
                        <br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-primary">Přihlásit</button>
                        </div>
                    </form>
                </div>
            </main>
            <footer>
                <div class="footer">
                    <span>Copyright &copy; 2022 VUT</span>
                </div>
            </footer>
        </div>
    </body>
</html>