@extends('admin.form-base')
@section('title', 'checkmail admin')

@section('content')

    <div class="divinscrip connexion">
        <div class="titreinscriotion">
            <h2>Email check</h2>
        </div>


        <form method="POST" class="forminscrip">
            <div class="divinput">
                @csrf
                <input type="email" name="email" placeholder="email"  value="{{@old('email')}}" required class="input01">
                @error('email')
                <span>{{$message}}</span>
                @enderror

                <div class="divbtninput">
                    <button type="submit" class="btninput">Soumettre</button><br>
                </div>
            </div>


        </form>

    @if(session('message'))
        <div>
            {{ session('message') }}
        </div>
    @endif
@endsection
