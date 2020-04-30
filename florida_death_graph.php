<?PHP
$page_description = "Florida Deaths";
include_once('menu.php');
global $florida_deaths;
$florida_deaths = $florida = make_florida_zip_array2('','','');
global $graph_total;
$graph_total='';
global $graph_total_int;
$graph_total_int=0;
function make_fl_deaths(){
        global $core;
        global $florida_deaths;
	global $graph_total;
	global $graph_total_int;
        $return = '';
	$count=0;
	global $today;
	foreach ($florida_deaths as $date => $array){
		$last_count = $count;
		$count = intval($array['Deaths']);
		if ($date > 0){
			$time = $date / 1000;
			$date = date('Y-m-d',$time+14400);
			$return .= '{ label: "'.$date.'", y: '.$count.' }, ';
			$graph_total_int = $graph_total_int + $count;
			$graph_total .= '{ label: "'.date('Y-m-d',$date).'", y: '.$graph_total_int.' }, ';
		}
		$today[$county] = $count;
	}
	$graph_total 	= rtrim(trim($graph_total), ",");
      	$return 	= rtrim(trim($return), ",");
    return $return;
}
?>
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	theme:"light2",
	animationEnabled: true,
	exportEnabled: true,
	title:{
		text: "Florida Death Data"
	},
	axisY :{
		includeZero: false,
		title: "Number of Deaths",
		suffix: ""
	},
	toolTip: {
		shared: "true"
	},
	legend:{
		cursor:"pointer",
		itemclick : toggleDataSeries
	},
	data: [{
		type: "spline",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "New Deaths",
		dataPoints: [
			<?PHP echo make_fl_deaths(); ?>
		]
	},
	      {
		type: "spline",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Total Deaths",
		dataPoints: [
			<?PHP echo $graph_total; ?>
		]
	}]
}			      			      
);
chart.render();

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

<div id="chartContainer" style="height: 370px; max-width: 1020px; margin: 0px auto;"></div>
<script src="canvasjs.min.js"></script>

<?PHP include_once('footer.php'); ?>
