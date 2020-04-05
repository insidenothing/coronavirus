<?PHP
if(isset($_GET['novideo'])){
	$logo = 'off';
}
include_once('menu.php');
global $maryland_history;
$maryland_history = make_maryland_array();

echo '<div class="container">';


echo '
<div class="row">';
//<iframe width="1100" height="600" src="https://www.youtube.com/embed/videoseries?list=PLhAvAcGuQOsHsqKlOb2gpIgvAP7nFXyVS?autoplay=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
global $send_message;
$send_message = 'off';

// Last Version
$r = $core->query("SELECT html, checked_datetime FROM coronavirus order by id DESC limit 0,1");
$d = mysqli_fetch_array($r);
$old = $d['html'];
$json = json_encode($maryland_history);
$new = $core->real_escape_string($json);
$test1 = $old;
$test2 = $json;
if ($test1 != $test2){
    	$core->query("insert into coronavirus (checked_datetime,just_date, html) values (NOW(),NOW(), '$new')");
    	$send_message = 'update disabled';
}

// Compare Most Recent to Last Change
$r = $core->query("SELECT id, checked_datetime FROM coronavirus order by id DESC limit 0,1");
$d = mysqli_fetch_array($r);
//global $new_date;
//$new_date = $d['checked_datetime'];
$new_date = $maryland_history['date'];
global $new_id;
$new_id = $d['id'];

$y_time = strtotime($new_date) - 86400;
$yesterday = date('Y-m-d',$y_time);

$dropdown = "<form method='POST'><select name='checked_datetime' class='form-control' id='sel1'>";
$r = $core->query("SELECT checked_datetime FROM coronavirus order by id DESC");
while($d = mysqli_fetch_array($r)){
   $dropdown .= "<option>$d[checked_datetime]</option>"; 
}
$dropdown .= "</select><input value='Load Date' type='submit' class='btn btn-default'></form>";

if (isset($_POST['checked_datetime'])){
    $date = $_POST['checked_datetime'];
    $r = $core->query("SELECT id, html, checked_datetime FROM coronavirus where checked_datetime = '$date' ");
}else{
    // first frport from yesterday to last report of this day
    $r = $core->query("SELECT id, html, checked_datetime FROM coronavirus order by id DESC limit 1, 1");  
}
$d = mysqli_fetch_array($r);
$old = $d['html'];
global $maryland_history_last;
$maryland_history_last = make_maryland_array($old);
global $old_date;
$old_date = $d['checked_datetime'];

echo "<div class='col-sm-12'>";










// Convert json objects to array
$array1 = json_decode($old, true);
$array2 = json_decode($json, true);

function do_math_location($county){
	global $maryland_history;
	global $maryland_history_last;
	global $new_id;
	global $new_date;
	global $old_date;
	global $core;
	$today = date('Y-m-d',strtotime($new_date));
	$aka = county_aka($county);
	$count_today = $maryland_history[$today][$aka];
	
	
	// this is yesterdays update, we want the last
	$yesterday = date('Y-m-d',strtotime($old_date));
	$count_yesterday = $maryland_history_last[$yesterday][$aka];
	
	
	$field = $county.'COVID19Cases';
	$core->query("update coronavirus set $field = '$count_today' where id = '$new_id' ");
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
echo '<div>Covid19math.net Update </div>';
echo do_math_location('Maryland');
echo do_math_location('total_hospitalized');
echo do_math_location('total_released');
echo do_math_location('deaths');
echo do_math_location('NegativeTests');

echo do_math_location('case0to9');
echo do_math_location('case10to19');
echo do_math_location('case20to29');
echo do_math_location('case30to39');
echo do_math_location('case40to49');
echo do_math_location('case50to59');
echo do_math_location('case60to69');
echo do_math_location('case70to79');
echo do_math_location('case80plus');

echo do_math_location('Male');
echo do_math_location('Female');

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
$new_master_message = ob_get_clean();


echo "$new_master_message";
echo "<p>Update String Legenth: ".strlen($new_master_message)." ($send_message)</p>";
echo "</div>";
if ($send_message == 'on' || isset($_GET['forcesms'])){
	global $core;
	$r = $core->query("SELECT sms_number FROM coronavirus_sms where sms_status = 'confirmed' ");
	while($d = mysqli_fetch_array($r)){
		$sms = trim($d['sms_number']);
		message_send($sms,$new_master_message);
	}
}  
echo "</div></div>";
include_once('footer.php');
