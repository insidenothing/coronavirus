<?PHP
include_once('../menu.php');


if (isset($_GET['delete'])){
	$delete = date('Y-m-d');
	$covid_db->query(" delete from coronavirus_zip where report_date = '$delete' and state_name = 'Florida'");
	die('done '.$delete);
}

if (isset($_GET['delete_date'])){
	$delete = $_GET['delete_date'];
	$covid_db->query(" delete from coronavirus_zip where report_date = '$delete' and state_name = 'Florida'");
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
	global $covid_db;
	global $zipcode;
	$town = $zipcode[$zip];
	$date_now = time() - 1814400;
	$date_then = strtotime($date);
	$q = "select * from coronavirus_zip where zip_code = '$zip' and report_date = '$date'";
	$r = $covid_db->query($q);
	$d = mysqli_fetch_array($r);
	if ($d['id'] == ''){
		echo "[$date insert $zip $count]";
		$q = "insert into coronavirus_zip (zip_code,report_date,report_count,town_name,state_name) values ('$zip','$date','$count','$town','Florida') ";
	}else{
		echo "[$date update $zip $count]";
		$q = "update coronavirus_zip set report_count = '$count', town_name = '$town'  where zip_code = '$zip' and report_date = '$date' ";	
	}
	$covid_db->query($q) or die("SQL Error " . mysqli_error($covid_db));
	//slack_general("$q",'covid19-sql');
}


global $nocases;
global $cases;
global $zipData;
global $date;


if (isset($_GET['id'])){
	$cache_id = $_GET['id'];
	$r = $covid_db->query("select * from coronavirus_api_cache where id = '$cache_id' limit 0, 1"); // use a specific item from the cache
}else{
	$r = $covid_db->query("select * from coronavirus_api_cache where api_id = '30' order by id desc limit 0, 1"); // always get the latest from the cache
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
//echo "<pre>";
//print_r($array);
//echo "</pre>";

if (empty($_GET['run'])){
	die('missing &run=1');
}


?>
<script>
function scrolldown() {
  setTimeout(
    function()
    {
      window.scrollTo(0,document.body.scrollHeight);
      scrolldown();
    }, 1000
  )
}

scrolldown();
	
	
</script>


<?PHP


if($global_date == date('Y-m-d') || isset($_GET['id']) ){
	foreach ($array['features'] as $key => $value){
		//OBJECTID" : 642, "ZIP" : "33445", "OBJECTID_1" : 1053, "DEPCODE" : 50, "COUNTYNAME" : "Palm Beach", "FieldMatch" : "Palm Beach-33445", "POName" : "Delray Beach", "Places" : "Boca Raton, Delray Beach, Boynton Beach", "OBJECTID_12" : 798, "ZIPX" : "Palm Beach-33445", "c_places" : "Delray Beach", "Cases_1" : "221", "LabelY" : 221, "Shape__Area" : 0.00188006293865328, "Shape__Length" : 0.199578714953371 } }, 
		$zip = $value['attributes']['ZIPX'];
		$count = $value['attributes']['Cases_1'];
		if ($count == '<5'){
			$count = 5;
		}
		echo "<li>".date('r')." $key coronavirus_zip($zip,$date,$count)</li>";
		coronavirus_zip($zip,$date,$count);
	}
}	
	

$covid_db->query("update coronavirus_apis set last_run_date = NOW() where id = '30' ");


if (isset($_GET['id'])){
	$cache_id = $_GET['id'];
	$r = $covid_db->query("SELECT id, cache_date_time FROM coronavirus_api_cache where api_id = '30' and id > '$cache_id' order by id limit 0,1");
   	$d = mysqli_fetch_array($r);
	if ($d['id']){
		echo "<meta http-equiv=\"refresh\" content=\"1; url=https://www.covid19math.net/Florida/florida_zip.php?id=".$d['id']."&run=1&from_id=$cache_id\">";
	}
}else{
	$q = "update coronavirus_zip set change_percentage_time = '' where state_name = 'florida' ";
	$covid_db->query($q);	
}
die('DONE '.$q);
