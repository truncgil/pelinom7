<?php $firmalar = contents_to_array("Müşteriler"); ?>
<div class="content">
    <div class="row">
        <?php $siparis_durumlari = siparis_durumlari(); ?>
        <?php 
        $k=10;
        $siparisler = db("siparisler")->get();
        $total = array();
        foreach($siparisler AS $s) {
            
            if($s->title=="") {
                if(!isset($total["İşlem Yapılmayan"])) $total["İşlem Yapılmayan"] = 0;
                $total["İşlem Yapılmayan"]++;
            } else {
                if(!isset($total[$s->title])) $total[$s->title] = 0;
                $total[$s->title]++;
            }   
        }
        array_push($siparis_durumlari,"İşlem Yapılmayan");
        foreach($siparis_durumlari AS $sd)   { 
            $k++;
         ?>
         {{col("col-md-2 text-center",$sd,$k)}} 
            <div class="font-size-h3 font-w600">
                <?php if(isset($total[$sd])) {
                     ?>
                     {{$total[$sd]}}
                     <?php 
                } else {
                     ?>
                     {{0}}
                     <?php 
                } ?>
            </div>
         {{_col()}}
         <?php } ?>
        {{col("col-md-6","Günü Yaklaşan Siparişler",22)}}

                <?php 
                $bas = date("Y-m-d");
                $son = date("Y-m-d",strtotime(" +10 days"));
               // echo $son;
                $siparisler = db("siparisler")->whereBetween("date",[$bas,$son])->orderBy("date","ASC")->get(); ?>
                <table class="table">
                    <tr>
                        <td>{{e2("MÜŞTERİ")}}</td>
                        <td>{{e2("TERMİN TARİHİ")}}</td>
                    </tr>
                    <?php foreach($siparisler AS $s)  { 
                        $firma = $firmalar[$s->kid];
                      ?>
                     <tr>
                         <td>{{$firma->title}} / {{$firma->title2}}</td>
                         <td>{{date("d.m.Y",strtotime($s->date))}}</td>
                     </tr> 
                     <?php } ?>
                </table>
        {{_col()}}
        {{col("col-md-6","Günü Geçen Siparişler",22)}}

                <?php 
                $bas = date("Y-m-d",strtotime(" -10 days"));
                $son = date("Y-m-d",strtotime(" -1 days"));
               // echo $son;
                $siparisler = db("siparisler")->where("date","<=",$son)
                ->where(function($query) {
                    $query->whereNull("title");
                    $query->orwhere("title","<>","Tamamlandı");
                })
                ->orderBy("date","ASC")->get(); ?>
                <table class="table">
                    <tr>
                        <td>{{e2("MÜŞTERİ")}}</td>
                        <td>{{e2("TERMİN TARİHİ")}}</td>
                    </tr>
                    <?php foreach($siparisler AS $s)  { 
                        $firma = $firmalar[$s->kid];
                      ?>
                     <tr>
                         <td>{{$firma->title}} / {{$firma->title2}}</td>
                         <td>{{date("d.m.Y",strtotime($s->date))}}</td>
                     </tr> 
                     <?php } ?>
                </table>
        {{_col()}}
    </div>
    <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title"><i class="fa fa-{{$c->icon}}"></i> {{e2("Ürün Stok Durumları")}}</h3>
            </div>
            <div class="block-content">
                
                @include("admin.type.istatistik.urun-stoklari")
            </div>

            

        </div>

    </div>
</div>