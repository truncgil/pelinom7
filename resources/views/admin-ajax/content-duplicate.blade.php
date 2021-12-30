<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Contents;
use Illuminate\Support\Facades\DB;
$c2 = c($_GET['cid']);
if($c2) {
	$c = new Contents;
	$c->title = $c2->title;
	$c->kid = $c2->kid;
	$c->breadcrumb = $c2->breadcrumb;
	$c->cover = $c2->cover;
	$c->type = $c2->type;
	$c->slug = $c2->slug."-2";
	$c->s = $c2->s;
	$c->json = $c2->json;
	$c->tkid = $c2->tkid;
	$c->save();
}

echo back();
 ?>