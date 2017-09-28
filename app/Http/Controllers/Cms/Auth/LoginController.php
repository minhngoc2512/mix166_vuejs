<?php

namespace App\Http\Controllers\Cms\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginCmsRequest;

class LoginController extends Controller
{
    function checkLogin(){


    }
    function registerUser(UserLoginCmsRequest $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->remember_token = $request->_token;
        $user->save();
        dd(User::all());
    }
    function resetPassword(){

    }
    function showFormLogin(){
        return view('cms.user.login');
    }
    function showFormRegister(){
        return view('cms.user.register');
    }
    function showFormResetPassword(){

    }
    //
}
