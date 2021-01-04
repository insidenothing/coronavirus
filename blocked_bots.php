<?PHP
$block_list    = array();
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
           $msg = 'UNION blocked';
           die($msg);
        } 
   }
}
// User Agents
if (isset($_SERVER['HTTP_USER_AGENT'])){
    foreach ($block_list as $blocked){
       $bot = $_SERVER['HTTP_USER_AGENT'];
       $pos = strpos($bot, $blocked);
       if ($pos !== false) {
           $msg = $blocked.' blocked.';
           die($msg);
       } 
    }   
}else{
   $msg = 'Missing HTTP_USER_AGENT';
   die($msg);
}
?>
