<!-- Top post -->
<div class="container">
    <div class="top-post">
        <div class="top-post-desc">
            <div class="col-lg-12  col-md-12 col-sm-12 col-xs-12 top-post-title">
                <a href="{{ route('posts', ['slug' => $post->slug]) }}">{{$post->title}}</a>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-sx-12 top-post-img">
          <a href="/upload/covers/{{ $post->img }}" class="fancybox"><img src="/upload/covers/{{ $post->img }}" class="img-thumbnail img-responsive center-block"></a>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-12 col-sx-12 top-post-textarea">
            <div><em class="top-post-date">{{ $post->published_at->diffForHumans() }} - <strong>{{ $post->user->name }}</strong></em>
                @include('frontend.partials.tags', ['tags' => $post->tags])
            </div>
            <ul class="nav nav-pills cl-effect-1" id="post-tabs">
                <li class="active"><a data-toggle="tab" href="#{{ $post->id}}tab1">Обзор</a></li>
                <li><a data-toggle="tab" href="#{{ $post->id}}tab2">Видео</a></li>
                <li><a data-toggle="tab" href="#{{ $post->id}}tab3">Ссылки</a></li>
                <li><a data-toggle="tab" href="#{{ $post->id}}tab4">Похожие исполнители</a></li>
            </ul>
            <div class="tab-content">
                <div id="{{ $post->id}}tab1" class="tab-pane fade in active">
                  <p>{!! $post->excerpt !!}</p>
                  <p>{!! $post->content !!}</p>
                </div>
                <div id="{{ $post->id}}tab2" class="tab-pane fade">
                    <div class="video-pane">
                        <div class="js-lazyYT" data-youtube-id="{{$post->video}}" data-ratio="16:9"></div>
                    </div>
                </div>
                <div id="{{ $post->id}}tab3" class="tab-pane fade">
                    <div class="text-center top-post-links">
                        {!! $post->links !!}
                    </div>
                </div>
                <div id="{{ $post->id}}tab4" class="tab-pane fade">
                    <div class="text-center">
                        <ul class="list-unstyled">
                            {!! $post->similar !!}
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clearfix post-filters">
                <span class="label label-default pull-right">
                    Фильтры: <a href="{{ route('bands', ['slug' => $post->band->slug]) }}">По группе</a>
                </span>
            </div>
        </div>
    </div>
</div>
