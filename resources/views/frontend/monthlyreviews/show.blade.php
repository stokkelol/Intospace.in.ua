@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="review-presenter-container">
                <div class="text-center review-title-strong clearfix">
                    <a href="{{ $review->slug }}" class="review-title-strong">{!! $review->title !!}</a>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <img src="/upload/images/{{ $review->img }}" alt="" / class="text-center img-responsive img-thumbnail">
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 review-content">
                            <div class="text-left">
                                {!! $review->excerpt !!}
                            </div>
                            <br>
                            <a href="/monthlyreviews/{{ $review->slug }}">Читать далее...</a>
                            <div class="clearfix pull-right">
                                <strong class="post-filters">{{ $review->published_at->diffForHumans() }} | <i class="fa fa-user" aria-hidden="true"> </i> {{ $review->user->name }}</strong>
                            </div>
                        </div>
                    <div class="col-lg-offset-3 col-lg-6">
                        <hr>
                    </div>
                </div>
                <br>
                @for ($x = 0; $x < $counter; $x++)
                    <div class="col-lg-12 clearfix">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <img src="/upload/covers/{{ $presenter->imgs[$x] }}" class="review-img-align img-responsive img-thumbnail">
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <p class="clearfix review-title">{!! $presenter->titles[$x] !!}</p>
                            <div class="clearfix">
                                {!! $presenter->contents[$x] !!}
                            </div>
                        </div>
                        <div class="col-lg-offset-3 col-lg-6">
                            <hr>
                        </div>
                    </div>
                @endfor
                <div class="col-lg-12">
                    <div class="review-links">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <p>Обзоры за прошедший месяц:</p>
                                <ul class="list-unstyled cl-effect-1 review-items">
                                    @foreach ($latest_posts as $post)
                                        <li><a href="/posts/{{ $post->slug }}">{{ $post->title }}</a></li>
                                    @endforeach
                                </ul>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <p>Видео за прошедший месяц:</p>
                            <ul class="list-unstyled cl-effect-1 review-items">
                                @foreach ($latest_videos as $video)
                                    <li><a href="/videos/{{ $video->slug }}">{{ $video->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <p>Популярные обзоры:</p>
                            <ul class="list-unstyled cl-effect-1 review-items">
                                @foreach ($popular_posts as $post)
                                    <li><a href="/posts/{{ $post->slug }}">{{ $post->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
