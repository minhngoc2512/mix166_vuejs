<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//User
Route::get('user/list','Cms\UsersApiController@getList')->middleware('auth:api');
Route::put('user/changeStatus/{id}/{status}','Cms\UsersApiController@changeStatus')->middleware('auth:api');
Route::put('user/delete/{id}','Cms\UsersApiController@delete')->middleware('auth:api');
//Artist
Route::get('artist/list','Cms\ArtistsApiController@getList')->middleware('auth:api');
Route::post('artist/add','Cms\ArtistsApiController@addArtist')->middleware('auth:api');
Route::put('artist/changeStatus/{id}/{status}','Cms\ArtistsApiController@changeStatus')->middleware('auth:api');
Route::post('artist/update','Cms\ArtistsApiController@updateArtist')->middleware('auth:api');
Route::post('artist/search/{name}','Cms\ArtistsApiController@searchArtist')->middleware('auth:api');
Route::put('artist/delete/{id}','Cms\ArtistsApiController@delete')->middleware('auth:api');
//Category
Route::get('category/list','Cms\CategoriesApiController@getList')->middleware('auth:api');
Route::post('category/add','Cms\CategoriesApiController@addCategory')->middleware('auth:api');
Route::put('category/changeStatus/{id}/{status}','Cms\CategoriesApiController@changeStatus')->middleware('auth:api');
Route::post('category/update','Cms\CategoriesApiController@update')->middleware('auth:api');
Route::put('category/delete/{id}','Cms\CategoriesApiController@delete')->middleware('auth:api');
//Genre
Route::get('genre/list','Cms\GenresApiController@getList')->middleware('auth:api');
Route::post('genre/add','Cms\GenresApiController@addGenre')->middleware('auth:api');
Route::put('genre/changeStatus/{id}/{status}','Cms\GenresApiController@changeStatus')->middleware('auth:api');
Route::post('genre/update','Cms\GenresApiController@update')->middleware('auth:api');
Route::put('genre/delete/{id}','Cms\GenresApiController@delete')->middleware('auth:api');
//File 
Route::post('file/add','Cms\FilesApiController@addFile')->middleware('auth:api');
Route::get('file/list','Cms\FilesApiController@getList')->middleware('auth:api');


