@extends ('layouts.app')
@section('content')
    <div class="container main-video clearfix">
        @foreach ($videos as $video)
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 clearfix">
              <div class="embed-responsive embed-responsive-16by9">
                <iframe width="854" height="480" src="https://www.youtube.com/embed/{{ $video->video }}" frameborder="0" allowfullscreen></iframe>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 video-text clearfix">
                <p class="video-title"><a href="{{ route('videos', ['slug' => $video->slug]) }}">{{ $video->title}}</a></p>
                <div class="video-date">
                    <em>{{ $video->published_at->diffForHumans() }}</strong></em>
                </div>
                <br>
                <div class="embed-responsive embed-responsive-16by9">
                <p>{!! $video->excerpt !!}</p>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <hr>
            </div>
        @endforeach
    </div>
@endsection
