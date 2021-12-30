<?php 
			$urunler = contents_to_array("Ürünler");

			$stok = array();
			$stok_sahipli = array();
			$tum_stok = array();
			$siparis = array();
			$siparis_tamam = array(); //tamamlanan siparis
			$urun_stok = array();
			$stok_cikisi = array();
			$stok_cikislari = db("stok_cikislari")->get();
			$stoklar = db("stoklar")->get();
			$siparisler = db("siparisler")->get();
			
			foreach($siparisler AS $si) { //ürün bazlı stok girişleri
				if($si->y==1) {
					if(!isset($siparis_tamam[$si->type]))  $siparis_tamam[$si->type] = 0;
					$siparis_tamam[$si->type] += $si->qty;
				} else {
					if(!isset($siparis[$si->type]))  $siparis[$si->type] = 0;
					$siparis[$si->type] += $si->qty; // sevkten geriye kalan
				}
			}
			foreach($stoklar AS $s) { //ürün bazlı stok girişleri
				if($s->cikis!="") {
					if(!isset($stok_sahipli[$s->type]))  $stok_sahipli[$s->type] = 0;
					$stok_sahipli[$s->type] += $s->net;
				} else {
					if(!isset($stok[$s->type]))  $stok[$s->type] = 0;
					$stok[$s->type] += $s->net;
				}
				if(!isset($tum_stok[$s->type]))  $tum_stok[$s->type] = 0;
				$tum_stok[$s->type] += $s->net;
			}
			foreach($stok_cikislari AS $sc) { // ürün bazlı stok çıkışları
				$j = j($sc->stok);
				$type = $j['type'];
				if(!isset($stok_cikisi[$type])) $stok_cikisi[$type] = 0;
				$stok_cikisi[$type] += $sc->qty;
			}
			foreach($urunler AS $u) {
				if(!isset($urun_stok[$u->id])) $urun_stok[$u->id] = array();
				if(isset($stok[$u->id])) {
					$urun_stok[$u->id]['stok'] = $stok[$u->id]; 
				} else {
					$urun_stok[$u->id]['stok'] = 0;
				}
				if(isset($siparis[$u->id])) {
					$urun_stok[$u->id]['stok_sahipli'] = $siparis[$u->id];
					if(isset($stok_sahipli[$u->id])) { 
						$urun_stok[$u->id]['stok_sahipli'] -= $stok_sahipli[$u->id]; //sevki yapılan siparişleri çıkar
					} 
				} else {
					$urun_stok[$u->id]['stok_sahipli'] = 0;
				}
				if(isset($stok_cikisi[$u->id])) {
					$urun_stok[$u->id]['stok_cikis'] = $stok_cikisi[$u->id]; 
				} else {
					$urun_stok[$u->id]['stok_cikis'] = 0;
				}
				if(isset($siparis[$u->id])) {
					$urun_stok[$u->id]['siparis'] = $siparis[$u->id]; 
				} else {
					$urun_stok[$u->id]['siparis'] = 0;
				}
				if(isset($siparis_tamam[$u->id])) {
					$siparis_tamam[$u->id]['siparis_tamam'] = $siparis_tamam[$u->id]; 
				} else {
					$urun_stok[$u->id]['siparis_tamam'] = 0;
				}
			
			}
			//print2($urun_stok);
			?>
			<div class="btn-group">
				<?php if(!getisset("negatif-gizle"))  { 
				  ?>
 				<a href="?negatif-gizle" class="btn btn-primary">{{e2("Negatif Stokları Gizle")}}</a> 
				 <?php } ?>
				 <?php if(getisset("negatif-gizle"))   { 
				   
 				  ?>
 				<a href="?negatif-goster" class="btn btn-primary">{{e2("Negatif Stokları Göster")}}</a> 
				  <?php } ?>
			</div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <tr>
                        <th>{{e2("ÜRÜN ADI")}}</th>
                        <th>{{e2("REEL STOK")}}</th>
                        <th>{{e2("SAHİPLİ STOK")}}</th>
                        <th>{{e2("SAHİPSİZ STOK")}}</th>
                    </tr>
                    <?php  foreach($urunler AS $u) { 
                        if(isset($urun_stok[$u->id])) { 
                            $stok_durum = $urun_stok[$u->id];
                            $reel_stok = $stok_durum['stok'];;
                            $sahipli_stok = $stok_durum['stok_sahipli'];
                            $sahipsiz_stok = $stok_durum['stok'] - $stok_durum['stok_sahipli'];
							$goster = true;
							if(getisset("negatif-gizle")) {
								if($sahipsiz_stok<0) {
									$goster = false;
								}

							}
							if($goster)  { 
							 
                         ?>
                         <tr>
                             <td>{{$u->title}}</td>
                             <td>{{$reel_stok}}</td>
                             <td>{{$sahipli_stok}}</td>
                             <td>{{$sahipsiz_stok}}</td>
                         </tr> 
							 <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </table>
            </div>
			<div class="row">
				<?php  foreach($urunler AS $u) { 
					if(isset($urun_stok[$u->id])) { 
						$stok_durum = $urun_stok[$u->id];
						$reel_stok = $stok_durum['stok'];;
						$sahipli_stok = $stok_durum['stok_sahipli'];
						$sahipsiz_stok = $stok_durum['stok'] - $stok_durum['stok_sahipli'];
						$goster = true;
						if(getisset("negatif-gizle")) {
							if($sahipsiz_stok<0) {
								$goster = false;
							}
						}
						if($goster)  { 
						 
 					?>
								{{col("col-md-4",$u->title)}}
									{{charts("Reel Stok,Sahipli Stok,Sahipsiz Stok","$reel_stok,$sahipli_stok,$sahipsiz_stok","","bar")}}
								{{_col()}}  
 					 		<?php } ?> 
						 <?php } ?>
				 <?php } ?>
		
			</div>
            