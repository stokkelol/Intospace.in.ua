@extends('layouts.backend')

@section('content')
    <div class="contrainer">
        <div class="col-lg-8">
            <img src="/{{ $file['dirname'] }}/{{ $file['basename'] }}" alt="" class="img-thumbnail img-responsive"/>
        </div>
        <div class="col-lg-4">
            Post associated with img:
            <a href="/posts/{{ $post->slug }}"><p>{{ $post->title }}</p></a>
            {!! Form::open(['route' => 'backend.files.store', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                {!! Form::label('inputTitle', 'New title:') !!}
                {!! Form::text('title', null, ['class' => 'form-control']) !!}
                <input type="hidden" name="old_title" value="{{ $file['dirname'] }}/{{ $file['basename'] }}">
                <div class="row">
                    {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection