@extends('admin.base')
@section('title','Password reset')

@section('content')
    <form action="" method="post">
        @csrf


        <h3>Password reset</h3>


        <!--  MOT DE PASSE -->
        <div>
            <input type="email" name="email" placeholder="email" value="{{@old('email')}}" required>
            @error('email')
            <span>{{$message}}</span>
            @enderror
        </div>
        <button onclick="verifie()">Soumettre</button>
        </div>

        @if(session('message'))
            <div>
                {{ session('message') }}
            </div>
        @endif


    </form>

@endsection
