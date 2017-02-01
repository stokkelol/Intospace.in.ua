@extends ('layouts.backend')

@section('content')
    {!! Form::open(['url' => $save_url, 'enctype' => 'multipart/form-data']) !!}
        @include('backend.bands.form')
    {!! Form::close() !!}
@endsection
