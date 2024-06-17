@extends('student.formbase')
@section('title','Password reset')

@section('content')
    <form action="" method="post">
        @csrf


        <h3>Password reset</h3>


        <!--  MOT DE PASSE -->
        <div>
            <input type="email" name="email" value="{{@old('email')}}" placeholder="email" required>
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
