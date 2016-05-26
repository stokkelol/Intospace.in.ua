@extends('layouts.backend')

@section('content')

@foreach ($users as $user)
    {{ $user->name }}
    @endforeach

@endsection