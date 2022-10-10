<!DOCTYPE html>
<html lang="en" style="height=100%">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>KNOTIS</title>
</head>
<body style="background:lightgrey; height=100%">
    <div class="container" style="background:white; height:960px; padding:0">
        <header>
            <a href="/login"><img src="logo_vut.png" alt="logo" style="width:110px; float:left"></a>
            <h1 style="padding-top:24px">KNOTIS</h1>
        </header>
        <hr style="clear:both">
        <div class="col-md-7 col-md-offset-7" style="margin:100px auto; padding-top:120px; padding-bottom:120px; padding-left:40px; padding-right:40px; background:grey;">
            <h4 style="text-align:center">Přihlášení do Informačního systému KNOTIS</h4>
            <hr>
            <form style="margin:auto; width:340px">
                <div class="form-group">
                    <label for="name">Login:</label>
                    <input type="text" class="form-control" placeholder="Enter Login" name="name" value="">
                    <span class="text-danger">@error('name') {{$message}} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="heslo">Heslo:</label>
                    <input type="password" class="form-control" placeholder="Enter Password" name="heslo" value="">
                    <span class="text-danger">@error('heslo') {{$message}} @enderror</span>
                </div>
                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary" style="background:red; width:340px">Přihlásit</button>
                </div>
            </form>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</html>