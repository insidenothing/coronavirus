<?PHP
include_once('../menu.php');

if(isset($_GET['global_date'])){
	$global_date = date('Y-m-d',strtotime($_GET['global_date']));
}

if (isset($_GET['delete'])){
	$delete = date('Y-m-d');
	$covid_db->query(" delete from coronavirus_state where report_date = '$delete' and state_name = 'Delaware'");
	die('done '.$delete);
}

if (isset($_GET['delete_date'])){
	$delete = $_GET['delete_date'];
	$covid_db->query(" delete from coronavirus_state where report_date = '$delete' and state_name = 'Delaware'");
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
	$q = "select * from coronavirus_state where report_date = '$date' and state_name = 'Delaware'";
	$r = $covid_db->query($q);
	$d = mysqli_fetch_array($r);
	
	if ($d['id'] == ''){
		echo "[insert $date $count]";
		$q = "insert into coronavirus_state (testing_count,county_name,report_date,report_count,town_name,state_name) values ('$testing','$zip','$date','$count','$town','Delaware') ";
	}else{
		echo "[update $date $count]";
		$q = "update coronavirus_state set testing = '$testing', report_count = '$count' where state_name='Delaware' and report_date = '$date' ";	
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

$new_array = array();

foreach($pieces as $row => $csv){
	$data = explode(',',$csv);
	$Statistic = $data[2];
	$date = $data[4].'-'.$data[5].'-'.$data[6]; // year - month - day
	$value = $data[3];
	$types[] = $Statistic.'-'.$data[9]; // for unique display
	if ($Statistic == 'Cumulative Number of Confirmed Positive Cases' && $data[9] == 'false'){
		$new_array[$date]['cases'] = $value;
	}
	if ($Statistic == 'Confirmed Deaths' && $data[9] == 'false'){
		$new_array[$date]['deaths'] = $value;
	}
	
}


echo "<pre>";
print_r($new_array);
echo "</pre>";	


$result = array_unique($types);
echo "<pre>";
print_r($result);
echo "</pre>";	




echo "<pre>";
print_r($pieces);
echo "</pre>";	






die('DONE');
