<?PHP
$type_graph='column';
if (isset($_GET['type_graph'])){
	$type_graph = $_GET['type_graph'];
}
include_once('county_zip_codes.php');
global $zip;
if(isset($_GET['zip'])){
	$zip = $_GET['zip'];	
}else{
  	$zip = '99999';	
}
global $zip2;
$zip2 = '99999';
$pos = strpos($zip, ',');
if ($pos !== false) {
	$zips = explode(',',$zip);
	$zip = $zips[0];
	$zip2 = $zips[1];
}
$logo = 'off';
global $zip_debug;
include_once('/var/www/secure.php'); //outside webserver
include_once('functions.php'); //outside webserver

if (isset($_GET['auto'])){
	$q = "SELECT zip_code FROM coronavirus_zip where report_count <> '0' and change_percentage_time = '00:00:00' and report_date = '".date('Y-m-d')."' order by RAND() ";
	$r = $core->query($q);
	$d = mysqli_fetch_array($r);
	$left = mysqli_num_rows($r);
	echo "<meta http-equiv=\"refresh\" content=\"5; url=https://www.covid19math.net/zipcode.php?zip=".$d['zip_code']."&auto=$left\">";
}


function data_points($zip,$field){
	global $core;
	$q = "SELECT report_date, $field FROM coronavirus_zip where zip_code = '$zip' and $field <> '' order by report_date";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		$chart .=  '{ label: "'.$d['report_date'].'", y: '.$d[$field].' }, ';
	}
	$chart = rtrim(trim($chart), ",");
	return $chart;
}

function make_chart($range){
	global $core;
	global $zip;
	global $zip2;
$time_chart='';
$text_div='';
$time_chart2='';
$text_div2='';
$q = "SELECT * FROM coronavirus_zip where zip_code = '$zip' order by report_date";
$r = $core->query($q);
$rows = mysqli_num_rows($r);
$start = $rows - $range;
$range2= $range - 1;
$q = "SELECT * FROM coronavirus_zip where zip_code = '$zip' order by report_date limit $start, $range";
$r = $core->query($q);
$i=0;
while ($d = mysqli_fetch_array($r)){
	$name = "$d[town_name], $d[state_name]";
	$time_chart .=  '{ label: "'.$d['report_date'].'", y: '.$d['report_count'].' }, ';
	if ($i == 0){
		$me = 0;
	}else{
		$me = intval($d['report_count'] - $last);
	}
	$new_chart .=  '{ label: "'.$d['report_date'].'", y: '.$me.' }, ';
	$last = $d['report_count'];
	$text_div .= "<li>$d[report_date] $d[report_count] $d[trend_direction] $d[trend_duration]</li>";
	$last_count = $d[report_count];
	if($i == 0){
		$start_value = $d['report_count'];
	}
	if($i == $range2){
		$end_value = $d['report_count'];
	}
	$i++; // number of days in the graph
}
$time_chart = rtrim(trim($time_chart), ",");
$new_chart = rtrim(trim($new_chart), ",");
$page_description = "$date $name at $last_count Cases";
$name2='';
$i2=0;
if ($zip2 != '99999'){
	$q = "SELECT * FROM coronavirus_zip where zip_code = '$zip' order by report_date";
	$r = $core->query($q);
	$rows = mysqli_num_rows($r);
	$start = $rows - $range;
	$q = "SELECT * FROM coronavirus_zip where zip_code = '$zip2' order by report_date limit $start, $range";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		$name2 = " $d[town_name], $d[state_name]";
		$count = $d['report_count'];
		if ($count == 0){
			if ($last_count2 > 0){
				$count = $last_count2; // patch missing data with yesterday	
			}
		}
		$time_chart2 .=  '{ label: "'.$d['report_date'].'", y: '.$count.' }, ';
		$text_div2 .= "<li>$d[report_date] $d[report_count] $d[trend_direction] $d[trend_duration]</li>";
		$last_count2 = $count;
		$i2++; // number of days in second graph
	}
	$time_chart2 = rtrim(trim($time_chart2), ",");
	$page_description = "$date $name at $last_count, $name2 at $last_count2 Cases";
}
$name = $name.$name2;
if ($zip2 != '99999'){
	if ($i > $i2){
		$time_chart2_pre='';
		// add blank days to the front of $time_chart2
		foreach (range($i2, $i-1) as $back_days) {
			$back_days = -1 * $back_days; 
			$date = date('Y-m-d',strtotime($back_days.' days'));
			$time_chart2_pre =  '{ label: "'.$date.'", y: 0 }, ' . $time_chart2_pre;
		}
		$time_chart2 = $time_chart2_pre.$time_chart2;
	}elseif($i < $i2){
		$time_chart_pre='';
		$back_days = -1 * $back_days; 
		// add blank days to the front of $time_chart
		foreach (range($i, $i2-1) as $back_days) {
			$back_days = -1 * $back_days; 
			$date = date('Y-m-d',strtotime($back_days.' days'));
			$time_chart_pre =  '{ label: "'.$date.'", y: 0 }, ' . $time_chart_pre;
		}
		$time_chart = $time_chart_pre.$time_chart;
	}
}
ob_start();
?>
<div class="row">
	<?PHP 
	$per = round( ( ( $end_value - $start_value ) / $start_value ) * 100); 
	if ($per == '0'){
		$color = 'lightgreen';	
	}elseif($per < '10'){
		$color = 'lightyellow';
	}elseif($per < '50'){
		$color = '#fed8b1'; // light orange
	}elseif($per < '100'){
		$color = '#fed8b1'; // light red
	}elseif($per < '150'){
		$color = '#fed8b1'; // light purple
	}else{
		$color = '#800080'; // dark purple	
	}
	?>
	
	<p style='text-align:center; background-color:<?PHP echo $color;?>;'>
		From <?PHP echo $start_value;?> cases to <?PHP echo $end_value;?> cases is a <?PHP echo $per;?>% change in <?PHP echo $range;?> days. (<?PHP echo $color;?>)
	</p>
	
</div>
<?PHP 
$page_description = $per."% change $page_description";
$alert = ob_get_clean();
	$return = array();
	$return['alert'] = $alert;
	$return['page_description'] = $page_description;
	$return['time_chart'] = $time_chart;
	$return['time_chart2'] = $time_chart2;
	$return['new_chart'] = $new_chart;
	$return['range'] = $range;
	$return['name'] = $name;
	$return['per'] = $per;
	return $return;
}
$day7 = make_chart('7');
$day14 = make_chart('14');
$day30 = make_chart('30');
$day45 = make_chart('45');
$page_description = $day14['page_description'];
include_once('menu.php');


// Chart 1

$alert_1 		= $day7['alert'];
$time_chart_1 		= $day7['time_chart'];
$time_chart2_1 		= $day7['time_chart2'];
$new_chart_1 		= $day7['new_chart'];
$range_1 		= $day7['range'];
$name_1 		= $day7['name'];
$per_1 			= $day7['per'];

// Chart 2

$alert_2 		= $day14['alert'];
$time_chart_2 		= $day14['time_chart'];
$time_chart2_2 		= $day14['time_chart2'];
$new_chart_2 		= $day14['new_chart'];
$range_2 		= $day14['range'];
$name_2 		= $day14['name'];
$per_2 			= $day14['per'];

// Chart 3

$alert_3 		= $day30['alert'];
$time_chart_3 		= $day30['time_chart'];
$time_chart2_3 		= $day30['time_chart2'];
$new_chart_3 		= $day30['new_chart'];
$range_3 		= $day30['range'];
$name_3 		= $day30['name'];
$per_3 			= $day30['per'];

// Chart 4

$alert_4 		= $day45['alert'];
$time_chart_4 		= $day45['time_chart'];
$time_chart2_4 		= $day45['time_chart2'];
$new_chart_4 		= $day45['new_chart'];
$range_4 		= $day45['range'];
$name_4 		= $day45['name'];
$per_4 			= $day45['per'];

$date = date('Y-m-d');
$q = "update coronavirus_zip set change_percentage_time= NOW(), day7change_percentage = '$per_1', day14change_percentage = '$per_2', day30change_percentage = '$per_3', day45change_percentage = '$per_4' where zip_code = '$zip' and report_date = '$date'";
$core->query($q);
?>
<script src="canvasjs.min.js"></script>
<script>
window.onload = function () {
	var chartZIP1 = new CanvasJS.Chart("chartContainerZIP1", {
		theme:"light2",
		animationEnabled: true,
		exportEnabled: true,
		title:{
			text: "<?PHP echo $range_1;?> days <?PHP echo $name_1;?> <?PHP echo $per_1;?>% change - source covid19math.net"
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
		name: "<?PHP echo $zip;?> Total Count",
		dataPoints: [
			<?PHP echo $time_chart_1; ?>
		]
		},
		{
		type: "column",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "<?PHP echo $zip;?> New Count",
		dataPoints: [
			<?PHP echo $new_chart_1; ?>
		]
		}<?PHP if ($zip2 != '99999'){ echo ',{
		type: "spline",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "'.$zip2.';",
		dataPoints: [
			'.$time_chart2_1.'
		]
		}'; } ?>]
	})
	chartZIP1.render();	

	var chartZIP2 = new CanvasJS.Chart("chartContainerZIP2", {
		theme:"light2",
		animationEnabled: true,
		exportEnabled: true,
		title:{
			text: "<?PHP echo $range_2;?> days <?PHP echo $name_2;?> <?PHP echo $per_2;?>% change - source covid19math.net"
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
		name: "<?PHP echo $zip;?> Total Count",
		dataPoints: [
			<?PHP echo $time_chart_2; ?>
		]
		},
		{
		type: "column",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "<?PHP echo $zip;?> New Count",
		dataPoints: [
			<?PHP echo $new_chart_2; ?>
		]
		}<?PHP if ($zip2 != '99999'){ echo ',{
		type: "spline",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "'.$zip2.';",
		dataPoints: [
			'.$time_chart2_2.'
		]
		}'; } ?>]
	})
	chartZIP2.render();	
var chartZIP3 = new CanvasJS.Chart("chartContainerZIP3", {
		theme:"light2",
		animationEnabled: true,
		exportEnabled: true,
		title:{
			text: "<?PHP echo $range_3;?> days <?PHP echo $name_3;?> <?PHP echo $per_3;?>% change - source covid19math.net"
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
		name: "<?PHP echo $zip;?> Total Count",
		dataPoints: [
			<?PHP echo $time_chart_3; ?>
		]
		},
		{
		type: "column",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "<?PHP echo $zip;?> New Count",
		dataPoints: [
			<?PHP echo $new_chart_3; ?>
		]
		}<?PHP if ($zip2 != '99999'){ echo ',{
		type: "spline",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "'.$zip2.';",
		dataPoints: [
			'.$time_chart2_3.'
		]
		}'; } ?>]
	})
	chartZIP3.render();	
var chartZIP4 = new CanvasJS.Chart("chartContainerZIP4", {
		theme:"light2",
		animationEnabled: true,
		exportEnabled: true,
		title:{
			text: "<?PHP echo $range_4;?> days <?PHP echo $name_4;?> <?PHP echo $per_4;?>% change - source covid19math.net"
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
		name: "<?PHP echo $zip;?> Total Count",
		dataPoints: [
			<?PHP echo $time_chart_4; ?>
		]
		},
		{
		type: "column",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "<?PHP echo $zip;?> New Count",
		dataPoints: [
			<?PHP echo $new_chart_4; ?>
		]
		}<?PHP if ($zip2 != '99999'){ echo ',{
		type: "spline",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "'.$zip2.';",
		dataPoints: [
			'.$time_chart2_4.'
		]
		}'; } ?>]
	})
	chartZIP4.render();	
	var chartZIP5 = new CanvasJS.Chart("chartContainerZIP5", {
		theme:"light2",
		animationEnabled: true,
		exportEnabled: true,
		title:{
			text: "<?PHP echo $name_4;?> Changes in Percentages - source covid19math.net"
		},
		axisY :{
			includeZero: false,
			title: "Percentage of Change",
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
		name: "<?PHP echo $zip;?> 7 Day",
		dataPoints: [
			<?PHP echo data_points($zip,'day7change_percentage'); ?>
		]
		},
		{
		type: "line",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "<?PHP echo $zip;?> 14 Day",
		dataPoints: [
			<?PHP echo data_points($zip,'day14change_percentage'); ?>
		]
		},
		{
		type: "line",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "<?PHP echo $zip;?> 30 Day",
		dataPoints: [
			<?PHP echo data_points($zip,'day30change_percentage'); ?>
		]
		},
		{
		type: "line",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "<?PHP echo $zip;?> 45 Day",
		dataPoints: [
			<?PHP echo data_points($zip,'day45change_percentage'); ?>
		]
		}]
	})
	chartZIP5.render();
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

<div class="row">
	<div class="col-sm-12"><div id="chartContainerZIP5" style="height: 500px; width: 100%;"></div></div>
</div>


<div class="row">
	<div class="col-sm-6"><?PHP echo $alert_1;?><div id="chartContainerZIP1" style="height: 500px; width: 100%;"></div></div>
	<div class="col-sm-6"><?PHP echo $alert_2;?><div id="chartContainerZIP2" style="height: 500px; width: 100%;"></div></div>
</div>
<div class="row">
	<div class="col-sm-6"><?PHP echo $alert_3;?><div id="chartContainerZIP3" style="height: 500px; width: 100%;"></div></div>
	<div class="col-sm-6"><?PHP echo $alert_4;?><div id="chartContainerZIP4" style="height: 500px; width: 100%;"></div></div>
</div>

<div class="row">
	<div class="col-sm-12">
		<?PHP echo $text_div1;?><?PHP echo $text_div2;?><?PHP echo $text_div3;?><?PHP echo $text_div4;?>
	</div>
</div>
	
<?PHP include_once('footer.php'); ?>
	
