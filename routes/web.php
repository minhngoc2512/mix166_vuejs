<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});
Route::get('file/manage',function(){
    return view('cms.file.file_manage');
});
Route::get('cms/user/login','Cms\Auth\LoginController@showFormLogin');
Route::post('cms/user/login',['as'=>'cms.user.check.login','uses'=>'Cms\Auth\LoginController@checkLogin']);
Route::get('cms/user/register','Cms\Auth\LoginController@showFormRegister');
Route::post('cms/user/register',['as'=>'cms.user.register','uses'=>'Cms\Auth\LoginController@registerUser']);
Route::prefix('cms')->group(function(){
    Route::prefix('user')->group(function(){

    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
