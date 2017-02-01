@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <h3>{{ $band->title }}</h3>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <ul>
                    @foreach ($band->posts as $post)
                        <a href="/posts/{{ $post->slug }}"><li>{{ $post->title }}</li></a>
                    @endforeach
                </ul>
                <ul>
                    @foreach ($band->videos as $video)
                        <a href="/videos/{{ $video->slug }}"><li>{{ $video->title }}</li></a>
                    @endforeach
                </ul>
                <ul>
                    @foreach ($band->reviews as $review)
                        <a href="/reviews/{{ $review->slug }}"><li>{{ $review->title }}</li></a>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
