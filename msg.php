<?PHP 
include_once('/var/www/secure.php'); //outside webserver
include_once('functions.php'); //outside webserver

$q = "select * from coronavirus_msg order by id desc limit 1";
$r = $core->query("SELECT id, checked_datetime FROM coronavirus order by id DESC limit 0,1");
$d = mysqli_fetch_array($r);
$date = $d['msg_made_datetime'];
$clean = strip_tags($d['msg']);

$msg="
$clean
".$date;


// GD Code Here
header('Content-Type: image/png');
$height = strlen($msg) * 1.20;
$width = '450';
$im = imagecreatetruecolor($width, $height);
$white = imagecolorallocate($im, 255, 255, 255);
$grey = imagecolorallocate($im, 128, 128, 128);
$black = imagecolorallocate($im, 0, 0, 0);
$width_rec = $width - 1;
$height_rec = $height - 1;
imagefilledrectangle($im, 0, 0, $width_rec, $height_rec, $white);
$text = $msg;
$Regular = 'fonts/OpenSans-Regular.ttf';
$BoldItalic = 'fonts/OpenSans-BoldItalic.ttf';
$title = 'Covid19math.net Update';
// https://www.php.net/manual/en/function.imagettftext.php
$font_size_title = '25';
$x = '11';
$y = '25';
imagettftext($im, $font_size_title, 0, $x, $y, $grey, $BoldItalic, $title);
imagettftext($im, $font_size_title, 0, $x-1, $y-1, $black, $BoldItalic, $title);
$x = 20; // how far from the left
$y = 30; // how far down from the top
$font_size_text = '20';
imagettftext($im, $font_size_text, 0, $x, $y, $grey, $Regular, $text);
imagettftext($im, $font_size_text, 0, $x-1, $y-1, $black, $Regular, $text);
imagepng($im);
imagedestroy($im);
?>
