@extends('student.base')
@section('title', 'booking')
@section('content')

    <livewire:booking :student="$student" />

    <form action="{{ route('user.logout') }}" method="POST">@csrf @method('DELETE')<button type="submit">Logout</button></form>
@endsection
