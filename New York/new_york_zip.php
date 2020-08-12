<?PHP
include_once('../menu.php');

global $state;
// EDIT HERE
$state = 'New York';
$api_id = '62';
/* 
0 MODIFIED_ZCTA,
1 NEIGHBORHOOD_NAME,
2 BOROUGH_GROUP,
3 COVID_CASE_COUNT,
4 COVID_CASE_RATE,
5 POP_DENOMINATOR,
6 COVID_DEATH_COUNT,
7 COVID_DEATH_RATE,
8 PERCENT_POSITIVE,
9 TOTAL_COVID_TESTS
*/
$town_piece = '1';
$zip_piece = '0';
$count_piece = '3';
$testing_piece = '9';
$positivity_piece = '8'; 
// EDIT HERE

if (isset($_GET['delete'])){
	$delete = date('Y-m-d');
	$covid_db->query(" delete from coronavirus_zip where report_date = '$delete' and state_name = '$state'");
	die('done '.$delete);
}

if (isset($_GET['delete_date'])){
	$delete = $_GET['delete_date'];
	$covid_db->query(" delete from coronavirus_zip where report_date = '$delete' and state_name = '$state'");
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


function coronavirus_zip($zip,$date,$count,$testing,$positivity,$town){
	global $covid_db;
	global $zipcode;
  	global $state;
	$q = "select * from coronavirus_zip where zip_code = '$zip' and report_date = '$date'";
	$r = $covid_db->query($q);
	$d = mysqli_fetch_array($r);
	$town = $covid_db->real_escape_string($town);
	if ($d['id'] == ''){
		echo "[insert $town $zip $date $count]";
		$q = "insert into coronavirus_zip (positivity_rate,testing_count,zip_code,report_date,report_count,town_name,state_name) values ('$positivity','$testing','$zip','$date','$count','$town','$state') ";
	}else{
		echo "[update $town $zip $date $count]";
		$q = "update coronavirus_zip set positivity_rate='$positivity', testing = '$testing', report_count = '$count', town_name = '$town'  where zip_code = '$zip' and report_date = '$date' ";	
	}
	$covid_db->query($q);
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
		$r = $covid_db->query("select * from coronavirus_api_cache where id = '$id' order by id desc limit 0, 1"); // always get the latest from the cache
	}else{
		$r = $covid_db->query("select * from coronavirus_api_cache where api_id = '$api_id' order by id desc limit 0, 1"); // always get the latest from the cache	
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
			$town =  $pieces2[$town_piece];
			if ($count == 'Suppressed*'){
				$count = 4;
			}
			if ($zip == 'NA'){
				$zip = '00003';
			}
			if ($date != '1969-12-31' && $count > 0){
				echo "<li>$date - $town - $zip - $count / $testing = $positivity</li>";
				coronavirus_zip($zip,$date,$count,$testing,$positivity,$town);
			}
		}
		$i++;
	}


}

print_r($pieces);
	





die('DONE');

