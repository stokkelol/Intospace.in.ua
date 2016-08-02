@extends('layouts.backend')

@section('content')
    {!! Form::model($user, ['method' => 'PATCH', 'url' => 'backend/users/'.$user->id, 'enctype' => 'multipart/form-data']) !!}
        @include('backend.users.form')
    {!! Form::close() !!}
@endsection
