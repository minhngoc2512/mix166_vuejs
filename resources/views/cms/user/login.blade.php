@extends('layouts.cms.auth')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(isset($status))
                <div class="alert alert-info" > {{$status}}</div>
                @endif
            <div class="card-group mb-0">

                <div class="card p-4">
                    <div class="card-body">
                        <h1>Login</h1>
                        <p class="text-muted">Sign In to your account</p>
                        <form action="{!! route('cms.user.check.login') !!}" method="post">
                            {!! csrf_field() !!}
                            @if($errors->first('email')!=null)
                                <span class="badge badge-danger">{{$errors->first('email')}}</span>
                            @endif
                        <div class="input-group mb-3">
                                <span class="input-group-addon"><i class="icon-user"></i>
                                </span>
                            <input type="email" name="email"  class="form-control" placeholder="Email" >
                        </div>
                            @if($errors->first('password')!=null)
                                <span class="badge badge-danger">{{$errors->first('password')}}</span>
                            @endif
                        <div class="input-group mb-4">
                                <span class="input-group-addon"><i class="icon-lock"></i>
                                </span>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary px-4">Login</button>
                            </div>
                            <div class="col-6 text-right">
                                <button type="button" class="btn btn-link px-0">Forgot password?</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>

                <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                    <div class="card-body text-center">
                        <div>
                            <h2>Sign up</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            <a href="{!! url('cms/user/register') !!}"> <button type="button" class="btn btn-primary active mt-3">Register Now!</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @endsection

