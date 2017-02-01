@extends('layouts.app')

@section('content')
    <div class="container review-container">
        @foreach ($reviews as $review)
            <div class="review-items">
                <div class="text-center">
                    <p class="review-title-strong"><a href="/monthlyreviews/{{ $review->slug }}">{{ $review->title }}</a></p>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <img src="/upload/images/{{ $review->img }}" alt="" / class="img-responsive img-thumbnail">
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <div class="main-post-author clearfix">
                            <em>{{ $review->published_at->diffForHumans() }} - {{ $review->user->name }}</em>
                        </div>
                        {!! $review->excerpt !!}
                        <br>
                        <a href="/monthlyreviews/{{ $review->slug }}">Читать далее...</a>
                    </div>
                </div>
                <div class="col-lg-offset-3 col-lg-6">
                    <hr>
                </div>
            </div>
        @endforeach
    </div>
@endsection
