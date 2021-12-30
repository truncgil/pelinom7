{{col("col-md-12 noprint","Yeni Stok Çıkışı",3)}}
    
    <?php 
    if($user->level=="Admin") {
        if(getisset("sil")) {

            db("stok_cikislari")->where("id",get("sil"))
            ->delete();
           // echo "ok";
           // exit();
           db("stoklar")->where("id",get("stok_id"))
           ->update(['cikis'=>null]);
           bilgi("Kayıt başarıyla silinmiştir");
        }
    }
    
    if(getisset("ekle")) {
        //print2($_POST);
        foreach($_POST['stok'] AS $stok_id) {
            $stokobj = db("stoklar")->where("id",$stok_id)->first();
            $musteri = json_encode_tr($musteriler[post("firma")]);
            $stok = json_encode_tr($stokobj);
            $siparis = json_encode_tr(db("siparisler")->where("id",post("siparis"))->first());
            $dizi = [
                "siparis" =>$siparis,
                "stok" =>$stok,
                "musteri" =>$musteri,
                "qty" =>$stokobj->net,
                "siparis_id"=>post("siparis"),
                "stok_id" => $stok_id,
                "musteri_id" => post("firma")
            ];
            $varmi = db("stok_cikislari")
                ->where("siparis_id",post("siparis"))
                ->where("stok_id",$stok_id)
                ->where("musteri_id",post("firma"))
                ->get();
            if($varmi->count()==0) {
                ekle($dizi,"stok_cikislari");
                db("stoklar")->where("id",$stok_id)
                ->update(['cikis'=>1]);
                bilgi("Stok çıkışı başarılı bir şekilde yapılmıştır");
            } else {
                bilgi("Bu stok çıkışı daha önce yapılmıştır");
            }
        }
        
        
    } ?>
   
        <form action="?ekle" method="post" class="">
            <div class="row">
                <div class="col-md-9">
                    {{csrf_field()}}
                    {{e2("FİRMA:")}}
                    <select name="firma" id="" class="form-control select2 firma-sec" required>
                            <option value="">{{e2("MÜŞTERİ SEÇİNİZ")}}</option>
                        <?php foreach($musteriler AS $m) {
                            ?>
                            <option value="{{$m->id}}">{{$m->title}}</option>
                            <?php 
                        } ?>
                        
                    </select>
                    <div class="detay"></div>

                    <button class="btn btn-primary mt-10" type="submit">{{e2("Ekle")}}</button>

                </div>
                <div class="col-md-3">
                    <div class="float-right">
                        <div class="info"></div>
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
        </form>
    {{_col()}}