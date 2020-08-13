<?PHP
include_once('../menu.php');

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




function coronavirus_state($date,$death_count,$report_count,$testing_count){
	
	global $covid_db;
	
	$q = "select * from coronavirus_state where report_date = '$date' and state_name = 'Delaware'";
	$r = $covid_db->query($q);
	$d = mysqli_fetch_array($r);
	
	if ($d['id'] == ''){
		echo "[insert $date $count]";
		$q = "insert into coronavirus_state (testing_count,death_count,report_date,report_count,state_name) values ('$testing_count','$death_count','$date','$report_count','Delaware') ";
	}else{
		echo "[update $date $count]";
		$q = "update coronavirus_state set death_count='$death_count', testing_count = '$testing_count', report_count = '$report_count' where state_name='Delaware' and report_date = '$date' ";	
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
	$csv = str_replace('"rate per 10,000 people"','rate',$csv);
	$data = explode(',',$csv);
	$Statistic = $data[2];
	$date = date('Y-m-d',strtotime($data[4].'-'.$data[5].'-'.$data[6])); // year - month - day
	$value = $data[3];
	$types[] = $Statistic.'-'.$data[7]; // for unique display
	if ($Statistic == 'Cumulative Number of Positive Cases' && $data[7] == 'people'){
		$new_array[$date]['report_count'] = $value;
	}
	if ($Statistic == 'Deaths' && $data[7] == 'people'){
		$new_array[$date]['death_count'] = $value;
	}
	if ($Statistic == 'Total Persons Tested' && $data[7] == 'people'){
		$new_array[$date]['testing_count'] = $value;
	}
	
	
}


foreach($new_array as $date => $data){
	echo "<li>coronavirus_state($date,$data[death_count],$data[report_count],$data[testing_count])</li>";
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
