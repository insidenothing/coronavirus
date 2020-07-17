<?PHP
include_once('../menu.php');

global $state;
// EDIT HERE
$state = 'New York';
$api_id = '62';
// "modzcta","Positive","Total","modzcta_cum_perc_pos"
$zip_piece = '0';
$count_piece = '1';
$testing_piece = '2';
$positivity_piece = '3'; 
// EDIT HERE

if (isset($_GET['delete'])){
	$delete = date('Y-m-d');
	$core->query(" delete from coronavirus_zip where report_date = '$delete' and state_name = '$state'");
	die('done '.$delete);
}

if (isset($_GET['delete_date'])){
	$delete = $_GET['delete_date'];
	$core->query(" delete from coronavirus_zip where report_date = '$delete' and state_name = '$state'");
	die('done '.$delete);
}

global $zipcode;
$zipcode = array();
$q = "select distinct zip_code, town_name from coronavirus_zip where town_name <> ''";
$r = $core->query($q);
while($d = mysqli_fetch_array($r)){
	$zip = $d['zip_code'];
	$zipcode[$zip] = $d['town_name'];
}


function coronavirus_zip($zip,$date,$count,$testing,$positivity){
	global $core;
	global $zipcode;
  	global $state;
	$town = $zipcode[$zip];
	$q = "select * from coronavirus_zip where zip_code = '$zip' and report_date = '$date'";
	$r = $core->query($q);
	$d = mysqli_fetch_array($r);
	// look for yesterday
	$date2 = date('Y-m-d',strtotime($date)-86400);
	$q2 = "select * from coronavirus_zip where zip_code = '$zip' and report_date = '$date2'";
	$r2 = $core->query($q2);
	$d2 = mysqli_fetch_array($r2);
	if ($d2['id'] != ''){
		// Let's Process Trend Data
		$last_trend_direction = $d2['trend_direction'];
		$last_trend_duration = $d2['trend_duration'];
		$last_report_count = $d2['report_count'];
		if ($count == $last_report_count){
			$current_trend = 'FLAT';	
		}elseif ($count > $last_report_count){
			$current_trend = 'UP';	
		}else{
			$current_trend = 'DOWN';
		}
		if ($last_trend_direction == $current_trend){
			$current_duration = $last_trend_duration + 1;
		}else{
			$current_duration = 0;
		}
	}else{
		// we reached the start of data collection.	
	}
	if ($d['id'] == ''){
		echo "[insert $zip $date $count]";
		$q = "insert into coronavirus_zip (positivity_rate,testing_count,zip_code,report_date,report_count,town_name,state_name,trend_direction,trend_duration) values ('$positivity','$testing','$zip','$date','$count','$town','$state','$current_trend','$current_duration') ";
	}else{
		echo "[update $zip $date $count]";
		$q = "update coronavirus_zip set positivity_rate='$positivity', testing = '$testing', report_count = '$count', trend_direction = '$current_trend', trend_duration = '$current_duration', town_name = '$town'  where zip_code = '$zip' and report_date = '$date' ";	
	}
	$core->query($q);
	//slack_general("$q",'covid19-sql');
}


global $nocases;
global $cases;
global $zipData;
global $date;





if (empty($_GET['run'])){
	die('missing run=1');
}



if($global_date == date('Y-m-d') || isset($_GET['id'])){

	
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$r = $core->query("select * from coronavirus_api_cache where id = '$id' order by id desc limit 0, 1"); // always get the latest from the cache
	}else{
		$r = $core->query("select * from coronavirus_api_cache where api_id = '$api_id' order by id desc limit 0, 1"); // always get the latest from the cache	
	}

	// watch for microsoft characters =(
	$d = mysqli_fetch_array($r);

	//echo $d['raw_response'];

$break = '
';

	$pieces = explode($break, $d['raw_response']);
	$i=0;
	foreach ($pieces as $v) {
		if ($i != 0){
			//echo "<li>$v</li>";
			$pieces2 = explode(',',$v);
			$date = $global_date;
			$zip = $pieces2[$zip_piece];
			$count = $pieces2[$count_piece];
			$testing = $pieces2[$testing_piece];
			$positivity = $pieces2[$positivity_piece];
			if ($count == 'Suppressed*'){
				$count = 4;
			}
			if ($zip == 'NA'){
				$zip = '00003';
			}
			if ($date != '1969-12-31' && $count > 0){
				echo "<li>$date - $zip - $count / $testing = $positivity</li>";
				coronavirus_zip($zip,$date,$count,$testing,$positivity);
			}
		}
		$i++;
	}


}

print_r($pieces);
	





die('DONE');

