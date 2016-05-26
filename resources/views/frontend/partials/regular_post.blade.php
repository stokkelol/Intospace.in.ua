@foreach ($posts as $post)
@if ($post->status == 'active'  && $post->is_pinned == '0')
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="clearfix regular-post-title clearfix">
          <a href="{{ route('post', ['slug' => $post->slug]) }}">{{$post->title}}</a>
      </div>
      <br>
      <div class="col-lg-5 clearfix">
          <img src="/upload/covers/{{ $post->img_thumbnail }}" class="img-responsive img-thumbnail">
      </div>
      <div class="col-lg-7 clearfix">
        <div>
            <em class="regular-post-author">{{ $post->published_at->diffForHumans() }} | <strong>{{ $post->user->name }}</strong></em>
        </div>
        <div class="regular-post-tags clearfix">
            @include('frontend.partials.tags', ['tags' => $post->tags])
        </div>
            @include('frontend.partials.share')
        <br>
        <div class="clearfix">
            {{ $post->excerpt }}
        </div>

        <div class="clearfix">
            <p>
              <a href="{{ route('post', ['slug' => $post->slug]) }}">Читать далее</a>
            </p>
        </div>
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <hr>
    </div>
@endif
@endforeach
