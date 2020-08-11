<?PHP
include_once('menu.php');
$msg = htmlspecialchars($_GET['msg']);
slack_general('hack detected: '.$msg,'covid');
?>
