<?PHP
$range='14';
if (isset($_GET['range'])){
	$range = intval($_GET['range']);
}
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
$time_chart='';
$text_div='';
$time_chart2='';
$text_div2='';
$q = "SELECT * FROM coronavirus_zip where zip_code = '$zip' order by report_date";
$r = $core->query($q);
$rows = mysqli_num_rows($r);
$start = $rows - $range;
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
	if($i == 13){
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
	$start = $rows - 14;
	$q = "SELECT * FROM coronavirus_zip where zip_code = '$zip2' order by report_date limit $start, 14";
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
	<div class="col-sm-12" style='text-align:center; background-color:yellow;'>
		<h1>From <?PHP echo $start_value;?> cases to <?PHP echo $end_value;?> cases is a <?PHP $per = round( ( ( $end_value - $start_value ) / $start_value ) * 100); echo $per;?>% change in 2 weeks.</h1>
	</div>
</div>
<?PHP 
$page_description = $per."% change $page_description";
$alert = ob_get_clean();
include_once('menu.php');
echo $alert;
?>


<script src="canvasjs.min.js"></script>
<script>
window.onload = function () {
	var chartZIP2 = new CanvasJS.Chart("chartContainerZIP2", {
		theme:"light2",
		animationEnabled: true,
		exportEnabled: true,
		title:{
			text: "Last <?PHP echo $range;?> days for <?PHP echo $name;?> <?PHP echo $per;?>% change - source covid19math.net"
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
			<?PHP echo $time_chart; ?>
		]
		},
		{
		type: "<?PHP echo $type_graph;?>",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "<?PHP echo $zip;?> New Count",
		dataPoints: [
			<?PHP echo $new_chart; ?>
		]
		}<?PHP if ($zip2 != '99999'){ echo ',{
		type: "spline",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "'.$zip2.';",
		dataPoints: [
			'.$time_chart2.'
		]
		}'; } ?>]
	})
	chartZIP2.render();	

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


<div class="row"><div class="col-sm-2"><?PHP echo $text_div;?><?PHP echo $text_div2;?></div><div class="col-sm-10"><div id="chartContainerZIP2" style="height: 500px; width: 100%;"></div></div></div>

	
<?PHP include_once('footer.php'); ?>
	
