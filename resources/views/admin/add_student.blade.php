@extends('admin.base')
@section('title','add_student')


@section('content')
    <form method="post">
        @csrf
        <input type="text" name="matricule" placeholder="matricule" value="{{@old('matricule')}}">
        @error('matricule')
        <span>{{$message}}</span>
        @enderror

        <select name="classe">
            @foreach($classes as $classe)
                <option value="{{$classe->id}}">{{ $classe->niveau.$classe->numero.$classe->specialite }}</option>
            @endforeach
        </select>

        <input type="text" name="nom" placeholder="nom" value="{{@old('nom')}}">
        @error('nom')
        <span>{{$message}}</span>
        @enderror


        <input type="text" name="prenom" placeholder="prenom" value="{{@old('prenom')}}">
        @error('prenom')
        <span>{{$message}}</span>
        @enderror

        <input type="date" name="date_naiss" placeholder="date_naiss" value="{{@old('date_naiss')}}">
        @error('date_naiss')
        <span>{{$message}}</span>
        @enderror

        <select name="sexe">
            <option value="M">homme</option>
            <option value="F">femme</option>
        </select>


        <button type="submit">Soumettre</button>
    </form>

    @if(session()->has('success'))
        <div>
            {{session('success')}}
        </div>
    @endif


    <livewire:users-table :admin="$admin" :admin_key="$admin_key"/>

    @if(session()->has('message'))
        <div>
            {{session('message')}}
        </div>
    @endif

@endsection
