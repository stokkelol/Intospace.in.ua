@extends ('layouts.backend')

@section('content')
    <div class="container">
        <h2>New review</h2>
        {!! Form::open(['url' => $save_url, 'enctype' => 'multipart/form-data']) !!}
            @include('backend.blogs.form')
        {!! Form::close() !!}
    </div>
@endsection
