<?PHP
if(isset($_GET['novideo'])){
	$logo = 'off';
}
include_once('menu.php');
global $maryland_history;
$maryland_history = make_maryland_array();
echo '<div class="container">';
$video_of_the_day = 'xv-8i59AUFY';
if(empty($_GET['novideo'])){
	echo '
	<div class="row">
		<div class="col-sm-12">
		<iframe id="ytplayer" type="text/html" width="1100" height="600"
	src="https://www.youtube.com/embed/'.$video_of_the_day.'?autoplay=1"
	frameborder="1" allowfullscreen> </iframe>
			</div>
	</div>';
}

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
    $send_message = 'on';
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
    $r = $core->query("SELECT id, html, checked_datetime FROM coronavirus where checked_datetime like '$yesterday %' order by id ASC limit 1");  
}
$d = mysqli_fetch_array($r);
$old = $d['html'];
global $old_date;
$old_date = $d['checked_datetime'];

echo "<div class='col-sm-3'><h3>Date Range</h3>
<p>$old_date</p>
<p>$new_date</p>
<h3>Select Different Date to Compare.</h3>";
echo "$dropdown";
echo "</div>";


echo "<div class='col-sm-3' style='text-align:left;'>
<h3>SMS Userlist</h3>";
$rSMS = $core->query("SELECT id FROM coronavirus_sms order by id desc limit 1");
$dSMS = mysqli_fetch_array($rSMS);
echo "<p>Registered Phones:  $dSMS[id]</p>";
echo "</div>";


// Convert json objects to array
$array1 = json_decode($old, true);
$array2 = json_decode($json, true);

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
	$count_delta = $count_today - $count_yesterday;
	if ($count_delta != 0) { sms("$count_delta New $county $count_yesterday to $count_today ");  } 
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

echo "<div class='col-sm-6' style='text-align:left;'><h3>Changes $send_message</h3>";
echo "$new_master_message";
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
