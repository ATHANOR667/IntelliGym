@extends('user.form-base')
@section('title', 'Password Reset')

@section('content')
    <div class="divinscrip connexion animlog">
        <div class="titreinscriotion" style="z-index: 1000;">
            <h2>Reinitialisation du mot de passe</h2>
        </div>


        <form method="POST" class="forminscrip" style="z-index: 1000;">
            <div class="divinput">
                @csrf

                <input type="text" name="otp" placeholder="otp"  value="{{@old('otp')}}" required class="input01">
                @error('otp')
                <span>{{$message}}</span>
                @enderror

                <input type="password" name="password" placeholder="password"  value="{{@old('password')}}" required class="input01">
                @error('password')
                <span>{{$message}}</span>
                @enderror

                <div class="divbtninput">
                    <button type="submit" class="btninput">Soumettre</button><br>
                </div>
            </div>


        </form>

        @if(session('message'))
            <div>
                {{ session('message') }}
            </div>
        @endif
    </div>

@endsection
