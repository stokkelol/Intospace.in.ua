@extends ('layouts.backend')

@section('content')
    <div class="container">

                <div class="row backend-posts-index">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-heading">
                        <ul class="list-unstyled list-inline">
                            <li>
                                <a href="{{ route('backend.posts.index') }}"><button type="button" class="btn btn-default">All posts</button></a></li>
                            <li>
                                <a href="{{ route('backend.posts.create') }}"><button type="button" class="btn btn-primary">Create post</button></a></li>
                            <li>
                                <a href="{{ route('backend.posts.index', ['status'  => 'active']) }}"><button type="button" class="btn btn-success">Active</button></a></li>
                            <li>
                                <a href="{{ route('backend.posts.index', ['status'  => 'draft']) }}"><button type="button" class="btn btn-warning">Draft</button></a></li>
                            <li>
                                <a href="{{ route('backend.posts.index', ['status'  => 'deleted']) }}"><button type="button" class="btn btn-danger">Deleted</button></a></li>
                            <li class="pull-right">{!! Form::open(['route' => 'backend.posts.index', 'role' => 'search', 'method' => 'get', 'class' =>'form-inline']) !!}
                                    {!! Form::text('search', null, ['class' => 'form-control']) !!}{!! Form::submit('search', ['class' => 'btn btn-default']) !!}
                                    {!! Form::close() !!}</li>
                        </ul>
                        <hr>
                    </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="panel panel-info">
                              <div class="panel panel-heading">
                                <p>
                                  Posts
                                </p>
                              </div>
                              <div class="posts-paginate text-center">
                                  {!! $posts->render() !!}
                              </div>
                                <div class="posts-list">
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-default">id</div>
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-danger">author</div>
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-primary">status</div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-success">title</div>
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-warning">category</div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-info">published at</div>
                                </div>
                                <hr>
                                @foreach($posts as $post)
                                <div style="min-height:80px">
                                  <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-default">{{ $post->id}} </div>
                                  <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><span>{{ $post->user->name }}</span>
                                  </div>
                                  <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><span>{{ $post->status }}</span>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><span>
                                          <a href="{{ route('posts', ['slug' => $post->slug]) }}" class="posts-title"><strong>{{ $post->title }}</strong></a></span>
                                          <p>
                                            <span class="label label-default"><a href="{{ route('backend.posts.edit', ['post_id' => $post->id]) }}">
                                                        <i class="fa fa-pencil" aria-hidden="true"></i>Edit</a></span>
                                            <span class="label label-default"><a href="{{ route('backend.posts.to-draft', ['post_id' => $post->id]) }}">
                                                    <i class="fa fa-outdent" aria-hidden="true"></i>To draft</a></span>
                                            <span class="label label-default"><a href="{{ route('backend.posts.to-active', ['post_id' => $post->id]) }}">
                                                    <i class="fa fa-indent" aria-hidden="true"></i>To active</a></span>
                                            <span class="label label-default"><a href="{{ route('backend.posts.to-deleted', ['post_id' => $post->id]) }}">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>To Deleted</a></span>
                                            @if ($post->is_pinned == '0')
                                                <span class="label label-default"><a href="{{ route('backend.posts.to-pinned', ['post_id' => $post->id]) }}">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>To pinned</a></span>
                                            @else
                                                <span class="label label-default"><a href="{{ route('backend.posts.to-regular', ['post_id' => $post->id]) }}">
                                                        <i class="fa fa-trash" aria-hidden="true"></i> To regular</a></span>
                                            @endif
                                          </p>


                                  </div>

                                  <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><span>{{ $post->category->title }}</span></div>
                                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><span>{{ $post->published_at }}</span></div>
                                </div>
                                <hr>

                                @endforeach
                                    <br>
                            </div>
                        </div>
                </div>
    </div>
@endsection
