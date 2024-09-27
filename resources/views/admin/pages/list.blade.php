@extends('admin.base')
@section('title','book-list')


@section('content')
    
    <livewire:book-list :admin="$admin" :admin_key="$admin_key"/>

@endsection