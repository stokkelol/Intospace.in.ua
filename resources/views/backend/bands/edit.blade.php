@extends ('layouts.backend')

@section('content')
    <div class="container">
        {!! Form::model($band, ['method' => 'PATCH', 'url' => 'backend/bands/'.$band->id, 'enctype' => 'multipart/form-data']) !!}
            @include('backend.bands.form')
        {!! Form::close() !!}
    </div>
@endsection
