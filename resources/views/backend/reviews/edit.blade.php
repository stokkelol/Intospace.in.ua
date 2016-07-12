@extends ('layouts.backend')

@section('content')
    <div class="container">
        <h1>{{ $review->title }}</h1>
        {!! Form::model($review, ['method' => 'PATCH', 'url' => 'backend/reviews/'.$review->id, 'enctype' => 'multipart/form-data']) !!}
            @include('backend.reviews.form')
        {!! Form::close() !!}
    </div>
@endsection
