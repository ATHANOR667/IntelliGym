@extends('student.formbase')
@section('title','emailcheck')

@section('content')
    @if(session('message'))
        <div>
            {{ session('message') }}
        </div>
    @else
        <div class="divinscrip connexion animlog">
            <div class="titreinscriotion" style="z-index: 1000;">
                <h2>Email check</h2>
            </div>


            <form method="POST" class="forminscrip" style="z-index: 1000;">
                <div class="divinput">
                    @csrf
                    <input type="email" name="email" placeholder="email"  value="{{@old('email')}}" required class="input01">

                    <div class="divbtninput">
                        <button type="submit" class="btninput">Soumettre</button><br>
                    </div>
                </div>


            </form>

    @endif
@endsection
            @error('email')
            <span>{{$message}}</span>
        @enderror
