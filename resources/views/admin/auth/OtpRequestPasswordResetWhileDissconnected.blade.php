@extends('admin.form-base')
@section('title', 'email check admin')

@section('content')
    <div class="divinscrip connexion animlog">
        <div class="titreinscriotion" style="z-index: 1000;">
            <h2>M'identifier</h2>
        </div>


        <form method="POST" class="forminscrip" style="z-index: 1000;">
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

        <-- MESSAGE -->
        @if(session('message'))
            <div >
                {{session('message')}}
            </div>
        @endif
    </div>

@endsection
