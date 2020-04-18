<?PHP $msg="
up 736 Maryland at 12,308.
up 38 deaths at 463.
up 145 total_hospitalized at 2,757.
up 35 total_released at 771.
up 2,625 NegativeTests at 53,062.
County by County
up 7 Allegany at 33.
up 39 AnneArundel at 1,005.
up 95 Baltimore at 1,664.
up 105 BaltimoreCity at 1,378.
up 5 Caroline at 33.
up 20 Carroll at 308.
up 4 Cecil at 131.
up 10 Charles at 347.
up 32 Frederick at 557.
up 19 Harford at 195.
up 33 Howard at 508.
up 2 Kent at 16.
up 124 Montgomery at 2,404.
up 194 PrinceGeorges at 3,160.
up 5 QueenAnnes at 24.
up 1 Somerset at 10.
up 1 StMarys at 101.
up 2 Talbot at 16.
up 3 Worcester at 31.
Age Groups
up 3 case0to9 at 89.
up 12 case10to19 at 254.
up 84 case20to29 at 1,311.
up 128 case30to39 at 2,010.
up 127 case40to49 at 2,215.
up 112 case50to59 at 2,399.
up 121 case60to69 at 1,831.
up 82 case70to79 at 1,253.
up 67 case80plus at 946.
Deltas
down -52 CaseDelta at 736.
up 247 NegDelta at 2,625.
down -16 hospitalizedDelta at 145.
up 35 releasedDelta at 35.
up 5 deathsDelta at 38.
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
