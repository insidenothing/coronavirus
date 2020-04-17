<?PHP $msg="
up 788 Maryland at 11,572.
up 33 deaths at 425.
up 161 total_hospitalized at 2,612.
up 2,378 NegativeTests at 50,437.
County by County
up 6 Allegany at 26.
up 70 AnneArundel at 966.
up 53 Baltimore at 1,569.
up 113 BaltimoreCity at 1,273.
up 6 Calvert at 109.
up 5 Caroline at 28.
up 5 Carroll at 288.
up 26 Cecil at 127.
up 10 Charles at 337.
up 2 Dorchester at 20.
up 28 Frederick at 525.
up 15 Harford at 176.
up 24 Howard at 475.
up 3 Kent at 14.
up 147 Montgomery at 2,280.
up 244 PrinceGeorges at 2,966.
up 3 Somerset at 9.
up 2 StMarys at 100.
up 7 Washington at 116.
up 3 Worcester at 28.
Age Groups
up 11 case10to19 at 242.
up 65 case20to29 at 1,227.
up 98 case30to39 at 1,882.
up 137 case40to49 at 2,088.
up 149 case50to59 at 2,287.
up 108 case60to69 at 1,710.
up 106 case70to79 at 1,171.
up 114 case80plus at 879.
Gender
up 356 Male at 5,323.
up 432 Female at 6,249.
Deltas
up 36 CaseDelta at 788.
up 50 NegDelta at 2,378.
down -59 hospitalizedDelta at 161.
down -129 releasedDelta at 0.
down -10 deathsDelta at 33.
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
