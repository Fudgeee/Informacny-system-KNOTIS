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
                <input type="file" name="file" id="file" style="border:2px solid black;" title="{{__('Soubor pro import')}}">
                <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                <br><br>
                <label for="osoba" style="width:75px">{{__('Osoba')}}:</label>
                <select name="osoba" id="osoba" title="{{__('Osoba, jejíž výkazy budou importovány')}}">
                    @foreach ($osoby as $osoba1)
                        <option value="{{ $osoba1->cele_meno }}">{{ $osoba1->cele_meno }}</option>
                    @endforeach
                </select>

                <!-- <input type="text" name="osoba" id="osoba" title="{{__('Osoba, jejíž výkazy budou importovány')}}"> -->
                <input type="text" name="login" id="login" title="{{__('Login (alternativa k výběru)')}}"> <!-- TODO -->
                <span class="vyrazneCervene sipka" title="{{__('Povinná položka')}}">*</span>
                <br><br>
                <input type="submit" class="btn btn-block btn-primary" style="margin-left:15%" value="{{__('Odeslat')}}">
            </form>
        </div>
    </div>
@endsection