<?PHP
if (isset($_GET['id'])){
  $id = intval($_GET['id']);
}else{
  die('no get id');
}
include_once('/var/www/secure.php'); // this makes $core with out credientals 
$id = substr($id,0,10); // protect strlen
$stmt = $core->prepare('SELECT * FROM coronavirus_api_cache WHERE id = ?');
$stmt->bind_param('i', $id); // https://www.php.net/manual/en/mysqli-stmt.bind-param.php
$stmt->execute();
$result = $stmt->get_result();
$cache = $result->fetch_assoc();
if ($cache['id'] < 1){
 die('id less than 1'); 
}
if (isset($_GET['type'])){
  $type = $_GET['type'];
}else{
  $type = $cache['api_flavor']; 
}
if ($type == 'csv'){
  $type = 'csv';
  header('Content-Type: application/csv');
  header('Content-Disposition: attachment; filename=covid19mathcache'.$id.'.csv');
  header('Pragma: no-cache');
}elseif($type == 'json'){
  $type = 'json';
  header('Content-Type: application/json');
  header('Content-Disposition: attachment; filename=covid19mathcache'.$id.'.json');
}elseif($type == 'xlsx'){
  $type = 'xlsx';
  header('Content-Disposition: attachment; filename=covid19mathcache'.$id.'.xlsx' );
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  // header('Content-Length: ' . filesize($file)); 
  // maybe get strlen of raw_response?
  header('Content-Transfer-Encoding: binary');
  header('Cache-Control: must-revalidate');
  header('Pragma: public');
}elseif($type == 'zip-csv'){
  header("Pragma: public");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Cache-Control: public");
  header("Content-Description: File Transfer");
  header("Content-type: application/octet-stream");
  header("Content-Disposition: attachment; filename=covid19mathcache".$id.".zip");
  header("Content-Transfer-Encoding: binary");
  //header("Content-Length: ".filesize($filepath.$filename)); 
}elseif($type == 'raw'){
  // do nothing but echo
}else{
  // unknown type
  die('unknown type'); 
}
echo $cache['raw_response'];
