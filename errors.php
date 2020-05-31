<?PHP
include_once('blocked_bots.php'); 
include_once('/var/www/secure.php');
?>
<h1>Nothing works perfectly<h1>
<h2>try to monitor for issues here</h2>
<ol>
<?PHP
$q = "SELECT distinct id, zip_code, day7change_percentage FROM `coronavirus_zip` where day7change_percentage < 0 order by day7change_percentage";
$r = $core->query($q);
while($d = mysqli_fetch_array($r)){	
  echo "<li>Check $d[id] $d[zip_code] $d[day7change_percentage] for math error.</li>";
}
?>
</ol>
