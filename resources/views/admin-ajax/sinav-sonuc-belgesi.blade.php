<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KONU ANALİZLİ SINAV SONUÇ; BELGESİ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <style>
        * {
            font-size: 10px;
        }
        .konular * {
            font-size:8px;
            
        }
        .konular td,.konular th {
            
            padding:0px !important;
            margin:0px !important;
            text-align:center;
        }
        .konular {
            margin:0px;
        }
        .konular .konu_title {
            white-space:nowrap;
            text-overflow:ellipsis;
            overflow:hidden;
            width:200px;
            margin:0 auto;
        }
        .konular .col-6 {
            padding:0px;
        }
    </style>
</head>

<body>
<?php $logo = url("assets/img/logo.svg"); 
$sonuc = db2("sonuclar")->where("id",get("id"))->first();
$analiz = j($sonuc->analiz);
$key = $sonuc->tc_kimlik_no;
if($key=="") $key = $sonuc->ogrenci_adi;


$tyt_sube_katilimci=0;
$tyt_okul_katilimci=0;
$yks_sube_katilimci=0;
$yks_okul_katilimci=0;
$tyt_sube_ortalama=0;
$tyt_okul_ortalama=0;
$yks_sube_ortalama=0;
$yks_okul_ortalama=0;
$yks_say_sube_katilimci = 0;
$yks_say_sube_ortalama = 0;
$yks_say_sube_katilimci = 0;
$yks_say_okul_ortalama  = 0;
 $yks_say_okul_katilimci  = 0;

if(!$sonuc) {

    die("Bu bölümü görme yetkiniz yok ya da böyle bir sonuç yok");
} ?>
    <div class="container">
        <table border="0" cellpadding="1" cellspacing="1" style="width:100%">
            <tbody>
                <tr>
                    <td style="text-align:center"><img src="{{$logo}}" width="300" style="margin:10px 0;" alt=""></td>
                    <td style="text-align:center">
                        <h1>{{e2("KONU ANALİZLİ SINAV SONUÇ BELGESİ")}}</h1>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-bordered table-striped">
            <tr>
                <td><strong>{{e2("Öğrenci Adı")}}</strong></td>
                <td>{{$sonuc->ogrenci_adi}}</td>
                <td><strong>{{e2("Numara")}}</strong></td>
                <td>{{$sonuc->tc_kimlik_no}}</td>
                <td><strong>{{e2("Şube")}}</strong></td>
                <td></td>
                <td><strong>{{e2("Okul")}}</strong></td>
                <td colspan="3" rowspan="1"></td>
            </tr>
            <tr>
                    <td><strong>{{e2("Sınav Adı")}}</strong></td>
                    <td>{{$sonuc->title}}</td>
                    <td><strong>{{e2("Alan")}}</strong></td>
                    <td></td>
                    <td><strong>{{e2("Sınav Tarihi")}}</strong></td>
                    <td>{{$sonuc->created_at}}</td>
                    <td><strong>{{e2("Kitapcık")}}</strong></td>
                    <td>{{$sonuc->kitapcik}}</td>
                    <td><strong>{{e2("Danışman")}}</strong></td>
                    <td></td>
                </tr>
        </table>

        <table class="table table-bordered table-striped konular" style="width:100%">
            <tbody>
                
                
                <tr>
                    <td style="text-align:center"><strong>{{e2("DERSLER")}}</strong></td>
                    <td style="text-align:center"><strong>{{e2("Soru Sayısı")}}</strong></td>
                    <td style="text-align:center"><strong>{{e2("Doğru")}}</strong></td>
                    <td style="text-align:center"><strong>{{e2("Yanlış")}}</strong></td>
                    <td style="text-align:center"><strong>{{e2("Boş")}}</strong></td>
                    <td style="text-align:center"><strong>{{e2("Net")}}</strong></td>
                    <td  style="text-align:center"><strong>{{e2("Başarı %")}}</strong></td>
                    <td colspan="4"   style="text-align:center"><strong>{{e2("Cevaplar")}}</strong></td>
                </tr>

            </tbody>
            <?php foreach($analiz AS $a => $d) { 
                $soru_sayisi = $d['dogru'] + $d['yanlis'] + $d['bos'];
                $net = $d['dogru'] - $d['yanlis'] / 4;
                ?>
            <tr>
                <td>{{slug_to_title($a)}}</td>
                <td>{{$soru_sayisi}}</td>
                <td>{{$d['dogru']}}</td>
                <td>{{$d['dogru']}}</td>
                <td>{{$d['bos']}}</td>
                <td>{{$net}}</td>
                <td></td>
                <td colspan="4" >{{$d['cevaplar']}}</td>
            </tr>
            <?php } ?>
        </table>

   
        <table border="0" cellpadding="1" cellspacing="1" style="width:100%;margin:10px 0;" class="text-center table table-bordered  konular">
            <tbody>
                <tr>
                    <td rowspan="4" style="text-align:center">TYT<br />
                        {{$sonuc->tyt}}</td>
                    <td style="text-align:center">&nbsp;</td>
                    <td style="text-align:center">{{e2("Şube")}}</td>
                    <td style="text-align:center">{{e2("Okul")}}</td>
                    <td rowspan="4" style="text-align:center">YKS-EA</td>
                    <td rowspan="1" style="text-align:center">{{$sonuc->yks_ea}}</td>
                    <td rowspan="1" style="text-align:center">{{e2("Şube")}}</td>
                    <td rowspan="1" style="text-align:center">{{e2("Okul")}}</td>
                </tr>
                <tr>
                    <td style="text-align:center">{{e2("Katılımcı Sayısı")}}</td>
                    <td style="text-align:center">{{$tyt_sube_katilimci}}</td>
                    <td style="text-align:center">{{$tyt_okul_katilimci}}</td>
                    <td style="text-align:center">Katılımcı Sayısı</td>
                    <td style="text-align:center">{{$yks_sube_katilimci}}</td>
                    <td style="text-align:center">{{$yks_okul_katilimci}}</td>
                </tr>
                <tr>
                    <td style="text-align:center">Ortalama</td>
                    <td style="text-align:center">{{$tyt_sube_ortalama}}</td>
                    <td style="text-align:center">{{$tyt_okul_ortalama}}</td>
                    <td style="text-align:center">Ortalama</td>
                    <td style="text-align:center">{{$yks_sube_ortalama}}</td>
                    <td style="text-align:center">{{$yks_okul_ortalama}}</td>
                </tr>
                <tr>
                    <td style="text-align:center">Derece</td>
                    <td style="text-align:center">&nbsp;</td>
                    <td style="text-align:center">&nbsp;</td>
                    <td style="text-align:center">Derece</td>
                    <td style="text-align:center">&nbsp;</td>
                    <td style="text-align:center">&nbsp;</td>
                </tr>
           
                <tr>
                    <td rowspan="4" style="text-align:center">YKS-SAY<br />
                    <strong>{{$sonuc->yks_say}}</strong></td>
                    <td style="text-align:center"></td>
                    <td style="text-align:center">Şube</td>
                    <td style="text-align:center">Okul</td>
                    <td rowspan="4" style="text-align:center">YKS-S&Ouml;Z
                    <br>
                    <strong>{{$sonuc->yks_soz}}</strong>
                    </td>
                    <td rowspan="1" style="text-align:center"></td>
                    <td rowspan="1" style="text-align:center">Şube</td>
                    <td rowspan="1" style="text-align:center">Okul</td>
                </tr>
                <tr>
                    <td style="text-align:center">Katılımcı Sayısı</td>
                    <td style="text-align:center">{{$yks_say_sube_katilimci}}</td>
                    <td style="text-align:center">{{$yks_say_okul_katilimci}}</td>
                    <td style="text-align:center">Katılımcı Sayısı</td>
                    <td style="text-align:center">{{$yks_say_sube_katilimci}}</td>
                    <td style="text-align:center">{{$yks_say_okul_katilimci}}</td>
                </tr>
                <tr>
                    <td style="text-align:center">Ortalama</td>
                    <td style="text-align:center">{{$yks_say_sube_ortalama}}</td>
                    <td style="text-align:center">{{$yks_say_okul_ortalama}}</td>
                    <td style="text-align:center">Ortalama</td>
                    <td style="text-align:center">{{$yks_say_sube_ortalama}}</td>
                    <td style="text-align:center">{{$yks_say_okul_ortalama}}</td>
                </tr>
                <tr>
                    <td style="text-align:center">Derece</td>
                    <td style="text-align:center">&nbsp;</td>
                    <td style="text-align:center">&nbsp;</td>
                    <td style="text-align:center">Derece</td>
                    <td style="text-align:center">&nbsp;</td>
                    <td style="text-align:center">&nbsp;</td>
                </tr>
            </tbody>
        </table>
        <div class="row d-none">
            <?php 
            $konular = array();
            foreach($analiz AS $a => $d) { 
                $title = slug_to_title($a);
              //  if(isset($d['kazanim-dogru']))
              /*
                if(!isset($konular[$d['kazanim-dogru']]['dogru'])) $konular[$d['kazanim-dogru']]['dogru'] = 0;
                if(!isset($konular[$d['kazanim-yanlis']]['yanlis'])) $konular[$d['kazanim-yanlis']]['yanlis'] = 0;
                if(!isset($konular[$d['kazanim-bos']]['bos'])) $konular[$d['kazanim-bos']]['bos'] = 0;
                */
                foreach($d['kazanim-dogru'] AS $dogru) {
                    if(!isset($konular[$title][$dogru]['dogru']))  $konular[$title][$dogru]['dogru'] = 0;
                    $konular[$title][$dogru]['dogru']++;
                }
                foreach($d['kazanim-yanlis'] AS $yanlis) {
                    if(!isset($konular[$title][$yanlis]['yanlis']))  $konular[$title][$yanlis]['yanlis'] = 0;
                    $konular[$title][$yanlis]['yanlis']++;
                }
                foreach($d['kazanim-bos'] AS $bos) {
                    if(!isset($konular[$title][$bos]['bos']))  $konular[$title][$bos]['bos'] = 0;
                    $konular[$title][$bos]['bos']++;
                }
                ?>
                <div class="col-md-4">
                    <div class="card bg-light mb-3">
                        <div class="card-header">{{$title}}</div>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <td>Doğru</td>
                                    <td>Yanlış</td>
                                    <td>Boş</td>
                                </tr>
                              
                                <tr>
                                    <td>
                                        {{$d['dogru']}} <br>
                                       <?php echo implode("<br>",$d['kazanim-dogru']) ?>
                                       <br>
                                       <?php echo implode("<br>",$d['tak-dogru']) ?>

                                    </td>
                                    <td>
                                        {{$d['yanlis']}} <br>
                                        <?php echo implode("<br>",$d['kazanim-yanlis']) ?> <br>
                                        <?php echo implode("<br>",$d['tak-yanlis']) ?>
                                    </td>
                                    <td>
                                        {{$d['bos']}} <br>
                                        <?php echo implode("<br>",$d['kazanim-bos']) ?> <br>
                                        <?php echo implode("<br>",$d['tak-bos']) ?>
                                        
                                    </td>

                                </tr>
                               
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
     <?php
     
     //print2($konular); 
     /*
     foreach($konular AS $ders_adi => $deger) {
         print2($deger);
     }
     */
     $col1 = array();
     $col2 = array();
     $boyut = count($konular);
     $boyut = round($boyut/2,0);
     $k=0;
     foreach($konular AS $ders_adi => $deger) {
        $col1[$ders_adi] = $deger;
        if($k==$boyut-1) break;
        $k++;
     }
     $k=0;
     foreach($konular AS $ders_adi => $deger) {
         if($k>$boyut-1) {
            $col2[$ders_adi] = $deger;
         }
        
        $k++;
     }
   //  print2($col1);
     ?>
     <div class="row konular">
        <div class="col-6">
        <table border="0" class="table table-bordered table-striped" cellpadding="1" class="" cellspacing="1" style="width:100%">
            <tbody>
        
                
                <?php foreach($col1 AS $ders_adi => $konu) { ?>
                <tr>
                    <th colspan="12"><strong>{{$ders_adi}}</strong></th>
                </tr>
                <tr>
                    <th style="text-align:center">Konu Adı</th>
                    <th style="text-align:center; width:30px">Sayı</th>
                    <th style="text-align:center; width:30px">Doğ</th>
                    <th style="text-align:center; width:30px">Yan</th>
                    <th style="text-align:center; width:30px">Boş</th>
                    <th style="text-align:center; width:30px">%</th>
                   
                </tr>
                <?php 
                $k = 0;
                foreach($konu AS $konu_adi => $icerik) {  ?>
                 <?php 
                    $dogru = @$icerik['dogru'];
                    $yanlis = @$icerik['yanlis'];
                    $bos = @$icerik['bos'];
                    if($dogru == "") $dogru = 0;
                    if($yanlis == "") $yanlis = 0;
                    if($bos == "") $bos = 0;

                    $toplam = $dogru + $yanlis + $bos;
                   // $isaretlenen = $dogru + $yanlis;
                    $net = $dogru - $yanlis / 4;
                    $yuzde = round($net *100 /$toplam,2);
                 //   $next = $konular[$ders_adi];
                    ?>
                 <?php // if($isaretlenen>0) { ?>
                <tr>
               
                    <td style="text-align:center">
                        <div class="konu_title">{{$konu_adi}}</div>
                    </td>
                    <td style="text-align:center">{{$toplam}}</td>
                    <td style="text-align:center">{{$dogru}}</td>
                    <td style="text-align:center">{{$yanlis}}</td>
                    <td style="text-align:center">{{$bos}}</td>
                    <td style="text-align:center">%{{$yuzde}}</td>
                   
                 
               
                   
                  
                </tr>
                <?php  //} ?>
                <?php $k++; } ?>
               <?php } ?>
            </tbody>
        </table>
        </div>
        <div class="col-6">
        <table border="0" class="table table-bordered table-striped" cellpadding="1" class="" cellspacing="1" style="width:100%">
            <tbody>
        
                
                <?php foreach($col2 AS $ders_adi => $konu) { ?>
                    <tr>
                    <th colspan="12"><strong>{{$ders_adi}}</strong></th>
                </tr>
                <tr>
                    <th style="text-align:center">Konu Adı</th>
                    <th style="text-align:center; width:30px">Sayı</th>
                    <th style="text-align:center; width:30px">Doğ</th>
                    <th style="text-align:center; width:30px">Yan</th>
                    <th style="text-align:center; width:30px">Boş</th>
                    <th style="text-align:center; width:30px">%</th>
                   
                </tr>
                <?php 
                $k = 0;
                foreach($konu AS $konu_adi => $icerik) {  ?>
                <tr>
                <?php 
                    $dogru = @$icerik['dogru'];
                    $yanlis = @$icerik['yanlis'];
                    $bos = @$icerik['bos'];
                    if($dogru == "") $dogru = 0;
                    if($yanlis == "") $yanlis = 0;
                    if($bos == "") $bos = 0;

                    $toplam = $dogru + $yanlis + $bos;
                    $net = $dogru - $yanlis / 4;
                    $yuzde = round($net *100 /$toplam,2);
                 //   $next = $konular[$ders_adi];
                    ?>
                 
                    <td style="text-align:center">
                        <div class="konu_title">{{$konu_adi}}</div>
                    </td>
                    <td style="text-align:center">{{$toplam}}</td>
                    <td style="text-align:center">{{$dogru}}</td>
                    <td style="text-align:center">{{$yanlis}}</td>
                    <td style="text-align:center">{{$bos}}</td>
                    <td style="text-align:center">%{{$yuzde}}</td>
                   
                 
               
                   
                  
                </tr>
                <?php $k++; } ?>
               <?php } ?>
            </tbody>
        </table>
        </div>
     </div>
       

    </div>

</body>

</html>