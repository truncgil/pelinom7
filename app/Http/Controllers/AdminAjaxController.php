<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Redirect;
use Illuminate\Support\Facades\Auth;

class AdminAjaxController extends Controller
{
    public function index(Request $request, string $var) {
		$u = Auth::user();
		//$izin = explode(",","Admin,Head Of Department");
		if(!isset($u->level)) {
			echo("permission error");
			exit();
		}
		//print_r($u->level); exit();
		/*
		$this->middleware('auth');
		$path = "AdminAjax/$var.php";
		include($path);
		return $return; // return işlemi include da çalışmadığından bir değişken ile buraya aktardık
		*/
		$return = null;
		$url = "admin-ajax.$var";
		
		return view($url,array(
			"request" => $request 	
		));
	
		/* 
		try {
			include("AdminAjax/$var.php");
		} catch (\Exception $e) {
			return abort(404);
		}
		*/
		
	}
}
