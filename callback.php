<?PHP
include_once('slack.php'); 
$msg = htmlspecialchars($_GET['msg']);
slack_bypass('hack detected: '.$msg,'anti-hack');
?>
