@extends ('layouts.backend')



@section('content')
    <div class="container">
        <div class="panel-heading">
            <ul class="list-unstyled list-inline">
                  <li>  <a href="{{ route('backend.bands.create') }}"><button type="button" class="btn btn-primary">Create band</button></a></li>

            </ul>
        </div>
        <div class="panel-body">
            @foreach($bands as $band)
                {{ $band->title }}
            @endforeach
        </div>
    </div>
@endsection
