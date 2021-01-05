<?PHP
//header('HTTP/1.0 403 Forbidden');
$block_list    = array();
$youtube_promote_link = 'https://www.youtube.com/channel/UCPatyRpy7cwh5wrZBMV5DJQ';
////   
////// Add IP addresses and User Agents Below
////
$block_list[]  = '91.240.84.154';   
$block_list[]  = '212.109.219.74';  
$block_list[]  = 'AhrefsBot';
$block_list[]  = 'SemrushBot';
$block_list[]  = 'J12bot';
$block_list[]  = 'Seznambot';
$block_list[]  = 'PetalBot';
$block_list[]  = 'bingbot';
$block_list[]  = 'ArcGIS';
$block_list[]  = 'AI';   
////   
////// Do not edit below here
////
// IP Addresses to Block 
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
// $_GET Values
if (isset($_GET)){
   foreach ($_GET as $k => $v){
        $pos = strpos($v, 'UNION');
        if ($pos !== false) {
           $reason_blocked_message = 'UNION blocked';
           error_log($reason_blocked_message.' '.$v, 3, "/var/tmp/blocked_bots.log");
           header('Location: '.$youtube_promote_link);
           die();
        } 
   }
}
// Keyword Blocking URL
if (isset($_SERVER['REQUEST_URI'])){
foreach ($block_list as $blocked){
       $page = $_SERVER['REQUEST_URI'];
       $pos = strpos($page, $blocked);
       if ($pos !== false) {
           $reason_blocked_message = $blocked.' blocked.';
           error_log($reason_blocked_message.' '.$page, 3, "/var/tmp/blocked_bots.log");
           header('Location: '.$youtube_promote_link);
           die();
       } 
    } 
}
// User Agents
if (isset($_SERVER['HTTP_USER_AGENT'])){
    foreach ($block_list as $blocked){
       $bot = $_SERVER['HTTP_USER_AGENT'];
       $pos = strpos($bot, $blocked);
       if ($pos !== false) {
           $reason_blocked_message = $blocked.' blocked.';
           error_log($reason_blocked_message.' '.$bot, 3, "/var/tmp/blocked_bots.log");
           header('Location: '.$youtube_promote_link);
           die();
       } 
    }   
}else{
   $reason_blocked_message = 'Missing HTTP_USER_AGENT';
   error_log($reason_blocked_message, 3, "/var/tmp/blocked_bots.log");
   header('Location: '.$youtube_promote_link);
   die();
}
?>
