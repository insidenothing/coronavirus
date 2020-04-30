<?PHP
$page_description = "Florida Death Data";
include_once('menu.php');
global $florida_deaths;
$florida_deaths = $florida = make_florida_zip_array2('','','');
function make_fl_deaths(){
        global $core;
        global $florida_deaths;
        $return = '';
	$count=0;
	global $today;
	foreach ($florida_deaths as $date => $array){
		$last_count = $count;
		$count = intval($array['Deaths']);
		$return .= '{ label: "'.date('Y-m-d',$date).'", y: '.$count.' }, ';
		$today[$county] = $count;
	}
      	$return = rtrim(trim($return), ",");
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
		name: "Floridians",
		dataPoints: [
			<?PHP echo make_fl_deaths(); ?>
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
