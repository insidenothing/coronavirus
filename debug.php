<?PHP
// break apart the API
include_once('menu.php');
if(isset($_GET['id'])){
  $id = intval($_GET['id']);
}else{
  $id = '13';
}
$r = $core->query("select raw_response from coronavirus_api_cache where api_id = '$id' order by id desc");
$d = mysqli_fetch_array($r);
if (isset($_GET['date'])){
 $date_formatted = $_GET['date'];
}else{
 $date_formatted = 'total'.date('m_d_Y');
}

$zipData = make_maryland_array3($d['raw_response'],$date_foramted);
//$zipData = format_json($d['raw_response']);
echo "<h1>INPUT</h1>";
echo "<div>".$d['raw_response']."</div>";
echo "<h1>OUPUT</h1>";
echo "<pre>";
print_r($zipData);
echo "</pre>";
include_once('footer.php');
