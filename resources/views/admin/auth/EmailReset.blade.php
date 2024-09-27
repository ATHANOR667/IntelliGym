@extends('admin.form-base')
@section('title', 'email reset')

@section('content')
    <!-- formulaire inscription -->
    <div class="divinscrip connexion">
        <div class="titreinscriotion">
            <h2>Mise ajour de l'adresse mail </h2>
        </div>


        <form method="POST" class="forminscrip" style="z-index: 1000;">
            <div class="divinput">
                @csrf

                <!-- OTP -->
                <input type="text" name="otp"    placeholder="otp" value="{{@old('otp')}}" class="input01" required>
                @error('otp')
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
