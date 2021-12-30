<?php 
$musteriler = contents_to_array("Müşteriler"); 
$urunler = contents_to_array("Ürünler"); 
?>

{{col("col-md-12","Yeni Çoklu Stok Çıkışı",3)}}
<div class="btn btn-success stok-cikisi-yazdir"><i class="fa fa-print"></i> {{e2("Stok Çıkışlarını Yazdır")}}</div>
<?php 
$dizi = explode(",",get("ids"));
foreach($dizi AS $deger) {
     $siparis = db("siparisler")->where("id",$deger)->first();
    $musteri = $musteriler[$siparis->kid];
    $urun = $urunler[$siparis->type];
    $siparis_ozellikleri = j($siparis->json);
    //print2($urun);
     
     ?>
     <script>
          $(function(){
               $.get("?ajax=siparis-detay3",{
                    id : "{{$siparis->type}}",
                    siparis_id : "{{$siparis->id}}"
               },function(d){
                    $(".detay{{$deger}}").html(d);
                  
               });
               $(".stok-cikisi-yazdir").on("click",function(){
                         $(".gecmis-stok-cikislari").addClass("noprint");
                         $(".filtrele").addClass("noprint");
                         window.print();
               });
               
              
          });
     </script>
     <table class="table table-bordered">
          <tr>
               <td>
                    {{e2("ÜNVAN")}}: <br>
                    <strong>{{$musteri->title}} {{$musteri->title2}}</strong>
               </td>
               <td>
                    {{e2("ÜRÜN")}}: <br>
                    <strong>{{$urun->title}}</strong>
               </td>
               <td>
                    {{e2("SİPARİŞ BİLGİSİ")}}: <br>
                    {{urun_ozellikleri($siparis_ozellikleri)}}
               </td>
               <td>{{e2("MİKTAR")}}
               <br>
                    <strong>{{nf($siparis->qty)}}</strong>
               </td>
               <td width="300">
                    <div class="noprint">
                         <div class="btn-group">
                              <div class="btn btn-primary bugun{{$deger}}">{{e2("Bugünkü")}}</div>
                              <div class="btn btn-primary tumu{{$deger}}">{{e2("Tüm Zamanlar")}}</div>
                         </div>
                    </div>

               </td>
               <script>
                    $(function(){
                         $("#satirlar{{$deger}}").load("?ajax=siparis-stok-cikisi&id={{$deger}}");
                         $(".bugun{{$deger}}").on("click",function(){
                              $("#satirlar{{$deger}}").load("?ajax=siparis-stok-cikisi&id={{$deger}}&bugun");
                         });
                         $(".tumu{{$deger}}").on("click",function(){
                              $("#satirlar{{$deger}}").load("?ajax=siparis-stok-cikisi&id={{$deger}}");
                         });
                         $(".serialize{{$deger}}").on("submit",function(){
                              
                              var bu = $(this);
                              var id= bu.attr("id");
                              var stok = $("#serialize{{$deger}} [name='stok']").val();
                              console.log("stok");
                              console.log(id);
                             
                              $.ajax({
                                   type : $(this).attr("method"),
                                   url : $(this).attr("action"),
                                   data : $(this).serialize(),
                                   success: function(d){
                                        var id = bu.attr("id");
                                        $('.detay{{$deger}} option:selected').remove();
                                        $(".detay{{$deger}} .select2").trigger("change");
                                        $("#satirlar"+id).load("?ajax=siparis-stok-cikisi&id="+id);
                                        
                                   }

                              });
                              
                              return false;

                         });
                    });
               </script>
               <tr>
                    
                    <td colspan="4" id="satirlar{{$deger}}" ></td>
                    <td>
                         <form action="?ekle" method="post" id="{{$deger}}" class="serialize{{$deger}}">
                              {{csrf_field()}}
                              <input type="hidden" name="firma" value="{{$musteri->id}}">
                              <input type="hidden" name="siparis" value="{{$deger}}">
                              <div class="detay{{$deger}}"></div>
                         </form>

                    </td>
               </tr>
          </tr>
        
     </table>
    
     <hr>
     <?php 
} ?>
{{_col()}}