<?php 
oturumAc();

$sorgu = db("pulse_data")
->where("created_at",">=",$tarih))
->where("mac",u()->mac)
->orderBy("id","DESC")
->first();
print_r($sorgu);
?>