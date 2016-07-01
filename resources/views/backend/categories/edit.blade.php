@extends ('layouts.backend')

@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>
        {!! Form::open(['method' => 'PATCH', 'url' => 'backend/categories/'.$category->id, 'enctype' => 'multipart/form-data']) !!}
            @include('backend.categories.form')
        {!! Form::close() !!}
    </div>


@endsection
