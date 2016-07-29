<div class="related-posts">
    <span class="text-center">Похожие обзоры:</span>
    <ul id="lightSlider" class="gallery content-slider list-unstyled list-inline clearfix cS-hidden">
        @foreach($posts as $post)
          <li>
              <div class="preview-element">
                  <a href="{{ route('posts', ['slug' => $post->slug]) }}">
                    <img src="/upload/covers/{{ $post->img_thumbnail }}" class="img-responsive img-thumbnail img-preview " alt="" />
                </a><br>
                  <a href="{{ route('posts', ['slug' => $post->slug]) }}"><em>{{ $post->title }}</em></a>
              </div>
        </li>
        @endforeach
    </ul>
</div>
<br>
