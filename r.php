<?php

ini_set('memory_limit', '256M');

header('Content-Type: text/html; charset=utf-8');


//if($_GET['p']=="file/" || $_GET['p']=="") $_GET['p'] = "file/gorsel-yok.jpg";
if(!isset($_GET['p'])) exit();

if(!isset($_GET['h'])) {

	$_GET['h'] = 0;

}

if(!isset($_GET['w'])) {

	$_GET['w'] = 0;

}

if(strpos("ile/data",$_GET['p'])) {

	header("Location:", $_GET['p']);

}

$_GET['p'] = str_replace("media","aa/lib/elfinder/",$_GET['p']);

$_GET['p'] = str_replace("file/data/","data/",$_GET['p']);



  $file				  = $_GET['p'];

  

  $slash = substr($file,0,1); //ilk karakter slash mı

  if($slash=="/") {

	  $file = substr($file,1,strlen($file));

  }

  $width              = $_GET['w'];

  $height             = $_GET['h']; 

  $proportional       = true; 

  $output             = 'file'; 

  $delete_original    = false; 

  $use_linux_commands = false;

$new = explode(".",$file);		

$varmi = "{$new[0]}_$width.{$new[1]}";   

$varmi2 = "{$new[0]}_$height.{$new[1]}";   

//echo($varmi);

if(file_exists($varmi)) {

	//echo($varmi);
  
	ob_start();

	header("Location: $varmi");

	exit(); 

} else if(file_exists($varmi2)) {

	ob_start();

	header("Location: $varmi2");

	exit(); 

}



//exit();

    if ( $height <= 0 && $width <= 0 ) return false;



    # Setting defaults and meta

    $info                         = getimagesize($file);

    $image                        = '';

    $final_width                  = 0;

    $final_height                 = 0;

    list($width_old, $height_old) = $info;



    # Calculating proportionality

    if ($proportional) {

      if      ($width  == 0)  $factor = $height/$height_old;

      elseif  ($height == 0)  $factor = $width/$width_old;

      else                    $factor = min( $width / $width_old, $height / $height_old );



      $final_width  = round( $width_old * $factor );

      $final_height = round( $height_old * $factor );

    }

    else {

      $final_width = ( $width <= 0 ) ? $width_old : $width;

      $final_height = ( $height <= 0 ) ? $height_old : $height;

    }



    # Loading image to memory according to type

    switch ( $info[2] ) {

      case IMAGETYPE_GIF:   $image = imagecreatefromgif($file);   break;

      case IMAGETYPE_JPEG:  $image = imagecreatefromjpeg($file);  break;

      case IMAGETYPE_PNG:   $image = imagecreatefrompng($file);   break;

      default: return false;

    }

    

    

    # This is the resizing/resampling/transparency-preserving magic

    $image_resized = imagecreatetruecolor( $final_width, $final_height );

    if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {

      $transparency = imagecolortransparent($image);



      if ($transparency >= 0) {

        $transparent_color  = imagecolorsforindex($image, $trnprt_indx);

        $transparency       = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);

        imagefill($image_resized, 0, 0, $transparency);

        imagecolortransparent($image_resized, $transparency);

      }

      elseif ($info[2] == IMAGETYPE_PNG) {

        imagealphablending($image_resized, false);

        $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);

        imagefill($image_resized, 0, 0, $color);

        imagesavealpha($image_resized, true);

      }

    }

    imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);

    

    # Taking care of original, if needed

    if ( $delete_original ) {

      if ( $use_linux_commands ) exec('rm '.$file);

      else @unlink($file);

    }



    # Preparing a method of providing result

    switch ( strtolower($output) ) {

      case 'browser':

        $mime = image_type_to_mime_type($info[2]);

        header("Content-type: $mime");

        $output = NULL;

      break;

      case 'file':

		$new = explode(".",$file);		

        $output = "{$new[0]}_$final_width.{$new[1]}";

      break;

      case 'return':

        return $image_resized;

      break;

      default:

      break;

    }

    

    if(!file_exists($output)) { //eğer dosya mevcut değilse yaz

	switch ( $info[2] ) {

		case IMAGETYPE_GIF:   

			imagegif($image_resized, $output);    

		break;

		case IMAGETYPE_JPEG:  

			imagejpeg($image_resized, $output);  

		break;

		case IMAGETYPE_PNG:   

			imagepng($image_resized, $output); 

		

		break;

      default: return false;

    }

		header("Location:$output");

	} else {

		header("Location:$output");

	}

	//imagedestroy($sonuc);







?> 