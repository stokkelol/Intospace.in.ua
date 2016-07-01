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
                    <div class="panel-body">
                        <div class="categories-list">
                            <div class="col-lg-1 element">id</div>
                            <div class="col-lg-2 element">title</div>
                            <div class="col-lg-3 element">posts</div>
                            <div class="col-lg-3 element">videos</div>
                            <div class="col-lg-3 element">reviews</div>
                            <hr>
                        </div>
                        <hr>
                        @foreach($bands as $band)
                            <div class="col-lg-1 element">{{ $band->id }}</div>
                            <div class="col-lg-2">{{ $band->title }}</div>
                            <div class="col-lg-3">
                                @foreach ($band->posts as $post)
                                    {{ $post->title }}
                                @endforeach
                            </div>
                            <div class="col-lg-3">
                                @foreach ($band->videos as $video)
                                    {{ $video->title }}
                                @endforeach
                            </div>
                            <div class="col-lg-3">
                                @foreach ($band->reviews as $review)
                                    {{ $review->title }}
                                @endforeach
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
