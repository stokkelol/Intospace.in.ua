@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row bands-container">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 band-search-conteiner">
                <div class="">
                    <h3>Bands</h3>
                    {!! Form::open(['url' => '/bands', 'role' => 'search', 'method' => 'get', 'class' =>'main-search form-inline']) !!}
                    {!! Form::text('search', null, ['class' => 'form-inline']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <ul class="list-unstyled">
                        @foreach($bands as $band)
                            @if(count($band->posts) || count($band->videos))
                                <p class="band-title"><a href="/bands/{{ $band->slug }}">{{ $band->title }}</a></p>
                                <ul>
                                    @foreach($band->posts as $post)
                                        @if($post->status == 'active')
                                            <li><a href="/posts/{{ $post->slug }}">{{ $post->title }}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                                <ul>
                                    @foreach($band->videos as $video)
                                        <li><a href="/videos/{{ $video->slug }}">{{ $video->title }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
