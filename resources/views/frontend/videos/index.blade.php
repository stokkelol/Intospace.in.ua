@extends ('layouts.app')
@section('content')
    <div class="container main-video clearfix">
        @foreach ($videos as $video)
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 video-item clearfix">
                {{ $video->video}}
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 video-text clearfix">
                <p class="video-title"><a href="{{ route('videos', ['slug' => $video->slug]) }}">{{ $video->title}}</a></p>
                <div class="video-date">
                    <em>{{ $video->published_at->diffForHumans() }} | <strong>{{ $video->user->name }}</strong></em>
                </div>
                <br>
                <p>{{ $video->excerpt}}</p>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <hr>
            </div>
        @endforeach
    </div>
@endsection
