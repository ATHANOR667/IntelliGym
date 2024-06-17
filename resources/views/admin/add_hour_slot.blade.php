@extends('admin.base')

@section('title', 'hour_slot')



@section('content')

    <livewire:hour-slot :admin="$admin" :admin_key="$admin_key" />


@endsection
