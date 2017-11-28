<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FilesController extends Controller
{
    public function getList(){
        return view('cms.file.file_manage');
    }
    public function createFile(){
        return view('cms.file.file_create');
    }
    //
}
