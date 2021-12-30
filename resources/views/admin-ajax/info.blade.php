   
   <div class="input-group">
    <input type="datetime-local" name="d1" id="d1">
    <input type="datetime-local" name="d2" id="d2">
    <button class="btn btn-primary getir">Getir</button>
   </div>
   <div class="ekg-date"></div>
   <script>
     $(function(){
      $(".getir").on("click",function(){
      //    $(".ekg-zone").load("?ajax=ekg&id={{$_GET['id']}}");
          $.get("?ajax=ekg-date&id={{$_GET['id']}}",{
            d1 : $("#d1").val(),
            d2 : $("#d2").val()
          },function(d){
            $(".ekg-date").html(d);
          });
      });
     });
   </script>
   <div class="ekg-zone">
    @include("admin.inc.ekg")
   </div>
   <?php $veri = db("pulse_data")
    ->where("mac",get("id"))
    ->orderBy("id","DESC")
    ->first();
    //print_R($veri);
    $data = $veri->data;
    $data = explode(",",$data);
    $dizi = array();
    $k=0;
    foreach($data AS $d) {
        $k++;
        if($d!="") {
          if($d<500) {
            $d=500;
          }
            array_push($dizi,"['$k',$d]");
        }
        
    }
    $hasta = db("users")
    ->where("mac",get("id"))
    ->first();
  //  print_R($hasta);

    ?>
   <table class="table table-bordered">
      <tr>
          <td>Son Sinyal Zamanı:</td>
          <td><strong>{{df($veri->created_at,"d.m.Y H:i")}} ({{zf($veri->created_at)}})</strong></td>
      </tr>
      <tr>
          <td>Lokasyon:</td>
          <td><strong>{{$veri->lat}}, {{$veri->lng}}</strong></td>
      </tr>
      <tr>
          <td>Pil Durumu:</td>
          <td><strong>%{{$veri->battery}}</strong></td>
      </tr>
      <?php if($hasta) { ?>
      <tr>
          <td>Hasta Bilgisi:</td>
          <td><strong>{{$hasta->name}} {{$hasta->surname}}</strong></td>
      </tr>
      <?php } ?>
    </table>
    <div class="row">
        <div class="col-12">
        <iframe src="https://maps.google.com/maps?q={{$veri->lat}}, {{$veri->lng}}&z=18&output=embed"  width="100%" height="270" frameborder="0" style="border:0;width:100%;"></iframe>
        </div>
      
    </div>
    
    
    
    