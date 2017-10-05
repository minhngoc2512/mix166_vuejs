<?php

namespace App\Http\Controllers\Cms\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginCmsRequest;
use App\Http\Requests\UserLogin;
use Auth;
use Illuminate\Support\Facades\App;

class LoginController extends Controller
{
    function checkLogin(UserLogin $request){

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true)) {
                    return redirect()->route('home_cms');
            }

        $status = 'Login error!!! Try again!!!';
        return view('cms.user.login',compact('status'));

    }
    function registerUser(UserLoginCmsRequest $request){
        $user = User::where('email',$request->email)->get();

        if(count($user)!=0){
            $status = 'User existed!!!';
          return $this->showFormLogin($status);
        }
        $user = new User();
        $user->name = $request->name;
        $user->slug = str_slug($request->name);
        $user->email = $request->email;
        $user->status=0;
        $user->role_id =1;
        $user->password = bcrypt($request->password);
        $user->remember_token = $request->_token;
        $user->save();
        $status = 'Register finish!';
        $this->showFormLogin($status);
    }
    function logoutUser(){
        Auth::logout();
        return view('cms.user.login');
    }
    function resetPassword(){

    }
    function showFormLogin($status=null){

        if(Auth::check())return redirect()->route('home_cms');
        if($status!=null)return view('cms.user.login',compact('status'));
        return view('cms.user.login');
    }
    function showFormRegister(){
        return view('cms.user.register');
    }
    function showFormResetPassword(){

    }
    //
}
