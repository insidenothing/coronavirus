<?PHP
include_once('/var/www/secure.php'); //outside webserver
include_once('../functions.php'); //outside webserver
$page_description = 'Maryland Facilities Abstract Data Table';
include_once('../menu.php');
ob_start();
$q = "select * from coronavirus_apis where run_order = '5000' "; // MD Facilities
$r = $core->query($q);
while ($d = mysqli_fetch_array($r)){
  $q2 = "select * from coronavirus_api_cache where api_id = '$d[id]' order by id desc limit 0,1 ";
  $r2 = $core->query($q2);
  $d2 = mysqli_fetch_array($r2);
  echo "<h1>$d[api_name] from $d2[cache_date_time]<h1>";
  $json = $d2['raw_response'];
  $array = json_decode($json, true);
  echo "<pre>";
  //echo $d2['raw_response'];
  print_r($array);
  echo "</pre>";
}
$buffer=ob_get_clean();






echo $buffer;
include_once('../footer.php');
