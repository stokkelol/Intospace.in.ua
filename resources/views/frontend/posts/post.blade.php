@extends ('layouts.app')

@section('content')
    <div class="container main-post">
        <h1>{{ $post->title }}</h1>
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 main-post-img">
            <img src="/upload/covers/{{ $post->img }}" class="img-responsive img-thumbnail">
            <br>
            <div class="post-links text-center">
                <br>
                {!! $post->links !!}
                <br>
            </div>
            @if (isset($post->similar))
            <div class="post-similars hidden-sm hidden-xs text-center">
                <p>Похожие исполнители:</p>
                <ul class="list-unstyled">{!! $post->similar !!}</ul>
            </div>
            @endif
        </div>
        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 main-post-text">
            <a href="{{ $post->slug }}"><span class="main-post-title">{{$post->title}}</span></a>
            <div  class="regular-post-author clearfix">
                <em> {{ $post->published_at->diffForHumans() }}</em> <em>|</em> <em><strong>{{ $post->user->name }}</strong></em>
            </div>
            <div class="regular-post-tags clearfix">
                @include('frontend.partials.tags', ['tags' => $post->tags])
            </div>
            <div>
                @include('frontend.partials.share')
            </div>
            <br>
            <div class="clearfix text-justify clearfix">
              {!! $post->excerpt !!}
              {!! $post->content !!}
            </div>
            <br>
            <div class="embed-responsive embed-responsive-16by9 clearfix">
                <iframe src="https://www.youtube.com/embed/{{ $post->video }}" frameborder="0" allowfullscreen></iframe>
            </div>
            <br>
            @if ($post->similar)
            <div class="post-similars hidden-lg hidden-md">
                <p>Похожие исполнители:</p>
                {!! $post->similar !!}
            </div>
            @endif
        </div>

    </div>
    <hr>
    <div class="container">
        <div class="col-lg-1"></div>
            <div class="col-lg-10">
                @include('frontend.partials.related')
                <hr>
                @include('frontend.partials.disqus')

            </div>
        <div class="col-lg-1"></div>
    </div>
@endsection
