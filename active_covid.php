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

echo "<table><tr><td valign='top' width='33%'>";

ob_start();
echo "<h3>Cases are removed after 14 days and 28 days, sorted by zip code.</h3><ol>";
$q = "SELECT * FROM coronavirus_zip where active_count > '0' and report_date = '$date' and state_name = 'Maryland'  order by zip_code DESC";
$r = $core->query($q);
$total = 0;
$total2 = 0;
while ($d = mysqli_fetch_array($r)){
  $zip_c = $d['zip_code'];
  $name = $zipcode[$zip_c];
  $total = $total + $d['active_count'];
  $total2 = $total2 + $d['active_count_28day'];
	$to = '';
	if ($d['active_count_28day'] > 0){
	 $to = "to ".$d['active_count_28day'];	
	}
  echo "<li class='".$d['percentage_direction30']."'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['active_count']." $to infections. 30 Day Change ".$d['day30change_percentage']."% ".$d['percentage_direction30']."</li>";
}
echo "</ol>";
$list = ob_get_clean();

echo "<h1>".number_format($total)." to ".number_format($total2)." Maryland Active COVID-19 Cases $date</h1><style> .up { background-color: yellow; font-weight:bold; } </style>".$list;

echo "</td><td valign='top' width='33%'>";

ob_start();
echo "<h3>Cases are removed after 14 days and 28 days, sorted by zip code.</h3><ol>";
$q = "SELECT * FROM coronavirus_zip where active_count > '0' and report_date = '$date' and state_name = 'Virginia'  order by zip_code DESC";
$r = $core->query($q);
$total = 0;
$total2 = 0;
while ($d = mysqli_fetch_array($r)){
  $zip_c = $d['zip_code'];
  $name = $zipcode[$zip_c];
  $total = $total + $d['active_count'];
	$total2 = $total2 + $d['active_count_28day'];
	$to = '';
	if ($d['active_count_28day'] > 0){
	 $to = "to ".$d['active_count_28day'];	
	}
  echo "<li class='".$d['percentage_direction30']."'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['active_count']." $to infections. 30 Day Change ".$d['day30change_percentage']."% ".$d['percentage_direction30']."</li>";
}
echo "</ol>";
$list = ob_get_clean();

echo "<h1>".number_format($total)." to ".number_format($total2)." Virginia Active COVID-19 Cases $date</h1><style> .up { background-color: yellow; font-weight:bold; } </style>".$list;

echo "</td><td valign='top' width='33%'>";

ob_start();
echo "<h3>Cases are removed after 14 days and 28 days, sorted by zip code.</h3><ol>";
$q = "SELECT * FROM coronavirus_zip where active_count > '0' and report_date = '$date' and state_name = 'Florida'  order by zip_code DESC";
$r = $core->query($q);
$total = 0;
$total2 = 0;
while ($d = mysqli_fetch_array($r)){
  $zip_c = $d['zip_code'];
  $name = $zipcode[$zip_c];
  $total = $total + $d['active_count'];
	$total2 = $total2 + $d['active_count_28day'];
	$to = '';
	if ($d['active_count_28day'] > 0){
	 $to = "to ".$d['active_count_28day'];	
	}
  echo "<li class='".$d['percentage_direction30']."'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['active_count']." $to infections. 30 Day Change ".$d['day30change_percentage']."% ".$d['percentage_direction30']."</li>";
}
echo "</ol>";
$list = ob_get_clean();

echo "<h1>".number_format($total)." to ".number_format($total2)." Florida Active COVID-19 Cases $date</h1><style> .up { background-color: yellow; font-weight:bold; } </style>".$list;


echo "</tr></td></table>";


include_once('footer.php');
