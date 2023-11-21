<!--napoveda-->
@extends('dashboard')
@section('content')
    <div class="import-vykazov-zo-suboru">
        <div class="import-vykazov-zo-suboru-l">
            <h2>{{__('Import výkazů - výběr souboru s výkazy')}}</h2>
            <div class="medzera"></div>
            <hr>
            <div class="medzera"></div>
            <h3>{{__('Vyberte soubor pro import')}}:</h3>
            <div class="medzera"></div>
            <form action="{{ route('import_vykazov') }}" method="post" enctype="multipart/form-data">
                @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif
                @if(Session::has('fail'))
                    <div class="alert alert-danger">{{Session::get('fail')}}</div>
                @endif
                @csrf
                <label for="file" style="width:75px">{{__('Soubor')}}:</label>
                <input type="file" name="file" id="file" style="border:2px solid black;">
                <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                <br><br>
                <label for="osoba" style="width:75px">{{__('Osoba')}}:</label>
                <input type="text" name="osoba" id="osoba">
                <input type="text" name="login" id="login"> <!-- TODO -->
                <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                <br><br>
                <input type="submit" class="btn btn-block btn-primary" value="{{__('Odeslat')}}">
            </form>
        </div>
    </div>
@endsection