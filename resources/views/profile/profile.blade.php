@extends('layouts.main')
@section('title','Dashboard')
@section('content')
    <section class="content-header">
        <h1>
            Profile
            <small>edit profile information</small>
        </h1>
        <ol class="breadcrumb">
            <li class=""><a href="{{url('home')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active"><a href="#"><i class="fa fa-male"></i>Profile</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box" style="padding:20px">
                    <div class="box-content">
                        <form class="form" action="{{url('profile')}}" method="POST">
                            {{csrf_field()}}
                            <div class="form-group {{$errors->has('name') ? 'has-error':''}}">
                                <label for="">Name:</label>
                                <input type="text" name="name" class="form-control" value="{{$user->name}}"/>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('email') ? 'has-error':''}}">
                                <label for="">Email:</label>
                                <input type="email" name="email" class="form-control" value="{{$user->email}}"/>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('current_password') ? 'has-error':''}}">
                                <label for="">Current Password:</label>
                                <input type="password" name="current_password" class="form-control"/>
                                @if ($errors->has('current_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('current_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('password') ? 'has-error':''}}">
                                <label for="">New Password:</label>
                                <input type="password" name="password" class="form-control"/>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group {{$errors->has('password_confirmation') ? 'has-error':''}}">
                                <label for="">Password Confirmation:</label>
                                <input type="password" name="password_confirmation" class="form-control"/>
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Update" class="btn btn-info">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection