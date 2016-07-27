@extends ('layouts.backend')

@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>
        {!! Form::model($review, ['method' => 'PATCH', 'url' => 'backend/monthlyreviews/'.$review->id, 'enctype' => 'multipart/form-data']) !!}
            @include('backend.monthlyreviews.form')
        {!! Form::close() !!}
    </div>
@endsection
