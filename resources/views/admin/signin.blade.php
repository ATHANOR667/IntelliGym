@extends('admin.form-base')
@section('title', 'signin admin')

@section('content')
    <!-- formulaire inscription -->
    <div class="divinscrip connexion">
        <div class="titreinscriotion">
            <h2>Inscription</h2>
        </div>


        <form method="POST" class="forminscrip" style="z-index: 1000;">
            <div class="divinput">
                @csrf

                <!-- MATRICULE -->
                <input type="text" name="matricule"    placeholder="matricule" value="{{@old('matricule')}}" class="input01" required>
                @error('matricule')
                <span>{{$message}}</span>
                @enderror

                <!--  MOT DE PASSE -->
                <input type="password" name="password" placeholder="password"  class="input01" required>
                @error('password')
                <span>{{$message}}</span>
                @enderror

                <div class="divbtninput">
                    <button type="submit" class="btninput">Soumettre</button><br>
                </div>
            </div>


        </form>

    <!-- MESSAGE -->
    @if(session('message'))
        <div>
            {{session('message')}}
        </div>
    @endif
@endsection
