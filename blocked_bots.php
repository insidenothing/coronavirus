<?PHP
// review get values
if (isset($_GET)){
   foreach ($_GET as $k => $v){
        $pos = strpos($v, 'UNION');
        if ($pos !== false) {
            header('Location: callback.php?msg=UNION detected');
        } 
   }
}
// die on bot match
if (isset($_SERVER['HTTP_USER_AGENT'])){
    
    $bot = $_SERVER['HTTP_USER_AGENT'];
    $pos = strpos($bot, 'SemrushBot');
    if ($pos !== false) {
        header('Location: callback.php?msg=SemrushBot detected');
    } 
    
    $pos = strpos($bot, 'AhrefsBot');
    if ($pos !== false) {
        header('Location: callback.php?msg=AhrefsBot detected');
    } 
    
}else{
    
  header('Location: callback.php?msg=missing HTTP_USER_AGENT');
    
}
?>
