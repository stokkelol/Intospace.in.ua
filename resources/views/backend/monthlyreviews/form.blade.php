<div class="row">
    <div class="col-lg-8">
        <div class="form-group">
            {!! Form::label('inputTitle', 'Title:') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('inputContent', 'Content:') !!}
            {!! Form::textarea('content', null, ['class' => 'form-control ckeditor']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('inputPublished_at', 'Published at:') !!}
            {!! Form::input('datetime', 'published_at', isset($post->published_at) ? $post->published_at : Carbon\Carbon::now(), ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Posts
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="inputLatest_posts">Posts:</label>
                    <textarea name="latest_posts" class="form-control links" id="latest_posts" cols="50" rows="10">
                        @foreach($latest_posts as $post)
                            <li><a href="/posts/{{ $post->slug }}">{{ $post->title }}</a></li>
                        @endforeach
                    </textarea>
                </div>
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                Videos
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="inputLatest_videos">Posts:</label>
                    <textarea name="latest_videos" class="form-control links" id="latest_videos" cols="50" rows="10">
                        @foreach($latest_videos as $video)
                            <li><a href="/videos/{{ $video->slug }}">{{ $video->title }}</a></li>
                        @endforeach
                    </textarea>
                </div>
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                Popular posts
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="inputPopular_posts">Posts:</label>
                    <textarea name="popular_posts" class="form-control links" id="latest_posts" cols="50" rows="10">
                        @foreach($popular_posts as $post)
                            <li><a href="/posts/{{ $post->slug }}">{{ $post->title }}</a></li>
                        @endforeach
                    </textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div>
            <input type="submit" value="Save" class="btn btn-block btn-success" >
        </div>
    </div>
</div>

<script>
    CKEDITOR.replace( 'ckeditor', {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
    });
</script>
