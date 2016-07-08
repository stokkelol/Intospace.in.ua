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
                        <li>{{ $post->title }}</li>
                    @endforeach
                </ul>
                <ul>
                    @foreach ($band->videos as $video)
                        <li>{{ $video->title }}</li>
                    @endforeach
                </ul>
                <ul>
                    @foreach ($band->reviews as $review)
                        <li>{{ $review->title }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
