<?PHP
// Known Infected IP Addresses 
$block_list    = array();
$block_list[]  = '91.240.84.154';   // Probe Back HTTP WWW-Authenticate: Basic realm="sib service"
$block_list[]  = '212.109.219.74';  // Probe Back HTTP WWW-Authenticate: Basic realm="sib service"

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
   $host = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
   $host = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
   $host = $_SERVER['REMOTE_ADDR'];
}
if (in_array($host, $block_list)) {
    die();
}
// review get values
if (isset($_GET)){
   foreach ($_GET as $k => $v){
        $pos = strpos($v, 'UNION');
        if ($pos !== false) {
           $msg = 'UNION detected';
           include_once('callback.php');
           die();
        } 
   }
}
// die on bot match
if (isset($_SERVER['HTTP_USER_AGENT'])){
    $bot = $_SERVER['HTTP_USER_AGENT'];
    $pos = strpos($bot, 'SemrushBot');
    if ($pos !== false) {
        $msg = 'SemrushBot detected';
           //include_once('callback.php');
           die();
    } 
    $pos = strpos($bot, 'AhrefsBot');
    if ($pos !== false) {
        $msg = 'AhrefsBot detected';
           //include_once('callback.php');
           die();
    } 
}else{
   $msg = 'missing HTTP_USER_AGENT';
   include_once('callback.php');
   die();
}
?>
