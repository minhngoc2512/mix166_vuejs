<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
class CategoriesApiController extends Controller
{
	function getList(){
		$category = Category::paginate(10);
		return [
			'category'=>$category
		];

	}
	function addCategory(Request $request){
		$category = new Category();
		$category->name = $request->name;
		$category->slug = str_slug($request->name);
		if($request->status==true){
			$category->status= 'yes';
		}else{
			$category->status='no';
		}
		$category->type = $request->selected;
		$category->save();
		return;
	}
	function changeStatus($id,$status){
		// dd($id,$status);
		$category = Category::find($id);

		if($status=='yes'){
			$category->status= 'no';
		}else{
			$category->status='yes';
		}
		$category->save();
		return;
	}
	function update(Request $request ){
			$category = Category::find($request->id);
			$category->name = $request->name;
			if($request->status==true){
				$category->status="yes";
			}else{
				$category->status="no";
			}
			$category->type = $request->selected;
			$category->save();
			return ;
	}
	function delete($id){
		$category = Category::find($id);
		$category->delete();
		return ;
	}
    //
}
