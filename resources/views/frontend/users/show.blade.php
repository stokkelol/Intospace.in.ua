@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h4>{{ $user->name }}</h4>
            <ul>
                @foreach($posts as $post)
                    <li>{{ $post->title }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
