@extends ('layouts.backend')

@section('content')
    <div class="panel panel-primary">
    <div class="panel-heading">
        Bands
    </div>
    <div class="panel-body">
        <ul class="list-unstyled list-inline">
            <li>  <a href="{{ route('backend.bands.create') }}"><button type="button" class="btn btn-primary">Create band</button></a></li>
            <li class="pull-right">
                {!! Form::open(['route' => 'backend.bands.index', 'role' => 'search', 'method' => 'get', 'class' =>'form-inline']) !!}
                {!! Form::text('search', null, ['class' => 'form-control']) !!}{!! Form::submit('search', ['class' => 'btn btn-default']) !!}
                {!! Form::close() !!}
            </li>
        </ul>
        <hr>
        @foreach ($bands as $band)
            <div class="backend-item">
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 element">{{ $band->id }}</div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 element">{{ $band->title }}</div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 element">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 element">
                        @if (count($band->posts) !== 0)
                            @foreach ($band->posts as $post)
                                {{ $post->title }}
                            @endforeach
                        @else
                            ---
                        @endif
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 element">
                        @if (count($band->videos) !== 0)
                            @foreach ($band->videos as $video)
                                {{ $video->title }}
                            @endforeach
                        @else
                            ---
                        @endif
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 element">
                        @if (count($band->reviews) !== 0)
                            @foreach ($band->reviews as $review)
                                {{ $review->title }}
                            @endforeach
                        @else
                            ---
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="posts-paginate text-center">
        {!! $bands->render() !!}
    </div>
</div>
@endsection
