<?PHP
include_once('menu.php');
if (isset($_GET['delete'])){
	$delete = date('Y-m-d');
	$core->query(" delete from coronavirus_zip where report_date = '$delete'");
	die('done');
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
	global $zipcode;
	$town = $zipcode[$zip];
	// the order we call the function will matter...
	global $core;
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
		$q = "insert into coronavirus_zip (zip_code,report_date,report_count,town_name,state_name,trend_direction,trend_duration) values ('$zip','$date','$count','$town','Maryland','$current_trend','$current_duration') ";
	}else{
		$q = "update coronavirus_zip set report_count = '$count', trend_direction = '$current_trend', trend_duration = '$current_duration'  where zip_code = '$zip' and report_date = '$date' ";
		
	}
	$core->query($q);
	slack_general("$q",'covid19-sql');

}

global $nocases;
global $cases;
global $zipData;
global $date;

$q = "select * from coronavirus_api_cache where api_id = '13' order by id desc";
$r = $core->query($q);
echo "<h1>$q</h1>";
$d = mysqli_fetch_array($r);
if(isset($_GET['date_formatted'])){
	$zipData = make_maryland_array3($d['raw_response'],$_GET['date_formatted']);
	$date = $_GET['date'];
}else{
	$zipData = make_maryland_array3($d['raw_response'],'');
	$date = date('Y-m-d');
}



asort($zipData); // Sort Array (Ascending Order), According to Value - asort()


print_r($zipData);
echo $d['raw_response'];


die('dev hold');


$i=0;
foreach ($zipData as $key => $value){
  // coronavirus_zip($zip,$date,$count);
	$i++;
	echo "<h1>$i : ".$zipcode[$key]." $key $date ".intval($value)." </h1>";
	$count = intval($value);
	if ($count == 0){
		$count = 7; 
		// since we get data starting at 8- but only zips with cases are in the data set, 
		// so let's fix all the data and start with 1 less than the first number we get, 7
	}
	coronavirus_zip($key,$date,$count);
}
slack_general("*DONE*",'covid19');

die('done');

