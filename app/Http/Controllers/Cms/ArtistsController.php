<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Artist;

class ArtistsController extends Controller
{
	function getListArtist(){
		return view('cms.artist.list');		
	}

    //
}
