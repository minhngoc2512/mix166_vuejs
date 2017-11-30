<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteMapController extends Controller
{
	function getdata(){
		$data = file_get_contents("https://vieclamnambo.vn/sitemap.xml");
		$data = str_replace("\n", "",$data);
		$xml=simplexml_load_string($data) or die("Error: Cannot create object");
		$dataTmp = "";
		foreach ($xml->sitemap as $value) {
			if(strpos($value->loc, "page" )){
				$getPage = file_get_contents($value->loc);
				$getPage = str_replace("\n", "",$getPage);
				$xmlPage=simplexml_load_string($getPage) or die("Error: Cannot create object");
				$dataTmp .= $xmlPage->url->loc."\n";


			}
			# code...
		}

		// dd($xml->sitemap[0]);
		Storage::put('avatars/1.txt', $dataTmp);
		// $data = str_replace("\n", "",$data);
		// Storage::put('avatars/2.txt', $data);
		echo "ok";


	}
    //
}
