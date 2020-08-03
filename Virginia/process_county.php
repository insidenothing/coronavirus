<?PHP
include_once('../menu.php');
global $covid_db;
if(isset($_GET['global_date'])){
	$global_date = date('Y-m-d',strtotime($_GET['global_date']));
}
if (isset($_GET['delete'])){
	$delete = date('Y-m-d');
	$covid_db->query(" delete from coronavirus_county where report_date = '$delete' and state_name = 'virginia'");
	die('done '.$delete);
}
if (isset($_GET['delete_date'])){
	$delete = $_GET['delete_date'];
	$covid_db->query(" delete from coronavirus_county where report_date = '$delete' and state_name = 'virginia'");
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
function coronavirus_county($zip,$date,$count,$death_count,$hospitalizations){
	//return "<li>coronavirus_county($zip,$date,$count)</li>";
	if ($count == 0){
		echo "[skip - count too low $zip for $date]";
		return 1;
	}
	global $covid_db;
	global $zipcode;
	$town = $zipcode[$zip];
	$testing=0;
	$q = "select * from coronavirus_county where county_name = '$zip' and report_date = '$date' and state_name = 'virginia'";
	$r = $covid_db->query($q);
	$d = mysqli_fetch_array($r);
	// look for yesterday
	$date2 = date('Y-m-d',strtotime($date)-86400);
	$q2 = "select * from coronavirus_county where county_name = '$zip' and report_date = '$date2' and state_name = 'virginia'";
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
		$q = "insert into coronavirus_county (hospitalizations,death_count,testing_count,county_name,report_date,report_count,town_name,state_name,trend_direction,trend_duration) values ('$hospitalizations','$death_count','$testing','$zip','$date','$count','$town','virginia','$current_trend','$current_duration') ";
	}else{
		echo "[update $zip $date $count]";
		$q = "update coronavirus_county set hospitalizations='$hospitalizations', death_count='$death_count',testing_count = '$testing', report_count = '$count', trend_direction = '$current_trend', trend_duration = '$current_duration', town_name = '$town'  where county_name = '$zip' and report_date = '$date' ";	
	}
	$covid_db->query($q) or die(mysqli_error($covid_db));
	//slack_general("$q",'covid19-sql');
}
global $nocases;
global $cases;
global $zipData;
global $date;	
if(isset($_GET['id'])){
	$id = $_GET['id'];
	$r = $covid_db->query("select * from coronavirus_api_cache where id = '$id' order by id desc limit 0, 1"); // always get the latest from the cache
}else{
	$r = $covid_db->query("select * from coronavirus_api_cache where api_id = '35' order by id desc limit 0, 1"); // always get the latest from the cache	
}
$d = mysqli_fetch_array($r);
//$date = substr($d['cache_date_time'],0,10);

$break = '
';

$pieces = json_decode($d['raw_response'], true); 
echo "<h1>".count($pieces)."</h1>";
if (count($pieces) == 0){
	echo "<h1>USING CSV METHOD</h1>";
	$pieces = explode($break,$d['raw_response']);
	echo "<h3>".count($pieces)."</h3>";
	foreach ($pieces as $key => $value){
		// 6/25/2020,51840,Winchester,Lord Fairfax,301,21,3 coronavirus_county(,2020-08-02 11:06:01,,,);
		$parts = explode(',',$value);
		$date = $parts[0];
		$name = $parts[2];
		$count = $parts[4];
		$hospitalizations = $parts[5];
		$deaths = $parts[6];
		if ($name != 'Locality' && $name != ''){
			echo "<li>coronavirus_county($name,$date,$count,$deaths,$hospitalizations);</li>";
			coronavirus_county($name,$date,$count,$deaths,$hospitalizations);
		}
	}
	echo $d['raw_response'];
}else{
	echo "<h1>USING JSON METHOD</h1>";
	foreach ($pieces as $key => $value){
		//$time = $value['attributes']['DATE'] / 1000;
		//$date = date('Y-m-d',$time+14400);
		//echo "<li>$date </li>";
		$name = $value['locality'];
		$count = $value['total_cases'];
		$date = substr($value['report_date'],0,10);
		$hospitalizations = $value['hospitalizations'];
		$deaths = $value['deaths'];
		//if ($name != 'A State'){
			echo "<li>coronavirus_county($name,$date,$count,$deaths,$hospitalizations);</li>";
			//coronavirus_county($name,$date,$count,$deaths,$hospitalizations);
		//}
	}
	echo "<pre>";
	print_r($pieces);
	echo "</pre>";
}




if (isset($_GET['id'])){
	$cache_id = $_GET['id'];
	$r = $covid_db->query("SELECT id, cache_date_time FROM coronavirus_api_cache where api_id = '35' and id > '$cache_id' order by id limit 0,1");
   	$d = mysqli_fetch_array($r);
	if ($d['id']){
//		echo "<meta http-equiv=\"refresh\" content=\"1; url=https://www.covid19math.net/Virginia/process_county.php?id=".$d['id']."&run=1&from_id=$cache_id\">";
	}
}else{
	$q = "update coronavirus_county set change_percentage_time = '' where state_name = 'virginia' ";
	$covid_db->query($q);	
}
die('DONE '.$q);
