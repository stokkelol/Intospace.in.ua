<div class="row">
    <div class="col-lg-8">
        <div class="form-group">
            <label for="inputCategory">Title</label>
            <input id="inputCategory" type="text"  value="{!! $category->title or Input::old('title') !!}" class="form-control" name="title">
        </div>
    </div>
</div>
<div class="row">
    <div>
        <input type="submit" value="Save" class="btn btn-block btn-success" >
    </div>
</div>