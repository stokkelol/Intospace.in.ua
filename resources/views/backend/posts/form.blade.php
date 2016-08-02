<div id="post-form-preview" class="col-md-12">
    <div class="top-post">
        <div class="top-post-desc">
            <div class="col-lg-12  col-md-12 col-sm-12 col-xs-12 top-post-title">
                <a href="">@{{ title }}</a>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-sx-12 top-post-img">
            @if(isset($post))
                <img src="/upload/covers/{{ $post->img }}" class="img-thumbnail img-responsive center-block">
            @endif
        </div>
        <div class="col-lg-8 col-md-8 col-sm-12 col-sx-12 top-post-textarea">
            @if(isset($post))
                <div><em class="top-post-date">{{ $post->published_at->diffForHumans() }} - <strong>{{ $post->user->name }}</strong></em>
                    @include('frontend.partials.tags', ['tags' => $post->tags])
                </div>
            @endif
            <ul class="nav nav-pills cl-effect-1" id="post-tabs">
                @if(isset($post))
                    <li class="active"><a data-toggle="tab" href="#{{ $post->id}}tab1">Обзор</a></li>
                    <li><a data-toggle="tab" href="#{{ $post->id}}tab2">Видео</a></li>
                    <li><a data-toggle="tab" href="#{{ $post->id}}tab3">Ссылки</a></li>
                    <li><a data-toggle="tab" href="#{{ $post->id}}tab4">Похожие исполнители</a></li>
                @endif
            </ul>
                <div class="tab-content">
                    @if(isset($post))
                        <div id="{{ $post->id}}tab1" class="tab-pane fade in active">
                            <p>@{{ excerpt }}</p>
                            <p>@{{ content }}</p>
                        </div>
                        <div id="{{ $post->id}}tab2" class="tab-pane fade">
                            <div class="video-pane">
                                <div class="js-lazyYT" data-youtube-id="{{$post->video}}" data-ratio="16:9"></div>
                            </div>
                        </div>
                        <div id="{{ $post->id}}tab3" class="tab-pane fade">
                            <div class="text-center top-post-links">
                                {!! $post->links !!}
                            </div>
                        </div>
                        <div id="{{ $post->id}}tab4" class="tab-pane fade">
                            <div class="text-center">
                                <ul class="list-unstyled">
                                    {!! $post->similar !!}
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="clearfix post-filters">
                    <span class="label label-default pull-right">
                        @if(isset($post))
                            Фильтры: <a href="{{ route('bands', ['slug' => $post->band->slug]) }}">По группе</a>
                        @endif
                            </span>
                </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="form-group">
            {!! Form::label('inputTitle', 'Title:') !!}
            {!! Form::text('title', null, ['class' => 'form-control', 'v-model' => 'title']) !!}
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

            {!! Form::label('inputExcerpt', 'Excerpt:') !!}
            {!! Form::textarea('excerpt', null, ['class' => 'form-control', 'v-model' => 'excerpt']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('inputContent', 'Text:') !!}
            {!! Form::textarea('content', null, ['class' => 'form-control ckeditor', 'id' => 'ckeditor', 'v-model' => 'content']) !!}
            <script>
                $('.ckeditor').ckeditor(); // if class is prefered.
            </script>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="inputLinks">Links:</label>
                        <textarea class="form-control links" id="links" name="links" cols="50" rows="10">
                        @if (empty($post))
                                <a href="#"><i class="fa fa-home" aria-hidden="true"></i></a>
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
            <select name="category_id" id="inputCategory" class="select2-container form-control">
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
            {!! Form::select('tagList[]', $tags, null, ['id' => 'tagsselect', 'class' => 'select2-container form-control', 'multiple', 'v-model' => 'selected']) !!}
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
