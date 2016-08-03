<div class="row">
    <div class="col-lg-8">
        <div class="form-group">
            {!! Form::label('inputTitle', 'Title:') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label for="inputBand">Band title:</label>
            <select name="band_id" id="inputBand" class="select2-container form-control">
                @foreach ($bands as $band)
                    <option value="{{ $band->id }}"
                        {{ (!empty($video) && $video->band_id == $band->id) ? 'selected' : '' }}>
                        {{ $band->title }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            {!! Form::label('inputExcerpt', 'Excerpt:') !!}
            {!! Form::textarea('excerpt', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('inputVideo', 'Video link:') !!}
            {!! Form::text('video', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="inputImg">Cover</label>
            @if (!empty($video) && !empty($video->img))
                <img src="/upload/covers/{{ $video->img }}" alt="" class="img-responsive">
            @endif
            <input type="file" id="inputImg" name="img" class="">
        </div>
        <div class="form-group">
            {!! Form::label('inputPublished_at', 'Published at:') !!}
            {!! Form::input('datetime', 'published_at', isset($video->published_at) ? $video->published_at : Carbon\Carbon::now(), ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div>
        <input type="submit" value="Save" class="btn btn-block btn-success" >
    </div>
</div>
