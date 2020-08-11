<?PHP
include_once('slack.php'); 
if (isset($_GET['msg'])){
  $msg = htmlspecialchars($_GET['msg']);
}
slack_bypass('Hack Detected: '.$msg,'anti-hack');
?>
