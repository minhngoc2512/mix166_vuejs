<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
class UsersApiController extends Controller
{
	function getList(){
		$users = User::paginate(10);
		$roles = collect(Role::all());
		$arr_user = [];

		foreach ($users as $user) {
			$role = $roles->where('id',$user->role_id)->first();
			array_push($arr_user,['id'=>$user->id,'name'=>$user->name,'email'=>$user->email,'role'=>$role->name,'status'=>$user->status]);
			# code...
		}
		// var_dump($role);
		
		 return [
		 'user'=>$arr_user,
		 'paginate'=>$users
		 ];
	}
	function changeStatus($id,$status){
		if($status==0){
			$status=1;
		}else{
			$status =0;
		}
		$user = User::find($id);
		$user->status = $status;
		$user->save();
	}
	function delete($id){
		$user = User::find($id);
		$user->delete();
		return ['status'=>'ok'];
	}
    //
}
