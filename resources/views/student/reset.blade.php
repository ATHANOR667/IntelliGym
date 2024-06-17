@extends('student.formbase')
@section('title','Password reset')

@section('content')
    <div class="divinscrip connexion animlog">
        <div class="titreinscriotion" style="z-index: 1000;">
            <h2>Passwor Reset</h2>
        </div>

        <form action="" method="post" class="forminscrip" style="z-index: 1000;">
            @csrf
            <div class="divinput">


                <!--  MOT DE PASSE -->
                <input type="password" name="password" placeholder="password" required class="input01">
                @error('password')
                <span>{{$message}}</span>
                @enderror


                <div class="divbtninput">
                    <button class="btninput">Soumettre</button>
                </div>
            </div>


        </form>
    </div>
@endsection
