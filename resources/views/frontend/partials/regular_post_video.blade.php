<div class="col-lg-12">
    <div class="">
        <div class="col-lg-9">
            <div class="clearfix regular-post-title clearfix">
                <a href="{{ route('videos', ['slug' => $post->slug]) }}">{{$post->title}}</a>
            </div>
        </div>
        <br>
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 clearfix">
            <div class="text-center">
                <a href="/upload/covers/{{ $post->img }}" class="fancybox"><img src="/upload/covers/{{ $post->img }}" class="img-responsive img-thumbnail"></a>
            </div>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 clearfix">
            <div>
                <em class="regular-post-author"> <a href="/videos">Видео</a></em>
            </div>
            <br>
            <div class="clearfix">
                {!! $post->excerpt !!}
            </div>
            <div class="clearfix cl-effect-1">
                <br>
                <p>
                    <a href="{{ route('videos', ['slug' => $post->slug]) }}" class="more-link">Читать далее</a>
                </p>
            </div>
            <div class="clearfix post-filters">
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
    </div>
</div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <hr>
    </div>
