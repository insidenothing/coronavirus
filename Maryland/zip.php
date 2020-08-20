<?PHP
//ob_get_clean();
include_once('../menu.php');
if (isset($_GET['delete'])){
	$delete = date('Y-m-d');
	$covid_db->query(" delete from coronavirus_zip where report_date = '$delete' and state_name = 'Maryland'");
	die('done');
}

global $zipcode;
$zipcode = array();
$q = "select distinct zip_code, town_name from coronavirus_zip where town_name <> ''";
$r = $covid_db->query($q);
while($d = mysqli_fetch_array($r)){
	$zip = $d['zip_code'];
	$zipcode[$zip] = $d['town_name'];
}
/*
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
*/
function coronavirus_zip($zip,$date,$count){
	global $zipcode;
	$town = '';
	if (isset($zipcode[$zip])){
		$town = $zipcode[$zip];
	}
	// the order we call the function will matter...
	global $covid_db;
	$q = "select * from coronavirus_zip where zip_code = '$zip' and report_date = '$date'";
	$r = $covid_db->query($q);
	$d = mysqli_fetch_array($r);
	if ($d['id'] == ''){
		echo "[insert $zip $count]";
		$q = "insert into coronavirus_zip (zip_code,report_date,report_count,town_name,state_name) values ('$zip','$date','$count','$town','Maryland') ";
	}else{
		echo "[update $zip $count]";
		$q = "update coronavirus_zip set report_count = '$count'  where zip_code = '$zip' and report_date = '$date' ";
		
	}
	$covid_db->query($q);


}

global $nocases;
global $cases;
global $zipData;
global $date;

//$q = "select * from coronavirus_api_cache where api_id = '13' order by id desc";


if(isset($_GET['id'])){
	$id = $_GET['id'];
	$q = "select * from coronavirus_api_cache where id = '$id' order by id desc limit 0, 1"; // always get the latest from the cache
}else{
	$q = "select * from coronavirus_api_cache where api_id = '13' order by id desc limit 0, 1"; // always get the latest from the cache	
}


$r = $covid_db->query($q);
echo "<h1>$q</h1>";
$d = mysqli_fetch_array($r);
echo "<h1>Cache ID $d[id] from $d[cache_date_time]</h1>";


//echo $d['raw_response'];

if(isset($_GET['id'])){
	$date = date('Y-m-d',strtotime($d['cache_date_time']));
	$date_formated = 'total'.$date_formated = date('m_d_Y',strtotime($date));
	$zipData = make_maryland_array3($d['raw_response'],$date_formated);
}else{
	$zipData = make_maryland_array3($d['raw_response'],'');
}





asort($zipData); // Sort Array (Ascending Order), According to Value - asort()

echo "<pre>";
print_r($zipData);
echo "</pre>";

if (empty($_GET['run'])){
	die('set run=1');
}

$i=count($zipData);
foreach ($zipData as $key => $value){
  // coronavirus_zip($zip,$date,$count);
	$i = $i - 1;
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
//$buffer = ob_get_clean();



if (isset($_GET['id'])){
	$cache_id = $_GET['id'];
	$r = $covid_db->query("SELECT id, cache_date_time FROM coronavirus_api_cache where api_id = '13' and id > '$cache_id' order by id limit 0,1");
   	$d = mysqli_fetch_array($r);
	if ($d['id']){
		echo "<meta http-equiv=\"refresh\" content=\"1; url=https://www.covid19math.net/Maryland/zip.php?id=".$d['id']."&run=1&from_id=$cache_id\">";
	}
}else{
	$q = "update coronavirus_county set change_percentage_time = '' where state_name = 'maryland' ";
	$covid_db->query($q);	
}



//header('Location: https://www.covid19math.net/zipcode.php?zip=21208&auto=1&state=maryland');

die('done');

