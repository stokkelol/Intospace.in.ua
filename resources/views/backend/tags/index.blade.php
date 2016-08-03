@extends ('layouts.backend')

@section('content')
    <div class="panel panel-info">
        <div class="panel-heading">
            Tags
        </div>
        <div class="panel-body">
            <ul class="list-unstyled list-inline">
                <li>  <a href="{{ route('backend.tags.create') }}"><button type="button" class="btn btn-primary">Create tag</button></a></li>
            </ul>
            <hr>
            @foreach ($tags as $tag)
            <div class="backend-item">
                <div class="col-lg-1 element">{{ $tag->id }}</div>
                <div class="col-lg-6 element"><a href="" class="categories-title"><strong>{{ $tag->tag }}</strong></a>
                <a href="{{ route('backend.tags.show', ['slug' => $tag->slug]) }}"><span class="label label-default pull-right"><i class="fa fa-list-alt" aria-hidden="true"></i> Show with posts</span></a>
                <a href="{{ route('backend.tags.edit', ['tag_id' => $tag->id]) }}"><span class="label label-default pull-right"><i class="fa fa-pencil" aria-hidden="true"></i> Edit </span></a>
                <span class="label pull-right">{{ $tag->num }}</span>
                </div>
                <div class="col-lg-3 element">{{ $tag->slug }}</div>
                <div class="col-lg-2 element">{{ $tag->created_at }}</div>
                <br>
            </div>
            @endforeach
        </div>
        <div class="posts-paginate text-center">
            {!! $tags->render() !!}
        </div>
    </div>
@endsection
