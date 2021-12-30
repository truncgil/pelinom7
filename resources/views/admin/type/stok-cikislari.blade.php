<?php 
$user = u();
$urunler = contents_to_array("Ürünler"); 
$musteriler = contents_to_array("Müşteriler"); 
$users = usersArray();

?>
<div class="content">
    <div class="row">
        
    <?php if(getisset("ids")) {
         ?>
         @include("admin.type.stok-cikislari.coklu-stok-cikisi")
         <?php 
    } else {
         ?>
         @include("admin.type.stok-cikislari.yeni-stok-cikisi")
         <?php 
    } ?>
    
    @include("admin.type.stok-cikislari.filtrele")
    @include("admin.type.stok-cikislari.gecmis-stok-cikislari")
    
    
    </div>
</div>
<script>
                $(function(){
                    <?php foreach($_GET AS $alan => $deger) {
                         ?>
                         $("[name='{{$alan}}']").val("{{$deger}}");
                         <?php 
                    } ?>
                });
            </script>

