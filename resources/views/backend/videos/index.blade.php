@extends ('layouts.backend')

@section('content')
    <div class="container">
      <div class="panel-heading">
          <ul class="list-unstyled list-inline">
                <li>  <a href="{{ route('backend.videos.create') }}"><button type="button" class="btn btn-primary">Create video</button></a></li>

          </ul>
      </div>
      <hr>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                  <div class="panel panel-success">
                    <div class="panel-heading">Videos</div>
                    <div class="panel-body">
                    <div class="categories-list">
                        <div class="col-lg-1 element">id</div>
                        <div class="col-lg-8 element">title</div>
                        <div class="col-lg-3 element">slug</div>
                    </div>

                        @foreach($videos as $video)
                            <div class="categories-table">
                                <div class="col-lg-1">{{ $video->id }}</div>
                                <div class="col-lg-8"><strong>{{ $video->title }}</strong>
                                        <span class="label label-default"><a href="{{ route('backend.videos.edit', ['video_id' => $video->id]) }}">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>Edit</a></span>
                                </div>
                                <div class="col-lg-3"> {{ $video->slug }}</div>
                                <br>
                            </div>
                            <hr>
                        @endforeach
                      </div>

                  </div>

                </div>
            </div>

    </div>
@endsection
