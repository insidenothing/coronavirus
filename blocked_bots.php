<?PHP

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
           include_once('callback.php');
           die();
    } 
    
    $pos = strpos($bot, 'AhrefsBot');
    if ($pos !== false) {
        $msg = 'AhrefsBot detected';
           include_once('callback.php');
           die();
    } 
    
}else{
    
   $msg = 'missing HTTP_USER_AGENT';
   include_once('callback.php');
   die();
    
}
?>
