@extends('layouts.backend')

@section('content')

<div class="container">
    <div class="row">
        <div class="panel-heading">
            <ul class="list-unstyled list-inline">
                <li>  <a href="{{ route('backend.users.create') }}"><button type="button" class="btn btn-primary">Create user</button></a></li>
            </ul>
        </div>
        <div class="panel panel-warning">
            <div class="panel-heading">
                <p>Users:</p>
            </div>
            <div class="panel-body">
                <div class="col-lg-1">id</div>
                <div class="col-lg-3">name</div>
                <div class="col-lg-3">email</div>
                <div class="col-lg-2">role</div>
                <div class="col-lg-3">created at</div>
                <hr>
                <ul class="list-unstyled">
                    @foreach ($users as $user)
                        <li>
                            <div class="col-lg-1">{{ $user->id }}</div>
                            <div class="col-lg-3">{{ $user->name }}</div>
                            <div class="col-lg-3">{{ $user->email }}</div>
                            <div class="col-lg-2">{{ $user->role }}</div>
                            <div class="col-lg-3">{{ $user->created_at }}</div>
                        </li>
                        <hr>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection