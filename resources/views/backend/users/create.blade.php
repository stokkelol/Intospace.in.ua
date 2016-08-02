@extends('layouts.backend')

@section('content')
    {!! Form::open(['url' => $url, 'enctype' => 'multipart/form-data']) !!}
        @include('backend.users.form')
    {!! Form::close() !!}
@endsection
