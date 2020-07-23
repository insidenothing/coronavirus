<?PHP

include_once('/var/www/secure.php'); //outside webserver
include_once('functions.php'); //outside webserver

$page_description = 'Facilities Data Table';
include_once('menu.php');

global $master_facility_table;
$master_facility_table = '';

// Assisted Living
function make_chart2($range,$Facility_Name){
	global $core;
	global $zip;
	global $zip2;
	global $remove;
	global $master_facility_table;
  $q = "SELECT * FROM coronavirus_facility where Facility_Name = '$Facility_Name' order by report_date";
  //slack_general("$q",'covid19-sql');
  $r = $core->query($q);
  $rows = mysqli_num_rows($r);
  $start = $rows - $range;
  $range2= $range - 1;
  $start = max($start, 0);
  $q = "SELECT * FROM coronavirus_facility where Facility_Name = '$Facility_Name' order by report_date limit $start, $range";
  slack_general("$q",'covid19-sql');
  $r = $core->query($q);
  while ($d = mysqli_fetch_array($r)){
    $name = "$d[Facility_Name], $d[state_name]";
    $Resident_Type = $d['Resident_Type'];
    $master_facility_table .= "<tr><td>$d[report_date]</td><td>$d[zip_code] ($rows)</td><td>$name</td><td>$Resident_Type</td><td>$d[report_count]</td><td>$d[Number_of_Resident_Cases]</td><td>$d[Number_of_Staff_Cases]</td><td>$d[Number_of_Resident_Deaths]</td><td>$d[Number_of_Staff_Deaths]</td></tr>";
  }
}

$q = "SELECT distinct Facility_Name FROM coronavirus_facility order by report_count DESC";
$r = $core->query($q);
while ($d = mysqli_fetch_array($r)){
  make_chart2('90',$d['Facility_Name']);
} 
?>

<div class="row">
	<table>
		<tr>
			<td>Report Date</td>
			<td>ZIP</td>
			<td>Name</td>
			<td>Resident Type</td>
			<td>Report Count</td>
			<td>Number of Resident Cases</td>
			<td>Number of Staff Cases</td>
			<td>Number of Resident Deaths</td>
			<td>Number of Staff Deaths</td>
		</tr>
		<?PHP echo $master_facility_table; ?>
	</table>
</div>

<?PHP 
 include_once('footer.php');
	
