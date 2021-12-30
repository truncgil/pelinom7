<?php $siparis = db("stoklar")->where("id",get("id"))->first();
$j = j($siparis->json);
print2($j);
?>