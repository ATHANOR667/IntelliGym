@extends('admin.form-base')
@section('title', 'login admin')

@section('content')
    <div class="divinscrip connexion animlog">
        <div class="titreinscriotion" style="z-index: 1000;">
            <h2>Se connecter</h2>
        </div>


        <form method="POST" class="forminscrip" style="z-index: 1000;">
            <div class="divinput">
                @csrf
                <input type="email" name="email" placeholder="email"  value="{{@old('email')}}" required class="input01">
                @error('email')
                <span>{{$message}}</span>
                @enderror

                <input type="password" name="password" placeholder="password" required class="input01">
                @error('password')
                <span>{{$message}}</span>
                @enderror
                <div class="changecon">
                    <h5><a href="{{route('admin.password_reset_init_while_disconnected')}}">Mot de passe oublie ? :</a></h5>
                </div>

                <div class="divbtninput">
                    <button type="submit" class="btninput">Soumettre</button><br>
                </div>
            </div>

            <div class="changecon">
                <p style="text-align: center">vous n'avez pas de compte?<span><a href="{{route('admin.otp_request_signin')}}" > Veuillez completter votrre inscription</a><br></span></p>
            </div>


        </form>

        @if(session('message'))
            <div>
                {{ session('message') }}
            </div>
        @endif

    </div>

@endsection
