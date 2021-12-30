<?php 
$db = ekle(array(
	"title" => post("title"),
	"json" => post("data"),
	"type" => post("type"),
	"uid" => u()->id,
	"created_at" => date("Y-m-d H:i:s")
),"plotly");

$saved_analyzes = db("plotly")->leftJoin('users', 'users.id', '=', 'plotly.uid')->orderBy("plotly.id", "DESC")->first(["plotly.id", "plotly.title", "users.name", "users.surname"]);

echo json_encode($saved_analyzes);
