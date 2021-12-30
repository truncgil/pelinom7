<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Contents;
use Illuminate\Support\Facades\DB;
DB::table(get("table"))->where("id",get("id"))->delete();
echo "ok";
exit();
 ?>