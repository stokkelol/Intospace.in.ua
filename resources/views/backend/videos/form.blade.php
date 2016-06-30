<div class="row">
    <div class="col-lg-8">
        <div class="form-group">
            <label for="inputTitle">Title</label>
            <input id="inputTitle" type="text"  value="{!! $video->title or Input::old('title') !!}" class="form-control" name="title">
        </div>

        <div class="form-group">
            <label for="inputExcerpt">Excerpt</label>
            <input id="inputExcerpt" type="text"  value="{!! $video->excerpt or Input::old('excerpt') !!}" class="form-control" name="excerpt">
        </div>

        <div class="form-group">
            <label for="inputVideo">Title</label>
            <input id="inputVideo" type="text"  value="{!! $video->video or Input::old('video') !!}" class="form-control" name="video">
        </div>
    </div>
</div>
<div class="row">
    <div>
        <input type="submit" value="Save" class="btn btn-block btn-success" >
    </div>
</div>
