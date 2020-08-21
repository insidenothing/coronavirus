<?PHP
include_once('../menu.php');

if(isset($_GET['global_date'])){
	$global_date = date('Y-m-d',strtotime($_GET['global_date']));
}

if (isset($_GET['delete'])){
	$delete = date('Y-m-d');
	$covid_db->query(" delete from coronavirus_zip where report_date = '$delete' and state_name = 'Arizona'");
	die('done '.$delete);
}

if (isset($_GET['delete_date'])){
	$delete = $_GET['delete_date'];
	$covid_db->query(" delete from coronavirus_zip where report_date = '$delete' and state_name = 'Arizona'");
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


function coronavirus_zip($zip,$date,$count){
	if ($count == 0){
		echo "[skip - count too low $zip for $date]";
		return 1;
	}
	global $covid_db;
	global $zipcode;
	$town = $zipcode[$zip];
	$testing=0;
	$q = "select * from coronavirus_zip where zip_code = '$zip' and report_date = '$date'";
	$r = $covid_db->query($q);
	$d = mysqli_fetch_array($r);
	if ($d['id'] == ''){
		echo "[insert $zip $date $count]";
		$q = "insert into coronavirus_zip (testing_count,zip_code,report_date,report_count,town_name,state_name) values ('$testing','$zip','$date','$count','$town','Arizona') ";
	}else{
		echo "[update $zip $date $count]";
		$q = "update coronavirus_zip set testing = '$testing', report_count = '$count', town_name = '$town'  where zip_code = '$zip' and report_date = '$date' ";	
	}
	$covid_db->query($q);
	//slack_general("$q",'covid19-sql');
}


global $nocases;
global $cases;
global $zipData;
global $date;








if($global_date == date('Y-m-d') || isset($_GET['id'])){

	
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$r = $covid_db->query("select * from coronavirus_api_cache where id = '$id' order by id desc limit 0, 1"); // always get the latest from the cache
	}else{
		$r = $covid_db->query("select * from coronavirus_api_cache where api_id = '68' order by id desc limit 0, 1"); // always get the latest from the cache	
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
			echo "<li>coronavirus_zip($zip,$date,$count)</li>";
			coronavirus_zip($zip,$date,$count);
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
			//coronavirus_zip($zip,$date,$count,$testing);
		}
		*/
	}
  
}

echo "<pre>";
print_r($pieces);
echo "</pre>";	

$covid_db->query("update coronavirus_apis set last_run_date = NOW() where id = '68' ");


$q = "update coronavirus_zip set change_percentage_time = '' where state_name = 'arizona' ";
$covid_db->query($q);
die('DONE '.$q);

