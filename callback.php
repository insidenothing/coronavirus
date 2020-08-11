<?PHP
include_once('menu.php');
$msg = htmlspecialchars($_GET['msg']);
slack_bypass('hack detected: '.$msg,'anti-hack');
?>
