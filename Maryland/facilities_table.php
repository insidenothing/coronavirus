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
    $name = "$d[Facility_Name], $d[state_name]";
    $Resident_Type = $d['Resident_Type'];
	  if ($i == 1){
		// highlight and use as "latest data"
		$master_facility_table .= "<tr style='background-color:yellow;'><td>$d[report_date]</td><td>$d[zip_code]</td><td>$name</td><td>$Resident_Type</td><td>$d[report_count]</td><td>$d[Number_of_Resident_Cases]</td><td>$d[Number_of_Staff_Cases]</td><td>$d[Number_of_Resident_Deaths]</td><td>$d[Number_of_Staff_Deaths]</td></tr>";
    		$ReportCount = $ReportCount + $d['report_count'];
		$NumberofResidentCases = $NumberofResidentCases + $d['Number_of_Resident_Cases'];
		$NumberofStaffCases = $NumberofStaffCases + $d['Number_of_Staff_Cases'];
		$NumberofResidentDeaths = $NumberofResidentDeaths + $d['Number_of_Resident_Deaths'];
		$NumberofStaffDeaths = $NumberofStaffDeaths + $d['Number_of_Staff_Deaths'];
	  }elseif ($i == 2){
		// highlight for delta
		$master_facility_table .= "<tr style='background-color:lightblue;'><td>$d[report_date]</td><td>$d[zip_code]</td><td>$name</td><td>$Resident_Type</td><td>$d[report_count]</td><td>$d[Number_of_Resident_Cases]</td><td>$d[Number_of_Staff_Cases]</td><td>$d[Number_of_Resident_Deaths]</td><td>$d[Number_of_Staff_Deaths]</td></tr>";
    		$ReportCount2 = $ReportCount2 + $d['report_count'];
		$NumberofResidentCases2 = $NumberofResidentCases2 + $d['Number_of_Resident_Cases'];
		$NumberofStaffCases2 = $NumberofStaffCases2 + $d['Number_of_Staff_Cases'];
		$NumberofResidentDeaths2 = $NumberofResidentDeaths2 + $d['Number_of_Resident_Deaths'];
		$NumberofStaffDeaths2 = $NumberofStaffDeaths2 + $d['Number_of_Staff_Deaths'];
	  }else{
		$master_facility_table .= "<tr><td>$d[report_date]</td><td>$d[zip_code]</td><td>$name</td><td>$Resident_Type</td><td>$d[report_count]</td><td>$d[Number_of_Resident_Cases]</td><td>$d[Number_of_Staff_Cases]</td><td>$d[Number_of_Resident_Deaths]</td><td>$d[Number_of_Staff_Deaths]</td></tr>";		  
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
			<td>This Weeks Totals</td>
			<td><?PHP echo number_format($ReportCount);?></td>
			<td><?PHP echo number_format($NumberofResidentCases);?></td>
			<td><?PHP echo number_format($NumberofStaffCases);?></td>
			<td><?PHP echo number_format($NumberofResidentDeaths);?></td>
			<td><?PHP echo number_format($NumberofStaffDeaths);?></td>
		</tr>
		<tr style='background-color:lightblue;'>
			<td>Last Weeks Totals</td>
			<td><?PHP echo number_format($ReportCount2);?></td>
			<td><?PHP echo number_format($NumberofResidentCases2);?></td>
			<td><?PHP echo number_format($NumberofStaffCases2);?></td>
			<td><?PHP echo number_format($NumberofResidentDeaths2);?></td>
			<td><?PHP echo number_format($NumberofStaffDeaths2);?></td>
		</tr>
		<tr style='background-color:orange; font-weight:bold;'>
			<td>Weekly Difference</td>
			<td><?PHP echo number_format($ReportCount - $ReportCount2);?></td>
			<td><?PHP echo number_format($NumberofResidentCases - $NumberofResidentCases2);?></td>
			<td><?PHP echo number_format($NumberofStaffCases - $NumberofStaffCases2);?></td>
			<td><?PHP echo number_format($NumberofResidentDeaths - $NumberofResidentDeaths2);?></td>
			<td><?PHP echo number_format($NumberofStaffDeaths - $NumberofStaffDeaths2);?></td>
		</tr>
		<tr style='background-color:orange; font-weight:bold;'>
			<td>Daily Average</td>
			<td><?PHP echo number_format(($ReportCount - $ReportCount2) / 7,2);?></td>
			<td><?PHP echo number_format(($NumberofResidentCases - $NumberofResidentCases2) / 7,2);?></td>
			<td><?PHP echo number_format(($NumberofStaffCases - $NumberofStaffCases2) / 7,2);?></td>
			<td><?PHP echo number_format(($NumberofResidentDeaths - $NumberofResidentDeaths2) / 7,2);?></td>
			<td><?PHP echo number_format(($NumberofStaffDeaths - $NumberofStaffDeaths2) / 7,2);?></td>
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

<?PHP 
 include_once('footer.php');
	