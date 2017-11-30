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
Route::get('user/list','Cms\UsersApiController@getList');
Route::put('user/changeStatus/{id}/{status}','Cms\UsersApiController@changeStatus');
Route::put('user/delete/{id}','Cms\UsersApiController@delete');
//Artist
Route::get('artist/list','Cms\ArtistsApiController@getList');
Route::post('artist/add','Cms\ArtistsApiController@addArtist');
Route::put('artist/changeStatus/{id}/{status}','Cms\ArtistsApiController@changeStatus');
Route::post('artist/update','Cms\ArtistsApiController@updateArtist');
Route::post('artist/search/{name}','Cms\ArtistsApiController@searchArtist');
Route::put('artist/delete/{id}','Cms\ArtistsApiController@delete');
//Category
Route::get('category/list','Cms\CategoriesApiController@getList');
Route::post('category/add','Cms\CategoriesApiController@addCategory');
Route::put('category/changeStatus/{id}/{status}','Cms\CategoriesApiController@changeStatus');
Route::post('category/update','Cms\CategoriesApiController@update');
Route::put('category/delete/{id}','Cms\CategoriesApiController@delete');
//Genre
Route::get('genre/list','Cms\GenresApiController@getList');
Route::post('genre/add','Cms\GenresApiController@addGenre');
Route::put('genre/changeStatus/{id}/{status}','Cms\GenresApiController@changeStatus');
Route::post('genre/update','Cms\GenresApiController@update');
Route::put('genre/delete/{id}','Cms\GenresApiController@delete');
//File 
Route::post('file/add','Cms\FilesApiController@addFile');


