@extends ('layouts.backend')

@section('content')
        {!! Form::model($post, ['method' => 'PATCH', 'url' => 'backend/posts/'.$post->id, 'enctype' => 'multipart/form-data']) !!}
            @include('backend.posts.form')
        {!! Form::close() !!}
@endsection
