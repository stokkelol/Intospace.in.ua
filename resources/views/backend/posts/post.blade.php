@extends ('layouts.backend')

@section('content')
    <div class="container">
        {!! Form::open(['url' => $save_url, 'enctype' => 'multipart/form-data']) !!}
            @include('backend.posts.form')
        {!! Form::close() !!}
    </div>
@endsection