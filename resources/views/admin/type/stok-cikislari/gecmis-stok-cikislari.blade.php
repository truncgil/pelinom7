{{col("col-md-12 gecmis-stok-cikislari","Geçmiş Stok Çıkışları",3)}} 

    <?php $stoklar = db("stok_cikislari");
    if(!getesit("urun","")) $stoklar = $stoklar->where("siparis->type",get("urun"));
    if(!getesit("musteri","")) $stoklar = $stoklar->where("musteri_id",get("musteri"));
    if(!getesit("date1","")) $stoklar = $stoklar->where("created_at",get("date1"));
    $stoklar = $stoklar->orderBy("id","desc")->get(); ?>
    <div class="table-responsive ">
        <table class="table" id="excel">
            <tr>
                <th>{{e2("STOK ÇIKIŞ NO")}}</th>
                <th>{{e2("İŞLEM TARİHİ")}}</th>
                <th>{{e2("FİRMA")}}</th>
                <th>{{e2("SİPARİŞ BİLGİSİ")}}</th>
                <th>{{e2("STOK BİLGİSİ")}}</th>
                <th>{{e2("MİKTAR")}}</th>
                <th>{{e2("İŞLEM")}}</th>
            </tr>
            <?php foreach($stoklar AS $s) {
                $firma = j($s->musteri);
                $stok = j($s->stok);
                $siparis = j($s->siparis);
                $urun = $urunler[$siparis['type']];
                ?>
            <tr>
                <td>{{$s->id}}</td>
                <td>
                    <input type="datetime-local" name="created_at" value="{{date('Y-m-d\TH:i', strtotime($s->created_at))}}" class="form-control edit" table="stok_cikislari" id="{{$s->id}}">

                </td>
                <td>{{$firma['title']}} / {{$firma['title2']}}
            
                </td>
                <td>{{$urun->title}} / {{date("d.m.Y H:i",strtotime($siparis['created_at']))}}</td>
                <td>
                <a href="?ajax=print-stok&id={{$stok['slug']}}&noprint" title="{{$stok['slug']}} Barkoduna Ait Bilgiler" class="ajax_modal">{{$stok['slug']}}</a>
               </td>
                <td>{{nf($s->qty)}}</td>
                <td>
                    <a href="?sil={{$s->id}}&stok_id={{$s->stok_id}}" teyit="{{e2("Bu kayıt silinecektir. Bu işlem geri alınamaz")}}" class="btn btn-danger">Sil</a>
                </td>
            </tr>
           <?php } ?>
        </table>
    </div>
    {{_col()}}