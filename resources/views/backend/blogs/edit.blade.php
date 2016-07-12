@extends ('layouts.backend')

@section('content')
    <div class="container">
        <h1>{{ $blog->title }}</h1>
        {!! Form::model($blog, ['method' => 'PATCH', 'url' => 'backend/blogs/'.$blog->id, 'enctype' => 'multipart/form-data']) !!}
            @include('backend.blogs.form')
        {!! Form::close() !!}
    </div>
@endsection
