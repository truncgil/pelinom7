<?php 
$u = Auth::user();
$save = db("history")->insert([
	"slug" => get("key"),
	"kid" => get("id"), 
	"uid" => $u->id,
	"html" => get("text"),
	"created_at" => date("Y-m-d H:i:s")
]);
 ?>