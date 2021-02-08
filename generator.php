<?php

$author = $_POST['author'] ?? false;
$msg    = $_POST['msg'] ?? false;
$bg     = $_POST['bg'] ?? false;

if($_POST && $author && $msg){


    $uploads = 'uploads/';


  // FETCH IMAGE & WRITE TEXT
  $img       = imagecreatefromjpeg('assets/img/backgrounds/insta-bg-0001.jpeg');

  $white = imagecolorallocate($img, 255, 255, 255);
  $grey = imagecolorallocate($img, 128, 128, 128);
  $black = imagecolorallocate($img, 0, 0, 0);

  $txt_input = $msg;
  $txt       = wordwrap($txt_input, 35, "\n", TRUE);
  $font      = realpath("assets/fonts/OpenSans-Semibold.ttf"); 
 //$font = "/var/www/html/text-on-img-php/arial.ttf"; 
  $font_size = 38;
  $angle     = 0;
  $text_color = imagecolorallocate($img, 0xFF, 0xFF, 0xFF);

  // THE IMAGE SIZE
  $width = imagesx($img);
  $height = imagesy($img);
  $splittext = explode ( "\n" , $txt );
  $lines = count($splittext);


  // FILENAME
  $str = trim($txt_input);
  $str = strtolower($str);
  $str = str_replace("'",'',$str);
  $str = preg_replace("/[^a-zA-Z]/", '-', $str);
  $str = rtrim($str, '-');

  $total = glob("$uploads{*.jpg, *.JPG, *.jpeg}", GLOB_BRACE);
  $id    = count($total)+1;

  $filename = $uploads.$id.'-'.$str.".jpg"; 

  if (file_exists($filename)) {
       unlink($filename);
  }

  $i = 0;
  foreach ($splittext as $text) {
      $text_box = imagettfbbox($font_size, $angle, $font, $txt);
      $text_width = abs(max($text_box[2], $text_box[4]));
      $text_height = abs(max($text_box[5], $text_box[7]));
      $x = (imagesx($img) - $text_width)/2;
      $y = ((imagesy($img) + $text_height)/2)-($lines-2)*$text_height-30;
      $lines=$lines-1;
      $y = $y+$i*30;

 
      $i++;
      //imagettftext($img, $font_size, 0, $x, $y+1, $black, $font, $text);
      imagettftext($img, $font_size, 0, $x, $y, $text_color, $font, $text);
      // break;
  }
  //OUTPUT IMAGE
  header('Content-type: image/jpeg');
  header("Cache-Control: no-store, no-cache");  
  //header('Content-Disposition: attachment; filename="'.str_replace(' ', '-', $txt_input).'.jpeg"');
  
  imagejpeg($img, $filename,90);
  imagedestroy($img);


}

?>