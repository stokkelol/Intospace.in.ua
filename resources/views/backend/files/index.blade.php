@extends('layouts.backend')

@section('content')
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h5>Total directory size: {{ $dir_size }}Mb</h5>
            <p>Total files: {{ $count }}</p>
        </div>
        <div class="panel-body">
            @foreach ($files as $file)
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="files-container">
                        <img src="/{{ $file['dirname'] }}/{{ $file['basename'] }}" alt="" class="img-thumbnail img-responsive"/>
                    </div>
                    <div class="file-dirname">
                        <p>Directory: {{ $file['dirname'] }}</p>

                    </div>
                    <div class="file-filename">
                        <p>Filename: <a href="/{{ $file['dirname'] }}/{{ $file['basename'] }}">{{ $file['filename'] }}</a>
                        <span class="label label-default">
                            <a href="{{ route('backend.files.open-image', ['path' => $file['basename'], 'dir' => $file['dirname']]) }}">RENAME</a>
                            </span>
                        </p>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
    <div class="text-center">
        {!! $links->links() !!}
    </div>
@endsection
