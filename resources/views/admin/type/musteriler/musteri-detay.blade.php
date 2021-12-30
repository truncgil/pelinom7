<div class="row">
		<?php if(getisset("detay"))  { 
			$musteri = c(get("detay"));
			$siparisler = db("siparisler")->where("kid",get("detay"))->orderBy("id","DESC")->get();
			$stok_cikislari = db("stok_cikislari")->where("musteri_id",get("detay"))->orderBy("id","DESC")->get();
			
		 ?>
  
 		<?php col("col-md-6","{$musteri->title} {$musteri->title2} Sipariş Detayları",2) ?>
         <div class="btn btn-group">
                <a target="_blank" href="?ajax=print-siparisler&id={{get("detay")}}" class="btn btn-primary"><i class="fa fa-print"></i> Açık Siparişleri Yazdır</a>
                <a target="_blank" href="?ajax=print-siparisler&id={{get("detay")}}&y=1" class="btn btn-danger"><i class="fa fa-print"></i> Kapalı Siparişleri Yazdır</a>
            </div>
		 <div class="table-responsive">
            
			 <table class="table">
				 <tr>
					 <th>İşlem Tarihi</th>
					 <th>Ürün</th>
					 <th>Miktar</th>
					 <th>Sevk Edilen</th>
					 <th>Kalan</th>
					 <th>Termin Tarihi</th>
				 </tr>
				 <?php foreach($siparisler AS $s)  { 
					 $urun = $urunler[$s->type];
				  ?>
 				 <tr>
 					 <td>{{date("d.m.Y H:i",strtotime($s->created_at))}}</td>
 					 <td>{{$urun->title}}</td>
 					 <td>{{$s->qty}}</td>
 					 <td>
						<?php 
						//  print2($stok_cikis_sayim);
						$stok_cikisi = 0;
						if(isset($stok_cikis_sayim[$s->id])) {
							$stok_cikisi = $stok_cikis_sayim[$s->id];
						} 
						?>
						{{$stok_cikisi}}
					</td>
					<td>
						{{$s->qty-$stok_cikisi}}
					</td>
 					 <td>{{date("d.m.Y",strtotime($s->date))}}</td>
 				 </tr> 
				  <?php } ?>
			 </table>
		 </div>
			
 		<?php _col(); ?> 
 		<?php col("col-md-6 ","{$musteri->title} {$musteri->title2} Stok Çıkışları",3) ?>
                        <div class="btn-group">
                            <a  class="btn btn-success d-none"><i class="fa fa-print"></i> Seçili Stok Çıkışlarını Yazdır</a>
                            <a href="?ajax=print-musteri-stok-cikis&detay={{get("detay")}}" target="_blank" class="btn btn-warning"><i class="fa fa-print"></i> Tüm Stok Çıkışlarını Yazdır</a>
                        </div>
			<div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>
                            <input type="checkbox" name="" class="stok_cikisi_all" id="">
                        </th>
                        <th>Tarih</th>
                        <th>Barkod</th>
                        <th>Ürün</th>
                        <th>Miktar</th>
                    </tr>
                    <?php foreach($stok_cikislari AS $s)  { 
                        $stok = j($s->stok);
                        $siparis = j($s->siparis);
                        $urun = $urunler[$siparis['type']];
                     ?>
                     <tr>
                         <td>
                            <input type="checkbox" name="" value="{{$s->id}}" class="stok_cikisi" id="">
                         </td>
                         <td>{{date("d.m.Y H:i",strtotime($s->created_at))}}</td>
                         <td>
                             <a href="?ajax=print-stok&id={{$stok['slug']}}&noprint" title="{{$stok['slug']}} Barkoduna Ait Bilgiler" class="ajax_modal">{{$stok['slug']}}</a>
                         </td>
                         <td>{{$urun->title}}</td>
                         <td>{{$s->qty}}</td>
                     </tr> 
                     <?php } ?>
                </table>
            </div>
 		<?php _col(); ?> 
		 <?php } ?>
	</div>
    <script>
$(function(){
    $(".stok_cikisi_all").click(function(){
        $('.stok_cikisi:checkbox').not(this).prop('checked', this.checked);
    });
})

    </script>