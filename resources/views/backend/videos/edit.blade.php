@extends ('layouts.backend')

@section('content')
    <div class="container">
        <h1>{{ $video->title }}</h1>
        {!! Form::model($video, ['method' => 'PATCH', 'url' => 'backend/videos/'.$video->id, 'enctype' => 'multipart/form-data']) !!}
        @include('backend.videos.form')
        {!! Form::close() !!}

    </div>


@endsection
