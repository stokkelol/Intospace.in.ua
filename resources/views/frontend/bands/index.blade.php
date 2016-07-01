@extends('layouts.app')

@section('content')
    <div class="bands-container">
        <ul class="list-unstyled">
            @foreach($bands as $band)
                <div class="col-lg-12 band-container">
                    <div class="col-lg-6">
                        <p class="band-title">{{ $band->title }}</p>
                    </div>
                    <div class="col-lg-6">
                        @foreach($band->posts as $post)
                            <li><a href="/posts/{{ $post->slug }}">{{ $post->title }}</a></li>
                        @endforeach
                        @foreach($band->videos as $video)
                            <li><a href="/videos/{{ $post->slug }}">{{ $video->title }}</a></li>
                        @endforeach
                        @foreach($band->reviews as $review)
                            <li><a href="/reviews/{{ $post->slug }}">{{ $review->title }}</a></li>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </ul>
    </div>
@endsection
