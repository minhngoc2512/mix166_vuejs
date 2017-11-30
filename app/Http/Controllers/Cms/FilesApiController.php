<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\File;
use App\Artist;
use App\Genre;
use App\Category;
use Storage;
use Carbon\Carbon;

class FilesApiController extends Controller
{
    function addFile(Request $request){
        $name = $request->name;
        $now = Carbon::now();
        $category_id = $request->category;
        $status = $request->status;
        $genre = $request->genre;
        $artist = $request->artist;
        $user = json_decode($request->user);
        $path = null;
        $thumbnail = null;
        $type = $request->typeFile;
        if($request->typeFileInput=="file"){
            $file = $request->file("file");
            $path = 'public/file/user_'.$user[0].'/'.$now->year.'/'.$now->month.'/'.$now->day;
            $path_file = Storage::put($path,$file);
            $path=str_replace('public','',$path_file);
        }else{
            $path= $request->url;
        }
        $img_thumbnail = $request->file("thumbnail");
        $path_thumbnail = 'public/thumnail/user_'.$user[0].'/'.$now->year.'/'.$now->month.'/'.$now->day;
        $path_img_file = Storage::put($path_thumbnail,$img_thumbnail);
        $path_thumbnail_db=str_replace('public','',$path_img_file);
        $file_db = new File();
        $file_db->name = $name;
        $file_db->category_id = $category_id;
        $file_db->artist_id = $artist;
        $file_db->genre_id = $genre;
        $status=="true"? $file_db->status="yes":$file_db="no";
        $file_db->user_create_id = $user[0];
        $file_db->user_publish_id= 0;
        $file_db->slug = str_slug($name);
        $file_db->path = $path;
        $file_db->type = $type;
        $file_db->thumbnail = $path_thumbnail_db;
        $file_db->save();
    }
    function getList(){
        $file = File::paginate(10);

    }

    function getFormAdd(){
        $artists = Artist::all();
        $genres = Genre::all();
        $categories = Category::all();
        return [
            'artists'=>$artists,
            'genres'=>$genres,
            'categories'=>$categories
        ];
    }
    //
}
