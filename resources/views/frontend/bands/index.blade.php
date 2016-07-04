@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row bands-container">
            <ul class="list-unstyled">
                @foreach($bands as $band)
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 band-container">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <p class="band-title">{{ $band->title }}</p>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                @foreach($band->posts as $post)
                                    @if($post->status == 'active')
                                    <li><p><a href="/posts/{{ $post->slug }}">{{ $post->title }}</a></p></li>
                                    @endif
                                @endforeach
                                @foreach($band->videos as $video)
                                    <li><p><a href="/videos/{{ $video->slug }}">{{ $video->title }}</a></p></li>
                                @endforeach
                                @foreach($band->reviews as $review)
                                    <li><p><a href="/reviews/{{ $review->slug }}">{{ $review->title }}</a></p></li>
                                @endforeach
                            </div>
                        </div>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
