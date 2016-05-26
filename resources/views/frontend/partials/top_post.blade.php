<div class="container">
  <div class="top-post">
    <div class="col-lg-12 top-post-title">
      <a href="{{ route('post', ['slug' => $post->slug]) }}">{{$post->title}}</a>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-sx-12 top-post-img">
      <img src="/upload/covers/{{ $post->img }}" class="img-thumbnail img-responsive center-block">
    </div>
    <div class="col-lg-8 col-md-8 col-sm-12 col-sx-12 top-post-textarea">
        <div><em class="post-top-author">{{ $post->published_at->diffForHumans() }} | <strong>{{ $post->user->name }}</strong></em>
            <br>
          @include('frontend.partials.tags', ['tags' => $post->tags])
        </div>
            @include('frontend.partials.share')
        <br>
        <ul class="nav nav-pills">
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
            <div id="{{ $post->id}}tab3" class="tab-pane fade">{!! $post->links !!}  </div>
            <div id="{{ $post->id}}tab4" class="tab-pane fade">{!! $post->similar !!}</div>
        </div>
    </div>

  </div>
</div>
