@extends('admin.form-base')
@section('title', 'OtpRequest')

@section('content')
    <div class="divinscrip connexion animlog">
        <div class="titreinscriotion" style="z-index: 1000;">
            <h2>Demande d'otp</h2>
        </div>


        <form method="POST" class="forminscrip" style="z-index: 1000;">
            <div class="divinput">
                @csrf
                <input type="email" name="email" placeholder="email"  value="{{@old('email')}}" required class="input01">
                @error('email')
                <span>{{$message}}</span>
                @enderror

                <input type="text" name="matricule" placeholder="matricule"  value="{{@old('matricule')}}" required class="input01">
                @error('matricule')
                <span>{{$message}}</span>
                @enderror

                <div class="divbtninput">
                    <button type="submit" class="btninput">Soumettre</button><br>
                </div>
            </div>


        </form>
    </div>
    @if(session('message'))
        <div>
            {{ session('message') }}
        </div>
    @endif
@endsection
