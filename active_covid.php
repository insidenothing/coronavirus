<?PHP
$page_description = "Maryland COVID 19 Active Cases";
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




ob_start();
echo "<h3>This list of ZIP codes have active cases. Cases are removed after 14 days.</h3><ol>";
$q = "SELECT * FROM coronavirus_zip where active_count > '0' and report_date = '$date'  order by active_count DESC";
$r = $core->query($q);
$total = 0;
while ($d = mysqli_fetch_array($r)){
  $zip_c = $d['zip_code'];
  $name = $zipcode[$zip_c];
  $total = $total + $d['active_count'];
  echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['active_count']." infections. 30 Day Change ".$d['day30change_percentage']."% ".$d['percentage_direction30']."</li>";
}
echo "</ol>";
$list = ob_get_clean();

echo "<h1>".number_format($total)." Maryland Active COVID-19 Infections for $date</h1>".$list;

include_once('footer.php');
