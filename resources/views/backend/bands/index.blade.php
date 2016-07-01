@extends ('layouts.backend')

@section('content')
    <div class="container">
        <div class="panel-heading">
            <ul class="list-unstyled list-inline">
                  <li>  <a href="{{ route('backend.bands.create') }}"><button type="button" class="btn btn-primary">Create band</button></a></li>

            </ul>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <p>Bands</p>
                    </div>
                    {!! $bands->render() !!}
                    <div class="panel-body bands-container">
                        <div class="categories-list">
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 element">id</div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 element">title</div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 element">posts</div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 element">videos</div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 element">reviews</div>
                            <hr>
                        </div>
                        <hr>
                        @foreach($bands as $band)
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 element">{{ $band->id }}</div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 element">{{ $band->title }}</div>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 element">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 element">
                                        @if (count($band->posts) !== 0)
                                            @foreach ($band->posts as $post)
                                                {{ $post->title }}
                                            @endforeach
                                        @else
                                            1111
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
                                <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
