<?PHP
include_once('../menu.php');

if(isset($_GET['global_date'])){
	$global_date = date('Y-m-d',strtotime($_GET['global_date']));
}

if (isset($_GET['delete'])){
	$delete = date('Y-m-d');
	$covid_db->query(" delete from coronavirus_county where report_date = '$delete' and state_name = 'maryland'");
	die('done '.$delete);
}

if (isset($_GET['delete_date'])){
	$delete = $_GET['delete_date'];
	$covid_db->query(" delete from coronavirus_county where report_date = '$delete' and state_name = 'maryland'");
	die('done '.$delete);
}

global $zipcode;
$zipcode = array();
$q = "select distinct zip_code, town_name from coronavirus_zip where town_name <> ''";
$r = $covid_db->query($q);
while($d = mysqli_fetch_array($r)){
	$zip = $d['zip_code'];
	$zipcode[$zip] = $d['town_name'];
}


function coronavirus_state($state,$date,$count){
	if ($count == 0){
		echo "[skip - count too low $zip for $date]";
		return 1;
	}
	global $covid_db;
	global $zipcode;
	$town = $zipcode[$zip];
	$testing=0;
	$q = "select * from coronavirus_state where county_name = '$zip' and report_date = '$date' and state_name = 'maryland'";
	$r = $covid_db->query($q);
	$d = mysqli_fetch_array($r);
	// look for yesterday
	$date2 = date('Y-m-d',strtotime($date)-86400);
	$q2 = "select * from coronavirus_state where county_name = '$zip' and report_date = '$date2' and state_name = 'maryland'";
	$r2 = $covid_db->query($q2);
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
		$q = "insert into coronavirus_state (testing_count,county_name,report_date,report_count,town_name,state_name,trend_direction,trend_duration) values ('$testing','$zip','$date','$count','$town','maryland','$current_trend','$current_duration') ";
	}else{
		echo "[update $zip $date $count]";
		$q = "update coronavirus_state set testing = '$testing', report_count = '$count', trend_direction = '$current_trend', trend_duration = '$current_duration', town_name = '$town'  where county_name = '$zip' and state_name='maryland' and report_date = '$date' ";	
	}
	$covid_db->query($q);
	//slack_general("$q",'covid19-sql');
}

	
	if(isset($_GET['id'])){
		$id = intval($_GET['id']);
		$r = $covid_db->query("select * from coronavirus_api_cache where id = '$id' order by id desc limit 0, 1"); // always get the latest from the cache
	}else{
		$r = $covid_db->query("select * from coronavirus_api_cache where api_id = '48' order by id desc limit 0, 1"); // always get the latest from the cache	
	}


	$d = mysqli_fetch_array($r);

	$date = substr($d['cache_date_time'],0,10);
	
	

$break = '
'; 
 
$pieces = explode($break,$d['raw_response']);

//coronavirus_state($state,$date,$count)


$types = array();


foreach($pieces as $row => $csv){
	$data = explode(',',$csv);
	$types[] = $data[2];
}

$result = array_unique($types);
echo "<pre>";
print_r($result);
echo "</pre>";	


echo "<pre>";
print_r($pieces);
echo "</pre>";	






die('DONE');
