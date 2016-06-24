@foreach($latestposts as $latestpost)
    <li><a href="{{$latestpost->slug}}"><em>{{$latestpost->title}}</em></a></li>
@endforeach
