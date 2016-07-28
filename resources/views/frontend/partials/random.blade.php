<!-- Random posts section -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="col-lg-12 preview-panel">
        <ul id="lightSlider" class="gallery content-slider list-unstyled list-inline clearfix cS-hidden">
            @foreach($randposts as $post)
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
</div>
