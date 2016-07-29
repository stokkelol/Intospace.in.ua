@extends ('layouts.backend')

@section('content')
    <div class="container">
        {!! Form::model($post, ['method' => 'PATCH', 'url' => 'backend/posts/'.$post->id, 'enctype' => 'multipart/form-data']) !!}
            @include('backend.posts.form')
        {!! Form::close() !!}
    </div>
@endsection
