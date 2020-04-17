<?PHP $msg="Covid19math.net Update
up 752 Maryland at 10,784.
up 43 deaths at 392.
up 220 total_hospitalized at 2,451.
up 129 total_released at 736.
up 2,328 NegativeTests at 48,059.
County by County
up 3 Allegany at 20.
up 51 AnneArundel at 896.
up 31 Baltimore at 1,516.
up 100 BaltimoreCity at 1,160.
up 1 Calvert at 103.
up 1 Caroline at 23.
up 21 Carroll at 283.
up 11 Cecil at 101.
up 17 Charles at 327.
up 2 Dorchester at 18.
up 55 Frederick at 497.
up 9 Harford at 161.
up 27 Howard at 451.
up 200 Montgomery at 2,133.
up 206 PrinceGeorges at 2,722.
up 1 Somerset at 6.
down -1 StMarys at 98.
up 3 Washington at 109.
up 3 Worcester at 25.
Age Groups
up 12 case0to9 at 86.
up 27 case10to19 at 231.
up 73 case20to29 at 1,162.
up 114 case30to39 at 1,784.
up 143 case40to49 at 1,951.
up 133 case50to59 at 2,138.
up 128 case60to69 at 1,602.
up 55 case70to79 at 1,065.
up 67 case80plus at 765.
Gender
up 374 Male at 4,967.
up 378 Female at 5,817.
Deltas
up 192 CaseDelta at 752.
up 858 NegDelta at 2,328.
up 111 hospitalizedDelta at 220.
up 129 releasedDelta at 129.
down -4 deathsDelta at 43.";

// Set the content-type
header('Content-Type: image/png');

// Create the image
$im = imagecreatetruecolor(400, 30);

// Create some colors
$white = imagecolorallocate($im, 255, 255, 255);
$grey = imagecolorallocate($im, 128, 128, 128);
$black = imagecolorallocate($im, 0, 0, 0);
imagefilledrectangle($im, 0, 0, 399, 29, $white);

// The text to draw
$text = 'Testing...';
// Replace path by your own font path
$font = 'fonts/OpenSans-Regular.ttf';

// Add some shadow to the text
imagettftext($im, 20, 0, 11, 21, $grey, $font, $text);

// Add the text
imagettftext($im, 20, 0, 10, 20, $black, $font, $text);

// Using imagepng() results in clearer text compared with imagejpeg()
imagepng($im);
imagedestroy($im);
?>

