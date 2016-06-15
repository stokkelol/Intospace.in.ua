<div class="row">
    <div class="col-lg-9">

        <div class="form-group">
            {!! Form::label('inputTitle', 'Title:') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
         </div>

        <div class="form-group">

            {!! Form::label('inputExcerpt', 'Excerpt:') !!}
            {!! Form::textarea('excerpt', null, ['class' => 'form-control']) !!}
        </div>


        <div class="form-group">
            {!! Form::label('inputContent', 'Text:') !!}
            {!! Form::textarea('content', null, ['class' => 'form-control ckeditor', 'id' => 'ckeditor']) !!}
            <script>
                $('.ckeditor').ckeditor(); // if class is prefered.
            </script>
        </div>


        <div class="row">
        <div class="col-lg-10"><div class="form-group">
            <label for="inputLinks">Links:</label>
            <textarea class="form-control links" id="links" name="links" cols="50" rows="10">
            @if (empty($post))
            <a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa-vk" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa-youtube" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa-lastfm-square" aria-hidden="true"></i></a>
            @endif
            @if (!empty($post) && !empty($post->links))
              {{ $post->links }}
            @endif
            </textarea>
            <!--{{ Form::label('inputLinks', 'Links:') }}
            {{ Form::textarea('links', null, ['class' => 'form-control links', 'id' => 'links']) }}-->
            </div>
        </div>
        <div class="col-lg-2">
        </div>
        </div>

        <div class="form-group">
            {!! Form::label('inputVideo', 'Video:') !!}
            {!! Form::text('video', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('inputSimilar', 'Similars:') !!}
            {!! Form::textarea('similar', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="inputCategory">Categories</label>
            <select name="category_id" id="inputCategory" class="form-control">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                            {{ (!empty($post) && $post->category_id == $category->id) ? 'selected' : '' }}>
                        {{ $category->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            {!! Form::label('tagList', 'Tags:') !!}
            {!! Form::select('tagList[]', $tags, null, ['id' => 'tagsselect', 'class' => 'select2-container form-control', 'multiple']) !!}
        </div>

        <div class="form-group">
            <label for="inputImg">Cover</label>
            @if (!empty($post) && !empty($post->img))
                <img src="/upload/covers/{{ $post->img }}" alt="" class="img-responsive">
                @endif
            <input type="file" id="inputImg" name="img" class="">
        </div>

        <div class="form-group">
            <label for="inputLogo">Logo</label>
            @if (!empty($post) && !empty($post->img))
                <img src="/upload/logos/{{ $post->logo }}" alt="" class="img-responsive">
                @endif
            <input type="file" id="inputLogo" name="logo" class="">
        </div>

        <div class="form-group">
            {!! Form::label('inputPublished_at', 'Published at:') !!}
            {!! Form::input('datetime', 'published_at', isset($post->published_at) ? $post->published_at : Carbon\Carbon::now(), ['class' => 'form-control']) !!}
        </div>


        <br>

        <div class="row">
            {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
</div>
    <script>
        CKEDITOR.replace( 'ckeditor', {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
        });
    </script>
