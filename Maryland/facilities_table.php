<?PHP

include_once('/var/www/secure.php'); //outside webserver
include_once('../functions.php'); //outside webserver

$page_description = 'Maryland Facilities Data Table';
include_once('../menu.php');

global $master_facility_table;
$master_facility_table = '';

global $ReportCount;
global $NumberofResidentCases;
global $NumberofStaffCases;
global $NumberofResidentDeaths;
global $NumberofStaffDeaths;


global $ReportCount2;
global $NumberofResidentCases2;
global $NumberofStaffCases2;
global $NumberofResidentDeaths2;
global $NumberofStaffDeaths2;

// Assisted Living
function make_chart2($range,$Facility_Name){
	global $core;
	global $zip;
	global $zip2;
	global $remove;
	global $master_facility_table;
	global $ReportCount;
	global $NumberofResidentCases;
	global $NumberofStaffCases;
	global $NumberofResidentDeaths;
	global $NumberofStaffDeaths;
	global $ReportCount2;
	global $NumberofResidentCases2;
	global $NumberofStaffCases2;
	global $NumberofResidentDeaths2;
	global $NumberofStaffDeaths2;
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
  $i=$rows;
  while ($d = mysqli_fetch_array($r)){
    $name = str_replace('_',' ',"$d[Facility_Name], $d[state_name]");
    $Resident_Type = $d['Resident_Type'];
	$now = time(); // or your date as well
	$your_date = strtotime($d['report_date']);
	$datediff = $now - $your_date;
	$days = round($datediff / (60 * 60 * 24));
	  if ($i == 1 && $days < 20){
		// highlight and use as "latest data"
		$master_facility_table .= "<tr style='background-color:yellow;'><td style='white-space:pre;'>$d[report_date] <b>$days days ago</b></td><td>$d[zip_code]</td><td>$name</td><td>$Resident_Type</td><td title='Total'>$d[report_count]</td><td title='Number_of_Resident_Cases'>$d[Number_of_Resident_Cases]</td><td title='Number_of_Staff_Cases'>$d[Number_of_Staff_Cases]</td><td title='Number_of_Resident_Deaths'>$d[Number_of_Resident_Deaths]</td><td title='Number_of_Staff_Deaths'>$d[Number_of_Staff_Deaths]</td></tr>";
    		$ReportCount = $ReportCount + $d['report_count'];
		$NumberofResidentCases = $NumberofResidentCases + $d['Number_of_Resident_Cases'];
		$NumberofStaffCases = $NumberofStaffCases + $d['Number_of_Staff_Cases'];
		$NumberofResidentDeaths = $NumberofResidentDeaths + $d['Number_of_Resident_Deaths'];
		$NumberofStaffDeaths = $NumberofStaffDeaths + $d['Number_of_Staff_Deaths'];
	  }elseif ($i == 2 && $days < 40){
		// highlight for delta
		$master_facility_table .= "<tr style='background-color:lightblue;'><td style='white-space:pre;'>$d[report_date] <b>$days days ago</b></td><td>$d[zip_code]</td><td>$name</td><td>$Resident_Type</td><td title='Total'>$d[report_count]</td><td title='Number_of_Resident_Cases'>$d[Number_of_Resident_Cases]</td><td title='Number_of_Staff_Cases'>$d[Number_of_Staff_Cases]</td><td title='Number_of_Resident_Deaths'>$d[Number_of_Resident_Deaths]</td><td title='Number_of_Staff_Deaths'>$d[Number_of_Staff_Deaths]</td></tr>";
    		$ReportCount2 = $ReportCount2 + $d['report_count'];
		$NumberofResidentCases2 = $NumberofResidentCases2 + $d['Number_of_Resident_Cases'];
		$NumberofStaffCases2 = $NumberofStaffCases2 + $d['Number_of_Staff_Cases'];
		$NumberofResidentDeaths2 = $NumberofResidentDeaths2 + $d['Number_of_Resident_Deaths'];
		$NumberofStaffDeaths2 = $NumberofStaffDeaths2 + $d['Number_of_Staff_Deaths'];
	  }else{
		  $color = 'white';
		  if ($days > 90){
			  $color = '#FF0000;';
		  }elseif ($days > 60){
			  $color = '#FFcccc;';
		  }elseif ($days > 30){
			  $color = 'lightorange;';
		  }elseif($days > 15){
			  $color = 'lightgreen;';
		  }
		  $master_facility_table .= "<tr><td style='white-space:pre; background-color:$color'>$d[report_date] <b>$days days ago</b></td><td>$d[zip_code]</td><td>$name</td><td>$Resident_Type</td><td title='Total'>$d[report_count]</td><td title='Number_of_Resident_Cases'>$d[Number_of_Resident_Cases]</td><td title='Number_of_Staff_Cases'>$d[Number_of_Staff_Cases]</td><td title='Number_of_Resident_Deaths'>$d[Number_of_Resident_Deaths]</td><td title='Number_of_Staff_Deaths'>$d[Number_of_Staff_Deaths]</td></tr>";		  
	  }
    $i = $i - 1;
  }
}

$q = "SELECT distinct Facility_Name FROM coronavirus_facility order by report_count DESC";
$r = $core->query($q);
while ($d = mysqli_fetch_array($r)){
  make_chart2('90',$d['Facility_Name']);
} 
?>


<div class="row">
	<table border='1' cellpadding='0' cellspacing='0'>
		<tr style='background-color:lightgrey; font-weight:bold;'>
			<td>Maryland Facilities</td>
			<td>Report Count</td>
			<td>Number of Resident Cases</td>
			<td>Number of Staff Cases</td>
			<td>Number of Resident Deaths</td>
			<td>Number of Staff Deaths</td>
		</tr>
		<tr style='background-color:yellow;'>
			<td>Most Recent Total</td>
			<td><?PHP echo number_format($ReportCount);?></td>
			<td><?PHP echo number_format($NumberofResidentCases);?></td>
			<td><?PHP echo number_format($NumberofStaffCases);?></td>
			<td><?PHP echo number_format($NumberofResidentDeaths);?></td>
			<td><?PHP echo number_format($NumberofStaffDeaths);?></td>
		</tr>
		<tr style='background-color:lightblue;'>
			<td>Prior Update's Totals</td>
			<td><?PHP echo number_format($ReportCount2);?></td>
			<td><?PHP echo number_format($NumberofResidentCases2);?></td>
			<td><?PHP echo number_format($NumberofStaffCases2);?></td>
			<td><?PHP echo number_format($NumberofResidentDeaths2);?></td>
			<td><?PHP echo number_format($NumberofStaffDeaths2);?></td>
		</tr>
		<tr style='background-color:orange; font-weight:bold;'>
			<td>Difference</td>
			<td><?PHP echo number_format($ReportCount - $ReportCount2);?></td>
			<td><?PHP echo number_format($NumberofResidentCases - $NumberofResidentCases2);?></td>
			<td><?PHP echo number_format($NumberofStaffCases - $NumberofStaffCases2);?></td>
			<td><?PHP echo number_format($NumberofResidentDeaths - $NumberofResidentDeaths2);?></td>
			<td><?PHP echo number_format($NumberofStaffDeaths - $NumberofStaffDeaths2);?></td>
		</tr>
		<tr style='font-weight:bold;'>
			<td>Assuming Weekly Update - Daily Average</td>
			<td><?PHP echo number_format(($ReportCount - $ReportCount2) / 7,2);?></td>
			<td><?PHP echo number_format(($NumberofResidentCases - $NumberofResidentCases2) / 7,2);?></td>
			<td><?PHP echo number_format(($NumberofStaffCases - $NumberofStaffCases2) / 7,2);?></td>
			<td><?PHP echo number_format(($NumberofResidentDeaths - $NumberofResidentDeaths2) / 7,2);?></td>
			<td><?PHP echo number_format(($NumberofStaffDeaths - $NumberofStaffDeaths2) / 7,2);?></td>
		</tr>
		<tr style='font-weight:bold;'>
			<td>Assuming 2x Week Update - Daily Average</td>
			<td><?PHP echo number_format(($ReportCount - $ReportCount2) / 14,2);?></td>
			<td><?PHP echo number_format(($NumberofResidentCases - $NumberofResidentCases2) / 14,2);?></td>
			<td><?PHP echo number_format(($NumberofStaffCases - $NumberofStaffCases2) / 14,2);?></td>
			<td><?PHP echo number_format(($NumberofResidentDeaths - $NumberofResidentDeaths2) / 14,2);?></td>
			<td><?PHP echo number_format(($NumberofStaffDeaths - $NumberofStaffDeaths2) / 14,2);?></td>
		</tr>
		<tr style='font-weight:bold;'>
			<td>Assuming Monthly Update - Daily Average</td>
			<td><?PHP echo number_format(($ReportCount - $ReportCount2) / 30,2);?></td>
			<td><?PHP echo number_format(($NumberofResidentCases - $NumberofResidentCases2) / 30,2);?></td>
			<td><?PHP echo number_format(($NumberofStaffCases - $NumberofStaffCases2) / 30,2);?></td>
			<td><?PHP echo number_format(($NumberofResidentDeaths - $NumberofResidentDeaths2) / 30,2);?></td>
			<td><?PHP echo number_format(($NumberofStaffDeaths - $NumberofStaffDeaths2) / 30,2);?></td>
		</tr>
	</table>
</div>	
<hr>
<div class="row">
	<table border='1' cellpadding='0' cellspacing='0'>		
		<tr style='background-color:lightgrey; font-weight:bold;'>
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

<div>
	<?PHP 
	$r = $core->query("SELECT * FROM coronavirus_facility where zip_code = '0' order by Facility_Name");
  	while ($d = mysqli_fetch_array($r)){
	  	echo '<li>$Facility_ZIP[\''.$d['Facility_Name'].'\'] = \'00000\';</li>';
	}
	?>
</div>
<?PHP 
 include_once('../footer.php');
	
