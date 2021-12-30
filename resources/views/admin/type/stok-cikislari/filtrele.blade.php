{{col("col-md-12 filtrele","Filtrele",2)}}
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
                            <input type="date" name="date1"  value="{{get("date1")}}" id="" class="form-control">
                        </div>
                        <div class="col-md-6">
                            {{e2("İŞLEM TARİHİ BİTİŞ")}} : 
                            <input type="date" name="date2"  value="{{get("date2")}}" id="" class="form-control">
                        </div>
                       
                       
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary mt-10" name="filtre" value="ok">{{e2("FİLTRELE")}}</button>
                        </div>
                    </div>
                    
                   
                    
                    
                    

                </form>
    {{_col()}}