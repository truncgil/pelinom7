<?php $urun = db("contents")
->where("type","Ürünler")
->where("id",get("id"))->first();

$alt = explode(",",$urun->alt_type);
$stoklar = db("stoklar")->select("json")->orderBy("id","DESC")->get();
$alanlar = array();
foreach($stoklar AS $s) {
    $j = j($s->json);
    foreach($j AS $alan=>$deger) {
       
            if(!isset($alanlar[$alan])) $alanlar[$alan] = array();
            if(!in_array($deger,$alanlar[$alan])) {
                array_push($alanlar[$alan],$deger);
            }
    }
}
//print2($alanlar);
if(count($alt)>0) {
?>
<div class="row">
<?php 
$sayisal = explode(",","EN,BOY,GRAMAJ,ADET,LAMİNE,METRE,ÇEKER");
foreach($alt AS $a) {
    if($a!="") {
        $a2 = str_replace(" ","_",$a);
     ?>
     <div class="col-md-3">
        {{$a}}:
        <?php if(in_array($a,$sayisal)) {
 ?> (Aralık girmek için - kullanın)
        <div class="input-group">
            <input type="text" name="{{$a2}}" class="form-control" id="">
        </div>
 <?php  
        } else  { 
          ?>
         <select name="{{$a2}}" id="{{$a2}}" class="form-control select2">
             <option value="">{{e2("Tümü")}}</option>
             <?php 
             if(isset($alanlar[$a2])) {
                 foreach($alanlar[$a2] AS $option) { ?>
                     <option value="{{$option}}">{{$option}}</option>
                 <?php } ?>
             <?php } ?>
         </select> 
         <?php } ?>
     </div>
     
     <?php 
    }
} ?>
<?php } ?>
</div>
<script>
    $(".select2").select2({
        tags: true
    });
</script>