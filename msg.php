<?PHP $msg="
up 522 Maryland at 12,830.
up 23 deaths at 486.
up 129 total_hospitalized at 2,886.
up 143 total_released at 914.
up 1,999 NegativeTests at 55,061.
County by County
up 42 AnneArundel at 1,047.
up 69 Baltimore at 1,733.
up 14 BaltimoreCity at 1,392.
up 4 Calvert at 113.
up 5 Carroll at 313.
up 23 Charles at 370.
up 1 Dorchester at 21.
up 34 Frederick at 591.
up 15 Harford at 210.
up 7 Howard at 515.
up 2 Kent at 18.
up 103 Montgomery at 2,507.
up 185 PrinceGeorges at 3,345.
up 1 QueenAnnes at 25.
up 4 StMarys at 105.
up 3 Talbot at 19.
up 1 Washington at 117.
up 2 Worcester at 33.
Age Groups
up 4 case0to9 at 93.
up 23 case10to19 at 277.
up 80 case20to29 at 1,391.
up 90 case30to39 at 2,100.
up 97 case40to49 at 2,312.
up 93 case50to59 at 2,492.
up 67 case60to69 at 1,898.
up 33 case70to79 at 1,286.
up 35 case80plus at 981.
Deltas
down -214 CaseDelta at 522.
down -626 NegDelta at 1,999.
down -16 hospitalizedDelta at 129.
up 108 releasedDelta at 143.
down -15 deathsDelta at 23.
".date('r');

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
