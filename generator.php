<?php

// WIP, test...not intended for production

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $author = $_POST['author'] ?? false;
    $msg    = $_POST['msg']    ?? false;

    function cleanstr($str){
        $str = trim($str);
        $str = strtolower($str);
        $str = str_replace("'",'',$str);
        $str = preg_replace("/[^a-zA-Z|0-9]/", '-', $str);
        $str = str_replace("--",'-',$str);
        $str = rtrim($str, '-');
        return $str;
    }
    $img_name    = $_FILES["bg"]["name"]; 
    $temp_name   = $_FILES["bg"]["tmp_name"];   
    $uploads     = 'uploads/';
    $img         = imagecreatefromjpeg('assets/img/backgrounds/insta-bg-0001.jpeg');
    $white       = imagecolorallocate($img, 255, 255, 255);
    $grey        = imagecolorallocate($img, 128, 128, 128);
    $black       = imagecolorallocate($img, 0, 0, 0);
    $bg_color    = imagecolorallocatealpha($img, 0, 0, 0, 50);       
    $lng         = strlen($msg);  
    $fsize       = 70;
    $char_length = 40;
    $font_sub_size = 20;
    $lineheight  = 45;
    $padding_bg  = 20;

    if($lng > 50){
        $fsize = 60;
        $char_length = 30;
        $lineheight  = 40;
        $padding_bg  = 17;
    }
    if($lng > 100){
        $fsize = 50;
        $char_length = 24;
        $lineheight  = 35;
        $padding_bg  = 17;
    }
    if($lng > 150){
        $fsize = 40;
        $char_length = 20;
        $lineheight  = 30;
    }
    if($lng > 200){
        $fsize = 34;
        $char_length = 36;
        $font_sub_size = 14;
        $lineheight  = 35;
    }
    if($lng > 250){
        $fsize = 32;
        $char_length = 38;
        $font_sub_size = 14;
        $lineheight  = 0;
        $padding_bg  = 20;
    }
    $txt_input   = trim($msg);
    $txt         = wordwrap($txt_input,  $char_length, "\n", TRUE);
    $i           = 0;
    $font        = realpath("assets/fonts/OpenSans-Bold.ttf"); 
    $font_sub    = realpath("assets/fonts/GreatVibes-Regular.ttf"); 
    $font_size   = $fsize;
    $angle       = 0;
    $text_color  = imagecolorallocate($img, 0xFF, 0xFF, 0xFF);
    $width       = imagesx($img);
    $height      = imagesy($img);
    $splittext   = explode ( "\n" , $txt );
    $splittext[] = '';//add extra line
    $splittext[] = $author;
    $lines       = count($splittext);
    $c_name      = cleanstr($msg);
    $c_author    = cleanstr($author);
    $id          = 1;

    $filename = $uploads.$id.'_'.$lng.'_'.$c_author.'_'.substr($c_name,0,80).".jpg"; 

    if (file_exists($filename)) {
        unlink($filename);
    }
    foreach ($splittext as $text) {

        $text = trim($text);           
        if($text == $author){
            $font_size = $font_sub_size;
        }
        
        $text_box    = imagettfbbox($font_size, $angle, $font, $text);
        $text_width  = abs(max($text_box[2], $text_box[4]));
        $text_height = abs(max($text_box[5], $text_box[7]));            
        $x           = (imagesx($img) - $text_width)/2;
        $y           = ((imagesy($img) + $text_height)/2)-($lines-2)*$text_height-$lineheight;
        $lines       = $lines-1;
        $y           = $y + $i * $lineheight;            
        $bg_x1       = $x - $padding_bg;
        $bg_y1       = $y - ($text_height + $padding_bg);
        $bg_x2       = imagesx($img) - $bg_x1;
        $bg_y2       = imagesy($img) - (imagesy($img) - $y) + $padding_bg;

        if(!empty($text)){
            imagefilledrectangle($img, $bg_x1, $bg_y1, $bg_x2, $bg_y2, $bg_color);
        }
        imagettftext($img, $font_size, 0, $x+2, $y+2, $black, $font, $text);
        imagettftext($img, $font_size, 0, $x, $y, $text_color, $font, $text);

        $i++;
    }

    imagefilledrectangle($img, 0, 0, 0, 0, $black);
    imagejpeg($img, $filename, 99);
    imagedestroy($img);

    echo '<div class="msg msg--success">Image uploaded...</div>';

    unset($_POST);

}

?>