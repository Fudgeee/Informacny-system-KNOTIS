<!--ZMENA HESLA-->
@extends('dashboard')
@section('content')
    <div class="change-password">
        <form action="{{route('update_password')}}" method="post">
            @if(Session::has('success'))
                <div class="alert alert-success">{{Session::get('success')}}</div>
            @endif
            @if(Session::has('fail'))
                <div class="alert alert-danger">{{Session::get('fail')}}</div>
            @endif
            @csrf
            <div class="form-group">
                <label for="old_password" class="form-label">{{__('Aktuální heslo')}}:</label>
                <input type="password" name="old_password" class="form-control" placeholder="{{__('Aktuální heslo')}}">
                <span class="text-danger">@error('old_password') {{$message}} @enderror</span>
            </div>
            <div class="form-group">
                <label for="new_password" class="form-label">{{__('Nové heslo')}}:</label>
                <input type="password" name="new_password" class="form-control" placeholder="{{__('Nové heslo')}}">
                <span class="text-danger">@error('new_password') {{$message}} @enderror</span>
            </div>
            <div class="form-group">
                <label for="new_password_confirm">{{__('Nové heslo (kontrola)')}}:</label>
                <input type="password" name="new_password_confirmation" class="form-control" placeholder="{{__('Zadajte heslo znovu')}}"> 
            </div>
            <br>
            <div class="form-group form-group-change-pw">
                <button type="submit" class="btn btn-block btn-primary">{{__('Změnit heslo')}}</button>
            </div>
        </form>
    </div>
@endsection