<?php 

function admin_delete($id) {
    ?>
    <?php if(u()->level=="Admin") {
         ?>
         <a href="?sil=<?php echo $id ?>"  teyit="Bu kaydı silmek istediğinizden emin misiniz? Bu işlem geri alınamaz" class="btn btn-danger"><i class="fa fa-times"></i></a>
         <?php 
    } ?>
    <?php 
}


function col($size,$title="",$color="1") {
    $colors = colors();
   
     ?>
     <div class="<?php echo $size ?>">
        <div class="block block-themed">
            <?php if($title!="") {
                 ?>
                 <div class="block-header bg-<?php echo $colors[$color]; ?>"><?php echo $title ?></div>
                 <?php 
            } ?>
            
            <div class="block-content">
               
           
     <?php 
}
function _col() {
     ?>
      </div>
        </div>
    </div>
     <?php 
}
function colors() {
    $dizi = explode("\n","Primary
Primary Light
Primary Dark
Primary Darker
Success
Info
Warning
Danger
Gray
Gray Dark
Gray Darker
Black
Elegance
Elegance Light
Elegance Dark
Elegance Darker
Pulse
Pulse Light
Pulse Dark
Pulse Darker
Flat
Flat Light
Flat Dark
Flat Darker
Corporate
Corporate Light
Corporate Dark
Corporate Darker
Earth
Earth Light
Earth Dark
Earth Darker
Aqua
Cherry
Dusk
Emerald
Lake
Leaf
Sea
Sun");
    $dizi = array_map("str_slug",$dizi);
    return $dizi;
}

function bootstrap() {
     ?>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script>
$(function(){
$(".select2").select2();
});
</script>
     <?php 
}
function slug_to_title($slug) {
    $sorgu = db("contents")->where("slug",$slug)->first("title");
    if($sorgu) {
        return $sorgu->title;
    } else {
        return $slug;
    }
    
}


function encoder($icerik) {
   // $icerik = utf8_encode($icerik);
    $icerik = strtr($icerik, array(
		'â€¢' => '•',
		'â€œ' => '“',
		'â€' => '”',
		'â€˜' => '‘',
		'â€™' => '’',
		'Ý¾' => 'İ',
		'Ý' => 'İ',
		'Ä°' => 'İ',
		'Ã' => 'İ',
		'â€¹' => 'İ',
		'&Yacute;' => 'İ',
		'ý' => 'ı',
		'Ä±' => 'ı',
		'Â±' => 'ı',
		'Ã½' => 'ı',
		'Ã›' => 'ı',
		'â€º' => 'ı',
		'&yacute;' => 'ı',
		'Þ' => 'Ş',
		'Åž' => 'Ş',
		'Ã…Å¸' => 'Ş',
		'Ã¥Ã¿' => 'Ş',
		'&THORN;' => 'Ş',
		'þ' => 'ş',
		'Å?' => 'ş',
		'ÅŸ' => 'ş',
		'&thorn;' => 'ş',
		'Ð' => 'Ğ',
		'Äž' => 'Ğ',
		'ð' => 'ğ',
		'Ä?' => 'ğ',
		'ÄŸ' => 'ğ',
		'&eth;' => 'ğ',
		'Ã‡' => 'Ç',
		'Ã?' => 'Ç',
		'&Ccedil;' => 'Ç',
        'Ã§' => 'ç',
		'&ccedil;' => 'ç',
		'Ã–' => 'Ö',
		'&Ouml;' => 'Ö',
		'Ã¶' => 'ö',
		'&ouml;' => 'ö',
		'Ãœ' => 'Ü',
		'&Uuml;' => 'Ü',
		'ÃƒÂ¼' => 'ü',
		'Ã£Â¼' => 'ü',
		'Ã¼' => 'ü',
        '&uuml;' => 'ü',
	));
    return $icerik;
}
function trk($icerik) {
//  $icerik =  iconv("ISO-8859-1", "UTF-8//TRANSLIT", $icerik);
 $encode = mb_detect_encoding($icerik);
 //echo $encode;
 //  $icerik =   mb_convert_encoding($icerik, "windows-1254", $encode);
  $icerik =   @iconv('windows-1254','UTF-8',$icerik);
   $icerik = encoder($icerik);
    return $icerik;
}

function zf($d2){
$d1 = date('Y-m-d H:i:s');
//$d1= date('Y-m-d H:i:s', strtotime($d1. "$zaman_dilimi hour"));
//e($d1);
    if(!is_int($d1)) $d1=strtotime($d1);
    if(!is_int($d2)) $d2=strtotime($d2);
    $d=abs($d1-$d2);
if ($d1-$d2<0) {
$ifade = "sonra";
} else {
$ifade = "önce";
}

$once = " "; 
    if($d>=(60*60*24*365))    $sonuc  = $once . floor($d/(60*60*24*365)) . " yıl $ifade";
    else if($d>=(60*60*24*30))     $sonuc = $once . floor($d/(60*60*24*30)) . " ay $ifade";
    else if($d>=(60*60*24*7))  $sonuc  = $once . floor($d/(60*60*24*7)) . " hafta $ifade";
    else if($d>=(60*60*24))    $sonuc  = $once . floor($d/(60*60*24)) . " gün $ifade";
    else if($d>=(60*60))   $sonuc = $once . floor($d/(60*60)) . " saat $ifade";
    else if($d>=60) $sonuc  = $once . floor($d/60)  . " dakika $ifade";
    else $sonuc = "Az $ifade";

    return $sonuc;
}
function cfg($slug) {
    $c = db("contents")
    ->Where("kid","configuration-".$slug)
    ->get();
    $cikti = array();
    foreach($c AS $s) {
        array_push($cikti,$s->title);
    }
    return $cikti;
}

function logo($size="128",$style="") {
     ?>
     <img src="<?php echo url("assets/logo.svg") ?>" width="<?php echo $size ?>" style="    width: <?php echo $size ?>px;<?php echo $style ?>" alt="">
     <?php 
}
function center_logo() {
    logo("128","display:block;margin:0 auto;");
}
function navbar($title="") {
     ?>
     <!-- Top Navbar -->
<div class="navbar">
  <div class="navbar-bg"></div>
  <div class="navbar-inner">
    <div class="title">
        <!--
        <a href="./" class="back icon-only">
        <i class="f7-icons">arrow_left_circle_fill</i>
        </a>
-->
        <img src="<?php echo url("assets/icon.svg") ?>" width="48" style="    width: 40px;
vertical-align: middle" alt="">
       <?php echo $title ?>
    </div>
  </div>
</div>
     <?php 
}
function mailtemp($mail,$name,$data="") {
    $temp = db("contents")->where("title",$name)->first();
    $html = $temp->html;
    $subject = $temp->title2;
    if(is_array($data)) {
        foreach($data AS $a => $d) {
            $html = str_replace("{".$a."}",$d,$html);
            $subject = str_replace("{".$a."}",$d,$subject);
        }
    }
    
    @mailsend($mail,$subject,$html);
}

function total($tablo,$col,$val) {
    $sorgu = db($tablo)->where($col,$val)->get($col);
    return count($sorgu);
}
function variable($title) {
    $s = db("contents")->where("title",$title)->first();
    return $s->html;
}
function df($date,$format="d.m.Y H:i") {
    return date($format,strtotime($date));
}
function mailsend($to="",$subject="",$html="") {
    //VBgDMfu6L5kksh noreply@truncgil.com
    
    $data = array(
        'html'=>$html,
        "subject" => $subject,
        "to" => $to 
    );
    $title = "Pelinom";
    try {
        Mail::send("mail-template", $data, function($message) use($to, $subject,$title){
        
            $message->from("noreply@truncgil.com", $title);
            $message->to($to);
            $message->subject($subject);
        });
    } catch (\Throwable $th) {
        //throw $th;
    }

    
}

function alert($text,$type="success") {
     ?>
    <script>
    
        window.setTimeout(function(){
            var notification  = app.notification.create({
            // icon: '',
                title: 'Pelinom',
           //     titleRightText: 'Şimdi',
                subtitle: '<?php e2($text) ?>',
                text: 'Kapat',
                closeOnClick: true,
            });
            notification.open();
        },500);
  
    </script>
     <?php 
}

function iptolocation() {
    $j = file_get_contents("http://ip-api.com/json/{$_SERVER['REMOTE_ADDR']}");
    $j = json_decode($j);
    if($j->country == "United States") {
        $j->country = "USA";
    }
    return $j;
    
}
function ed($text,$elsetext) {
    if($text=="") return $elsetext;
    else return $text;
}
function sales_status($y="") {
    if($y=="") {
        return explode(",","Under Negotiate,Due to Payment,Payment Complete,Booking,Shipment,Sold");
    }
    
}

function status_color($y) {
    $color = array("danger","warning","success");
    return $color[$y];
}
function languages() {
    $diller = explode(",","en,tr");
    return $diller;
}
function picture($f,$type="large") {
    $f =  str_replace("storage/app/files/","",$f);
    $f = url("cache/$type/".$f);
    return $f;
}
function picture2($f,$size,$storage=1) {
    if($storage==1) {
        $f = "storage/app/files/$f";
    }    
    $f = url("r.php?p=$f&w=$size");
    return $f;
}
function price($price,$type="¥") {
    $price = str_replace(",","",$price);
    $price = str_replace(".","",$price);
    $price = str_replace("$","",$price);
    $price = str_replace(" ","",$price);
  //  echo $price;
    $price = @number_format($price, 0, ',', '.');
    return "$type $price";
}
function nf($price,$type="KG") {
    /*
    $price = str_replace(",","",$price);
    $price = str_replace(".","",$price);
    $price = str_replace("$","",$price);
    $price = str_replace(" ","",$price);
    */
  //  echo $price;
    $price = @number_format($price, 2, ',', '.');
    return "$price $type";
}

function clean_price($price) {
    $price = str_replace(",","",$price);
    $price = str_replace(".","",$price);
    $price = str_replace("$","",$price);
    $price = str_replace("¥","",$price);
    $price = str_replace("€","",$price);
    $price = str_replace(" ","",$price);
  //  echo $price;
 //   $price = @number_format($price, 0, ',', '.');
    return (float) $price;
}


function price2($price,$type="¥") {
    //$price = str_replace(".","",$price);
    $price = @number_format($price, 0, ',', '.');
    return "$type $price";
}
function mile($mile,$type="KM") {
    $type = strtoupper($type);
    $mile = str_replace(".","",$mile);
    $mile = @number_format($mile, 0, ',', '.');
    return "$mile $type";
}
function currency() {
    return explode(",","Dolar,Euro");
}

function simdi() {
    return date("Y-m-d H:i:s");
}
function fob($price) {
    $fob = str_replace("$ ","",$price);
	$fob = str_replace(",","",$fob);
	return $fob;
}
function curr($type) {
    $kur = cfg3("currency-settings");
    return $kur[$type];
}

function cfg2($slug) {
    $c = db("contents")
    ->Where("kid","configuration-".$slug)
    ->get();
    $cikti = array();
    foreach($c AS $s) {
        array_push($cikti,$s);
    }
    return $cikti;
}
function cfg3($slug)
{

    $c = Contents::where("slug", $slug)->orWhere("type", $slug)->orderBy("id","DESC")->first();
    if($c) {
        $c = json_decode($c->json,true);
    } else {
        $c = array();
    }
    
    return $c;
}
function pic($pic,$type) {
    $pic = str_replace("storage/app/files/","",$pic); 
    return url("cache/$type/$pic");
}
function product($c) {
    //bu fonk. bir ürün blok tasarımını örnekler
     ?>
       <div class="card">
        <img class="card-img" src="https://s3.eu-central-1.amazonaws.com/bootstrapbaymisc/blog/24_days_bootstrap/vans.png" alt="Vans">
        <div class="card-img-overlay d-flex justify-content-end">
          <a href="#" class="card-link text-danger like">
            <i class="fas fa-heart"></i>
          </a>
        </div>
        <div class="card-body">
          <h4 class="card-title">{title}</h4>
          <h6 class="card-subtitle mb-2 text-muted">Style: VA33TXRJ5</h6>
          <p class="card-text">
            The Vans All-Weather MTE Collection features footwear and apparel designed to withstand the elements whilst still looking cool.             </p>
          <div class="options d-flex flex-fill">
             <select class="custom-select mr-1">
                <option selected>Color</option>
                <option value="1">Green</option>
                <option value="2">Blue</option>
                <option value="3">Red</option>
            </select>
            <select class="custom-select ml-1">
                <option selected>Size</option>
                <option value="1">41</option>
                <option value="2">42</option>
                <option value="3">43</option>
            </select>
          </div>
          <div class="buy d-flex justify-content-between align-items-center">
            <div class="price text-success"><h5 class="mt-4">$125</h5></div>
             <a href="#" class="btn btn-danger mt-3"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
          </div>
        </div>
      </div>
     <?php 
}



function number($str)
{
    $str = str_replace(",", ".", $str);
    $str = floatval($str);
    return $str;
}

function map($title)
{
    $sorgu = db("contents")->where("kid", "configuration-planning-column-mapping")
        ->where("title", $title)
        ->first();
    if ($sorgu) {
        if ($sorgu->title2 != "") {
            return $sorgu->title2;
        } else {
            return $title;
        }
    } else {
        return $title;
    }

}

function is_json($string)
{
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

function whereJ($db, $col, $isaret, $val, $fonk = "")
{
    $db = $db->whereRaw("$fonk(JSON_UNQUOTE(json_extract(json, '$.\"$col\"'))) $isaret $val");
    return $db;
}

function orWhereJ($db, $col, $isaret, $val, $fonk = "")
{
    $db = $db->orWhereRaw("$fonk(JSON_UNQUOTE(json_extract(json, '$.\"$col\"'))) $isaret $val");
    return $db;
}
function tirnakli($text) {
    return "'$text'";
}
function chartsByData($db,$labelGroup,$title="",$type="bar",$colorItem="1",$columnSize="col-md-6") {
    $array = array();
    $db = db($db)->get();
    foreach($db AS $d) {
        if($labelGroup=="date") {
            $label = date("d.m.Y",strtotime($d->created_at));
        } else {
            $label = $d->{$labelGroup};
        }
        if(!isset($array[$label])) $array[$label] = 0;
        $array[$label]++;
    }       
    $values = implode(",",$array);
    $labels =  implode_key(",",$array);
     ?>
     <div class="<?php echo $columnSize ?>">
        <div class="block block-themed">
            <div class="block-header bg-<?php echo colors()[$colorItem]; ?>">
                <div class="block-title">
                    <span><?php echo $title ?></span>
                </div>
                <div class="block-options">
                   <?php echo $db->count() ?>
                </div>
            </div>
            <div class="block-content">
            <?php 
                    charts($labels,$values,$title,$type);
                ?>
            </div>
        </div>
     </div>
     <?php 
}
function charts($labels,$values,$title="",$type="doughnut",$height="400") {
    $id = rand();
    $opacity = 1;
    $labels = explode(",",$labels);
    $labels = array_map('tirnakli', $labels);
    $labels = implode(",",$labels);
     ?>
<canvas id="truncgil<?php echo $id ?>" class="truncgil-chart"  style="width:<?php echo $height; ?>px !important;height:<?php echo $height; ?>px !important;max-height:<?php echo $height; ?>px !important" ></canvas>
<script>
var ctx = document.getElementById('truncgil<?php echo $id ?>');
var myChart = new Chart(ctx, {
    type: '<?php echo $type ?>',
    data: {
        labels: [<?php echo $labels ?>],
        datasets: [{
            label: '<?php echo $title ?>',
            data: [<?php echo $values ?>],
            backgroundColor: [
                'rgba(54, 162, 235, <?php echo $opacity ?>)',
                'rgba(255, 99, 132, <?php echo $opacity ?>)',
                'rgba(255, 206, 86, <?php echo $opacity ?>)',
                'rgba(75, 192, 192, <?php echo $opacity ?>)',
                'rgba(153, 102, 255, <?php echo $opacity ?>)',
                'rgba(255, 159, 64, <?php echo $opacity ?>)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
            display: false
            }
        }
    }
});
</script>
     <?php 
}
function charts2($labels,$values,$title="",$type="doughnut",$height="400") {
    $id = rand();
    $opacity = 1;
    $labels = explode(",",$labels);
    $labels = array_map('tirnakli', $labels);
    $labels = implode(",",$labels);
     ?>
<canvas id="truncgil<?php echo $id ?>" class="truncgil-chart"  style="width:<?php echo $height; ?>px !important;height:<?php echo $height; ?>px !important;max-height:<?php echo $height; ?>px !important" ></canvas>
<script>
var ctx = document.getElementById('truncgil<?php echo $id ?>');
var myChart = new Chart(ctx, {
    type: '<?php echo $type ?>',
    data: {
        labels: [<?php echo $labels ?>],
        datasets: [{
            
            label: '<?php echo $title ?>',
            data: [<?php echo $values ?>],
            backgroundColor: [
                'rgba(54, 162, 235, <?php echo $opacity ?>)',
                'rgba(255, 99, 132, <?php echo $opacity ?>)',
                'rgba(255, 206, 86, <?php echo $opacity ?>)',
                'rgba(75, 192, 192, <?php echo $opacity ?>)',
                'rgba(153, 102, 255, <?php echo $opacity ?>)',
                'rgba(255, 159, 64, <?php echo $opacity ?>)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            },
            x: [{
            gridLines: {
                display:false
            }
            }],
            y: [{
                gridLines: {
                    display:false
                }   
            }]
        },
        plugins: {
            legend: {
            display: false
            }
        }
    }
});
</script>
     <?php 
}
function chart($type, $col, $val)
{
    $id = rand(111, 999);
    ?>

    <canvas id="chart-area<?php echo $id ?>"></canvas>

    <script>


        var config<?php echo $id ?> = {
            type: '<?php echo $type ?>',
            data: {
                datasets: [{
                    data: [
                        <?php echo $val; ?>
                    ],
                    backgroundColor: [
                        window.chartColors.red,
                        window.chartColors.orange,
                        window.chartColors.yellow,
                        window.chartColors.green,
                        window.chartColors.blue,
                    ],
                    label: 'Dataset <?php echo $id ?>'
                }],
                labels: [
                    <?php echo $col; ?>
                ]
            },
            options: {
                responsive: false
            }
        };

        window.onload = function () {
            var ctx<?php echo $id ?> = document.getElementById('chart-area<?php echo $id ?>').getContext('2d');
            window.test<?php echo $id ?> = new Chart(ctx<?php echo $id ?>, config<?php echo $id ?>);
        };


    </script>

    <?php
}
function tak_list() {
    $tak_harf = explode(",","A,B,C,D");
    $tak_sayi = 6;
    $dizi = array();
    foreach($tak_harf AS $t) {
        for($z=1;$z<=$tak_sayi;$z++) {
            array_push($dizi,$t.$z);
        }
    }
    return $dizi;
}
function upload($file, $folder = "")
{
    $request = \Request::all();

    $ext = $request[$file]->getClientOriginalExtension();
    $name = str_slug($request[$file]->getClientOriginalName());
    $path = $request[$file]->storeAs("files/$folder", $name);
    return "storage/app/$path";
}
function upload2($file, $folder = "") 
{
    $u = u();
    $dizin = str_slug($u->name." ". $u->surname);
    $request = \Request::all();
    @mkdir("storage/app/$dizin/$folder",true);
    $ext = $request[$file]->getClientOriginalExtension();
    $name = str_slug($request[$file]->getClientOriginalName());
    $path = $request[$file]->storeAs("files/$dizin/$folder", $name.".".$ext);
    return "storage/app/$path";
}
function file_get_contents_utf8($fn) {
    $content = file_get_contents($fn);
     return iconv("ISO-8859-1","UTF-8",$content);
}
function correct_encoding($text) {
    $current_encoding = mb_detect_encoding($text, 'auto');
    $text = iconv($current_encoding, 'UTF-8', $text);
    return $text;
}

function varmi($dizi)
{
    if (count($dizi) > 0) {
        return true;
    } else {
        return false;
    }
}
function vehicles() {
    $s = db("vehicles");
    $s = $s->where("y","1");
    $s = $s->take(10);
    return $s;
}

function slugtotitle($slug)
{
    $slug = str_replace("-", " ", $slug);
    $slug = ucwords($slug);
    return $slug;
}

function seri()
{
    ?>
    <script type="text/javascript">
        $(function () {

            $(".seri").on("submit", function (e) {
                var buton = $(".seri button");
                var ajax_alan = $(this).attr("ajax");
                if (ajax_alan == undefined) {
                    ajax_alan = ".seri_ajax";
                }
                var yazi = buton.html();
                var data = $(this).serialize();
                buton.prop("disabled", "disabled");
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: $(this).attr("action"),
                    type: "POST",
                    cache: false,
                    processData: false,  // tell jQuery not to process the data
                    contentType: false,  // tell jQuery not to set contentType
                    data: formData,
                    success: function (d) {
                        buton.removeAttr("disabled");
                        $(ajax_alan).html(d);


                    }
                });
                return false;
            });
        });
    </script>
    <?php
}

function sf($id, $ajax = ".ajax", $html = "")
{
    $ajax = "$id $ajax";
    ?>
    <script type="text/javascript">
        $(function () {
            $("<?php echo $id ?>").on("submit", function () {
                var form = $("<?php echo $id ?>");
                var data = form.serialize();
                $(this).children("button").html("<?php e2("İşlem başarılı") ?>");
                $.ajax({
                    type: "POST",
                    url: form.attr("action"),
                    data: data,
                    dataType: "json",
                    success: function (data) {
                        <?php if($html == "") { ?>
                        $("<?php echo $ajax ?>").html(d);
                        <?php } else { ?>
                        $("<?php echo $ajax ?>").html("<?php echo($html) ?>");
                        <?php } ?>
                        $("<?php echo $id ?> button").html("<?php e2("İşlem başarılı") ?>");
                    }
                });
                return false;
            });
        });
    </script>
    <?php
}
 
function c($slug)
{
    $c = Contents::where("slug", $slug)->orWhere("id", $slug)->first();
    return $c;
}


function contents($type)
{
    return db("contents")
        ->where("kid", $type)
        ->orWhere("type", $type)
//		->orWhere("title",$type)
        ->get();
}
function contents2($type)
{
    return db("contents")
        ->where("kid", $type)
        ->orWhere("type", $type);
//		->orWhere("title",$type)
       
}

function kd()
{
    return 0;
}

function user() {
    global $_SESSION;
    oturumAc();
    if(oturumisset("uid")) {
        $u = (Array) db("users")->where("id",oturum("uid"))->first();
        unset($u['id']);
        unset($u['password']);
        unset($u['password_hash']);
        unset($u['recover']);
        unset($u['remember_token']);
        unset($u['permissions']);
        unset($u['created_at']);
        unset($u['updated_at']);
        return $u;
    } else {
        return false;
    }
    
}
function usersArray() {
    $users = db("users")
    ->get();
    $users = dbArray($users,"id");
    return $users;
}
function users($level)
{
    return User::where("level", $level)->get();
}

function who($uid)
{
    return User::where("id", $uid)->first();
}

function ksorgu()
{
    return 0;
}

function e2($text)
{
    echo __($text);
}

function set($text)
{
    echo __($text);
}

function set_return($text)
{
    return __($text);
}
function permission() {
    oturumAc();

    if(!oturumisset("uid"))  {
       
        echo("Bu sayfayı görmek için yetkiniz bulunmamaktadır");
        exit();
    }
}

function u()
{   
    oturumAc();
    if(Auth::check()) {
        $u = Auth::user();
        $alias = alias_to_ids($u->alias);
        $u['alias_ids'] = $alias;
        return $u;
    } elseif(oturumisset("uid")) {
        $uid = db("users")->where("id",oturum("uid"))->first();
        
        return $uid;
    }
    
}

function u2($id)
{   
   
        $uid = db("users")->where("id",$id)->first();
        return $uid;
    
    
}

function alias_to_ids($alias) { //aynı etki alanına sahip kullanıcıların id listesini döndürür.
    $sorgu = db("users")->where("alias",$alias)->get();
    $ids = array();
    foreach($sorgu AS $s) {
        array_push($ids,$s->id);
    }
    return $ids;
}
function ekle($dizi, $tablo = "contents")
{
    oturumAc();
    $uid = "";
    if(isset(u()->id)) {
        $uid = u()->id;
    }
    
    if($uid=="") $uid = oturum("uid");
    $dizi['created_at'] = date("Y-m-d H:i:s");
    $dizi['uid'] = $uid;
    if($dizi['uid']=="") unset($dizi['uid']);
	//print_r($dizi);
    return DB::table($tablo)->insertGetId($dizi);
}
function ekle2($dizi, $tablo = "contents") //uid siz ekleme yapar
{
    oturumAc();
    $dizi['created_at'] = date("Y-m-d H:i:s");
   // $dizi['uid'] = "";
    return DB::table($tablo)->insertGetId($dizi);
}
function login() {
    oturumAc();
    global $_SESSION;
    if(oturumisset("uid")) {
        return true;
    } else {
        return false;
    }
}

function kripto($text) {
    return Hash::make($text);
}
function guncelle($dizi, $tablo = "contents")
{
    oturumAc();
    $dizi['updated_at'] = date("Y-m-d H:i:s");
    $dizi['uid'] = u()->id;
//	print_r($dizi);
    return DB::table($tablo)->update($dizi);
}

function dbFirst($tablo, $id)
{
    return $s = DB::table($tablo)->where("id", $id)->first();
}

function db($tablo)
{

    $s = DB::table($tablo);
    return $s;
}
function db2($tablo)
{
    $u = u();
 //   $alias_id = implode(",",$u->alias_ids);

    $s = DB::table($tablo)->whereIn("uid",$u->alias_ids);
    return $s;
}

function sorgu($tablo, $where = "", $order = "")
{
    $s = DB::table($tablo);
    if (strpos("%", $where) !== false) {
        $s = $s->where("json", "like", "$where");
    } else {
        if ($where != "") {
            $where = explode(",", $where);
            foreach ($where as $w) {
                $w2 = explode("=", $w);
                if (count($w2) > 1) {
                    $s = $s->whereJsonContains("json->" . $w2[0], $w2[1]);
                }
                $w2 = explode("%", $w);
                if (count($w2) > 1) {
                    $s = $s->where("json", "like", $w2[1]);
                }

            }
        }
    }
    if ($order != "") $s = $s->orderByRaw($order);
    $cache = array();
    $sorgu = $s->simplePaginate(15);
    $col = array();
    $row = array();
    $cache['col'] = array();
    $cache['row'] = array();
    $cache['links'] = "";
    if (count($sorgu) > 0) {

        foreach ($sorgu as $s) {
            $j = json_decode($s->json);
            $j->id = $s->id;
            $j->Create_Date = $s->created_at;
            unset($j->_token);
            array_push($cache, $j);
        }
        foreach ($cache as $a => $d) {
            array_push($row, $d);
        }
        foreach ($cache[0] as $a => $d) {
            array_push($col, str_replace("_", " ", $a));
        }
        $cache['col'] = $col;
        $cache['row'] = $row;
        $cache['row'] = array_filter($cache['row']);
        $cache['links'] = $sorgu->links();
        $cache['table'] = $tablo;
    }

    return $cache;
}
function dbArray($db,$key) {
    $dizi = array();
    foreach($db AS $d) {
  
        $dizi[$d->$key] = $d;
    }
    return $dizi;
}
function table_to_array($table,$key="id") {
    $dizi = array();
    $db = db($table)->get();
    foreach($db AS $d) {
  
        $dizi[$d->$key] = $d;
    }
    return $dizi;
}
function table_to_array2($table,$key="id") {
    $dizi = array();
    if($table=="users") {
        $db = db($table)->where("alias",u()->alias)->get();
    } else {
        $db = db2($table)->get();
    }
    
    foreach($db AS $d) {
  
        $dizi[$d->$key] = $d;
    }
    return $dizi;
}
function contents_to_array($type,$key="id") {
    $dizi = array();
   
    $db = db("contents")->where("type",$type)
    ->whereNotNull("title")
    ->get();
   
    
    foreach($db AS $d) {
  
        $dizi[$d->$key] = $d;
    }
    return $dizi;
}
function dbJson($db, $tablo = "")
{ //db oluşturulmuş bir sorguyu json cache çıktısını verir.

    $cache = array();
    $sorgu = $db;
    $col = array();
    $row = array();
    $cache['col'] = array();
    $cache['row'] = array();
    $cache['links'] = "";
    if (count($sorgu) > 0) {

        foreach ($sorgu as $s) {
            $j = json_decode($s->json);
            $j->id = $s->id;
            $j->Create_Date = $s->created_at;
            unset($j->_token);
            array_push($cache, $j);
        }
        foreach ($cache as $a => $d) {
            array_push($row, $d);
        }
        foreach ($cache[0] as $a => $d) {
            array_push($col, str_replace("_", " ", $a));
        }
        $cache['col'] = $col;
        $cache['row'] = $row;
        $cache['row'] = array_filter($cache['row']);
        $cache['links'] = $sorgu->links();
        $cache['table'] = $tablo;
    }

    return $cache;
}


function bilgi($text,$type="success")
{
    ?>
    <div class="alert alert-<?php echo $type ?>"><?php echo __($text); ?></div>
    <?php
}

function showMessage($text, $message_type)
{
    switch ($message_type) {
        case MessageType::Success:
            ?>
            <div class="alert alert-success"><?php echo __($text); ?></div>
            <?php
            break;
        case MessageType::Error:
            ?>
            <div class="alert alert-danger"><?php echo __($text); ?></div>
            <?php
            break;
    }
}

function json_encode_tr($string)
{
    return json_encode($string, JSON_UNESCAPED_UNICODE);
}

function j($json, $true = true)
{
    return json_decode($json, $true);
}

function get($isim)
{
    if (isset($_GET[$isim])) {
        return $_GET[$isim];
    } else {
        return "";
    }
}

function yonlendir($url)
{
    header("Location: $url");
    exit();
}

function getisset($isim)
{
    if (isset($_GET[$isim])) {
        return 1;
    } else {
        return 0;
    }
}

function postEsit($post, $deger)
{
    $post = post($post);
    if ($post == $deger) {
        return 1;
    } else {
        return 0;
    }
}

function oturumEsit($oturum, $deger)
{
    $oturum = oturum($oturum);
    if ($oturum == $deger) {
        return 1;
    } else {
        return 0;
    }
}

function getEsit($get, $deger)
{
    $get = get($get);
    if ($get == $deger) {
        return 1;
    } else {
        return 0;
    }
}

function post($isim, $deger = "")
{
    if ($deger != "") {
        $_POST[$isim] = $deger;
    } else {
        if (isset($_POST[$isim])) {
            return @trim($_POST[$isim]);
        } else {
            return "";
        }
    }
}

function postisset($isim)
{
    if (isset($_POST[$isim])) {
        return 1;
    } else {
        return 0;
    }
}

function oturum($isim, $deger = "")
{
    oturumAc();
    if (isset($_SESSION[$isim])) {
        if ($deger == "") {
            return $_SESSION[$isim];
        } else {
            $_SESSION[$isim] = $deger;
            return $_SESSION[$isim];
        }
    } elseif ($deger != "") {
        $_SESSION[$isim] = $deger;
        return $_SESSION[$isim];

    }
}

function oturumisset($isim)
{
    oturumAc();
    if (isset($_SESSION[$isim])) {
        return 1;
    } else {
        return 0;
    }
}

function oturumAc($sonuc = "")
{
    if (!isset($_SESSION)) {
        session_start();
        echo $sonuc;
    }
}

function diger_ayarlar()
{
    return explode(",", "users,languages,contents,new,fields,search,ALL PRIVILEGES");

}

function fields()
{
    $fields = Fields::get();
    $fields = json_decode($fields, true);
    $fields2 = array();
    foreach (@$fields as $r) {
        if (in_array($r['title'], $content_type)) {
            $fields2[$r['title']] = array(
                "values" => explode(",", $r['values']),
                "type" => $r['input_type']
            );
        }

    }
    $fields = $fields2;
    /*
        if(isset($ct->fields)) {
            $content_fields = explode(",",$ct->fields); // içerik alanları
        }
    */
    return $fields;
}

function json_field($json, $field)
{ //bir json içinde girilmiş alanı bulur bu aslında post ederken boşluk içeren alanlarda otomatik oluşan _ karakteri sorunundan dolayı üretildi
    return @$json[str_replace(" ", "_", $field)];

}

function validBase64($string)
{
    $decoded = base64_decode($string, true);

    // Check if there is no invalid character in string
    if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $string)) return false;

    // Decode the string in strict mode and send the response
    if (!base64_decode($string, true)) return false;

    // Encode and compare it to original one
    if (base64_encode($decoded) != $string) return false;

    return true;
}

function isJSON($string)
{
    return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
}

function getLangFile($lang)
{
    $path = "resources/lang/$lang" . ".json";
    if (file_exists($path)) {
        return file_get_contents($path);
    } else {
        $json = json_encode(array());
        file_put_contents($path, $json);
        return file_get_contents($path);
    }
}

function putLangFile($lang, $json)
{
    if (isJSON($json)) {
        return file_put_contents("resources/lang/$lang" . ".json", $json);
    } else {
        return null;
    }
}

function is_html($string)
{
    return preg_match("/<[^<]+>/", $string, $m) != 0;
}


function print2($array) {
     ?>
     <pre>
     <?php print_r($array); ?>
     </pre>
     <?php 
}
