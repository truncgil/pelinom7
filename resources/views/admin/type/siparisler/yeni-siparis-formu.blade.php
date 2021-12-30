{{col("col-md-12","Yeni Sipariş Formu")}}
        <?php if(getisset("ekle")) {
            $post = $_POST;
            unset($post['_token']);
            unset($post['kid']);
            unset($post['type']);
            unset($post['date']);
            unset($post['html']);
            ekle([
                "kid" => post("kid"),
                "qty" => post("qty"),
                "type" => post("type"),
                "html" => post("html"),
                "json" => json_encode_tr($post),
                "date" => post("date")
            ],"siparisler");
            bilgi("Sipariş başarıyla oluşturuldu");
        }
        if(getisset("guncelle")) {
            $post = $_POST;
            unset($post['_token']);
            unset($post['kid']);
            unset($post['type']);
            unset($post['date']);
            unset($post['html']);
            db("siparisler")
            ->where("id",post("id"))
            ->update([
                "kid" => post("kid"),
                "qty" => post("qty"),
                "type" => post("type"),
                "html" => post("html"),
                "json" => json_encode_tr($post),
                "date" => post("date")
            ]);
            bilgi("{$_POST['id']} Numaralı sipariş başarıyla güncellendi");
        }
        $action= "?ekle";
        $btn_text = "Siparişi Oluştur";
        $html = "";
        if(getisset("duzenle")) {
            $siparis = db("siparisler")->where("id",get("duzenle"))->first();
            $action = "?guncelle";
            $btn_text = "Siparişi Güncelle";
            $html = $siparis->html;
        }
         ?>
         <script>
$('body').on('keydown', 'input, select', function(e) {
    if (e.key === "Enter") {
        var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
        focusable = form.find('input,a,select,button,textarea').filter(':visible');
        next = focusable.eq(focusable.index(this)+1);
        if (next.length) {
            next.focus();
        } else {
            form.submit();
        }
        return false;
    }
});

         </script>
            <form action="{{$action}}" method="post">
                <?php if(getisset("duzenle")) {
                     ?>
                     <input type="hidden" name="id" value="{{get("duzenle")}}">
                     <?php 
                } ?>
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-6">
                        {{e2("FİRMA ÜNVANI")}}
                        <select name="kid" class="form-control select2" required id="kid">
                                <option value="">Seçiniz</option>
                            <?php foreach($firmalar AS $f) { ?>
                                <option value="{{$f->id}}">{{$f->title}} / {{$f->title2}}</option>
                            <?php } ?>
                        </select>
                        
                        
                        {{e2("SİPARİŞ MİKTARI (KG): ")}}
                        <input type="number" class="form-control" name="qty" step="any" value="" required id="qty">
                        {{e2("SİPARİŞ NOTLARI: ")}}
                        <textarea name="html" id="html" cols="30" rows="10" class="form-control">{{$html}}</textarea>
                        {{e2("TERMİN TARİHİ (HEDEFLENEN YÜKLEME TARİHİ)")}}:
                        <input type="date" name="date" required class="form-control" id="date">
                    </div>
                    <div class="col-md-6">
                        {{e2("ÜRÜN:")}}
                        <select name="type" class="form-control select2 urun-sec" required id="type">
                                <option value="">Seçiniz</option>
                            <?php foreach($urunler AS $u) { ?>
                                <option value="{{$u->id}}">{{$u->title}}</option>
                            <?php } ?>
                        </select>
                        <div class="alt-detay mt-10"></div>
                    </div>
                </div>
               
                <button class="mt-10 btn btn-primary">{{$btn_text}}</button>
            </form>
            
            <script>
                $(function(){
                    $(".urun-sec").on("change",function(){
                        $(".alt-detay").html("Yükleniyor...");
                        $.get("?ajax=urun-alt-detay",{
                            id : $(this).val()
                        },function(d){
                            $(".alt-detay").html(d);
                            <?php if(getisset("duzenle")) {
                                 $j = j($siparis->json);
                                 ?>
                                 <?php 
                                    foreach($j AS $alan=> $deger) {
                                        ?>
                                        var newOption = new Option("{{$deger}}", "{{$deger}}", true, true);
                                        $("[name='{{$alan}}']").append(newOption).trigger('change');
                                    //.val("{{$deger}}").trigger("change");
                                        <?php 
                                    }
                                    ?>
                                 <?php 
                            } ?>
                        });
                        
                    });
                    <?php if(getisset("duzenle"))  {
                        
                        $j = j($siparis->json);
                        foreach($j AS $alan=> $deger) {
                             ?>
                           //  $("")
                             <?php 
                        }
                        ?>
                        $("#qty").val("{{$siparis->qty}}");
                       // $("#html").val("{{$siparis->html}}");
                        $("#type").val("{{$siparis->type}}").trigger("change");
                        $("#kid").val("{{$siparis->kid}}");
                        $("#date").val("{{$siparis->date}}");
                        window.setTimeout(function(){
<?php 
   foreach($j AS $alan=> $deger) {
       ?>
   $("[name='{{$alan}}']").val("{{$deger}}");
       <?php 
  }
   ?>
   console.log("ok");
                        },2000);
                   <?php  } ?>
                }); 
            </script>
        {{_col()}}