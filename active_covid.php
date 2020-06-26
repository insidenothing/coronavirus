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


echo "<h1>Maryland Active COVID-19 Cases for $date</h1>";
echo "<h3>This list of ZIP codes have active cases. Cases are removed after 14 days.</h3><ol>";
$q = "SELECT * FROM coronavirus_zip where active_cases <> '1' and report_date = '$date'  order by active_cases DESC";
$r = $core->query($q);
while ($d = mysqli_fetch_array($r)){
  $zip_c = $d['zip_code'];
  $name = $zipcode[$zip_c];
  echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['active_cases']." infections</li>";
}
echo "</ol>";



include_once('footer.php');
