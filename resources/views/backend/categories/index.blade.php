@extends ('layouts.backend')

@section('content')
    <div class="container">
      <div class="panel-heading">
          <ul class="list-unstyled list-inline">
                <li>  <a href="{{ route('backend.categories.create') }}"><button type="button" class="btn btn-primary">Create category</button></a></li>

          </ul>
      </div>
      <hr>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                  <div class="panel panel-success">
                    <div class="panel-heading">Categories</div>
                    <div class="panel-body">
                    <div class="categories-list">
                        <div class="col-lg-1 element">id</div>
                        <div class="col-lg-8 element">title</div>
                        <div class="col-lg-3 element">slug</div>
                    </div>

                        @foreach($categories as $category)
                            <div class="categories-table">
                                <div class="col-lg-1">{{ $category->id }}</div>
                                <div class="col-lg-8"><strong>{{ $category->title }}</strong>
                                    <a href="{{ route('backend.categories.show', ['category_id' => $category->id]) }}"><span class="label label-default pull-right"><i class="fa fa-list-alt" aria-hidden="true"></i> Show with posts</span></a>
                                    <a href="{{ route('backend.categories.edit', ['category_id' => $category->id]) }}"><span class="label label-default pull-right"><i class="fa fa-pencil" aria-hidden="true"></i> Edit </span></a>
                                    <span class="label pull-right"><i class="fa fa-file-o" aria-hidden="true"></i> {{ $category->num }}</span>
                                </div>
                                <div class="col-lg-3"> {{ $category->slug }}</div>
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
