<?PHP
$page_description = "Arizona COVID 19 Active Cases";
include_once('../menu.php');
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


if (isset($_GET['sort'])){
	$order = 'active_count';	
}else{
	$order = 'zip_code';	
}




echo "<a href='?sort=count'>Sort by Count</a><table><tr><td valign='top' width='25%'>";

ob_start();
echo "<h3>Cases are removed after 14 days and 28 days, sorted by $order.</h3><ol>";
$q = "SELECT * FROM coronavirus_zip where active_count > '0' and report_date = '$date' and state_name = 'Arizona'  order by $order DESC";
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
  echo "<li class='".$d['percentage_direction']."'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['active_count']." $to infections. 7 Day Change ".$d['day7change_percentage']."% ".$d['percentage_direction']."</li>";
}
echo "</ol>";
$list = ob_get_clean();


echo "<div>
<li><a target='_Blank' href='https://www.reddit.com/r/CoronavirusAZ/submit'>Post Top 100 To: /r/CoronavirusAZ</a>, use flair - TESTING UPDATES</li>
<li>Title: ".number_format($total)." to ".number_format($total2)." Arizona Active COVID-19 Cases $date</li>
</div>";


echo "<h1>".number_format($total)." to ".number_format($total2)." Arizona Active COVID-19 Cases $date</h1><li>SOURCE: https://www.covid19math.net/Arizona/active.php</li> <style> .up { background-color: yellow; font-weight:bold; } </style>".$list;

echo "</td></tr></table>";


include_once('../footer.php');
