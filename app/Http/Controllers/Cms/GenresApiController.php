<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Genre;

class GenresApiController extends Controller
{
	function getList(){

		$genre = Genre::paginate(10);
		return [
			'genre'=>$genre
		];
	}

	function delete($id){
		$genre = Genre::find($id);
		$genre->delete();
		return ;
	}

	function update(Request $request){
		$genre = Genre::find($request->id);
		$genre->name = $request->name;
		if($request->status==true){
			$genre->status='yes';

		}else{
			$genre->status='no';
		}
		$genre->save();
		return;
	}

	function addGenre(Request $request){
		$genre = new Genre();
		$genre->name = $request->name;
		$genre->slug = str_slug($request->name);
			if($request->status==true){
			$genre->status='yes';

		}else{
			$genre->status='no';
		}
		$genre->save();
		return;
	}
	function changeStatus($id,$status){
		$genre = Genre::find($id);
		if($status=='no'){
			$genre->status ='yes';
		}else{
			$genre->status = 'no';
		}
		$genre->save();
		return ;

	}
    //
}
