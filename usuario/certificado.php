<?php 
//Carregando fontes TrueType

//imagecreatefromjpeg(filename)
$image = imagecreatefromjpeg("certificado.jpg");

$titleColor = imagecolorallocate($image, 0, 0, 0);
$gray = imagecolorallocate($image, 100, 100, 100);

$font1= realpath('BevanRegular.ttf');
$font2= realpath('PlayballRegular.ttf');
//imagettftext(image, size, angle, x, y, color, fontfile, text)

imagettftext($image, 32, 0, 320, 250, $titleColor,$font1,"CERTIFICADO");
imagettftext($image, 32, 0, 375, 350, $titleColor,$font2,"Carlos Zeve");

imagestring($image, 3, 440, 370, utf8_decode("Concluído em: ").date("d/m/Y"),$titleColor);

header("Content-Type: image/jpeg");

imagejpeg($image);
//imagejpeg($image, "certificado-".date("Y-m-d").".jpg");

imagedestroy($image);

?>