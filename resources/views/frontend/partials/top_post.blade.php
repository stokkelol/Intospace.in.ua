<div class="container">
  <div class="top-post">
    <div class="top-post-desc">
        <div class="col-lg-10  col-md-10 col-sm-10 col-xs-10 top-post-title">
            <a href="{{ route('posts', ['slug' => $post->slug]) }}">{{$post->title}}</a>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            @include('frontend.partials.share')
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-sx-12 top-post-img">
      <img src="/upload/covers/{{ $post->img }}" class="img-thumbnail img-responsive center-block">
    </div>
    <div class="col-lg-8 col-md-8 col-sm-12 col-sx-12 top-post-textarea">
        <div><em class="top-post-date">{{ $post->published_at->diffForHumans() }} - <strong>{{ $post->user->name }}</strong></em>
            @include('frontend.partials.tags', ['tags' => $post->tags])
        </div>
        <ul class="nav nav-pills cl-effect-1">
            <li class="active"><a data-toggle="tab" href="#{{ $post->id}}tab1">Обзор</a></li>
            <li><a data-toggle="tab" href="#{{ $post->id}}tab2">Видео</a></li>
            <li><a data-toggle="tab" href="#{{ $post->id}}tab3">Ссылки</a></li>
            <li><a data-toggle="tab" href="#{{ $post->id}}tab4">Похожие исполнители</a></li>
        </ul>
        <div class="tab-content">
            <div id="{{ $post->id}}tab1" class="tab-pane fade in active">{!! $post->content !!}</div>
            <div id="{{ $post->id}}tab2" class="tab-pane fade">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe src="https://www.youtube.com/embed/{{ $post->video }}" frameborder="0" allowfullscreen></iframe>
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
    </div>
  </div>
</div>
