<?PHP 
include_once('/var/www/secure.php'); //outside webserver
include_once('functions.php'); //outside webserver
global $attributes;
global $maryland_history;
global $new_id;
global $new_date;
global $old_date;
global $core;
$maryland_history = make_maryland_array();

function attribute_aka($county){
	global $attributes;
	if ($county == 'caseAfrAmer'){ return $attributes['raceAfrAmer']['CaseCount']; }
	if ($county == 'deathAfrAmer'){ return $attributes['raceAfrAmer']['DeathCount']; }
	
	if ($county == 'caseWhite'){ return $attributes['raceWhite']['CaseCount']; }
	if ($county == 'deathWhite'){ return $attributes['raceWhite']['DeathCount']; }
	
	if ($county == 'caseAsian'){ return $attributes['raceAsian']['CaseCount']; }
	if ($county == 'deathAsian'){ return $attributes['raceAsian']['DeathCount']; }
	
	if ($county == 'caseOther'){ return $attributes['raceOther']['CaseCount']; }
	if ($county == 'deathOther'){ return $attributes['raceOther']['DeathCount']; }
	
	if ($county == 'caseNotAVail'){ return $attributes['raceNotAvail']['CaseCount']; }
	if ($county == 'deathNotAvail'){ return $attributes['raceNotAvail']['DeathCount']; }
}

function do_math_location($county){
	
	global $maryland_history;
	global $new_id;
	global $new_date;
	global $old_date;
	global $core;
	$today = date('Y-m-d',strtotime($new_date));
	$aka = county_aka($county);
	$count_today = $maryland_history[$today][$aka];
	
	$yesterday = date('Y-m-d',strtotime($old_date));
	$count_yesterday = $maryland_history[$yesterday][$aka];
	$core->query("update coronavirus set $countyCOVID19Cases = '$count_today' where id = '$new_id' ");
	
	if ($count_today == 0){
		// failure detected
		// check attributes
		$count_fix = attribute_aka($county);
		//echo "<p>PATCH $count_today to $count_fix for $county ($count_yesterday)</p>";
		$count_today = $count_fix;
	}
	
	$count_delta = $count_today - $count_yesterday;
	$dir = 'up';
	if ( $count_today < $count_yesterday){
		$dir = 'down';
	}
	$human_count = number_format($count_today);
	$human_delta = number_format($count_delta);
	if ($count_delta != 0) { sms("$dir $human_delta <b>$county</b> at $human_count. ");  } 
}

ob_start();
// V3
echo do_math_location('Maryland');
echo do_math_location('deaths');
echo do_math_location('total_hospitalized');
echo do_math_location('total_released');
echo do_math_location('NegativeTests');
echo '<h4>County by County</h4>';
echo do_math_location('Allegany');
echo do_math_location('AnneArundel');
echo do_math_location('Baltimore');
echo do_math_location('BaltimoreCity');
echo do_math_location('Calvert');
echo do_math_location('Caroline');
echo do_math_location('Carroll');
echo do_math_location('Cecil');
echo do_math_location('Charles');
echo do_math_location('Dorchester');
echo do_math_location('Frederick');
echo do_math_location('Garrett');
echo do_math_location('Harford');
echo do_math_location('Howard');
echo do_math_location('Kent');
echo do_math_location('Montgomery');
echo do_math_location('PrinceGeorges');
echo do_math_location('QueenAnnes');
echo do_math_location('Somerset');
echo do_math_location('StMarys');
echo do_math_location('Talbot');
echo do_math_location('Washington');
echo do_math_location('Worcester');
echo '<h4>Age Groups</h4>';
echo do_math_location('case0to9');
echo do_math_location('case10to19');
echo do_math_location('case20to29');
echo do_math_location('case30to39');
echo do_math_location('case40to49');
echo do_math_location('case50to59');
echo do_math_location('case60to69');
echo do_math_location('case70to79');
echo do_math_location('case80plus');
echo '<h4>Deltas</h4>';	
echo do_math_location('CaseDelta');
echo do_math_location('NegDelta');
echo do_math_location('hospitalizedDelta');
echo do_math_location('releasedDelta');
echo do_math_location('deathsDelta');	
$new_master_message = ob_get_clean();

$msg="
$new_master_message
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
