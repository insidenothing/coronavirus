<?PHP
include_once('../menu.php');


if (isset($_GET['delete'])){
	$delete = date('Y-m-d');
	$core->query(" delete from coronavirus_zip where report_date = '$delete' and state_name = 'Florida'");
	die('done '.$delete);
}

if (isset($_GET['delete_date'])){
	$delete = $_GET['delete_date'];
	$core->query(" delete from coronavirus_zip where report_date = '$delete' and state_name = 'Florida'");
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


function coronavirus_zip($zip,$date,$count){
	global $core;
	global $zipcode;
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
		echo "[$date insert $zip $count]";
		$q = "insert into coronavirus_zip (zip_code,report_date,report_count,town_name,state_name,trend_direction,trend_duration) values ('$zip','$date','$count','$town','Florida','$current_trend','$current_duration') ";
	}else{
		echo "[$date update $zip $count]";
		$q = "update coronavirus_zip set report_count = '$count', trend_direction = '$current_trend', trend_duration = '$current_duration', town_name = '$town'  where zip_code = '$zip' and report_date = '$date' ";	
	}
	$core->query($q);
	//slack_general("$q",'covid19-sql');
}


global $nocases;
global $cases;
global $zipData;
global $date;


if (isset($_GET['id'])){
	$cache_id = $_GET['id'];
	$r = $core->query("select * from coronavirus_api_cache where id = '$cache_id' limit 0, 1"); // use a specific item from the cache
}else{
	$r = $core->query("select * from coronavirus_api_cache where api_id = '30' order by id desc limit 0, 1"); // always get the latest from the cache
}
$d = mysqli_fetch_array($r);

//echo $d['raw_response'];
$date = substr($d['cache_date_time'],0,10);
$array = json_decode($d['raw_response'], true);
/*
$return = array();

foreach ($array['features'] as $key => $value){
	//OBJECTID" : 642, "ZIP" : "33445", "OBJECTID_1" : 1053, "DEPCODE" : 50, "COUNTYNAME" : "Palm Beach", "FieldMatch" : "Palm Beach-33445", "POName" : "Delray Beach", "Places" : "Boca Raton, Delray Beach, Boynton Beach", "OBJECTID_12" : 798, "ZIPX" : "Palm Beach-33445", "c_places" : "Delray Beach", "Cases_1" : "221", "LabelY" : 221, "Shape__Area" : 0.00188006293865328, "Shape__Length" : 0.199578714953371 } }, 
	$zip = $value['attributes']['ZIP'];
	$return[$zip] = $value['attributes']['Cases_1'];
}

print_r($return);
*/
echo "<pre>";
print_r($array);
echo "</pre>";

if (empty($_GET['run'])){
	die('missing &run=1');
}

if($global_date == date('Y-m-d') || isset($_GET['id']) ){
	foreach ($array['features'] as $key => $value){
		//OBJECTID" : 642, "ZIP" : "33445", "OBJECTID_1" : 1053, "DEPCODE" : 50, "COUNTYNAME" : "Palm Beach", "FieldMatch" : "Palm Beach-33445", "POName" : "Delray Beach", "Places" : "Boca Raton, Delray Beach, Boynton Beach", "OBJECTID_12" : 798, "ZIPX" : "Palm Beach-33445", "c_places" : "Delray Beach", "Cases_1" : "221", "LabelY" : 221, "Shape__Area" : 0.00188006293865328, "Shape__Length" : 0.199578714953371 } }, 
		$zip = $value['attributes']['ZIP'];
		$count = $value['attributes']['Cases_1'];
		if ($count == '<5'){
			$count = 5;
		}
		echo "<li>$key coronavirus_zip($zip,$date,$count)</li>";
		coronavirus_zip($zip,$date,$count);
	}
}	
	



$q = "update coronavirus_zip set change_percentage_time = '' where state_name = 'florida' ";
$core->query($q);
die('DONE '.$q);
