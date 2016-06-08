@extends ('layouts.app')

@section('content')
    <div class="container main-post">
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
            <div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-sx-9">
                    <a href="{{ $post->slug }}"><span class="main-post-title">{{$post->title}}</span></a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    @include('frontend.partials.share', ['post' => $post])
                </div>
            </div>
            <br>
            <div class="col-lg-12">
              <div  class="main-post-author clearfix">
                  <em> {{ $post->published_at->diffForHumans() }}</em> <em>|</em> <em><strong>{{ $post->user->name }}</strong></em>
              </div>
              <div class="regular-post-tags clearfix pull-left">
                    @include('frontend.partials.tags', ['tags' => $post->tags])
              </div>
              <div class="text-left clearfix main-post-body">
                {!! $post->excerpt !!}
                {!! $post->content !!}
              </div>
              <br>
              <div class="embed-responsive embed-responsive-16by9 clearfix">
                  <iframe src="https://www.youtube.com/embed/{{ $post->video }}" frameborder="0" allowfullscreen></iframe>
              </div>
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

            <div class="col-lg-12">
                @include('frontend.partials.related')
                <hr>
                @include('frontend.partials.disqus')

            </div>

    </div>
@endsection
