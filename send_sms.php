<?PHP
include_once('menu.php');
// make it hard to accidently send - not to be mistaken for security
if ($_POST['send'] == 'confirm'){
	global $core;
	$r = $core->query("SELECT sms_number FROM coronavirus_sms where sms_status = 'confirmed' ");
	while($d = mysqli_fetch_array($r)){
		$sms = trim($d['sms_number']);
		echo message_send($sms,'Touch the picture to expand http://covid19math.net','http://covid19math.net/msg.php');
	}
	$val = 'Sent!';
}elseif($_POST['send'] != ''){
  	$val = 'Rabbit Hole';
}else{
  	$val = 'Send SMS';
}
?>

<form method='POST'> 
<input type='password' name='send'><input type='submit' value='<?PHP echo $val;?>'>
</form>

<h3>Current Message</h3>
<img src='msg.php'>

<?PHP
include_once('footer.php');
?>
