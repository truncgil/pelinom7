<?php 
$urunler = contents_to_array("Ürünler"); 
$musteriler = contents_to_array("Müşteriler"); 
$stok_cikis_sayim = stok_cikis_sayim();
$stok_metre_sayim = stok_metre_sayim();
$users = usersArray();
$user = u();
?>
<div class="content">
    <img src="{{url("logo.svg")}}" style="    position: absolute;
    width: 300px;
    top: 20px;
    left: 20px;" class="yesprint" alt="">
    <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title"><i class="fa fa-{{$c->icon}}"></i> {{e2("Filtrele")}}</h3>
            </div>
            <div class="block-content">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-6">
                        {{e2("MÜŞTERİ")}} : 
                            <select name="musteri" id="" class="form-control select2 firma-sec">
                                <option value="">{{e2("TÜMÜ")}}</option>
                                <?php $musteri = contents_to_array("Müşteriler"); foreach($musteri AS $m) { ?>
                                <option value="{{$m->id}}">{{$m->title}} / {{$m->title2}}</option>
                                <?php } ?>
                            </select>
                        
                            <div class="detay"></div>

                        </div>
                        <div class="col-md-6">
                            {{e2("ÜRÜN")}} : 
                            <select name="urun" id="" class="form-control select2">
                                <option value="">{{e2("TÜMÜ")}}</option>
                                <?php $sorgu = contents_to_array("Ürünler"); foreach($sorgu AS $m) { ?>
                                <option value="{{$m->id}}">{{$m->title}}</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            {{e2("İŞLEM TARİHİ BAŞLANGIÇ")}} : 
                            <input type="date" name="date1" value="{{ed(get("date1"),"")}}" id="" class="form-control">
                            {{e2("İŞLEM TARİHİ BİTİŞ")}} : 
                            <input type="date" name="date2"  value="{{ed(get("date2"),"")}}" id="" class="form-control">
                        </div>
                        <div class="col-md-6">
                            {{e2("TERMİN BAŞLANGIÇ")}} : 
                            <input type="date" name="tdate1" value="{{ed(get("tdate1"),"")}}" id="" class="form-control">
                            {{e2("TERMİN BİTİŞ")}} : 
                            <input type="date" name="tdate2" value="{{ed(get("tdate2"),"")}}" id="" class="form-control">
                        </div>
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary mt-10 noprint" name="filtre" value="ok">{{e2("FİLTRELE")}}</button>
                        </div>
                    </div>
                    
                   
                    
                    
                    

                </form>
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
            

        </div>
        <div class="row">
            <?php if(getisset("filtre")) { 
              ?>
                {{col("col-md-12","Filtreye Göre Çıkan Siparişler",3)}}
                <?php 
                $sorgu = db("siparisler");
                if(!getesit("musteri","")) $sorgu = $sorgu->where("kid",get("musteri"));
                if(!getesit("urun","")) $sorgu = $sorgu->where("type",get("urun"));
                if(!getesit("date1","")) {
                    $sorgu = $sorgu->WhereBetween('created_at', [get("date1"), get("date2")]);
                }
                if(!getesit("tdate1","")) {
                    $sorgu = $sorgu->WhereBetween('date', [get("tdate1"), get("tdate2")]);
                }
                
                $sorgu = $sorgu->orderBy("id","DESC");
                $sorgu = $sorgu->get();
               // print2($sorgu);
               $toplam = $sorgu->count();
               $alt_toplam = 0;
               $sevk_toplam = 0;
               $kalan_toplam = 0;
                ?>
                    {{bilgi("Yapmış olduğunuz filtreye göre $toplam sipariş döndürüldü")}}
                    <div class="float-right">
                        <div class="btn btn-success noprint" onclick="window.print()"><i class="fa fa-print"></i> Yazdır</div>
                    </div>
                    <div class="table-responsive yazdir">
                        <table class="table" id="excel">
                            <tr>
                                <th>{{e2("Sipariş Kodu")}}</th>
                                <th>{{e2("İşlem Tarihi")}}</th>
                                <th>{{e2("Firma Adı")}}</th>
								<th>{{__("Ürün Adı")}}</th>
                                <th>{{e2("Ürün Özellikleri")}}</th>
                                <th>{{e2("Sipariş Notları")}}</th>
                                <th>{{e2("Sipariş Miktarı")}}</th>
                                <th>{{e2("Sevk Edilen")}}</th>
                                <th>{{e2("Kalan Miktar")}}</th>
                                <th>{{e2("Termin Tarihi")}}</th>
                                <th>{{e2("Personel")}}</th>
                                <th>{{e2("Durum")}}</th>
                            </tr>
                            <?php foreach($sorgu AS $s) { 
                                $alt_toplam += $s->qty;
                                
                                $firma = $musteriler[$s->kid];
                                $urun = $urunler[$s->type];
                                $j = j($s->json);
                                $user = $s->id;
                                if(isset($users[$s->uid])) {
                                    $user = $users[$s->uid];
                                    $user = $user->name . " " . $user->surname;
                                }
                                
                                $sayim = 0;
                                $metre_sayim = 0;
                                if(isset($stok_cikis_sayim[$s->id])) {
                                    $sayim = $stok_cikis_sayim[$s->id];
                                }
                                if(isset($stok_metre_sayim[$s->id])) {
                                    $metre_sayim = $stok_metre_sayim[$s->id];
                                }
                                $kalan_metre = 0;
                                if(isset($j['METRE'])) {
                                    $kalan_metre = $metre_sayim - $j['METRE']; 
                                }
                                $sevk_toplam += $sayim;
                                $kalan_toplam += ($s->qty - $sayim);
                              ?>
                             <tr class="<?php if($s->qty - $sayim<0) echo "table-danger"; ?>">
                                 <td>{{$s->id}}</td>
                                 <td>{{date("d.m.Y H:i",strtotime($s->created_at))}}</td>
                                 <td>{{$firma->title}} / {{$firma->title2}}</td>
                                 <td>{{$urun->title}}</td>
                                 <td>
                                 <?php urun_ozellikleri($j); ?>
                                 </td>
                                 <td>{{$s->html}}</td>
                                 <td>{{nf($s->qty)}}
                                    <hr>
                                    {{nf(@$j['METRE'],"MT")}}

                                 </td>
                                 <td>
                                     {{nf($sayim)}}
                                    <hr>
                                    {{nf($metre_sayim,"MT")}}

                                 </td>
                                 <td>{{nf($s->qty - $sayim)}}
                                    <hr>
                                    {{nf($kalan_metre,"MT")}}
                                 </td>
                                 <td>{{date("d.m.Y",strtotime($s->date))}}</td>
                                 <td>{{$user}}</td>
                                 <td>{{$s->title}}</td>
                             </tr> 
                             <?php } ?>
                             <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>{{nf($alt_toplam)}}</th>
                                        <th>{{nf($sevk_toplam)}}</th>
                                        <th>{{nf($kalan_toplam)}}</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                        </table>
                    </div>
                {{_col()}} 
                {{col("col-md-12","Filtreye Göre Stok Girişleri",9)}}
                <?php 
                $stoklar = db("stoklar")
                ->where("type",get("urun"));
                if(!getesit("date1","")) {
                    $stoklar = db("stoklar")->WhereBetween('created_at', [get("date1"), get("date2")]);
                }
                $stoklar = $stoklar->get();
                $toplam = $stoklar->count();
                $alt_toplam = 0;
                ?>
                    {{bilgi("Yapmış olduğunuz sorguya göre $toplam stok girişi döndürüldü")}}
                    <table class="table">
                                    <tr>
                                        <th>{{e2("STOK NO")}}</th>
                                        <th>{{e2("BARKOD")}}</th>
                                        <th>{{e2("ÜRÜN ADI")}}</th>
                                        <th>{{e2("ÜRÜN ÖZELLİKLERİ")}}</th>
                                        <th>{{e2("DARA KG")}}</th>
                                        <th>{{e2("KANTAR KG")}}</th>
                                        <th>{{e2("NET KG")}}</th>
                                        <th>{{e2("İŞLEM TARİHİ")}}</th>
                                        <th>{{e2("PERSONEL")}}</th>
                                        <th>{{e2("DURUM")}}</th>
                                        <th>{{e2("İŞLEM")}}</th>
                                    </tr>
                                    <?php foreach($stoklar AS $stok) { 
                                        $alt_toplam += $stok->net;
                                        $j = j($stok->json);
                                        $urun = $urunler[$stok->type];
                                        
                                        $u = @$users[$stok->uid];
                                        ?>
                                    <tr id="t{{$stok->id}}">
                                        <td>{{$stok->id}}</td>
                                        <td>{{$stok->slug}}</td>
                                        <td>{{$urun->title}}</td>
                                        <td>
                                            <?php foreach($j AS $alan => $deger) {
                                                $alan = str_replace("_"," ",$alan);
                                                    ?>
                                                    <div class="badge badge-primary">
                                                    <strong>{{$alan}}</strong> : {{$deger}} </div>

                                                    <?php 
                                            } ?>
                                        </td>
                                        <td>{{nf($stok->dara)}}</td>
                                        <td>{{nf($stok->qty)}}</td>
                                        <td>{{nf($stok->net)}}</td>
                                        <td>{{date("d.m.Y H:i",strtotime($stok->created_at))}}</td>
                                        <td>{{$u->name}} {{$u->surname}}</td>
                                        <td><?php if($stok->cikis!="") {
                                            ?>
                                            <div class="badge badge-success">
                                                <i class="fa fa-check"></i>
                                            </div>
                                            <?php 
                                        } ?></td>
                                        <td>
                                            
                                            <a href="?ajax=print-stok&id={{$stok->id}}" target="_blank" class="btn btn-success">
                                                <i class="fa fa-print"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>{{nf($alt_toplam)}}</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </table>
                            {{_col()}}
                            {{col("col-md-12","Filtreye Göre Stok Çıkışları",15)}}
                            <?php $stoklar = db("stok_cikislari");
                            if(!getesit("date1","")) {
                                $stoklar = db("stok_cikislari")->WhereBetween('created_at', [get("date1"), get("date2")]);
                            }
                            if(!getesit("urun","")) $stoklar = $stoklar->where("siparis->type",get("urun"));
                            if(!getesit("musteri","")) $stoklar = $stoklar->where("musteri_id",get("musteri"));
                      
                            $stoklar = $stoklar->get(); 
                            $toplam = $stoklar->count();
                            $alt_toplam = 0;
                            ?>
                              {{bilgi("Yapmış olduğunuz sorguya göre $toplam stok çıkışı döndürüldü")}}
                            <table class="table">
                                <tr>
                                    <th>{{e2("STOK ÇIKIŞ NO")}}</th>
                                    <th>{{e2("İŞLEM TARİHİ")}}</th>
                                    <th>{{e2("FİRMA")}}</th>
                                    <th>{{e2("SİPARİŞ BİLGİSİ")}}</th>
                                    <th>{{e2("STOK BİLGİSİ")}}</th>
                                    <th>{{e2("MİKTAR")}}</th>
                                   
                                </tr>
                                <?php foreach($stoklar AS $s) {
                                    $alt_toplam += $s->qty;
                                    $firma = j($s->musteri);
                                    $stok = j($s->stok);
                                    $siparis = j($s->siparis);
                                    $urun = $urunler[$siparis['type']];
                                    ?>
                                <tr>
                                    <td>{{$s->id}}</td>
                                    <td>{{date("d.m.Y H:i",strtotime($s->created_at))}}</td>
                                    <td>{{$firma['title']}} / {{$firma['title2']}}
                                
                                    </td>
                                    <td>{{$urun->title}} / {{date("d.m.Y H:i",strtotime($siparis['created_at']))}}</td>
                                    <td>
                                    <a href="?ajax=print-stok&id={{$stok['slug']}}&noprint" title="{{$stok['slug']}} Barkoduna Ait Bilgiler" class="ajax_modal">{{$stok['slug']}}</a>
                                </td>
                                    <td>{{nf($s->qty)}}</td>
                                   
                                </tr>
                            <?php } ?>
                                <tr>
                                    <th  colspan="6" class="text-right">{{nf($alt_toplam)}}</th>
                                </tr>
                            </table>
                {{_col()}}
             <?php } ?>
    </div>
    </div>
    
</div>
<script>
                $(function(){
                    $(".firma-sec").on("change",function(){
                        $(".detay").html("Yükleniyor...");
                        $.get("?ajax=siparisler",{
                            id : $(this).val()
                        },function(d){
                            $(".detay").html(d);
                        });
                        
                    });
                }); 
            </script>
           