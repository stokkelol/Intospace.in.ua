@extends ('layouts.app')

@section('content')
    <div class="container main-post">
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 main-post-img">
            <a href="/upload/covers/{{ $post->img }}" class="fancybox"><img src="/upload/covers/{{ $post->img }}" class="img-responsive img-thumbnail"></a>
            <br>
            <div class="post-links text-center">
                <br>
                {!! $post->links !!}
                <br>
            </div>
            @if (!empty($post->similar))
            <div class="post-similars hidden-sm hidden-xs text-center">
                <p>Похожие исполнители:</p>
                <ul class="list-unstyled">{!! $post->similar !!}</ul>
            </div>
            @endif
        </div>
        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 main-post-text">
            <div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-sx-12">
                    <a href="{{ $post->slug }}"><span class="main-post-title">{{$post->title}}</span></a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    @include('frontend.partials.share', ['post' => $post])
                </div>
            </div>
            <br>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div>
                    @if ($post->category->id == '1')
                        <em class="main-post-author"><a href="/categories/new-reviews">Новый обзор</a></em>
                    @elseif ($post->category->id == '2')
                        <em class="main-post-author"><a href="/categories/old-reviews">Старый обзор</a></em>
                    @elseif ($post->category->id == '3')
                        <em class="main-post-author"><a href="/categories/short-reviews">Мини-обзор</a></em>
                    @endif
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 regular-post-tags clearfix pull-left">
                    @include('frontend.partials.tags', ['tags' => $post->tags])
                </div>
                <div class="text-justify clearfix main-post-body">
                    <div class="clearfix">
                        {!! $post->excerpt !!}
                    </div>
                    <br>
                    <div class="clearfix">
                        {!! $post->content !!}
                    </div>
                    <div class="clearfix">
                        <span class="pull-right" >
                            <p>
                                @include('frontend.partials.datetime', ['post' => $post])
                                |
                                @include('frontend.partials.author', ['post' => $post])
                                |
                                <span class="post-filters-filter">Фильтры:</span>
                                <span class="post-filters"><a href="{{ route('bands', ['slug' => $post->band->slug]) }}" class="post-filters"> По группе</a></span>
                            </p>
                        </span>
                    </div>
                </div>
                <div class="js-lazyYT" data-youtube-id="{{$post->video}}" data-ratio="16:9"></div>
            </div>
            <br>
            @if (!empty($post->similar))
            <div class="post-similars hidden-lg hidden-md">
                <p>Похожие исполнители:</p>
                {!! $post->similars !!}
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
