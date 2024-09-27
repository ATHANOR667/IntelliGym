@extends('admin.base')

@section('title', 'add_free_hour')



@section('content')

    <livewire:free-hour :admin="$admin" :admin_key="$admin_key" />


@endsection
