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
$q = "SELECT * FROM coronavirus_zip where report_date = '$date' and percentage_direction = 'up' and percentage_direction14 = 'up' and percentage_direction30 = 'up' and percentage_direction45 = 'up' order by report_count DESC";
$r = $core->query($q);
while ($d = mysqli_fetch_array($r)){
  $zip_c = $d['zip_code'];
  $name = $zipcode[$zip_c];
  echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']."</a> $name 7 Days ".$d['day7change_percentage']."% 14 Days ".$d['day14change_percentage']."% 30 Days ".$d['day30change_percentage']."% 45 Days ".$d['day45change_percentage']."% at ".$d['report_count']."</li>";
}
include_once('footer.php');
