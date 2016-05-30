<p>...и всё более странная музыка...</p>
<div class="sidebar-image">
    <img src="http://www.intospace.in.ua/wp-content/uploads/2015/05/intospacewithdeath.jpg">
</div>
<br>

<div class="text-center clearfix">
    <br>
    <br>
    @foreach ($tags as $tag)
        <a href="{{ route('tag', ['slug' => $tag->slug]) }}" class="{{ (($tag->id)%2 == 0) ? 'tag-odd' : 'tag-even' }}">{{ $tag->tag }}</a>
    @endforeach
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
