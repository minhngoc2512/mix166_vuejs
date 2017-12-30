<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\File;
use App\Artist;
use App\Genre;
use App\Category;
use App\User;
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
        $categories = Category::all();
        $categories_map = collect([]);
        $categories->map(function($item)use($categories_map){
            $categories_map->put($item->id,$item->name);
        });
        $genres = Genre::all();
        $genres_map = collect([]);
        $genres->map(function($item) use($genres_map){
            $genres_map->put($item->id,$item->name);
        });
        $artists = Artist::all();
        $artists_map = collect([]);
        $artists->map(function($item) use($artists_map){
            $artists_map->put($item->id,$item->name);
        });
        $users = User::all();
        $users_map = collect([]);
        $users->map(function($item) use($users_map){
            $users_map->put($item->id,$item->name);
        });
        $file = File::orderBy('created_at','DESC')->paginate(10);
        $fileMap = $file->map(function($item) use($categories_map,$genres_map,$artists_map,$users_map){
            return [
                "id"=>$item->id,
                "name"=>$item->name,
                "status"=>$item->status,
                "type"=>$item->type,
                "category"=>$categories_map[$item->category_id],
                "genre"=>$genres_map[$item->genre_id],
                "artist"=>$artists_map[$item->artist_id],
                "user"=>$users_map[$item->user_create_id],
                "path"=>$item->path,
                "thumbnail"=>$item->thumbnail,
                "view"=>$item->file_view,
                "created"=>$item->created_at
            ];
        });
        $file = collect($file);
        return [
            "listFile"=>$fileMap,
            "paginate"=>[
                "current_page_url"=>$file['current_page'],
                "first_page_url"=>$file['first_page_url'],
                "last_page"=>$file['last_page'],
                "last_page_url"=>$file['last_page_url'],
                "next_page_url"=>$file['next_page_url'],
                "per_page"=>$file['per_page'],
                "prev_page_url"=>$file['prev_page_url'],
                "total"=>$file['total']
            ]
        ];

    }

    function getFormAdd(){
        $artists = Artist::orderBy('created_at','DESC')->get();
        $genres = Genre::orderBy('created_at','DESC')->get();
        $categories = Category::orderBy('created_at','DESC')->get();
        return [
            'artists'=>$artists,
            'genres'=>$genres,
            'categories'=>$categories
        ];
    }
    function deleteFile($id){
        $file = File::find($id);
        if($file->delete()){
            return [
                'status'=>'ok'
            ];
        }else{
            return ['status'=>'error'];
        }

    }
    function changeStatus($id,$status){
        $file = File::find($id);
        $status=='yes'?$file->status='no':$file->status='yes';
        $file->save();
        return ['status'=>'ok'];
    }

    function getInformationFile($id){
        $file = File::find($id);
        if($file){
            $categories = Category::all();
            $categories_map = collect([]);
            $categories->map(function($item)use($categories_map){
                $categories_map->put($item->id,$item->name);
            });
            $genres = Genre::all();
            $genres_map = collect([]);
            $genres->map(function($item) use($genres_map){
                $genres_map->put($item->id,$item->name);
            });
            $artists = Artist::all();
            $artists_map = collect([]);
            $artists->map(function($item) use($artists_map){
                $artists_map->put($item->id,$item->name);
            });
            return [
                'categories'=>$categories,
                'genres'=>$genres,
                'artists'=>$artists,
                'file'=>$file
            ];
        }
        return about(404);
    }
    //
}
