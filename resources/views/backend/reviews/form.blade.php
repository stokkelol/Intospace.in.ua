<div class="row">
    <div class="col-lg-9">
        <div class="form-group">
            {!! Form::label('inputTitle', 'Title:') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label for="inputBand">Band title:</label>
            <select name="band_id" id="inputBand" class="select2-container form-control">
                @foreach($bands as $band)
                    <option value="{{ $band->id }}"
                        {{ (!empty($post) && $post->band_id == $band->id) ? 'selected' : '' }}>
                        {{ $band->title }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            {!! Form::label('inputContent', 'Text:') !!}
            {!! Form::textarea('content', null, ['class' => 'form-control ckeditor', 'id' => 'ckeditor']) !!}
            <script>
                $('.ckeditor').ckeditor(); // if class is prefered.
            </script>
        </div>
        <div class="form-group">
            {!! Form::label('inputVideo', 'Video:') !!}
            {!! Form::text('video', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="inputImg">Cover</label>
            @if (!empty($post) && !empty($post->img))
                <img src="/upload/covers/{{ $post->img }}" alt="" class="img-responsive">
                @endif
            <input type="file" id="inputImg" name="img" class="">
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
