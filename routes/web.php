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

Route::get('cms', 'HomeController@index')->middleware('auth_cms')->name('home_cms');
// Route::get('file/manage',function(){
//     return view('cms.file.file_manage');
// })->middleware('auth_cms')->name('file_manage');
Route::get('cms/user/logout','Cms\Auth\LoginController@logoutUser')->name('logout');
Route::get('cms/user/login','Cms\Auth\LoginController@showFormLogin')->name('login_cms');
Route::post('cms/user/login',['as'=>'cms.user.check.login','uses'=>'Cms\Auth\LoginController@checkLogin']);
Route::get('cms/user/register','Cms\Auth\LoginController@showFormRegister');
Route::post('cms/user/register',['as'=>'cms.user.register','uses'=>'Cms\Auth\LoginController@registerUser']);
Route::prefix('cms')->middleware('auth_cms')->group(function(){
    Route::prefix('user')->group(function(){
        Route::get('list','Cms\UsersController@getListUser')->name('user_list');
    });
    Route::prefix('artist')->middleware('auth_cms')->group(function(){
    	Route::get('list','Cms\ArtistsController@getListArtist')->name('artist_list');
    });
    Route::prefix('category')->group(function(){
    	Route::get('list','Cms\CategoriesController@getListCategory');
    });
     Route::prefix('genre')->group(function(){
        Route::get('list','Cms\GenresController@getList');
    });
    Route::prefix('file')->group(function(){
        Route::get('list','Cms\FilesController@getList')->name('list_file');
        Route::get('create','Cms\FilesController@createFile')->name('create_file');
    });
});

//Auth::routes();
