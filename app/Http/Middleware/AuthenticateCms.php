<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\User;
use Illuminate\Support\Facades\Cache;

class AuthenticateCms
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            if(!Cache::has('statusLogin'.Auth::user()->id)){

                Cache::remember('statusLogin'.Auth::user()->id, 60, function () {
                    return 'on';
                });

            Auth::logout();
            return redirect('cms/user/login');
            }
//            dd('cache');
            if(Cache::has('users'.Auth::user()->id)){
                return $next($request);
            }
            Cache::remember('users'.Auth::user()->id, 60, function () {
                $user = User::find(Auth::user()->id);
                $api_token_new = str_random(60);
                $user->api_token = $api_token_new;
                $user->save();
                return $api_token_new;
            });
            return redirect('cms');
      
        }
        return redirect('cms/user/login');
    }
}
