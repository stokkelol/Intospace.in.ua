<p class="sidebar-tagline">...и всё более странная музыка...</p>
    <div class="sidebar-image">
        <img src="http://intospace.in.ua/upload/images/logo.jpg" class="main-img img-responsive">
    </div>
    <br>
    <div class="text-left">
        <p class="sidebar-title">Последние обзоры:</p>
        <ul class="list-unstyled">
            @foreach ($latestposts as $post)
                <li class="sidebar-list">
                    <a href="/posts/{{ $post->slug }}">{{ $post->title }}</a>
                </li>
            @endforeach
        </ul>
        <p class="sidebar-title">Последние видео:</p>
        <ul class="list-unstyled">
          @foreach ($latestvideos as $video)
              <li class="sidebar-list">
                  <a href="/videos/{{ $video->slug }}">{{ $video->title }}</a>
              </li>
          @endforeach
        </ul>
        <p class="sidebar-title">Популярные обзоры:</p>
        <ul class="list-unstyled">
            @foreach ($popularposts as $post)
                <li class="sidebar-list">
                    <a href="/posts/{{ $post->slug }}">{{ $post->title }}</a>
                </li>
            @endforeach
        </ul>
    </div>
          <div class="text-center clearfix">
              <br>
              <br>
              <div id="sticky-anchor"></div>
              <div>
              <section class="tagscloud" id="tagscloud">
                <p><i class="fa fa-tags" aria-hidden="true"></i> Облако тегов:</p>
                  @foreach ($counttags as $tag)
                      @if (($tag->cnt) > 5)
                          <a href="{{ route('tags', ['slug' => $tag->slug]) }}" class="{{ (($tag->id)%3 == 0) ? 'tag-even' : 'tag-odd' }}" style="font-size:14px"><span>{{ $tag->tag }}</span></a>
                      @elseif (($tag->cnt) > 3)
                          <a href="{{ route('tags', ['slug' => $tag->slug]) }}" class="{{ (($tag->id)%3 == 1) ? 'tag-even' : 'tag-odd' }}" style="font-size:12px"><span>{{ $tag->tag }}</span></a>
                      @else
                          <a href="{{ route('tags', ['slug' => $tag->slug]) }}" class="{{ (($tag->id)%3 == 2) ? 'tag-even' : 'tag-odd' }}" style="font-size:10px">{{ $tag->tag }}</a>
                      @endif
                  @endforeach
              </section>
            </div>
          </div>
      <!--
        <div class="sidebar-posts">
          <ul class="list-unstyled">
            @foreach($posts as $post)
              @if (($post->id) > 75)
                <li><a href="{{ $post->slug }}">{{ $post->title }}</a></li>
              @endif
            @endforeach
          </ul>
        </div>
      -->
