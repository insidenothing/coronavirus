<?PHP
//header('HTTP/1.0 403 Forbidden');
$block_list    = array();
$youtube_promote_links = array();
////   
////// Add YouTube Links
////
$youtube_promote_links[] = 'https://www.youtube.com/channel/UCPatyRpy7cwh5wrZBMV5DJQ'; // channel Patrick McGuire
$youtube_promote_links[] = 'https://www.youtube.com/channel/UC4HIYpyjcrS-V6c2xmIwQvg'; // channel 3D Printing
$youtube_promote_links[] = 'https://www.youtube.com/channel/UCNAW4EIdHrtIWXm74kS4cIg'; // channel Model Trains
$youtube_promote_links[] = 'https://www.youtube.com/channel/UCeIC-ux5H_Km5blR9cOnjWw';  // channel covid data
$youtube_promote_links[] = 'https://www.youtube.com/channel/UCRhUMYbpikXZ5xHEdDPNhgA';  // channel news 
////   
////// Add IP addresses, User Agents, Bot Names, Keywords to Block Below
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
$block_list[]  = 'crawler';
////   
////// Do not edit below here
////
// Pick a random channel
$top_link_index = count($youtube_promote_links) - 1;
$link_rand_index = rand(0,$top);
$youtube_promote_link = $youtube_promote_links[$link_rand_index];
// IP Addresses to Block 
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
   $host = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
   $host = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
   $host = $_SERVER['REMOTE_ADDR'];
}
if (in_array($host, $block_list)) {
   $reason_blocked_message = 'IP blocked';
   error_log($reason_blocked_message.' '.$ip." $youtube_promote_link \n", 3, "/var/tmp/blocked_bots.log");
   header('Location: '.$youtube_promote_link);
   die();
} 
// $_GET Values
if (isset($_GET)){
   foreach ($_GET as $k => $v){
        $pos = strpos($v, 'UNION');
        if ($pos !== false) {
           $reason_blocked_message = 'UNION blocked';
           error_log($reason_blocked_message.' '.$v." $youtube_promote_link \n", 3, "/var/tmp/blocked_bots.log");
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
           error_log($reason_blocked_message.' '.$page." $youtube_promote_link \n", 3, "/var/tmp/blocked_bots.log");
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
           error_log($reason_blocked_message.' '.$bot."$youtube_promote_link \n", 3, "/var/tmp/blocked_bots.log");
           header('Location: '.$youtube_promote_link);
           die();
       } 
    }   
}else{
   $reason_blocked_message = 'Missing HTTP_USER_AGENT';
   error_log($reason_blocked_message." $youtube_promote_link \n", 3, "/var/tmp/blocked_bots.log");
   header('Location: '.$youtube_promote_link);
   die();
}
?>
