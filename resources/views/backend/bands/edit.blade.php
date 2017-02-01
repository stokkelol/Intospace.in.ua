@extends ('layouts.backend')

@section('content')
    {!! Form::model($band, ['method' => 'PATCH', 'url' => 'backend/bands/'.$band->id, 'enctype' => 'multipart/form-data']) !!}
        @include('backend.bands.form')
    {!! Form::close() !!}
@endsection
