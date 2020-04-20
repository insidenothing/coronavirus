<?PHP $msg="
up 854 Maryland at 13,684.
up 30 deaths at 516.
up 128 total_hospitalized at 3,014.
up 3 total_released at 917.
up 2,652 NegativeTests at 57,713.
County by County
down -1 Allegany at 32.
up 51 AnneArundel at 1,098.
up 142 Baltimore at 1,875.
up 119 BaltimoreCity at 1,511.
up 1 Calvert at 114.
up 6 Caroline at 39.
up 22 Carroll at 335.
up 3 Cecil at 134.
up 22 Charles at 392.
up 2 Dorchester at 23.
up 25 Frederick at 616.
up 16 Harford at 226.
up 23 Howard at 538.
up 10 Kent at 28.
up 140 Montgomery at 2,647.
up 238 PrinceGeorges at 3,583.
up 1 QueenAnnes at 26.
up 1 Somerset at 11.
up 2 StMarys at 107.
up 3 Talbot at 22.
up 6 Washington at 123.
up 1 Worcester at 34.
Age Groups
up 15 case0to9 at 108.
up 23 case10to19 at 300.
up 97 case20to29 at 1,488.
up 145 case30to39 at 2,245.
up 130 case40to49 at 2,442.
up 140 case50to59 at 2,632.
up 117 case60to69 at 2,015.
up 99 case70to79 at 1,385.
up 88 case80plus at 1,069.
Deltas
up 332 CaseDelta at 854.
up 653 NegDelta at 2,652.
down -1 hospitalizedDelta at 128.
down -140 releasedDelta at 3.
up 7 deathsDelta at 30.
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
