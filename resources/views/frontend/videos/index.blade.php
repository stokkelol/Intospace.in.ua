@extends ('layouts.app')

@section('content')
    <div class="container main-video">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            @foreach ($videos as $video)
                <span class="video-title">{{ $video->title }}</span>
                {{ $video->excerpt }}
                <div class="video-main">
                    {{ $video->video }}
                </div>
                <div  class="video-author clearfix">
                    <em> {{ $video->published_at->diffForHumans() }} </em>
                </div>
        </div>
    </div>
            @endforeach
@endsection