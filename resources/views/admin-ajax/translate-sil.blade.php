<?php 
if(getisset("id")) {
	$sil = db("translate")->where("id",get("id"))->delete();
	echo  $sil;
	
}
 ?>