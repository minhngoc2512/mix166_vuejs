@extends('layouts.cms.auth')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mx-4">
                    <form method="post" action="{!! route('cms.user.register') !!}">
                        {!! csrf_field() !!}
                    <div class="card-body p-4">
                        <h1>Register</h1>
                        <p class="text-muted">Create your account</p>
                        @if($errors->first('name')!=null)
                            <span class="badge badge-danger">{{$errors->first('name')}}</span>
                        @endif
                        <div class="input-group mb-3">
                            <span class="input-group-addon"><i class="icon-user"></i>
                            </span>
                            <input type="text" class="form-control" name="name" placeholder="Username">

                        </div>
                        @if($errors->first('email')!=null)
                            <span class="badge badge-danger">{{$errors->first('email')}}</span>
                        @endif
                        <div class="input-group mb-3">
                            <span class="input-group-addon">@</span>
                            <input type="email" class="form-control" name="email" placeholder="Email">
                        </div>
                        @if($errors->first('password')!=null)
                            <span class="badge badge-danger">{{$errors->first('password')}}</span>
                        @endif
                        <div class="input-group mb-3">
                            <span class="input-group-addon"><i class="icon-lock"></i>
                            </span>
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        @if($errors->first('repeatpassword')!=null)
                            <span class="badge badge-danger">{{$errors->first('repeatpassword')}}</span>
                        @endif
                        <div class="input-group mb-4">
                            <span class="input-group-addon"><i class="icon-lock"></i>
                            </span>
                            <input type="password" class="form-control" name="repeatpassword" placeholder="Repeat password">
                        </div>

                        <button type="submit" class="btn btn-block btn-success">Create Account</button>
                    </div>
                    </form>
                    <div class="card-footer p-4">
                        <div class="row">
                            <div class="col-6">
                                <button class="btn btn-block btn-facebook" type="button">
                                    <span>facebook</span>
                                </button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-block btn-twitter" type="button">
                                    <span>twitter</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

