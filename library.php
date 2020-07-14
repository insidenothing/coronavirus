<?PHP
$page_description = "National Library of COVID-19 API Data";
include_once('menu.php');

$q = "SELECT * FROM coronavirus_apis where api_status = 'active' order by run_order DESC, last_updated DESC ";
$r = $core->query($q);
while($d = mysqli_fetch_array($r)){
  //slack_general("$d[run_delay] second delay to check $d[api_name]",'covid19-apis');
  //sleep($d['run_delay']);
  $color = 'lightblue';
  if (substr($d['last_updated'],0,10) == date('Y-m-d')){
    $color='lightgreen';
  }
  if (substr($d['last_updated'],0,10) == date('Y-m-d',strtotime('-1 day'))){
    $color='lightyellow';
  }
  echo "<li style='background-color:$color;' title='$d[api_description]'>$d[run_order]: $d[last_updated] <u>$d[api_name]</u> $d[api_status] <a target='_Blank' href='?debug=$d[id]'>CACHE</a> or <a target='_Blank' href='$d[api_url]'>SOURCE</a></li>";
  $url = $d['api_url'];
  $id = $d['id'];
  $name = $d['api_name'];
  $r2 = $core->query("SELECT id, cache_date_time FROM coronavirus_api_cache where api_id = '$id' order by id DESC);
  while($d2 = mysqli_fetch_array($r2)){
    echo "<li>$d2[id]: $d2[cache_date_time]</li>";
  }
}

include_once('footer.php');
?>
