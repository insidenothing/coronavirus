<?PHP

include_once('/var/www/secure.php'); //outside webserver
include_once('functions.php'); //outside webserver



$page_description = 'Facilities Data';
include_once('menu.php');


// Assisted Living
function make_chart2($range,$Facility_Name){
	global $core;
	global $zip;
	global $zip2;
	global $remove;
	
$time_chart='';
$text_div='';
$time_chart2='';
$text_div2='';
$q = "SELECT * FROM coronavirus_facility where Facility_Name = '$Facility_Name' order by report_date";
slack_general("$q",'covid19-sql');
$r = $core->query($q);
$rows = mysqli_num_rows($r);
$start = $rows - $range;
$range2= $range - 1;
$start = max($start, 0);
$q = "SELECT * FROM coronavirus_facility where Facility_Name = '$Facility_Name' order by report_date limit $start, $range";
slack_general("$q",'covid19-sql');
$r = $core->query($q);
$i=0;
	$remove_total=0;
while ($d = mysqli_fetch_array($r)){
	$name = "$d[Facility_Name], $d[state_name]";
	$Resident_Type = $d['Resident_Type'];
	$in_14_days = date('Y-m-d',strtotime($d['report_date'])+1209600); // date + 14 days
	if ($i == 0){
		$me = 0;
		$remove_base=$d['report_count']; // we can only assume all prior cases were reported on the first day of the graph
		$remove[$in_14_days] = $remove_base; //difference to remove
	}else{
		$me = intval($d['report_count'] - $last);
		$remove[$in_14_days] = $me; //difference to remove
	}

	$remove_date = $d['report_date'];
	$remove_count = $remove[$remove_date]; 
	$remove_total = $remove_total + $remove_count;
	
	$rolling = $d['report_count'] - $remove_total;

	$trader_sma_real[] = intval($d['report_count']);
	$trader_sma_timePeriod++;
	$trader_sma_7 = trader_sma($trader_sma_real,7);
	$trader_sma_3 = trader_sma($trader_sma_real,3);
	//print_r($trader_sma);
	$the_index = $trader_sma_timePeriod - 1;
	$this_sma7 = $trader_sma_7[$the_index]; // should be last value
	$this_sma3 = $trader_sma_3[$the_index]; // should be last value
	if ( $this_sma7 > 0 && $remove_total > 0 && $range == '60' ){
		// start making the charts when SMA and rolling have a value for the 60 day chart
		$time_chart .=  '{ label: "'.$d['report_date'].'", y: '.fix_zero($d['report_count']).' }, ';
		
		
		$time_charta .=  '{ label: "'.$d['report_date'].'", y: '.fix_zero($d['Number_of_Resident_Cases']).' }, ';
		$time_chartb .=  '{ label: "'.$d['report_date'].'", y: '.fix_zero($d['Number_of_Staff_Cases']).' }, ';
		$time_chartc .=  '{ label: "'.$d['report_date'].'", y: '.fix_zero($d['Number_of_Resident_Deaths']).' }, ';
		$time_chartd .=  '{ label: "'.$d['report_date'].'", y: '.fix_zero($d['Number_of_Staff_Deaths']).' }, ';
		
		
		$new_chart .=  '{ label: "'.$d['report_date'].'", y: '.$me.' }, ';
		$sma_chart .=  '{ label: "'.$d['report_date'].'", y: '.intval($this_sma7).' }, ';
		$sma_chart3 .=  '{ label: "'.$d['report_date'].'", y: '.intval($this_sma3).' }, ';
		$remove_chart .=  '{ label: "'.$d['report_date'].'", y: '.$rolling.' }, ';
	}elseif( $range != '60' ){
		$time_chart .=  '{ label: "'.$d['report_date'].'", y: '.fix_zero($d['report_count']).' }, ';
		
		$time_charta .=  '{ label: "'.$d['report_date'].'", y: '.fix_zero($d['Number_of_Resident_Cases']).' }, ';
		$time_chartb .=  '{ label: "'.$d['report_date'].'", y: '.fix_zero($d['Number_of_Staff_Cases']).' }, ';
		$time_chartc .=  '{ label: "'.$d['report_date'].'", y: '.fix_zero($d['Number_of_Resident_Deaths']).' }, ';
		$time_chartd .=  '{ label: "'.$d['report_date'].'", y: '.fix_zero($d['Number_of_Staff_Deaths']).' }, ';
		
		
		$new_chart .=  '{ label: "'.$d['report_date'].'", y: '.$me.' }, ';
		$sma_chart .=  '{ label: "'.$d['report_date'].'", y: '.intval($this_sma7).' }, ';
		$sma_chart3 .=  '{ label: "'.$d['report_date'].'", y: '.intval($this_sma3).' }, ';
		$remove_chart .=  '{ label: "'.$d['report_date'].'", y: '.$rolling.' }, ';
	}
	
	
	
	
	$last = $d['report_count'];
	$text_div .= "<li>$d[report_date] $d[report_count] $d[trend_direction] $d[trend_duration]</li>";
	$last_count = $d[report_count];
	if($i == 0){
		$start_value = fix_zero($d['report_count']);
	}
	if($i == $range2){
		$end_value = fix_zero($d['report_count']);
	}
	$i++; // number of days in the graph
}
$remove_chart 		= rtrim(trim($remove_chart), ",");
$sma_chart 		= rtrim(trim($sma_chart), ",");
$sma_chart3 		= rtrim(trim($sma_chart3), ",");
$time_chart 		= rtrim(trim($time_chart), ",");
	
	$time_charta 		= rtrim(trim($time_charta), ",");
	$time_chartb 		= rtrim(trim($time_chartb), ",");
	$time_chartc 		= rtrim(trim($time_chartc), ",");
	$time_chartd 		= rtrim(trim($time_chartd), ",");
	
	
$new_chart 		= rtrim(trim($new_chart), ",");
$page_description 	= "$date $name at $last_count Cases";
$name2			= '';
$i2			= 0;

$name = $name.$name2;

ob_start();
?>
<div class="row">
	<?PHP 
	$per = round( ( ( fix_zero($end_value) - fix_zero($start_value) ) / fix_zero($start_value) ) * 100); 
	if ($per == '0'){
		$color = 'lightgreen';	
	}elseif($per < '10'){
		$color = 'lightyellow';
	}else{
		$color = '#fed8b1'; // light orange
	}
	?>
	
	<p style='text-align:center; background-color:<?PHP echo $color;?>;'>
		<b>From <?PHP echo fix_zero($start_value);?> cases to <?PHP echo fix_zero($end_value);?> cases is a <?PHP echo $per;?>% change in <?PHP echo $range;?> days.</b>
	</p>
	
</div>
<?PHP 
$page_description = $per."% change $page_description";
$alert = ob_get_clean();
	$return = array();
	$return['alert'] = $alert;
	$return['page_description'] = $page_description;
	$return['time_chart'] = $time_chart;
	$return['time_charta'] = $time_charta;
	$return['time_chartb'] = $time_chartb;
	$return['time_chartc'] = $time_chartc;
	$return['time_chartd'] = $time_chartd;
	$return['time_chart2'] = $time_chart2;
	$return['new_chart'] = $new_chart;
	$return['remove_chart'] = $remove_chart;
	$return['sma_chart'] = $sma_chart;
	$return['sma3_chart'] = $sma_chart3;
	$return['range'] = $range;
	$return['active_count'] = $rolling;
	$return['name'] = $name;
	$return['per'] = $per;
	$return['Resident_Type'] = $Resident_Type;
	return $return;
}

?>



<script src="canvasjs.min.js"></script>
<script>
window.onload = function () {
<?PHP 
	$q = "SELECT distinct Facility_Name FROM coronavirus_facility order by report_count DESC";
	$r = $core->query($q);
	$i=1;
	while ($d = mysqli_fetch_array($r)){
		$day7 			= make_chart2('90',$d['Facility_Name']);
		$alert_1 		= $day7['alert'];
		$time_chart_1 		= $day7['time_chart'];
		$time_chart_1a 		= $day7['time_charta'];
		$time_chart_1b 		= $day7['time_chartb'];
		$time_chart_1c 		= $day7['time_chartc'];
		$time_chart_1d 		= $day7['time_chartd'];
		$time_chart2_1 		= $day7['time_chart2'];
		$new_chart_1 		= $day7['new_chart'];
		$remove_chart_1 	= $day7['remove_chart'];
		$sma_chart_1 		= $day7['sma_chart'];
		$sma3_chart_1 		= $day7['sma3_chart'];
		$range_1 		= $day7['range'];
		$name_1 		= $day7['name'];
		$per_1 			= $day7['per'];
		$Resident_Type_1 	= $day7['Resident_Type'];
	?>
var chartZIP<?PHP echo $i;?> = new CanvasJS.Chart("chartContainerZIP<?PHP echo $i;?>", {
		theme:"light2",
		animationEnabled: true,
		exportEnabled: true,
		title:{
			text: "<?PHP echo str_replace('_',' ',$d['Facility_Name']);?> - <?PHP echo $Resident_Type_1;?> - covid19math.net"
		},
		axisY :{
			includeZero: false,
			title: "Number of Infections",
			suffix: "",
			scaleBreaks: {
				autoCalculate: true
			}
		},
		toolTip: {
			shared: "true"
		},
		legend:{
			cursor:"pointer",
			itemclick : toggleDataSeries
		},
		data: [{
		type: "line",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Total Cases",
		dataPoints: [
			<?PHP echo $time_chart_1; ?>
		]
		},{
		type: "line",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Resident Cases",
		dataPoints: [
			<?PHP echo $time_chart_1a; ?>
		]
		},{
		type: "line",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Staff Cases",
		dataPoints: [
			<?PHP echo $time_chart_1b; ?>
		]
		},{
		type: "line",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Resident Deaths",
		dataPoints: [
			<?PHP echo $time_chart_1c; ?>
		]
		},{
		type: "line",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Staff Deaths",
		dataPoints: [
			<?PHP echo $time_chart_1d; ?>
		]
		},{
		type: "column",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "New Count",
		dataPoints: [
			<?PHP echo $new_chart_1; ?>
		]
		}]
	})
	chartZIP<?PHP echo $i;?>.render();


	<?PHP 
	$i++;
	} 
	?>
	
	function toggleDataSeries(e) {
		if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible ){
			e.dataSeries.visible = false;
		} else {
			e.dataSeries.visible = true;
		}
		chart.render();
	}	
}
</script>

<?PHP 

$q = "SELECT distinct Facility_Name FROM coronavirus_facility order by report_count DESC";
$r = $core->query($q);
$i=1;
while ($d = mysqli_fetch_array($r)){
	echo '<div class="row">
		<div class="col-sm-12"><div id="chartContainerZIP'.$i.'" style="height: 250px; width: 100%;"></div></div>
	</div>';
 	$i++;
}

 include_once('footer.php');
	
