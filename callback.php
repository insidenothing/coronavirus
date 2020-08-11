<?PHP
include_once('slack.php'); 
if (isset($_GET['msg'])){
  $msg = htmlspecialchars($_GET['msg']);
}
slack_bypass('Hack Attempt: '.$msg,'anti-hack');

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    		$host = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $host = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
      $host = $_SERVER['REMOTE_ADDR'];
}

//$host = 'google.com';
$ports = array(21, 25, 80, 81, 110, 143, 443, 587, 2525, 3306);

foreach ($ports as $port)
{
    $connection = @fsockopen($host, $port, $errno, $errstr, 2);

    if (is_resource($connection))
    {
        echo '<h2>' . $host . ':' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.</h2>' . "\n";
        slack_bypass('Hack Back: '.$host . ':' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.','anti-hack');
      
      if ($port == '80' || $port == '443'){
        $info = get_headers($host);
        $string0 = implode(' ', $info);
        $string1 = explode('Server:', $string0);
        //foreach($info as $k => $v){
          slack_bypass('Hack Back WWW: '.htmlspecialchars($string1),'anti-hack');  
        //}
        
      }
      
      
        fclose($connection);
    }
    else
    {
        echo '<h2>' . $host . ':' . $port . ' is not responding.</h2>' . "\n";
    }
}



?>
