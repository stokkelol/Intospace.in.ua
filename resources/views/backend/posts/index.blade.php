@extends ('layouts.backend')
@section('content')
    <div class="panel panel-info">
        <div class="panel-heading">
            Posts
        </div>
        <div class="panel-body">
            <ul class="list-unstyled list-inline">
                <li><a href="{{ route('backend.posts.index') }}"><button type="button" class="btn btn-default">All posts</button></a></li>
                <li><a href="{{ route('backend.posts.create') }}"><button type="button" class="btn btn-primary">Create post</button></a></li>
                <li><a href="{{ route('backend.posts.index', ['status'  => 'active']) }}"><button type="button" class="btn btn-success">Active</button></a></li>
                <li><a href="{{ route('backend.posts.index', ['status'  => 'draft']) }}"><button type="button" class="btn btn-warning">Draft</button></a></li>
                <li><a href="{{ route('backend.posts.index', ['status'  => 'deleted']) }}"><button type="button" class="btn btn-danger">Deleted</button></a></li>
                <li><a href="{{ route('backend.posts.index', ['orderby']) }}"><button type="button" class="btn btn-default">OrderBy</button></a></li>
                <li><a href="{{ route('backend.posts.updateall') }}"><button type="button" class="btn btn-default">Update all</button></a></li>
                <li class="pull-right">{!! Form::open(['route' => 'backend.posts.index', 'role' => 'search', 'method' => 'get', 'class' =>'form-inline']) !!}
                    {!! Form::text('search', null, ['class' => 'form-control']) !!}{!! Form::submit('search', ['class' => 'btn btn-default']) !!}
                    {!! Form::close() !!}</li>
            </ul>
            <hr>
                @foreach ($posts as $post)
                    <div class="backend-item" id="post-{{ $post->id }}">
                        <div class="col-md-1">{{ $post->id }}</div>
                        <div class="col-md-1">{{ $post->user->name }}</div>
                        <div class="col-md-1">{{ $post->status }}</div>
                        <div class="col-md-6"><a href="/posts/{{ $post->slug }}">{{ $post->title }}</a>
                            <br>
                        <span class="label label-default"><a href="{{ route('backend.posts.edit', ['post_id' => $post->id]) }}">
                                                        <i class="fa fa-pencil" aria-hidden="true"></i>Edit</a></span>

                            @if ($post->status == 'active')
                            <span class="label label-default"><a href="{{ route('backend.posts.to-draft', ['post_id' => $post->id]) }}">
                                <i class="fa fa-outdent" aria-hidden="true"></i>To draft</a></span>

                            @elseif ($post->status == 'draft')
                            <span class="label label-default"><a href="{{ route('backend.posts.to-active', ['post_id' => $post->id]) }}">
                                <i class="fa fa-indent" aria-hidden="true"></i>To active</a></span>
                            @endif

                            <span class="label label-default"><a href="{{ route('backend.posts.to-deleted', ['post_id' => $post->id]) }}"
                                id="delete-post" data-id="{{ $post->id }}" data-token="{{ csrf_token() }}">
                            <i class="fa fa-trash" aria-hidden="true"></i>To Deleted</a></span>
                        <!--<span class="label label-default"><a href="#" onClick="preview_post('{{$post->id}}')">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>Preview</a></span>-->
                            @if ($post->is_pinned == '0')
                                <span class="label label-default"><a href="{{ route('backend.posts.to-pinned', ['post_id' => $post->id]) }}">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>To pinned</a></span>
                            @else
                                <span class="label label-default"><a href="{{ route('backend.posts.to-regular', ['post_id' => $post->id]) }}">
                                                        <i class="fa fa-trash" aria-hidden="true"></i> To regular</a></span>
                            @endif
                        </div>
                        <div class="col-md-1">{{ $post->category->title }}</div>
                        <div class="col-md-2">{{ $post->published_at }}</div>
                    </div>
                @endforeach
        </div>
        <div class="posts-paginate text-center">
            {!! $posts->render() !!}
        </div>
    </div>
@endsection
