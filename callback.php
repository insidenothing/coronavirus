<?PHP
include_once('slack.php'); 
if (isset($_GET['msg'])){
  $msg = htmlspecialchars($_GET['msg']);
}

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    		$host = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $host = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
      $host = $_SERVER['REMOTE_ADDR'];
}

slack_bypass("*$host Hack Attempt*: $msg",'anti-hack');


function AB_test($host){
  $command = "ab -n 100000 -c 100 -H \"Host: example.com\" http://$host/ "; 
  //echo '<pre>';
  $last_line = system($command, $retval);
  // Printing additional info
  //echo '
  //</pre>
  //<hr />Last line of the output: ' . $last_line . '
  //<hr />Return value: ' . $retval;
  slack_bypass("$command $last_line",'anti-hack-tools');
}


function check_WWW_80($host){
        $www = "http://$host";
        $info = get_headers($www, 1);
        foreach($info as $type => $value){
          slack_bypass("Probe Back HTTP $type: $value",'anti-hack');
        }
}
function check_WWW_443($host){
        $www = "https://$host";
        $info = get_headers($www, 1);
        foreach($info as $type => $value){
          slack_bypass("Probe Back HTTPS $type: $value",'anti-hack');
        }
}

function check_FTP($ftp_server){
          // set up a connection or die
          $conn_id = ftp_connect($ftp_server) or slack_bypass("Couldn't connect FTP to $ftp_server",'anti-hack');


          // try to login
          if (@ftp_login($conn_id, "anonymous", "")) {
             slack_bypass("Probe FTP as anonymous@$ftp_server",'anti-hack');
          } else {
             slack_bypass("Probe failed to connect FTP as anonymous",'anti-hack');
          }

          // close the connection
          ftp_close($conn_id); 
}


function check_SMPT($host){
 require_once "Mail.php";
  $from = "Web Master <webmaster@example.com>";
  $to = "Nobody <nobody@example.com>";
  $subject = "Test email using PHP SMTP\r\n\r\n";
  $body = "This is a test email message";

  //$host = "pop.emailsrvr.com";
  $username = "webmaster@example.com";
  $password = "yourPassword";

  $headers = array ('From' => $from,
    'To' => $to,
    'Subject' => $subject);
  $smtp = Mail::factory('smtp',
    array ('host' => $host,
      'auth' => true,
      'username' => $username,
      'password' => $password));

  $mail = $smtp->send($to, $headers, $body);

  if (PEAR::isError($mail)) {
    echo("<p>" . $mail->getMessage() . "</p>");
    slack_bypass('Probe Back SMTP: '. $mail->getMessage() .'!','anti-hack'); 
  } else {
    echo("<p>Message successfully sent!</p>");
    slack_bypass('Probe Back SMTP: Message successfully sent!','anti-hack'); 
  } 
}


function check_SMPT2($host){
 require_once "Mail.php";
  $from = "Web Master <webmaster@example.com>";
  $to = "Nobody <nobody@example.com>";
  $subject = "Test email using PHP SMTP\r\n\r\n";
  $body = "This is a test email message";

  //$host = "pop.emailsrvr.com";
  $username = "webmaster@example.com";
  $password = "yourPassword";

  $headers = array ('From' => $from,
    'To' => $to,
    'Subject' => $subject);
  $smtp = Mail::factory('smtp',
    array ('host' => $host,
      'auth' => false));

  $mail = $smtp->send($to, $headers, $body);

  if (PEAR::isError($mail)) {
    echo("<p>" . $mail->getMessage() . "</p>");
    slack_bypass('Probe Back SMTP2: '. $mail->getMessage() .'!','anti-hack'); 
  } else {
    echo("<p>Message successfully sent!</p>");
    slack_bypass('Probe Back SMTP2: Message successfully sent!','anti-hack'); 
  } 
}






//$host = 'google.com';
$ports = array(21, 25, 80, 81, 110, 143, 443, 587, 2525, 3306);

foreach ($ports as $port)
{
    $connection = @fsockopen($host, $port, $errno, $errstr, 2);

    if (is_resource($connection))
    {
        echo '<h2>' . $host . ':' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.</h2>' . "\n";
        slack_bypass('Probe: '.$host . ':' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.','anti-hack');
      
      if ($port == 21){
       check_FTP($host); 
      }
      
      if ($port == '25'){
       check_SMPT($host); 
       check_SMPT2($host);
      }
      
      if ($port == '80'){
         check_WWW_80($host);
         AB_test($host);
      }
      if ($port == '443'){
         check_WWW_443($host);
      }
      
      
        fclose($connection);
    }
    else
    {
        echo '<h2>' . $host . ':' . $port . ' is not responding.</h2>' . "\n";
    }
}



?>
