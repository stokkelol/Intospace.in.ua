@extends ('layouts.backend')

@section('content')
    <h1>{{ $video->title }}</h1>
    {!! Form::model($video, ['method' => 'PATCH', 'url' => 'backend/videos/'.$video->id, 'enctype' => 'multipart/form-data']) !!}
        @include('backend.videos.form')
    {!! Form::close() !!}
@endsection
