@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class=" newsfeed-container">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <div class="newsfeed-item-container">
                        @foreach($posts as $post)
                            <img src="/upload/covers/{{ $post->img_thumbnail }}">
                            <br>
                            <a href="/posts/{{ $post->slug }}">{{ $post->title }}</a>
                            <hr>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    @foreach($videos as $video)
                        {{ $video->title }}
                    @endforeach
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

                </div>
            </div>
        </div>
    </div>
@endsection
