<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\File;
use App\Artist;
use App\Genre;
use App\Category;

class FilesApiController extends Controller
{
    function addFile(Request $request){


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
