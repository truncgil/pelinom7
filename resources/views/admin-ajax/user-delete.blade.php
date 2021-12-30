<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

use App\User;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

		$p = $request->all();
		$u = u();
		if($p['id']<$u->id) {

		} else {
			if($u->level!="Admin") {
				$user = User::where('id', $p['id'])->where("uid",$u->id)->delete();
				$return = back()->with("mesaj","Kullanıcı silindi");
				echo $return;
			} else {
				$user = User::where('id', $p['id'])->delete();
				$return = back()->with("mesaj","Kullanıcı silindi");
				echo $return;
			}
			
		}
		