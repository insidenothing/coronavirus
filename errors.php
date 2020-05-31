<?PHP
include_once('blocked_bots.php'); 
include_once('/var/www/secure.php');
?>
<h1>Nothing works perfectly<h1>
<h2>Try to monitor for issues here</h2>
<ol>
<?PHP
$q = "SELECT * FROM coronavirus_zip where day7change_percentage < 0 order by day7change_percentage";
$r = $core->query($q);
while($d = mysqli_fetch_array($r)){	
  $time = strtotime($d['report_date']) - 86400;
  $r_date = date('Y-m-d',$time);
  $q2 = "SELECT day7change_percentage FROM coronavirus_zip where zip_code = '$d[zip_code]' and report_date = '$r_date' ";
  $r2 = $core->query($q2);
  $d2 = mysqli_fetch_array($r2);
  echo "<li>Updating record $d[id] zip $d[zip_code] at $d[day7change_percentage] on $d[report_date] for math error with $d2[day7change_percentage].</li>";
  $core->query("update coronavirus_zip set day7change_percentage = '$d2[day7change_percentage]' where id = '$d[id]' ");
}
?>
</ol>
