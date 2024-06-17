@extends('student.formbase')
@section('title', 'signin student')

@section('content')
    <div class="divinscrip connexion animlog">
        <div class="titreinscriotion" style="z-index: 1000;">
            <h2>S'inscrire</h2>
        </div>

        <form action="" method="post" class="forminscrip" style="z-index: 1000;">
            @csrf
            <div class="divinput">

                <!--  MATRICULE -->
                <input type="text" name="matricule" placeholder="matricule" required class="input01">
                @error('matricule')
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
                    <button class="btninput">Soumettre</button>
                </div>
            </div>

        </form>
    </div>
    <!-- MESSAGE -->
    @if(session('message'))
        <div>
            {{session('message')}}
        </div>
    @endif
@endsection
