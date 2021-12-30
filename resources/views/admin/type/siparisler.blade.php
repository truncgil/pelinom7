<?php 
$firmalar = contents_to_array("Müşteriler");
$urunler = contents_to_array("Ürünler");
$stok_cikis_sayim = stok_cikis_sayim();
$stok_metre_sayim = stok_metre_sayim();
 ?>
<div class="content">
    <div class="row">
        
        @include("admin.type.siparisler.yeni-siparis-formu")

    </div>
	<div class="block">
		<div class="block-header block-header-default">
			<h3 class="block-title"><i class="fa fa-{{$c->icon}}"></i> Siparişleriniz</h3>
			<div class="block-options">
				<div class="block-options-item"> <a
						href="{{ url('admin-ajax/content-type-blank-delete?type='. $c->title) }}"
						teyit="{{__('Tüm boş '.$c->title.'  '._('') )}}" title="{{_('Boş Olan  İçeriklerini Sil')}}"
						class="btn btn-danger"><i class="fa fa-times"></i> </a> <a
						href="{{ url('admin-ajax/content-type-add?type='. $c->title) }}" class="btn btn-success"
						title="Yeni {{$c->title}} {{_('İçeriği Oluştur')}}"><i class="fa fa-plus"></i> </a> </div>
			</div>
		</div>
		<div class="block-content">
            <?php 
            if(getisset("sil")) {
                db("siparisler")
                ->where("id",get("sil"))
                ->delete();
                bilgi("{$_GET['sil']} numaralı sipariş silinmiştir");
            }
            $siparis_durumlari = siparis_durumlari();
            ?>
            <?php  $alt = db("siparisler");
                        if(getisset("q")) {
                            $musterilerdb = db("contents")->where("title","like","%".get("q")."%")->get();
                            if($musterilerdb) {
                                $musterilerdizi = array();
                                foreach($musterilerdb AS $mdb) {
                                    array_push($musterilerdizi,$mdb->id);
                                }
                                $alt = $alt->whereIn("kid",$musterilerdizi);
                            }
                            
                        }
                        if(getisset("durum")) {
                            $alt = $alt->where("title",get("durum"));
                        } else {
                            $alt = $alt->whereNull("title");
                        }

                        $alt = $alt->orderBy("id","DESC")->simplePaginate("20"); ?>
			<div class="js-gallery "> @include("admin.inc.table-search") 
                <div class="float-left">
                
                </div>
                <div class="float-right">
                    <div class="btn-group">
                            <a href="?" class="btn btn-<?php if(!getisset("durum")) echo "success"; else echo "default"; ?>">{{e2("Tümü")}}</a>
                        <?php foreach($siparis_durumlari AS $sd) {
                             ?>
                             <a href="?durum={{$sd}}" class="btn btn-<?php if(getesit("durum",$sd)) echo "success"; else echo "default"; ?>">{{$sd}}</a>
                             <?php 
                        } ?>
                    </div>
                </div>
                <script>
$(function(){
    $(".stok_cikisi_all").click(function(){
        $('.stok_cikisi:checkbox').not(this).prop('checked', this.checked);
    });
    $(".stok-cikisi-btn").on("click",function(){
        var valuesArray = $('.stok_cikisi:checked').map(function () {  
        return this.value;
        }).get().join(",");
        var url = "{{url("admin/types/stok-cikislari?ids=")}}" + valuesArray;
     //   alert(url);
        location.href=url;
    });
})

    </script>
    <div class="btn btn-primary stok-cikisi-btn">{{e2("Seçilen Siparişler İçin Stok Çıkışı Oluştur")}}</div>
                <div class="table-responsive">
					<table class="table table-striped table-hover table-bordered table-vcenter" id="excel">
						<thead>
							<tr>
                                <th>
                                    <input type="checkbox" name="" class="stok_cikisi_all" id="">
                                </th>
                                <th>{{e2("Sipariş Kodu")}}</th>
								<th>{{__("Firma Ünvanı")}}</th>
								<th>{{__("Ürün Adı")}}</th>
                                <th>{{e2("Ürün Özellikleri")}}</th>
                                <th>{{e2("Sipariş Notları")}}</th>
                                <th>{{e2("Sipariş Miktarı")}}</th>
                                <th>{{e2("Sevk Edilen")}}</th>
                                <th>{{e2("Kalan Miktar")}}</th>
                                <th>{{e2("Termin Tarihi")}}</th>
								<th class="d-none">{{__("Kategorisi")}}</th>
								<th class="d-none" style="width: 15%;">{{__("Tip")}}</th>
								<th>{{__("Durum")}}</th>
								<th class="d-none">{{__("Sıra")}}</th>
								<th class="text-center" style="width: 100px;">{{__("İşlemler")}}</th>
							</tr>
						</thead>
                        

						<tbody> @foreach($alt AS $a)
                        <?php 
                        $stok_cikisi = 0;
                        $stok_metre = 0;
                        if(isset($stok_cikis_sayim[$a->id])) {
                            $stok_cikisi = $stok_cikis_sayim[$a->id];
                        } 
                        if(isset($stok_metre_sayim[$a->id])) {
                            $stok_metre = $stok_metre_sayim[$a->id];
                        } 
                        $kalan_metre = 0;
                        if(isset($j['METRE'])) {
                            $kalan_metre = $stok_metre - $j['METRE']; 
                        }
                        ?>
                         <tr  class="<?php if($a->qty - $stok_cikisi<0) echo "table-danger"; ?>" id="t{{$a->id}} ">
                            <?php $firma = $firmalar[$a->kid];
                                $urun = $urunler[$a->type];
                                $j = j($a->json);
                            ?>
                                <td>
                                    <input type="checkbox" name="" value="{{$a->id}}" class="stok_cikisi" id="">
                                    
                                </td>
                                <td width="100" class="text-center">
                                    {{$a->id}}
                                </td>
                                <td><a href="{{url("admin/types/musteriler?detay=".$a->kid)}}">{{$firma->title}} / {{$firma->title2}}</a></td>
                                <td>{{$urun->title}}</td>
                                <td>
                                    <?php urun_ozellikleri($j) ?>
                                </td>
                                <td>{{$a->html}}</td>
                                <td>{{nf($a->qty)}}</td>
                                <td width="100">
                                    <?php 
                                  //  print2($stok_cikis_sayim);
                                    
                                    
                                    ?>
                                    {{nf($stok_cikisi)}}
                                    <hr>
                                    {{nf($stok_metre,"MT")}}
                                </td>
                                <td width="100">
                                    {{nf($a->qty-$stok_cikisi)}}
                                    <hr>
                                    {{nf($kalan_metre,"MT")}}
                                </td>
                                <td>
                                    {{date("d.m.Y",strtotime($a->date))}}
                                </td>
                                <td>
                                 
                                    <select name="title" id="{{$a->id}}" table="siparisler"  class="form-control edit">
                                        <option value="">Seçiniz</option>
                                        <?php foreach($siparis_durumlari AS $d) { 
                                          ?>
                                         <option value="{{$d}}" <?php if($a->title==$d) echo "selected"; ?>>{{$d}}</option> 
                                         <?php } ?>
                                    </select>
                                </td>
                                <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="{{url("admin/types/stok-cikislari?ids=".$a->id)}}" class="btn btn-primary  dropdown-item"><i class="fa fa-cubes"></i> {{e2("Stok Çıkışı")}}</a>
                                        
                                        <a href="?ajax=print-siparis2&id={{$a->id}}&siparis-emri" target="_blank" class="btn btn-success dropdown-item" title=""><i class="fa fa-print"></i> {{e2("Sipariş Emri Yazdır")}}</a>
                                        <a href="?ajax=print-siparis2&id={{$a->id}}" target="_blank" class="btn btn-success dropdown-item" title=""><i class="fa fa-print"></i> {{e2("Tüm Zamanların Stok Çıkışlarını Yazdır")}}</a>
                                        <a href="?ajax=print-siparis2&id={{$a->id}}&bugun" target="_blank" class="btn btn-success dropdown-item" title=""><i class="fa fa-print"></i> {{e2("Bugünkü Stok Çıkışlarını Yazdır")}}</a>
                                        <a href="?duzenle={{$a->id}}" class="btn btn-info dropdown-item"><i class="fa fa-edit"></i> {{e2("Düzenle")}}</a>
                                        {{admin_delete($a->id)}}
                                         </div>
                                </div>
                                    <div class="btn-group">
                                    </div>
                                </td>
								
							</tr> @endforeach 
                        </tbody>
					</table> {{$alt->fragment('alt')->appends(request()->query())->links() }}
				</div>
			</div>
		</div>
	</div>
</div>