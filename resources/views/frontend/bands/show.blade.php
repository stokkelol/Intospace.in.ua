@extends('layouts.app')

@section('content')
    @foreach ($posts as $post)
        <li>{{ $post->title }}</li>
    @endforeach
@endsection
