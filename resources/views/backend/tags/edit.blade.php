@extends ('layouts.backend')

@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>


        {!! Form::open(['method' => 'PATCH', 'url' => 'backend/tags/'.$tag->id, 'enctype' => 'multipart/form-data']) !!}
        <div class="row">
            <div class="col-lg-8">
                <div class="form-group">
                    <label for="inputTag">Title</label>
                    <input id="inputTag" type="text"  value="{!! $tag->tag or Input::old('tagtitle') !!}" class="form-control" name="tagtitle">
                </div>
            </div>
        </div>
        <div class="row">
            <div>
                <input type="submit" value="Save" class="btn btn-block btn-success" >
            </div>
        </div>
        {!! Form::close() !!}

    </div>


@endsection