<?PHP
include_once('/var/www/html/mdwestserve/newsbot.php');
$page_description = date('r')." Schedule";
include_once('menu.php');



function process_link_check($link,$status){
 if ($_SERVER['REMOTE_ADDR'] == '69.250.28.138' && $link != '' && $status == 'lightgreen'){ 
  return "<a target='_Blank' href='$link'>PROCESS</a>";
 }
}



function check_error($json,$url){
  $error429 = '{
  "error" : 
  {
    "code" : 429, 
    "message" : "Unable to perform query. Too many requests.", 
    "details" : [
      "API calls quota exceeded (24001)! maximum allowed (24000) per Minute. Retry after 60 sec."
    ]
  }
}';
  if ($json == $error429){
    slack_general("CODE 429 - 61 second delay",'covid19-apis');
    //sleep(61); // wait 61 seconds
    //slack_general("CODE 429 - resume",'covid19-apis');
    //$json = getPage($url);
   // $json = check_error($json,$url)
  }
 // slack_general("NO JSON ERROR",'covid19-apis');
  return $json;
}

if ($_GET['debug']){
  // this will debug a single api
  $api_id = intval($_GET['debug']);
  $r = $covid_db->query("SELECT id, cache_date_time FROM coronavirus_api_cache where api_id = '$api_id' order by id DESC");
  while($d = mysqli_fetch_array($r)){
    echo "<li>API $api_id CACHE $d[id] ON $d[cache_date_time]</li>";
  }
  $q = "SELECT * FROM coronavirus_apis where api_status = 'active' and id = '$api_id' order by run_order DESC ";
  slack_general("$q",'covid19-apis');
  $r = $covid_db->query($q);
  echo '<h1>Error Check: '.mysqli_error($covid_db).'</h1>';
  while($d = mysqli_fetch_array($r)){
    slack_general("debug $d[api_name]",'covid19-apis');
    //sleep($d['run_delay']);
    echo "<li title='$d[api_description]'>$d[last_updated] <u>$d[api_name]</u> <a target='_Blank' href='$d[api_url]'>$d[api_status] API</a></li>";
    $url = $d['api_url'];
    $id = $d['id'];
    $name = $d['api_name'];
    $r2 = $covid_db->query("SELECT raw_response FROM coronavirus_api_cache where api_id = '$id' order by id DESC limit 0,1");
    $d2 = mysqli_fetch_array($r2);
    $old = $d2['raw_response'];
    echo $old;
  }
  die('done');
}



if ($_GET['run']){
  // this is our cron job
  $q = "SELECT * FROM coronavirus_apis where api_status = 'active' order by run_order DESC ";
  $r = $covid_db->query($q);
  $left = $total_apis;
  while($d = mysqli_fetch_array($r)){
    $name = $d['api_name'];
    slack_general("$left) $name",'covid19-apis');
    $left = $left - 1;
    $url = $d['api_url'];
    $id = $d['id'];
    $r2 = $covid_db->query("SELECT raw_response, cache_date_time FROM coronavirus_api_cache where api_id = '$id' order by id DESC limit 0,1");
    $d2 = mysqli_fetch_array($r2);
    $old = $d2['raw_response'];
    if (substr($d2['cache_date_time'],0,10) != date('Y-m-d') || $_GET['run'] == 2){
      $wait_check='';
      $last_update_hour = date('G',strtotime($d2['cache_date_time'])); 
      $this_hour = date('G') + 2;
      if ($last_update_hour > $this_hour){
        slack_general("$left) *Wait* ( Last Hour $last_update_hour > $this_hour This Hour )",'covid19-apis');
      }else{
        slack_general("$left) *Start* ( Last Hour $last_update_hour > $this_hour This Hour )",'covid19-apis');
        sleep($d['run_delay']);
        $raw = getPage($url);
        $raw_response = $covid_db->real_escape_string($raw);
        $test1 = $old;
        $test2 = $raw;
        if (trim($test2) == '[]'){
          slack_general("$left) fail - empty json: $name - *bad update*",'covid19-apis');
        }elseif ($test1 != $test2){
              $covid_db->query("insert into coronavirus_api_cache ( api_id, cache_date_time, raw_response, api_flavor ) values ( '$id', NOW(), '$raw_response', '$d[api_flavor]' )");
              $cache_id = $covid_db->insert_id;
              $covid_db->query("update coronavirus_apis set last_updated = NOW() where id = '$id' ");
             slack_general("$left) done: $name - *update* https://www.covid19math.net/apis.php",'covid19-apis-update');
             galert_mail('trigger@applet.ifttt.com',$name.' API Cache Updated','https://www.covid19math.net/cache.php?id='.$cache_id.'&type='.$d['api_flavor']);
        }else{
             slack_general("$left) done: $name - *no change*",'covid19-apis');
        }
      }
    }else{
      slack_general("$left) *Skip* $name ".$d2['cache_date_time'],'covid19-apis');
    }
  }
  die('done');
}

if ($_GET['refill'] && $_GET['date'] && $_GET['url']){
  // this will debug a single api
  $api_id = $_GET['refill'];
  $refill_date = $_GET['date'];
  $refill_url = $_GET['url'];
  $raw = getPageDebug($refill_url);
  $raw_response = $covid_db->real_escape_string($raw);
  $covid_db->query("insert into coronavirus_api_cache ( api_id, cache_date_time, raw_response ) values ( '$api_id', '$refill_date', '$raw_response' )");
  echo '<h1>Error Check: '.mysqli_error($covid_db).'</h1>';
  $covid_db->query("update coronavirus_apis set last_updated = NOW() where id = '$api_id' ");
  echo '<h1>Error Check: '.mysqli_error($covid_db).'</h1>';
  slack_general("*$name refill*",'covid19-apis-update');
  die('done');
}

if ($_GET['single']){
  // this will debug a single api
  $api_id = $_GET['single'];
  $q = "SELECT * FROM coronavirus_apis where api_status = 'active' and id = '$api_id' order by run_order DESC ";
  slack_general("$q",'covid19-apis');
  $r = $covid_db->query($q);
  echo '<h1>Error Check: '.mysqli_error($covid_db).'</h1>';
  while($d = mysqli_fetch_array($r)){
    slack_general("single run to check $d[api_name]",'covid19-apis');
    echo "<li title='$d[api_description]'>$d[last_updated] <u>$d[api_name]</u> <a target='_Blank' href='$d[api_url]'>$d[api_status] API</a></li>";
    $url = $d['api_url'];
    $id = $d['id'];
    $name = $d['api_name'];
    $r2 = $covid_db->query("SELECT raw_response FROM coronavirus_api_cache where api_id = '$id' order by id DESC limit 0,1");
    echo '<h1>Error Check: '.mysqli_error($covid_db).'</h1>';
    $d2 = mysqli_fetch_array($r2);
    $old = $d2['raw_response'];
    $raw = getPageDebug($url);
    $raw_response = $covid_db->real_escape_string($raw);
    $test1 = $old;
    $test2 = $raw;
    if (trim($test2) == '[]'){
          slack_general("$left) fail - empty json: $name - *bad update*",'covid19-apis');
    }elseif ($test1 != $test2){
          $covid_db->query("insert into coronavirus_api_cache ( api_id, cache_date_time, raw_response ) values ( '$id', NOW(), '$raw_response' )");
          echo '<h1>Error Check: '.mysqli_error($covid_db).'</h1>';
          $covid_db->query("update coronavirus_apis set last_updated = NOW() where id = '$id' ");
          echo '<h1>Error Check: '.mysqli_error($covid_db).'</h1>';
         // message_send('4433862584',"$name update");
         slack_general("*$name update*",'covid19-apis-update');
    }else{
         slack_general("no change in $name",'covid19-apis');
    }
        echo "<table><tr><td>test1</td><td>test2</td></tr><tr><td>$test1</td><td>$test2</td></tr></table>"; 
    
  }
  die('done');
}

if ($_GET['level']){
  // this will debug a single api
  $api_id = $_GET['level'];
  $q = "SELECT * FROM coronavirus_apis where api_status = 'active' and run_order = '$api_id' order by run_order DESC ";
  slack_general("$q",'covid19-apis');
  $r = $covid_db->query($q);
  echo '<h1>Error Check: '.mysqli_error($covid_db).'</h1>';
  while($d = mysqli_fetch_array($r)){
    slack_general("checking all apis at level check $api_id $d[api_name]",'covid19-apis');
    sleep($d['run_delay']);
    echo "<li title='$d[api_description]'>$d[last_updated] <u>$d[api_name]</u> <a target='_Blank' href='$d[api_url]'>$d[api_status] API</a></li>";
    $url = $d['api_url'];
    $id = $d['id'];
    $name = $d['api_name'];
    $r2 = $covid_db->query("SELECT raw_response FROM coronavirus_api_cache where api_id = '$id' order by id DESC limit 0,1");
    echo '<h1>Error Check: '.mysqli_error($covid_db).'</h1>';
    $d2 = mysqli_fetch_array($r2);
    $old = $d2['raw_response'];
    $raw = getPageDebug($url);
    $raw_response = $covid_db->real_escape_string($raw);
    $test1 = $old;
    $test2 = $raw;
    if ($test1 != $test2){
          $covid_db->query("insert into coronavirus_api_cache ( api_id, cache_date_time, raw_response ) values ( '$id', NOW(), '$raw_response' )");
          echo '<h1>Error Check: '.mysqli_error($covid_db).'</h1>';
          $covid_db->query("update coronavirus_apis set last_updated = NOW() where id = '$id' ");
          echo '<h1>Error Check: '.mysqli_error($covid_db).'</h1>';
         slack_general("*$name update*",'covid19-apis-update');
    }else{
         slack_general("no change in $name",'covid19-apis');
    }
    echo "<table><tr><td>test1</td><td>test2</td></tr><tr><td>$test1</td><td>$test2</td></tr></table>"; 
  }
  die('done');
}

echo "<h1>County Level Data</h1>";
$done_list = '';
$todo_list = '';
$wait_list = '';
// display what is active
$q = "SELECT * FROM coronavirus_apis where api_status = 'active' and run_order = '3000' order by last_updated DESC ";
$r = $covid_db->query($q);
while($d = mysqli_fetch_array($r)){
  //slack_general("$d[run_delay] second delay to check $d[api_name]",'covid19-apis');
  //sleep($d['run_delay']);

  $list = ''; 
  $rX = $covid_db->query("SELECT id, cache_date_time FROM coronavirus_api_cache where api_id = '$d[id]' order by id DESC limit 0,1");
  $dX = mysqli_fetch_array($rX);
  $list .= "[<a target='_Blank' href='cache.php?id=$dX[id]&type=raw'>$dX[id] ON $dX[cache_date_time]</a>]";
  ob_start();
  $color = 'lightblue';
  if (substr($dX['cache_date_time'],0,10) == date('Y-m-d')){
    $color='lightgreen';
  }
  if (substr($dX['cache_date_time'],0,10) == date('Y-m-d',strtotime('-1 day'))){
    $color='lightyellow';
  }
  echo "<li style='background-color:$color;' title='$d[api_description]'>".process_link_check($d['run_after'],$color)." (# $d[id])(lvl $d[run_order]) $d[last_updated] <u>$d[api_name]</u> $d[api_status] $list or <a target='_Blank' href='$d[api_url]'>SOURCE</a></li>";
  $line = ob_get_clean();
  $last_update_hour = date('G',strtotime($dX['cache_date_time'])); 
  $this_hour = date('G') + 2;
  if ($last_update_hour > $this_hour){
    $wait_list .= $line;
  }elseif ($color == 'lightgreen'){
    $done_list .= $line;
  }else{
    $todo_list .= $line;
  }
}
echo "<table><tr><td>No Update Today - Wait</td><td>No Update Today - Check</td><td>Update Confirmed - Skip</td></tr><tr><td valign='top'><ol>$wait_list</ol></td><td valign='top'><ol>$todo_list</ol></td><td valign='top'><ol>$done_list</ol></td></tr></table>";
echo "<h1>ZIP Code Data</h1>";
$done_list = '';
$todo_list = '';
$wait_list = '';
// display what is active
$q = "SELECT * FROM coronavirus_apis where api_status = 'active' and run_order = '1000' order by last_updated DESC ";
$r = $covid_db->query($q);
while($d = mysqli_fetch_array($r)){
  //slack_general("$d[run_delay] second delay to check $d[api_name]",'covid19-apis');
  //sleep($d['run_delay']);

  $list = ''; 
  $rX = $covid_db->query("SELECT id, cache_date_time FROM coronavirus_api_cache where api_id = '$d[id]' order by id DESC limit 0,1");
  $dX = mysqli_fetch_array($rX);
  $list .= "[<a target='_Blank' href='cache.php?id=$dX[id]&type=raw'>$dX[id] ON $dX[cache_date_time]</a>]";
  ob_start();
  $color = 'lightblue';
  if (substr($dX['cache_date_time'],0,10) == date('Y-m-d')){
    $color='lightgreen';
  }
  if (substr($dX['cache_date_time'],0,10) == date('Y-m-d',strtotime('-1 day'))){
    $color='lightyellow';
  }
  echo "<li style='background-color:$color;' title='$d[api_description]'>".process_link_check($d['run_after'],$color)." (# $d[id])(lvl $d[run_order]) $d[last_updated] <u>$d[api_name]</u> $d[api_status] $list or <a target='_Blank' href='$d[api_url]'>SOURCE</a></li>";
  $line = ob_get_clean();
  $last_update_hour = date('G',strtotime($dX['cache_date_time'])); 
  $this_hour = date('G') + 2;
  if ($last_update_hour > $this_hour){
    $wait_list .= $line;
  }elseif ($color == 'lightgreen'){
    $done_list .= $line;
  }else{
    $todo_list .= $line;
  }
}
echo "<table><tr><td>No Update Today - Wait</td><td>No Update Today - Check</td><td>Update Confirmed - Skip</td></tr><tr><td valign='top'><ol>$wait_list</ol></td><td valign='top'><ol>$todo_list</ol></td><td valign='top'><ol>$done_list</ol></td></tr></table>";

echo "<h1>Facilities Data</h1>";
$done_list = '';
$todo_list = '';
$wait_list = '';
// display what is active
$q = "SELECT * FROM coronavirus_apis where api_status = 'active' and run_order = '5000' order by last_updated DESC ";
$r = $covid_db->query($q);
while($d = mysqli_fetch_array($r)){
  //slack_general("$d[run_delay] second delay to check $d[api_name]",'covid19-apis');
  //sleep($d['run_delay']);

  $list = ''; 
  $rX = $covid_db->query("SELECT id, cache_date_time FROM coronavirus_api_cache where api_id = '$d[id]' order by id DESC limit 0,1");
  $dX = mysqli_fetch_array($rX);
  $list .= "[<a target='_Blank' href='cache.php?id=$dX[id]&type=raw'>$dX[id] ON $dX[cache_date_time]</a>]";
  ob_start();
  $color = 'lightblue';
  if (substr($dX['cache_date_time'],0,10) == date('Y-m-d')){
    $color='lightgreen';
  }
  if (substr($dX['cache_date_time'],0,10) == date('Y-m-d',strtotime('-1 day'))){
    $color='lightyellow';
  }
  echo "<li style='background-color:$color;' title='$d[api_description]'>".process_link_check($d['run_after'],$color)." (# $d[id])(lvl $d[run_order]) $d[last_updated] <u>$d[api_name]</u> $d[api_status] $list or <a target='_Blank' href='$d[api_url]'>SOURCE</a></li>";
  $line = ob_get_clean();
  $last_update_hour = date('G',strtotime($dX['cache_date_time'])); 
  $this_hour = date('G') + 2;
  if ($last_update_hour > $this_hour){
    $wait_list .= $line;
  }elseif ($color == 'lightgreen'){
    $done_list .= $line;
  }else{
    $todo_list .= $line;
  }
}
echo "<table><tr><td>No Update Today - Wait</td><td>No Update Today - Check</td><td>Update Confirmed - Skip</td></tr><tr><td valign='top'><ol>$wait_list</ol></td><td valign='top'><ol>$todo_list</ol></td><td valign='top'><ol>$done_list</ol></td></tr></table>";

echo "<h1>Other API Schedule<h1>";


$done_list = '';
$todo_list = '';
$wait_list = '';
// display what is active
$q = "SELECT * FROM coronavirus_apis where api_status = 'active' and run_order <> '5000' and run_order <> '1000' and run_order <> '3000' order by last_updated DESC ";
$r = $covid_db->query($q);
while($d = mysqli_fetch_array($r)){
  //slack_general("$d[run_delay] second delay to check $d[api_name]",'covid19-apis');
  //sleep($d['run_delay']);

  $list = ''; 
  $rX = $covid_db->query("SELECT id, cache_date_time FROM coronavirus_api_cache where api_id = '$d[id]' order by id DESC limit 0,1");
  $dX = mysqli_fetch_array($rX);
  $list .= "[<a target='_Blank' href='cache.php?id=$dX[id]&type=raw'>$dX[id] ON $dX[cache_date_time]</a>]";
  ob_start();
  $color = 'lightblue';
  if (substr($dX['cache_date_time'],0,10) == date('Y-m-d')){
    $color='lightgreen';
  }
  if (substr($dX['cache_date_time'],0,10) == date('Y-m-d',strtotime('-1 day'))){
    $color='lightyellow';
  }
  echo "<li style='background-color:$color;' title='$d[api_description]'>(# $d[id])(lvl $d[run_order]) $d[last_updated] <u>$d[api_name]</u> $d[api_status] ".process_link_check($d['run_after'],$color)." $list or <a target='_Blank' href='$d[api_url]'>SOURCE</a></li>";
  $line = ob_get_clean();
  $last_update_hour = date('G',strtotime($dX['cache_date_time'])); 
  $this_hour = date('G') + 2;
  if ($last_update_hour > $this_hour){
    $wait_list .= $line;
  }elseif ($color == 'lightgreen'){
    $done_list .= $line;
  }else{
    $todo_list .= $line;
  }
}
echo "<table><tr><td>No Update Today - Wait</td><td>No Update Today - Check</td><td>Update Confirmed - Skip</td></tr><tr><td valign='top'><ol>$wait_list</ol></td><td valign='top'><ol>$todo_list</ol></td><td valign='top'><ol>$done_list</ol></td></tr></table>";

include_once('footer.php');
?>
