@extends('admin.base')
@section('title','Password reset')

@section('content')
    <form action="" method="post">
        @csrf


        <h3>Password reset</h3>


        <!--  MOT DE PASSE -->
        <div>
            <input type="password" name="password" placeholder="password" required>
            @error('password')
            <span>{{$message}}</span>
            @enderror
        </div>
        <button onclick="verifie()">Soumettre</button>
        </div>


    </form>

@endsection
