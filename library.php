<?PHP
$page_description = "National Library of COVID-19 API Data";
include_once('menu.php');




echo '<div class="row">';
echo "<h1>National Library of COVID API's</h1>";
$q = "SELECT * FROM coronavirus_apis where api_status = 'active' order by run_order DESC, last_updated DESC ";
$r = $covid_db->query($q);
while($d = mysqli_fetch_array($r)){
  echo "
  <a class='btn btn-primary' data-toggle='collapse' href='#multiCollapseExample$d[id]' role='button' aria-expanded='false' aria-controls='multiCollapseExample$d[id]'>$d[api_name]</a>";
}
echo "</div>";



//$raws='';

echo '<div class="row">';
$q = "SELECT * FROM coronavirus_apis where api_status = 'active' order by run_order DESC, last_updated DESC ";
$r = $covid_db->query($q);
while($d = mysqli_fetch_array($r)){
  echo '<div class="col"><div class="collapse multi-collapse" id="multiCollapseExample'.$d['id'].'"><div class="card card-body">';
  //slack_general("$d[run_delay] second delay to check $d[api_name]",'covid19-apis');
  //sleep($d['run_delay']);
  $color = 'lightblue';
  if (substr($d['last_updated'],0,10) == date('Y-m-d')){
    $color='lightgreen';
  }
  if (substr($d['last_updated'],0,10) == date('Y-m-d',strtotime('-1 day'))){
    $color='lightyellow';
  }
  echo "<center><a class='btn btn-info'>$d[api_name]</a></center>";
  $url = $d['api_url'];
  $id = $d['id'];
  $name = $d['api_name'];
  $r2 = $covid_db->query("SELECT id, cache_date_time, raw_response FROM coronavirus_api_cache where api_id = '$id' order by id DESC");
  while($d2 = mysqli_fetch_array($r2)){
    echo "
    <a class='btn btn-warning' href='cache.php?id=$d2[id]&type=$d[api_flavor]'>$d[api_flavor] $d2[cache_date_time]</a>";
    //echo "
    //<a class='btn btn-warning' data-toggle='collapse' href='#multiCollapseExamplecache$d2[id]' role='button' aria-expanded='false' aria-controls='multiCollapseExamplecache$d2[id]'>$d2[cache_date_time]</a>";
    //$raws .= '
    //<div class="col"><div class="collapse multi-collapse" id="multiCollapseExamplecache'.$d2['id'].'"><div class="card card-body"><h3>'.$d['api_name'].'</h3><pre><code>'.$d2[raw_response].'</code></pre></div></div></div>';
  }
  echo "</div></div></div>";
}
echo "</div>";



echo '<div class="row">';
echo $raws;
echo "</div>";



if (isset($_GET['cache'])){
  echo '<div class="row">';
    $id = substr(intval($_GET['cache']),0,10); 
    //$q = "SELECT raw_response FROM coronavirus_api_cache where id = '$id' ";
    //$r = $covid_db->query($q);
    //$d = mysqli_fetch_array($r);
    $q = "SELECT raw_response FROM coronavirus_api_cache where id = ?";
    $stmt = $covid_db->prepare($q);
    $stmt->bind_param('i', $id); 
    $stmt->execute();
    $result = $stmt->get_result();
    $coronavirus_api_cache = $result->fetch_assoc();
    echo "<h1>Response</h1><pre><code>$coronavirus_api_cache[raw_response]</code></pre>";
   echo '</div>';
}



include_once('footer.php');
?>
