<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CmsController extends Controller
{
    public function index(){
        return view('cms.index');
    }
    //
}
