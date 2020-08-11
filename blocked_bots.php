<?PHP
// die on bot match
if (isset($_SERVER['HTTP_USER_AGENT'])){
    
    $bot = $_SERVER['HTTP_USER_AGENT'];
    $pos = strpos($bot, 'SemrushBot');
    if ($pos !== false) {
        die('Your Bot (SemrushBot) Has Been Blocked contact Patrick McGuire at baltimorehacker [at] gmail.com');
    } 
    
    $pos = strpos($bot, 'AhrefsBot');
    if ($pos !== false) {
        die('Your Bot (AhrefsBot) Has Been Blocked contact Patrick McGuire at baltimorehacker [at] gmail.com');
    } 
    
}else{
    
  die('Your Bot (MISSING HTTP_USER_AGENT) Has Been Blocked contact Patrick McGuire at baltimorehacker [at] gmail.com');  
    
}
?>
