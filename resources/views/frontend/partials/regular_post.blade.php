@if (count($posts) == 0)
<!-- Nothing has been found -->
    <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12">
        <p>Что-то тут такого нет...</p>
    </div>
@endif
@if(!empty($posts))
@foreach($posts as $post)
    @if(isset($post->content))
    <!-- Post -->
        @if ($post->status == 'active'  && $post->is_pinned == '0')
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-lg-9">
                    <div class="clearfix regular-post-title clearfix">
                        <a href="{{ route('posts', ['slug' => $post->slug]) }}">{{$post->title}}</a>
                    </div>
                </div>
                <div class="col-lg-3">
                    <span class="pull-right">@include('frontend.partials.share')</span>
                </div>
                <br>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 clearfix">
                    <div class="text-center">
                        <img src="/upload/covers/{{ $post->img }}" class="img-responsive img-thumbnail">
                    </div>
                </div>
                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 clearfix">
                        <div>
                            @if ($post->category->id == '1')
                                <em class="regular-post-author"><a href="/categories/new-reviews">Обзор</a></em>
                            @elseif ($post->category->id == '2')
                                <em class="regular-post-author"><a href="/categories/old-reviews">Старый обзор</a></em>
                            @elseif ($post->category->id == '3')
                                <em class="regular-post-author"><a href="/categories/short-reviews">Мини-обзор</a></em>
                            @endif
                        </div>
                        <div>
                            <em class="regular-post-author">{{ $post->published_at->diffForHumans() }} - <strong>{{ $post->user->name }}</strong></em>
                        </div>
                        <div class="regular-post-tags clearfix">
                            @include('frontend.partials.tags', ['tags' => $post->tags])
                        </div>
                        <div class="clearfix">
                            {!! $post->excerpt !!}
                        </div>

                        <div class="clearfix cl-effect-1">
                            <p>
                                <a href="{{ route('posts', ['slug' => $post->slug]) }}" class="more-link">Читать далее</a>
                            </p>
                        </div>
                        <div class="clearfix post-filters">
                            <span class="label label-default pull-right">
                                Фильтры:
                                <!--<a href="{{ route('posts', ['year_filter' => $post->title]) }}">По году выпуска</a>-->
                                <a href="{{ route('bands', ['slug' => $post->band->slug]) }}">По группе</a>
                            </span>
                        </div>
                    </div>
                </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <hr>
            </div>
        @endif
    @else
    <!-- Video -->
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
                        <img src="/upload/covers/{{ $post->img }}" class="img-responsive img-thumbnail">
                    </div>
                </div>
                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 clearfix">
                        <div>
                            <em class="regular-post-author"> <a href="/videos">Видео</a></em>
                        </div>
                        <div>
                            <em class="regular-post-author">{{ $post->published_at->diffForHumans() }} - <strong>{{ $post->user->name }}</strong></em>
                        </div>
                        <br>
                        <div class="clearfix">
                            {!! $post->excerpt !!}
                        </div>
                        <div class="clearfix cl-effect-1">
                            <p>
                                <a href="{{ route('videos', ['slug' => $post->slug]) }}" class="more-link">Читать далее</a>
                            </p>
                        </div>
                        <div class="clearfix post-filters">
                            <span class="label label-default pull-right">
                                Фильтры: <a href="{{ route('bands', ['band_slug' => $post->band->slug]) }}">По группе</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <hr>
            </div>
    @endif
@endforeach
@endif
@if(Request::path() == '/')
    <!-- Main page paginator -->
    @if(!empty($links))
        <div class="paginate text-center">
            {!! $links->links() !!}
        </div>
    @endif
@endif
@if(Request::path() == 'posts')
    <!-- Posts page paginator -->
    <div class="paginate text-center">
        {!! $posts->links() !!}
    </div>
@endif
