@extends('layouts.backend')

@section('content')
    <div class="panel panel-warning">
        <div class="panel-heading">
            Users
        </div>
        <div class="panel-body">
            <ul class="list-unstyled list-inline">
                <li>  <a href="{{ route('backend.users.create') }}"><button type="button" class="btn btn-primary">Create user</button></a></li>
            </ul>
            <hr>
            <ul class="list-unstyled">
                @foreach ($users as $user)
                    <div class="backend-item">
                        <div class="col-lg-1">{{ $user->id }}</div>
                        <div class="col-lg-3">{{ $user->name }}</div>
                        <div class="col-lg-3">{{ $user->email }}</div>
                        <div class="col-lg-2">{{ $user->role }}</div>
                        <div class="col-lg-3">{{ $user->created_at }}</div>
                    </div>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
