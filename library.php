<?PHP
$page_description = "National Library of COVID-19 API Data";
include_once('menu.php');


$id=0;
if (isset($_GET['cache'])){
  $id = substr(intval($_GET['cache']),0,10); // take int val # or 0 , limit to first 10 digits
  $q = "SELECT raw_response FROM coronavirus_api_cache where id = '$id' ";
  $r = $core->query($q);
  $d = mysqli_fetch_array($r);
  echo "<div><h1>Response</h1><pre><code>$d[raw_response]</code></pre></div>";
}


echo "<h1>National Library of COVID API's</h1><table><tr>";
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
  echo "<td valign='top'><li style='background-color:$color;' title='$d[api_description]'>$d[run_order]: $d[last_updated] <u>$d[api_name]</u> $d[api_status]</li><ol>";
  $url = $d['api_url'];
  $id = $d['id'];
  $name = $d['api_name'];
  $r2 = $core->query("SELECT id, cache_date_time FROM coronavirus_api_cache where api_id = '$id' order by id DESC");
  while($d2 = mysqli_fetch_array($r2)){
    echo "<li style='white-space:pre;'>$d2[id]: <a target='_Blank' href='?cache=$d2[id]'>$d2[cache_date_time]</a></li>";
  }
  echo "</ol></td>";
}
echo "</tr></table>";

include_once('footer.php');
?>
