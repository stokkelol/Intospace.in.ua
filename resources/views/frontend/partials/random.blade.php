<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="preview-panel">
    <ul class="list-inline preview-list">
        @foreach($randposts as $post)
          <li>
            <div class="preview-element">
              <a href="{{ route('post', ['slug' => $post->slug]) }}">
                <img src="/upload/covers/{{ $post->img_thumbnail }}" class="img-responsive img-thumbnail img-preview " alt="" />
              </a>
              <a href="{{ route('post', ['slug' => $post->slug]) }}"><em>{{ $post->title }}</em></a>
            </div>
          </li>
        @endforeach
    </ul>
  </div>
</div>
