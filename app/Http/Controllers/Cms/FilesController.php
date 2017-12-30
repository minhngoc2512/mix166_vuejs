<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\File;

class FilesController extends Controller
{
    public function getList(){
        return view('cms.file.file_manage');
    }
    public function createFile(){
  
        return view('cms.file.file_create');
    }
    public function editFile($id){
        return view('cms.file.file_edit',['id'=>$id]);

    }
    //
}
