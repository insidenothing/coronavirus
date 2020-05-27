<?PHP
// break apart the API
include_once('menu.php');

$date = date('Y-m-d');
$r = $core->query("select raw_response from coronavirus_api_cache where id = '13' and just_date = '$date' order by id desc");
$d = mysqli_fetch_array($r);
$zipData = make_maryland_array3($d['raw_response']);
echo "<h1>INPUT</h1>";
echo "<div>".$d['raw_response']."</div>";
echo "<h1>OUPUT</h1>";
echo "<pre>".print_r($zipData)."</pre>";



include_once('footer.php');
