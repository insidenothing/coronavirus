<?PHP
$page_description = "Maryland COVID 19 Outbreak Monitor";
include_once('menu.php');
global $zipcode;
global $global_date;
$zipcode = array();
$q = "select distinct zip_code, town_name from coronavirus_zip where town_name <> ''";
$r = $core->query($q);
while($d = mysqli_fetch_array($r)){
	$zip = $d['zip_code'];
	$zipcode[$zip] = $d['town_name'];
}
$date = $global_date;
echo "<h1>Outbreak Monitor for $date</h1>";
echo "<h3>This table of ZIP codes are seeing a percentage increase in cases at 7, 14, 30, and 45 days.</h3><table width='100%' border='1' cellpadding='10' cellspacing='0'>";
$q = "SELECT * FROM coronavirus_zip where change_percentage_time <> '00:00:00' and report_date = '$date' and percentage_direction = 'up' and percentage_direction14 = 'up' and percentage_direction30 = 'up' and percentage_direction45 = 'up' order by report_count DESC";
$r = $core->query($q);
while ($d = mysqli_fetch_array($r)){
  $zip_c = $d['zip_code'];
  $name = $zipcode[$zip_c];
  echo "<tr><td>".$d['state_name']."</td><td><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']."</a></td><td> 
  $name</td><td>7 Days ".$d['day7change_percentage']."%</td><td>14 Days ".$d['day14change_percentage']."%</td><td>30 Days
  ".$d['day30change_percentage']."%</td><td>45 Days ".$d['day45change_percentage']."%</td><td>".$d['report_count']." infections</td><td>".$d['active_count']." to ".$d['active_count_28day']." active</td></tr>";
}
echo "</table>";
echo "<h1>Outbreak Monitor for $date</h1>";
echo "<h3>This list of ZIP codes are seeing a percentage increase in cases at 7, 14, 30, and 45 days.</h3><ol>";
$q = "SELECT * FROM coronavirus_zip where change_percentage_time <> '00:00:00' and report_date = '$date' and percentage_direction = 'up' and percentage_direction14 = 'up' and percentage_direction30 = 'up' and percentage_direction45 = 'up' order by report_count DESC";
$r = $core->query($q);
while ($d = mysqli_fetch_array($r)){
  $zip_c = $d['zip_code'];
  $name = $zipcode[$zip_c];
  echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name, ".$d['state_name']." ".$d['active_count']." to ".$d['active_count_28day']."  active infections</li>";
}
echo "</ol>";
include_once('footer.php');
