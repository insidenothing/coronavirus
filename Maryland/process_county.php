<?PHP
include_once('../menu.php');

if(isset($_GET['global_date'])){
	$global_date = date('Y-m-d',strtotime($_GET['global_date']));
}

if (isset($_GET['delete'])){
	$delete = date('Y-m-d');
	$core->query(" delete from coronavirus_county where report_date = '$delete' and state_name = 'maryland'");
	die('done '.$delete);
}

if (isset($_GET['delete_date'])){
	$delete = $_GET['delete_date'];
	$core->query(" delete from coronavirus_county where report_date = '$delete' and state_name = 'maryland'");
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


function coronavirus_county($zip,$date,$count){
	if ($count == 0){
		echo "[skip - count too low $zip for $date]";
		return 1;
	}
	global $core;
	global $zipcode;
	$town = $zipcode[$zip];
	$testing=0;
	$q = "select * from coronavirus_county where county_name = '$zip' and report_date = '$date'";
	$r = $core->query($q);
	$d = mysqli_fetch_array($r);
	// look for yesterday
	$date2 = date('Y-m-d',strtotime($date)-86400);
	$q2 = "select * from coronavirus_county where county_name = '$zip' and report_date = '$date2'";
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
		$q = "insert into coronavirus_county (testing_count,county_name,report_date,report_count,town_name,state_name,trend_direction,trend_duration) values ('$testing','$zip','$date','$count','$town','Arizona','$current_trend','$current_duration') ";
	}else{
		echo "[update $zip $date $count]";
		$q = "update coronavirus_county set testing = '$testing', report_count = '$count', trend_direction = '$current_trend', trend_duration = '$current_duration', town_name = '$town'  where county_name = '$zip' and report_date = '$date' ";	
	}
	$core->query($q);
	//slack_general("$q",'covid19-sql');
}


global $nocases;
global $cases;
global $zipData;
global $date;








if($global_date == date('Y-m-d') || isset($_GET['id'])){

	
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$r = $core->query("select * from coronavirus_api_cache where id = '$id' order by id desc limit 0, 1"); // always get the latest from the cache
	}else{
		$r = $core->query("select * from coronavirus_api_cache where api_id = '68' order by id desc limit 0, 1"); // always get the latest from the cache	
	}

	// watch for microsoft characters =(
	$d = mysqli_fetch_array($r);

	$date = substr($d['cache_date_time'],0,10);
	$parts = explode('ConfirmedCaseCount',$d['raw_response']);
	$subparts = explode('�',$parts[1]);
	$raw =  $subparts[0];
	$raw = str_replace('','',$raw); // \uc
	//echo $raw;

$break 		= ''; // \u5
$seperator 	= ''; // \u4	
  
$pieces = explode($break,$raw);  
 

  foreach ($pieces as $pieces2) {
	  	//$date = $global_date;
	  	$zip = intval(substr(trim($pieces2),0,5));	
	  	if ($zip != 0){
			$count = preg_replace("/[^a-zA-Z0-9]+/", "_", $pieces2);
			$count = str_replace($zip,'_',$count); 
			$count = str_replace('Tribal','_',$count); 
			$count = str_replace('Data','_',$count); 
			$count = str_replace('Suppressed','_',$count); 
			$piecesX = explode('_',$count);
			$bits = count($piecesX) - 1;
			$count = intval($piecesX[$bits]);
			echo "<li>coronavirus_county($zip,$date,$count)</li>";
			//coronavirus_county($zip,$date,$count);
		}
	  	/*
		
		$count = $pieces2['number_of_cases'];
		$testing = $pieces2['number_of_pcr_testing'];
		if ($count == 'Suppressed*'){
			$count = 4;
		}
		if ($testing == 'Suppressed*'){
			$testing = 4;
		}
		if ($zip == 'Not Reported'){
			$zip = '00002';
		}
		if ($zip == 'Out-of-State'){
			$zip = '00004';
		}
		if ($date != '1969-12-31'){
			echo "<li>$date - $zip - $count / $testing</li>";  
			      if (empty($_GET['run'])){
				//die('missing run=1');
			      }
			//coronavirus_county($zip,$date,$count,$testing);
		}
		*/
	}
  
}

echo "<pre>";
print_r($pieces);
echo "</pre>";	




$q = "update coronavirus_county set change_percentage_time = '' where state_name = 'maryland' ";
$core->query($q);
die('DONE '.$q);
