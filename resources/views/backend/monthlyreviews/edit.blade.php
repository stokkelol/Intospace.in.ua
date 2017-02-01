@extends ('layouts.backend')

@section('content')
    <h1>{{ $title }}</h1>
    {!! Form::model($review, ['method' => 'PATCH', 'url' => 'backend/monthlyreviews/'.$review->id, 'enctype' => 'multipart/form-data']) !!}
        @include('backend.monthlyreviews.form')
    {!! Form::close() !!}
@endsection
