@extends ('layouts.app')

@section('content')
    <div class="container main-post">
        <h1>{{ $post->title }}</h1>
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 main-post-img">
            <img src="/upload/{{ $post->img }}" class="img-responsive img-thumbnail">
        </div>
        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 main-post-text">
            <a href="{{ $post->slug }}"><span class="main-post-title">{{$post->title}}</span></a>
            <div  class="regular-post-author clearfix">
                <em> {{ $post->published_at->diffForHumans() }} | {{ $post->user->name }}</em>
            </div>
            <div class="regular-post-tags clearfix">
                @include('frontend.partials.tags', ['tags' => $post->tags])
            </div>
            <div>
                @include('frontend.partials.share')
            </div>
            <br>
            <div class="clearfix text-justify clearfix">
              {{ $post->content }}
            </div>
            <br>
            <div class="embed-responsive embed-responsive-16by9 clearfix">
                <iframe src="https://www.youtube.com/embed/{{ $post->video }}" frameborder="0" allowfullscreen></iframe>
            </div>
            <br>
            <div class="clearfix text-center">
                {!! $post->links !!}
            </div>
            <div class="clearfix">
                {!! $post->similar !!}
            </div>
        </div>

    </div>
    <hr>
    <div class="container">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
          @include('frontend.partials.related')
        </div>
        <div class="col-lg-1"></div>
    </div>
@endsection
