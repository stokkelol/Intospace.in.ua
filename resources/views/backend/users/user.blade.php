@extends('layouts.backend')

@section('content')

{!! Form::open(['url' => $url, 'enctype' => 'multipart/form-data']) !!}
<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
        <div class="form-group">

          <div class="form-group">
              {!! Form::label('inputName', 'Name:') !!}
              {!! Form::text('name', null, ['class' => 'form-control']) !!}
           </div>

          <div class="form-group">
              {!! Form::label('inputEmail', 'Email:') !!}
              {!! Form::text('email', null, ['class' => 'form-control']) !!}
          </div>

          <form class="form-group">
            {!! Form::label('inputPassword', 'Password:') !!}
            {!! Form::text('password', null, ['class' => 'form-control']) !!}
          </form>

        </div>
        <div>
            <input type="submit" value="Save" class="btn btn-block btn-success" >
        </div>
    </div>
    <div class="col-lg-2"></div>
</div>

{!! Form::close() !!}

@endsection
