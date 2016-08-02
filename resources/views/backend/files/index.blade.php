@extends('layouts.backend')

@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h5>Total directory size: {{ $dir_size }}Mb</h5>
            <p>Total files: {{ $count }}</p>
        </div>
        <div class="panel-body">
            @foreach($files as $file)
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 files-container">
                    <img src="/{{ $file['dirname']}}/{{ $file['basename'] }}" alt="" class="img-thumbnail img-responsive"/>
                    <p><a href="/{{ $file['dirname']}}/{{ $file['basename'] }}">{{ $file['filename']}}</a></p>
                </div>
            @endforeach
        </div>
    </div>
    <div class="text-center">
        {!! $links->links() !!}
    </div>
@endsection
