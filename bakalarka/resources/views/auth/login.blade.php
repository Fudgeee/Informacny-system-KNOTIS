<!--LOGIN PAGE-->
@extends('master')
@section('content')
    <div class="container">
        <header>
            <a href="/"><img class="main-logo" src="logo_vut.png" alt="logo"></a>
            <h1 class="main-h1">KNOTIS</h1>
        </header>
        <hr style="clear:both">
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
                    <input type="text" class="form-control" placeholder="Enter Login" name="name" value="{{old('name')}}">
                    <span class="text-danger">@error('name') {{$message}} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="password">Heslo:</label>
                    <input type="password" class="form-control" placeholder="Enter Password" name="password" value="">
                    <span class="text-danger">@error('password') {{$message}} @enderror</span>
                </div>
                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary">Přihlásit</button>
                </div>
            </form>
        </div>
        <footer>
            <div class="footer">
                <span>Copyright &copy; 2022 VUT</span>
            </div>
        </footer>
    </div>
@endsection