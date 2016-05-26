@extends ('layouts.backend')

@section('content')
    <div class="container">
      <div class="panel-heading">
          <ul class="list-unstyled list-inline">
                <li>  <a href="{{ route('backend.tags.create') }}"><button type="button" class="btn btn-primary">Create tag</button></a></li>

          </ul>
      </div>
      <hr>
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
              <div class="panel panel-warning">
                    <div class="panel-heading">Tags</div>
                    <div class="panel-body">
                      <div class="categories-list">
                          <div class="col-lg-1 element">id</div>
                          <div class="col-lg-6 element">title</div>
                          <div class="col-lg-3 element">slug</div>
                          <div class="col-lg-2 element">updated_at</div>
                          <hr>
                      </div>
                      </div>

                      @foreach($tags as $tag)
                          <div class="categories-table">
                              <div class="col-lg-1 element">{{ $tag->id }}</div>
                              <div class="col-lg-6 element"><a href="" class="categories-title"><strong>{{ $tag->tag }}</strong></a>
                                  <a href="{{ route('backend.tags.show', ['slug' => $tag->slug]) }}"><span class="label label-default pull-right"><i class="fa fa-list-alt" aria-hidden="true"></i> Show with posts</span></a>
                                  <a href="{{ route('backend.tags.edit', ['tag_id' => $tag->id]) }}"><span class="label label-default pull-right"><i class="fa fa-pencil" aria-hidden="true"></i> Edit </span></a>
                                  <span class="label pull-right">{{ $tag->num }}</span>
                              </div>
                              <div class="col-lg-3 element">{{ $tag->slug }}</div>
                              <div class="col-lg-2 element">updated_at</div>
                              <br>
                          </div>
                          <hr>
                      @endforeach
                    </div>
              </div>
          </div>
      </div>
@endsection
