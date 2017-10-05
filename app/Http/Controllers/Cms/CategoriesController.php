<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
	function getListCategory(){
		return view('cms.category.list');
	}
    //
}
