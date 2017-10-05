<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Genre;

class GenresController extends Controller
{
	function getList(){
		return view('cms.genre.list');
	}

    //
}
