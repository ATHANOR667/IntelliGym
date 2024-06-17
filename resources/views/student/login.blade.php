@extends('student.formbase')
@section('title','login student')

@section('content')
    <!-- formulaire connexion -->


    <div class="divinscrip connexion animlog">
        <div class="titreinscriotion" style="z-index: 1000;">
            <h2>Se connecter</h2>
        </div>

        <form action="" method="post" class="forminscrip" style="z-index: 1000;">
            @csrf
            <div class="divinput">
                <!--  EMAIL -->
                <input type="email" name="email"  value="{{old('email')}}" placeholder="email" required class="input01">
                @error('email')
                <span>{{$message}}</span>
                @enderror

                <!--  MOT DE PASSE -->
                <input type="password" name="password" placeholder="password" required class="input01">
                @error('password')
                <span>{{$message}}</span>
                @enderror
                <div class="changecon">
                    <h5><a href="{{route('user.reset_init')}}">Mot de passe oublie ?</a></h5>
                </div>

                <div class="divbtninput">
                    <button class="btninput">Connexion</button>
                </div>
            </div>

            <div class="changecon">
                <p style="text-align: center">vous n'avez pas de compte?<span><a href="{{route('user.mailcheck')}}" > S'inscrire</a><br>
         </span></p>
            </div>
        </form>
    </div>

    <!-- MESSAGE DE SUCCES OU PROPOSITION DE REDIRECTION -->
    @if(session('message'))
        <div>
            {{ session('message') }}
        </div>
    @endif
@endsection
