@extends('admin.form-base')
@section('title', 'password reset')

@section('content')
    <!-- formulaire inscription -->
    <div class="divinscrip connexion">
        <div class="titreinscriotion">
            <h2>Mise ajour du mot de passe </h2>
        </div>


        <form method="POST" class="forminscrip" style="z-index: 1000;">
            <div class="divinput">
                @csrf

                <!-- OTP -->
                <input type="text" name="otp"    placeholder="otp" value="{{@old('otp')}}" class="input01" required>
                @error('otp')
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

