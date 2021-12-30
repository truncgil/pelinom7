<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Contents;
use File;
use Illuminate\Support\Facades\DB;
		$post = $request->all();
		/*
		$ext = $request->file->getClientOriginalExtension();
		$path = $request->file->storeAs("files/{$post['slug']}",$post['slug']."-".$post['id']."-".rand(111,999).'.'.$ext);
		$path = str_replace("files/","",$path);
		
		*/
		echo "ok";
		oturumAc();
		
		$destinationPath = $post['file'];
		echo $destinationPath;
		File::delete($destinationPath);
		$dizi = $_SESSION['files']; //explode(",",$_SESSION['files']);
		foreach($dizi AS $a=>$d) {
			if($post['file']==$d) {
				unset($dizi[$a]);
			}
		}
		$_SESSION['files'] = $dizi; 
		print_r(oturum("files"));
		
		$return = null;