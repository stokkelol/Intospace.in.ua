@extends('layouts.app')

@section('content')
    <div class="container review-container">
        @foreach($reviews as $review)
            <div class="review-items">
                <p class="review-title-strong"><a href="/monthlyreviews/{{ $review->slug }}">{{ $review->title }}</a></p>
                <p><a href=""><em>{{ $review->published_at->diffForHumans() }}</em></a></p>
                <div>
                    {!! $review->content !!}
                </div>
            </div>
        @endforeach
    </div>
@endsection
