<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Artist;
use Storage;
use Carbon\Carbon;
use Auth;

class ArtistsApiController extends Controller
{
	function getList(){
		$artist = Artist::paginate(10);
		return [
			'artist'=>$artist
		];
	}
	function addArtist(Request $request){
		$image = $request->file('image');
		$now = Carbon::now();
		$user = json_decode($request->user);
		$path = 'public/user_'.$user[0].'/'.$now->year.'/'.$now->month.'/'.$now->day;
		$path_file = Storage::put($path,$image);
		$artist = new Artist();
		$artist->name = $request->name;
		$artist->slug = str_slug($artist->name);
		$artist->thumbnail=str_replace('public', '',$path_file);
		if($request->status==true){
			$artist->status='yes';
		}else{
			$artist->status='no';
		}
		$artist->save();
		return ['status'=>'ok'];
	}
	function changeStatus($id,$status){
		$artist = Artist::find($id);
		if($status=='no'){
			$artist->status ='yes';
		}else{
			$artist->status = 'no';
		}
		$artist->save();
		return ;
		
	}
	function updateArtist(Request $request){
		$artist = Artist::find($request->id);

		$artist->name = $request->name;
		$artist->slug = str_slug($request->name);

		if($request->status==true){
			$artist->status='yes';
		}else{
			$artist->status='no';
		}
		if(isset($request->image)){
		$image = $request->file('image');
		Storage::delete('public'.$artist->thumbnail);
		$now = Carbon::now();
		$user = json_decode($request->user);
		$path = 'public/user_'.$user[0].'/'.$now->year.'/'.$now->month.'/'.$now->day;
		$path_file = Storage::put($path,$image);
		$artist->thumbnail=str_replace('public', '',$path_file);
		}
		$artist->save();
		return;

	}
	function searchArtist($name){
		$name = str_slug($name);
		$artist = Artist::where('slug','like',"%$name%")->pagenate(10);
		return [
			'artist'=>$artist
		];

	}
	function delete($id){
		$artist = Artist::find($id);
		$artist->delete();
		return ;
	}
    //
}
