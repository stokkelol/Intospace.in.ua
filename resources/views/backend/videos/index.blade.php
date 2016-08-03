@extends ('layouts.backend')

@section('content')
    <div class="panel panel-info">
        <div class="panel-heading">
            Videos
        </div>
        <div class="panel-body">
            <ul class="list-unstyled list-inline">
                <li><a href="{{ route('backend.videos.create') }}"><button type="button" class="btn btn-primary">Create new video</button></a></li>
            </ul>
            <hr>
            @foreach ($videos as $video)
                <div class="backend-item">
                    <div class="col-lg-1">{{ $video->id }}</div>
                    <div class="col-lg-8"><strong>{{ $video->title }}</strong>
                                        <span class="label label-default"><a href="{{ route('backend.videos.edit', ['video_id' => $video->id]) }}">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>Edit</a></span>
                    </div>
                    <div class="col-lg-3"> {{ $video->slug }}</div>
                </div>
            @endforeach
        </div>
        <div class="posts-paginate text-center">
            {!! $videos->render() !!}
        </div>
    </div>
@endsection
