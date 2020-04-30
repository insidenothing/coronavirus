<?PHP
if(isset($_GET['novideo'])){
	$logo = 'off';
}
include_once('menu.php');
global $maryland_history;
$maryland_history = make_maryland_array();


echo '<div class="container">';


echo '<div class="row">';
global $send_message;
$send_message = 'off';

// Last Version
$url_pulled = $maryland_history['url_pulled'];
$r = $core->query("SELECT html, checked_datetime FROM coronavirus where url_pulled = '$url_pulled' order by id DESC limit 0,1");
$d = mysqli_fetch_array($r);
$old = $d['html'];
$json = json_encode($maryland_history);
$new = $core->real_escape_string($json);
global $raw;
$raw_response = $core->real_escape_string($raw);
$test1 = $old;
$test2 = $json;
if ($test1 != $test2){
    	$core->query("insert into coronavirus (checked_datetime,just_date, html, url_pulled,raw_response) values (NOW(),NOW(), '$new','$url_pulled','$raw_response')");
    	//$send_message = 'on';
	message_send('4433862584',"daily update");
}



// Last Version 2 ( extra data )
global $maryland_history2;
$maryland_history2 = make_maryland_array2();
$url_pulled2 = $maryland_history2['url_pulled'];
$r2 = $core->query("SELECT html, checked_datetime FROM coronavirus where url_pulled = '$url_pulled2' order by id DESC limit 0,1");
$d2 = mysqli_fetch_array($r2);
$old2 = $d2['html'];
$json2 = json_encode($maryland_history2);
$new2 = $core->real_escape_string($json2);
global $raw;
$raw_response = $core->real_escape_string($raw);
$test12 = $old2;
$test22 = $json2;
if ($test12 != $test22){
    	$core->query("insert into coronavirus (checked_datetime,just_date, html, url_pulled,raw_response) values (NOW(),NOW(), '$new2','$url_pulled2','$raw_response')");
    	//$send_message = 'on';
	message_send('4433862584',"attributes updated");
}


global $maryland_history3;
$maryland_history3 = make_maryland_array3('','','force');
$url_pulled3 = $maryland_history3['url_pulled'];
$r3 = $core->query("SELECT html, checked_datetime FROM coronavirus where url_pulled = '$url_pulled3' order by id DESC limit 0,1");
$d3 = mysqli_fetch_array($r3);
$old3 = $d3['html'];
$json3 = json_encode($maryland_history3);
$new3 = $core->real_escape_string($json3);
global $raw;
$raw_response = $core->real_escape_string($raw);
$test13 = $old3;
$test23 = $json3;
if ($test13 != $test23){
    	$core->query("insert into coronavirus (checked_datetime,just_date, html, url_pulled,raw_response) values (NOW(),NOW(), '$new3','$url_pulled3','$raw_response')");
    	//$send_message = 'on';
	message_send('4433862584',"maryland zip codes updated");
}

// FLORIDA
global $florida;
$url = 'https://services1.arcgis.com/CY1LXxl9zlJeBuRZ/ArcGIS/rest/services/COVID_19_Cases_in_Florida_by_Zip_Code/FeatureServer/0/query?where=1%3D1&objectIds=&time=&geometry=&geometryType=esriGeometryEnvelope&inSR=&spatialRel=esriSpatialRelIntersects&resultType=none&distance=0.0&units=esriSRUnit_Meter&returnGeodetic=false&outFields=*&returnGeometry=false&returnCentroid=false&featureEncoding=esriDefault&multipatchOption=xyFootprint&maxAllowableOffset=&geometryPrecision=&outSR=&datumTransformation=&applyVCSProjection=false&returnIdsOnly=false&returnUniqueIdsOnly=false&returnCountOnly=false&returnExtentOnly=false&returnQueryGeometry=false&returnDistinctValues=false&cacheHint=false&orderByFields=&groupByFieldsForStatistics=&outStatistics=&having=&resultOffset=&resultRecordCount=&returnZ=false&returnM=false&returnExceededLimitFeatures=true&quantizationParameters=&sqlFormat=none&f=pjson&token=';
$florida = make_florida_zip_array($url,'','force');
$url_pulled3 = $florida['url_pulled'];
$r3 = $core->query("SELECT html, checked_datetime FROM coronavirus where url_pulled = '$url_pulled3' order by id DESC limit 0,1");
$d3 = mysqli_fetch_array($r3);
$old3 = $d3['html'];
$json3 = json_encode($florida);
$new3 = $core->real_escape_string($json3);
global $raw;
$raw_response = $core->real_escape_string($raw);
$test13 = $old3;
$test23 = $json3;
if ($test13 != $test23){
    	$core->query("insert into coronavirus (checked_datetime,just_date, html, url_pulled,raw_response) values (NOW(),NOW(), '$new3','$url_pulled3','$raw_response')");
    	//$send_message = 'on';
	message_send('4433862584',"florida zip codes updated");
}

// FLORIDA
// FLORIDA
global $florida;
$url = 'https://services1.arcgis.com/CY1LXxl9zlJeBuRZ/ArcGIS/rest/services/Florida_COVID_19_Deaths_by_Day/FeatureServer/0/query?where=1%3D1&objectIds=&time=&resultType=none&outFields=*&returnIdsOnly=false&returnUniqueIdsOnly=false&returnCountOnly=false&returnDistinctValues=false&cacheHint=false&orderByFields=&groupByFieldsForStatistics=&outStatistics=&having=&resultOffset=&resultRecordCount=&sqlFormat=none&f=pjson&token=';
$florida = make_florida_zip_array($url,'','force');
$url_pulled3 = $florida['url_pulled'];
$r3 = $core->query("SELECT html, checked_datetime FROM coronavirus where url_pulled = '$url_pulled3' order by id DESC limit 0,1");
$d3 = mysqli_fetch_array($r3);
$old3 = $d3['html'];
$json3 = json_encode($florida);
$new3 = $core->real_escape_string($json3);
global $raw;
$raw_response = $core->real_escape_string($raw);
$test13 = $old3;
$test23 = $json3;
if ($test13 != $test23){
    	$core->query("insert into coronavirus (checked_datetime,just_date, html, url_pulled,raw_response) values (NOW(),NOW(), '$new3','$url_pulled3','$raw_response')");
    	//$send_message = 'on';
	message_send('4433862584',"florida deaths updated");
}




// Compare Most Recent to Last Change
$r = $core->query("SELECT id, checked_datetime FROM coronavirus where url_pulled = '$url_pulled' order by id DESC limit 0,1");
$d = mysqli_fetch_array($r);
//global $new_date;
//$new_date = $d['checked_datetime'];
$new_date = $maryland_history['date'];
$today = date('Y-m-d',strtotime($new_date));
global $new_id;
$new_id = $d['id'];

$y_time = strtotime($new_date) - 86400;
$yesterday = date('Y-m-d',$y_time);

$r = $core->query("SELECT id, html, checked_datetime FROM coronavirus url_pulled = '$url_pulled' order by id DESC limit 1, 1");  
$d = mysqli_fetch_array($r);
$old = $d['html'];
global $maryland_history_last;
$maryland_history_last = make_maryland_array($old);
global $old_date;
$old_date = $d['checked_datetime'];
$old_date = date('Y-m-d',strtotime($old_date));
echo "<div class='col-sm-12'><p>$old_date to $new_date</p>";

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
	$yesterday = date('Y-m-d',strtotime($old_date));
	$aka = county_aka($county);
	$count_today = $maryland_history[$today][$aka];
	$count_yesterdayA = $maryland_history_last[$today][$aka];
	echo "<h1>$county count_yesterdayA $count_yesterdayA $today</h1>";
	$count_yesterdayB = $maryland_history_last[$yesterday][$aka];
	echo "<h1>$county count_yesterdayB $count_yesterdayB $yesterday</h1>";
	if ($count_yesterdayA > $count_yesterdayB){
		$count_yesterday = $count_yesterdayA;
	}else{
		$count_yesterday = $count_yesterdayB;
	}
	$field = $county.'COVID19Cases';
	$core->query("update coronavirus set $field = '$count_today' where id = '$new_id' ");
	$count_delta = $count_today - $count_yesterday;
	$dir = 'up';
	if ( $count_today < $count_yesterday){
		$dir = 'down';
	}
	$human_count = number_format($count_today);
	$human_delta = number_format($count_delta);
	if ($count_delta != 0) { sms("$dir $human_delta <b>$county $update_version</b> at $human_count. ");  } 
}

ob_start();

// V3
echo '<div>Covid19math.net Update</div>';
echo do_math_location('Maryland');
echo do_math_location('total_hospitalized');
echo do_math_location('total_released');
echo do_math_location('deaths');
echo do_math_location('NegativeTests');

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

echo do_math_location('CaseDelta');
echo do_math_location('NegDelta');
echo do_math_location('hospitalizedDelta');
echo do_math_location('releasedDelta');
echo do_math_location('deathsDelta');

$new_master_message = ob_get_clean();


echo "$new_master_message";
echo "<p>Update String Legenth: ".strlen($new_master_message)." ($send_message)</p>";
echo "<a href='?forcesms=1'><img class='img-responsive' src='img/send.jpg'></a>";
echo "</div>";
if ($send_message == 'on' || isset($_GET['forcesms'])){
	global $core;
	$r = $core->query("SELECT sms_number FROM coronavirus_sms where sms_status = 'confirmed' ");
	while($d = mysqli_fetch_array($r)){
		$sms = trim($d['sms_number']);
		//message_send($sms,$new_master_message);
	}
}  
echo "</div></div>";
echo "<pre>".print_r($maryland_history_last)."</pre>";
include_once('footer.php');
