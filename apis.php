<?PHP
$page_description = "APIs and Descriptions";
include_once('menu.php');
$q = "SELECT * FROM coronavirus_apis where api_status = 'active' ";
$r = $core->query($q);
while($d = mysqli_fetch_array($r)){
  echo "<li title='$d[api_description]'>$d[last_updated] <u>$d[api_name]</u> <a target='_Blank' href='$d[api_url]'>$d[api_status] API</a></li>";
  $url = $d['api_url'];
  $id = $d['id'];
  $name = $d['api_name'];
  $r2 = $core->query("SELECT raw_response FROM coronavirus_api_cache where api_id = '$id' order by id DESC limit 0,1");
  $d2 = mysqli_fetch_array($r2);
  $old = $d2['raw_response'];
  $raw = getPage($url);
  $raw_response = $core->real_escape_string($raw);
  $test1 = $old;
  $test2 = $raw;
  if ($test1 != $test2){
        $core->query("insert into coronavirus_api_cache ( api_id, cache_date_time, raw_response ) values ( '$id', NOW(), '$raw_response' )");
        $core->query("update coronavirus_apis set last_updated = NOW() where id = '$id' ");
        message_send('4433862584',"$name update");
  }
}
include_once('footer.php');
?>
