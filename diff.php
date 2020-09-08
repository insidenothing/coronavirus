<?PHP
if (isset($_GET['id2'])){
  $id2 = intval($_GET['id2']);
}else{
  die('no get id2');
}
if (isset($_GET['id'])){
  $id = intval($_GET['id']);
}else{
  die('no get id');
}
include_once('/var/www/secure.php'); // this makes $covid_db with out credientals 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$id = substr($id,0,10); // protect strlen
$id2 = substr($id2,0,10); // protect strlen
$stmt = $covid_db->prepare('SELECT * FROM coronavirus_api_cache WHERE id = ?');
$stmt->bind_param('i', $id); // https://www.php.net/manual/en/mysqli-stmt.bind-param.php
$stmt->execute();
$result = $stmt->get_result();
$cache = $result->fetch_assoc();
if ($cache['id'] < 1){
 die('id less than 1'); 
}
$stmt = $covid_db->prepare('SELECT * FROM coronavirus_api_cache WHERE id = ?');
$stmt->bind_param('i', $id2); // https://www.php.net/manual/en/mysqli-stmt.bind-param.php
$stmt->execute();
$result = $stmt->get_result();
$cache2 = $result->fetch_assoc();
if ($cache['id'] < 1){
 die('id2 less than 1'); 
}
$diff = xdiff_string_diff($cache['raw_response'], $cache2['raw_response'], 1);
if (is_string($diff)) {
    echo "Differences:\n";
    echo $diff;
}
