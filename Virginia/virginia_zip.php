<?PHP
ob_start();
include_once('../menu.php');

if(isset($_GET['global_date'])){
	$global_date = date('Y-m-d',strtotime($_GET['global_date']));
}

if (isset($_GET['delete'])){
	$delete = date('Y-m-d');
	$covid_db->query(" delete from coronavirus_zip where report_date = '$delete' and state_name = 'Virginia'");
	die('done '.$delete);
}

if (isset($_GET['delete_date'])){
	$delete = $_GET['delete_date'];
	$covid_db->query(" delete from coronavirus_zip where report_date = '$delete' and state_name = 'Virginia'");
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


function coronavirus_zip($zip,$date,$count,$testing){
	global $covid_db;
	global $zipcode;
	$town = $zipcode[$zip];
	$q = "select * from coronavirus_zip where zip_code = '$zip' and report_date = '$date'";
	$r = $covid_db->query($q);
	$d = mysqli_fetch_array($r);
	// look for yesterday
	$date2 = date('Y-m-d',strtotime($date)-86400);
	$q2 = "select * from coronavirus_zip where zip_code = '$zip' and report_date = '$date2'";
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
		$q = "insert into coronavirus_zip (testing_count,zip_code,report_date,report_count,town_name,state_name,trend_direction,trend_duration) values ('$testing','$zip','$date','$count','$town','Virginia','$current_trend','$current_duration') ";
	}else{
		echo "[update $zip $date $count]";
		$q = "update coronavirus_zip set testing = '$testing', report_count = '$count', trend_direction = '$current_trend', trend_duration = '$current_duration', town_name = '$town'  where zip_code = '$zip' and report_date = '$date' ";	
	}
	$covid_db->query($q);
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
		$r = $covid_db->query("select * from coronavirus_api_cache where api_id = '43' order by id desc limit 0, 1"); // always get the latest from the cache	
	}

	
	$d = mysqli_fetch_array($r);
	$date = substr($d['cache_date_time'],0,10);
	//echo $d['raw_response'];

$break = '
';


	$pieces = json_decode($d['raw_response'], true);
$i = count($pieces);
echo "<h1>$i</h1>";
	foreach ($pieces as $pieces2) {
		$i = $i - 1;
		//$date = $global_date;
		$zip = $pieces2['zip_code'];
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
			echo "<li>$i) $date - $zip - $count / $testing</li>";
			coronavirus_zip($zip,$date,$count,$testing);
		}
	}


//echo "<pre>";
//print_r($pieces);
//echo "</pre>";	




$q = "update coronavirus_zip set change_percentage_time = '' where state_name = 'virginia' ";
$covid_db->query($q);
$buffer = ob_get_clean();


if (empty($_GET['run'])){
	echo $buffer;
	die('missing run=1');
}else{
	header('Location: https://www.covid19math.net/zipcode.php?zip=23224&auto=1&state=virginia');	
}



