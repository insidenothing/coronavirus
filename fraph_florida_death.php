<?PHP
global $show;
$show = '';
if(isset($_GET['show'])){
	$show = $_GET['show'];
}
global $days_to_predict;
$days_to_predict = '1';

if(isset($_POST['days'])){
	$days_to_predict = $_POST['days'];	
}
if(isset($_GET['day'])){
	$days_to_predict = $_GET['day'];	
}
$logo = 'off';
$page_description = "Florida Death Data";
include_once('menu.php');

global $today;
global $normal;
global $peak;
global $peak_str;
$today = array();
$normal = array();
$peak = array();
$peak_str = array();

global $florida_deaths;
$florida_deaths = $florida = make_florida_zip_array2('','','');




global $buffer;
$buffer = '.85';
if(isset($_POST['buffer'])){
	$buffer = $_POST['buffer'];	
}
global $debug_in;
global $debug_out;

function total_count($county){
	global $core;
	$q = "SELECT number_of_people FROM coronavirus_populations where name_of_location = '$county' ";
	$r = $core->query($q);
	$d = mysqli_fetch_array($r);
	return $d['number_of_people'];
}
function rate_of_infection($county){
	global $core;
	$q = "SELECT rate_of_infection FROM coronavirus_populations where name_of_location = '$county' ";
	$r = $core->query($q);
	$d = mysqli_fetch_array($r);
	return $d['rate_of_infection'];	
}
function show_on_graph($county){
	global $show;
	// if has cases = true else false
	global $maryland_history;
	$date = $maryland_history['date'];
	$aka = county_aka($county);
	error_log("show_on_graph($county) $date $aka", 0);
	$val = $maryland_history[$date][$aka];
	$count = intval($val);
	if ($show != ''){
		if ($show == $county){
			return 'true';	
		}else{
			return 'false';	
		}	
	}
	if ($count == 0){
		return 'false';
	}else{
		return 'true';	
	}
	
}
function make_fl_deaths(){
        global $core;
        global $florida_deaths;
        $return = '';
        $t = '0'; // days
        $dt= '1'; // change in days


	$count=0;
	global $today;
	foreach ($florida_deaths as $date => $array){
		$last_count = $count;
		$count = intval($array[$aka]);
		$return .= '{ label: "'.$date.'", y: '.$count.' }, ';
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
		name: "ICU Beds",
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

<?PHP print_r($florida_deaths); ?>



<?PHP include_once('footer.php'); ?>
