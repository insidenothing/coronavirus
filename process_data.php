<?PHP
$page_description = date('r');
include_once('menu.php');
include_once('/var/www/html/mdwestserve/newsbot.php');
function runLink($url){
    $curl = curl_init();
    curl_setopt ($curl, CURLOPT_URL, urlencode($url));
    curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("McGuire Coronavirus Monitor covid19math.net /%d.0",rand(4,50)));
    curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $html = curl_exec ($curl);
    curl_close ($curl);
    return $html;
}
// figure out what can run and if there are any dependencies 
echo "<h1>Run Now</h1>";
$q = "SELECT * FROM coronavirus_apis where run_after <> '' and api_status = 'active' and last_run_date <> '".date('Y-m-d')."' and last_updated like '".date('Y-m-d')." %' order by run_after_priority DESC, run_order DESC ";
$r = $covid_db->query($q);
while($d = mysqli_fetch_array($r)){
  echo "<li><a target='_Blank' href='$d[run_after]'>(lvl $d[run_after_priority] x $d[run_order]) $d[run_after]</a></li>";
  if (isset($_GET['run'])){
        $output = runLink($d['run_after']);
        $name = $d['api_name'];
        echo htmlspecialchars($output);
          if ($d['internal_page']){
            galert_mail('trigger@applet.ifttt.com',$name.' Update',$d['internal_page']);   
          }
        
        sleep($d['run_delay']);
  }
}
