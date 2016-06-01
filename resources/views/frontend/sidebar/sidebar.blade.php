
  <p class="sidebar-tagline">...и всё более странная музыка...</p>
  <div class="sidebar-image">
      <img src="images/avatar.png" class="main-img">
  </div>
  <br>

  <div class="text-center clearfix">
      <br>
      <br>
      <section class="tagscloud" id="tagscloud">
        <p><i class="fa fa-tags" aria-hidden="true"></i> Облако тегов:</p>
          @foreach ($counttags as $tag)
              @if (($tag->cnt) > 2)
                  <a href="{{ route('tags', ['slug' => $tag->slug]) }}" class="{{ (($tag->id)%2 == 0) ? 'tag-odd' : 'tag-even' }}" style="font-size:16px"><span>{{ $tag->tag }}</span></a>
              @else
                  <a href="{{ route('tags', ['slug' => $tag->slug]) }}" class="{{ (($tag->id)%2 == 0) ? 'tag-odd' : 'tag-even' }}" style="font-size:12px">{{ $tag->tag }}</a>
              @endif
          @endforeach
      </section>
  </div>
  <br>



  <div class="sidebar-posts">
    <ul>
      @foreach($posts as $post)
        @if ($post->id <=10)
          <li><a href="{{ $post->slug }}">{{ $post->title }}</a></li>
        @endif
      @endforeach
    </ul>
  </div>
