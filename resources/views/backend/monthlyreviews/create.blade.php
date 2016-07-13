@extends ('layouts.backend')

@section('content')
    <div class="container">
        <h1>{{ $title  }}</h1>
        {!! Form::open(['url' => $save_url, 'enctype' => 'multipart/form-data']) !!}
            @include('backend.monthlyreviews.form')
        {!! Form::close() !!}
    </div>
@endsection
