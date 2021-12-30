<?php 
$user = u();
$urunler = contents_to_array("Ürünler"); 
$users = usersArray();
?>
<div class="content">
    <div class="row">
    {{col("col-md-12","Yeni Stok Kartı",3)}}
    
    <?php 
    if(getisset("sil")) {
        db("stoklar")->where("id",get("sil"))
        ->whereNull("cikis")
        ->delete();
        echo "ok";
        exit();
    }
    if(getisset("ekle")) {
        $post = $_POST;
        $net = $post['qty'] - $post['dara'];
        $qty = $post['qty'];
        $dara = $post['dara'];
        $type = $post['type'];

        unset($post['_token']);
        unset($post['type']);
        unset($post['qty']);
        unset($post['dara']);
        $id = 1;
        
        $son_id = db("stoklar")->orderBy("id","DESC")->first();
        if($son_id) {
            $id = $son_id -> id;
        }
        $barcode = date("Ymdhi").$id;
        ekle([
            "type" => $type,
            "slug" => $barcode,
            "qty" => $qty,
            "dara" => $dara,
            "net" => $net,
            "json" => json_encode_tr($post)
        ],"stoklar");
        bilgi("Stok girişi başarıyla oluşturuldu");
    } ?>
   
        <form action="?ekle" method="post" class="">
            {{csrf_field()}}
            
            {{e2("ÜRÜN:")}}
            <select name="type" required class="form-control select2 urun-sec" required id="">
                    <option value="">Seçiniz</option>
                <?php foreach($urunler AS $u) { ?>
                    <option value="{{$u->id}}">{{$u->title}}</option>
                <?php } ?>
            </select>
            <div class="alt-detay"></div>
            {{e2("DARA KG")}}
            <input type="number"  name="dara" step="any" class="form-control" value="0" id="dara">
            {{e2("KANTAR KG")}} 
            <div class="badge badge-success baglanti-ok d-none">Bağlantı başarılı!</div>
            <div class="badge badge-info baglanti-false d-none">Kantar'dan veri okuma başarısız lütfen sağ taraftaki bağlan tuşundan kantarın bağlı olduğu portu seçiniz!</div>
            <div class="input-group">
                <input type="number"  name="qty" step="any" class="form-control" value="0" id="qty">
                <div class="btn btn-success baglan" onclick="serialScaleController.init();"><i class="fa fa-plug"></i> Bağlan</div>
         </div>

            <button class="btn btn-primary mt-10" type="submit">{{e2("Ekle")}}</button>
            <script>
                $(function(){
                    $(".urun-sec").on("change",function(){
                        $(".alt-detay").html("Yükleniyor...");
                        $.get("?ajax=urun-alt-detay",{
                            id : $(this).val()
                        },function(d){
                            $(".alt-detay").html(d);
                        });
                        
                    });
                    $(".urun-sec2").on("change",function(){
                        if($(this).val()!="") {
                            $(".alt-detay2").html("Yükleniyor...");
                            $.get("?ajax=urun-alt-detay2",{
                                id : $(this).val()
                            },function(d){
                                $(".alt-detay2").html(d);
                            });
                        }
                        
                        
                    });
                }); 
            </script>
        </form>
    {{_col()}}
    {{col("col-md-12","Filtrele")}}
       <form action="" method="get" class="filtre">
            {{e2("ÜRÜN:")}}
            <select name="type" class="form-control select2 urun-sec2" id="">
                    <option value="">{{e2("Tümü")}}</option>
                <?php foreach($urunler AS $u) { ?>
                    <option value="{{$u->id}}">{{$u->title}}</option>
                <?php } ?>
            </select>
            <div class="alt-detay2"></div>
           
            <br>
            <div class="row">
                <div class="col-md-6">
                    {{e2("DURUM")}} :  <br>
                    <select name="durum" id="" class="form-control">
                        <?php $durum = explode(",","Tümü,Gönderildi,Depoda") ?>
                        <?php foreach($durum AS $d)  { 
                          ?>
                         <option value="{{$d}}" <?php if(getesit("durum",$d)) echo "selected"; ?>>{{e2($d)}}</option> 
                         <?php } ?>
                       
                        
                    </select>
                </div>
                <div class="col-md-6">
                    {{e2("FİLTRELE")}} :
                    <div class="input-group">
                        <input type="number" name="satir" min="1" max="100000" value="20" class="form-control" title="{{e2("Sayfa başına düşen satır sayısı")}}" name="" id="">
                        <button class="btn btn-primary" name="filtre" value="ok">{{e2("Filtrele")}}</button>
                    </div>
                </div>
            </div>
            
            
            <script>
                
                <?php if(getisset("filtre")) {
 ?>
    $(".urun-sec2").val("{{get("type")}}");
    window.setTimeout(function(){
        $(".urun-sec2").trigger("change");
       window.setTimeout(function(){
        <?php 
        
        foreach($_GET AS $alan => $deger)  {
            if($alan!="type") {
                if($alan=="ROLL_NO") {
                    if($deger!="")  { 
                     
                      ?>
                      var newOption = new Option("{{$deger}}", "{{$deger}}", true, true);
                     $(".filtre [name='{{$alan}}']").append(newOption).trigger('change'); 
                     <?php } ?>
                     <?php 
                }
             ?>
             $(".filtre [name='{{$alan}}']").val("{{$deger}}").trigger("change");
             <?php 
            }
        } ?>
       },1000);
    },500);
 <?php  
                } ?>
            </script>
       </form> 
    {{_col()}}
    {{col("col-md-12","Geçmiş Stok Girişleri",3)}} 
    <div class="float-right">
        <a href="" class="btn btn-primary"><i class="fa fa-sync"></i> {{e2("Değişiklikleri Görmek İçin Yenileyin")}}</a>
    </div>
    <?php $stoklar = db("stoklar");
    
    if(getisset("q")) {
       // $stoklar = where("slug")
       $deger = "%".trim(get("q"))."%";
       $q = get("q");
       
      
        
        $urunlerdb = db("contents")->where("title","like","%{$_GET['q']}%")->where("type","Ürünler")->get();
        if($urunlerdb) {
            $urunlerdizi = array();
            foreach($urunlerdb AS $udb) {
                array_push($urunlerdizi,$udb->id);
            }
        //    print2($urunlerdizi);
            $stoklar = $stoklar->whereIn("type",$urunlerdizi);
        }
        
        $stoklar = $stoklar->orwhere(function($query) use($deger,$q){
               $query->orWhere("slug",$q);
               $query->orWhere("json","like",$deger);
        });
        
        

    }
    if(getisset("filtre")) {
        $get = $_GET;
        if(!getesit("type","")) {
            $stoklar = $stoklar->where("type",get("type"));
        }
        if(getesit("durum","Gönderildi")) {
            $stoklar = $stoklar->whereNotNull("cikis");
        }
        if(getesit("durum","Depoda")) {
            $stoklar = $stoklar->whereNull("cikis");
        }
        
        unset($get['filtre']);
        unset($get['type']);
        unset($get['satir']);
        unset($get['durum']);
        $stoklar = $stoklar->where(function($query) use($get){
            foreach($get AS $alan => $deger) {
                if($deger !="") {
                    if($alan=="ROLL_NO") {
                    
                    
                        $query->where("json","like","%$deger%");
                    } else {
                        $tire = explode("-",$deger);
                        if(count($tire)>1) {
                            $query->where("json->$alan",">=",$tire[0]);
                            $query->where("json->$alan","<=",$tire[1]);
                        } else {
                            $query->where("json->$alan",$deger);
                        }
                        
                    }
                   
                }
                    
            }
        });
    }
    $satir = 20;
    if(getisset("satir")) {
        $satir = get("satir");
    }
    $stoklar = $stoklar->orderBy("id","desc")->simplePaginate($satir); ?>
    <form action="" method="get">
        <input type="text" name="q" placeholder="{{e2("Ara...")}}" value="{{get("q")}}" id="" class="form-control">

    </form>
    <div class="table-responsive">
        <table class="table" id="excel">
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
            <?php 
            $sayim = array();
            $sayim['dara'] = 0;
            $sayim['qty'] = 0;
            $sayim['net'] = 0;
            foreach($stoklar AS $stok) { 
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
                        
                        $int = (int) $deger;
                        if(is_integer($int)) {
                            if(!isset($sayim[$alan])) $sayim[$alan] = 0;
                            $sayim[$alan] += $int;
                        } else {
                            if(!isset($sayim[$alan][$deger])) $sayim[$alan][$deger] = 0;
                            $sayim[$alan][$deger]++;
                        }
                                                    ?>
                            <div class="badge badge-primary">
                            <strong>{{$alan}}</strong> : {{$deger}} </div>

                            <?php 
                    }
                    $sayim['dara'] += $stok->dara;
                    $sayim['qty'] += $stok->qty;
                    $sayim['net'] += $stok->net;
                   ?>
                </td>
                <td>{{$stok->dara}}</td>
                <td>{{$stok->qty}}</td>
                <td>{{$stok->net}}</td>
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
                    <div class="no-print">
                    <?php if($user->level=="Admin") {
                         ?>
                         <?php if($stok->cikis=="")  { 
                          ?>
                          <a href="?sil={{$stok->id}}" ajax="#t{{$stok->id}}" teyit="{{e2("Bu stok bilgisini silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!")}}" class="btn btn-danger"><i class="fa fa-times"></i></a>
                          <?php } ?>
                          <?php 
                    } ?>
                    <a href="?ajax=print-stok&id={{$stok->id}}" target="_blank" class="btn btn-success">
                        <i class="fa fa-print"></i>
                    </a>
                    </div>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <th>
                    <?php if(isset($sayim['METRE'])) {
                        echo nf($sayim['METRE'],"METRE");
                    } ?>
                </th>
                <th>{{nf($sayim['dara'])}}</th>
                <th>{{nf($sayim['qty'])}}</th>
                <th>{{nf($sayim['net'])}}</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <?php //print2($sayim); ?>
        {{$stoklar->appends(request()->query())->links()}}
    </div>
    {{_col()}}
    </div>
</div>

<script>
    
    "use strict";
    class SerialScaleController {
        constructor() {
            this.encoder = new TextEncoder();
            this.decoder = new TextDecoder();
        }
        async init() {
            if ('serial' in navigator) {
                try {
                    const port = await navigator.serial.requestPort();
                    await port.open({ baudRate: 9600 });
                    this.reader = port.readable.getReader();
                    let signals = await port.getSignals();
                    console.log(signals);
                    $(".baglanti-false").addClass("d-none");
                    $(".baglanti-ok").removeClass("d-none");
                }
                catch (err) {
                    $(".baglanti-false").removeClass("d-none");
                    $(".baglanti-ok").addClass("d-none");
                    console.error('There was an error opening the serial port:', err);
                }
            }
            else {
                console.error('Web serial doesn\'t seem to be enabled in your browser. Try enabling it by visiting:');
                console.error('chrome://flags/#enable-experimental-web-platform-features');
                console.error('opera://flags/#enable-experimental-web-platform-features');
                console.error('edge://flags/#enable-experimental-web-platform-features');
            }
        }
        async read() {
            try {
                const readerData = await this.reader.read();
            //    console.log(readerData)
                return this.decoder.decode(readerData.value);
            }
            catch (err) {
                const errorMessage = `hata algılandı: ${err}`;
              //  console.error(errorMessage);
                return errorMessage;
            }
        }
    }

    const serialScaleController = new SerialScaleController();
    const connect = document.getElementById('connect-to-serial');
    const getSerialMessages = document.getElementById('get-serial-messages');

   
    function baglan() {
        console.log("baglan");
        serialScaleController.init();
    }
    /*
    window.setTimeout(function(){
        $(".baglan").trigger("click");
        baglan();

    },1000);
    */
    
  

    async function getSerialMessage() {
        try {
                var deger = await serialScaleController.read();
                var regex = /[+-]?\d+(\.\d+)?/g;
                var float = deger.match(regex).map(function(v) { return parseFloat(v); });
               // console.log(float);
                $("#qty").val(float);
            }
            catch (err) {
                const errorMessage = `hata algılandı: ${err}`;
              //  console.error(errorMessage);
                return errorMessage;
            }
        
        
    }
    window.setInterval(function(){
        getSerialMessage();
    },100);
    
  </script>