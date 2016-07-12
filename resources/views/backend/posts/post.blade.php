@extends ('layouts.backend')

@section('content')
    <div class="container">
        <h2>New post</h2>
        {!! Form::open(['url' => $save_url, 'enctype' => 'multipart/form-data']) !!}
            @include('backend.posts.form')
        {!! Form::close() !!}
    </div>
@endsection
