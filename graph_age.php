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
$page_description = "Infection History by Age";
include_once('menu.php');

global $today;
global $normal;
global $peak;
global $peak_str;
$today = array();
$normal = array();
$peak = array();
$peak_str = array();

global $maryland_history;
$maryland_history = make_maryland_array();


/*
$q = "SELECT distinct name_of_location FROM coronavirus_populations ";
$r = $covid_db->query($q);
while($d = mysqli_fetch_array($r)){	
	$today[$d[name_of_location]] = 0; // count
	$peak[$d[name_of_location]] = 0; // count
	$normal[$d[name_of_location]] = ''; // string
	$peak_str[$d[name_of_location]] = '<p>'.$d['name_of_location'].' peaked at 0<p>'; // string
}
*/


global $buffer;
$buffer = '.85';
if(isset($_POST['buffer'])){
	$buffer = $_POST['buffer'];	
}
global $debug_in;
global $debug_out;

function total_count($county){
	global $covid_db;
	$q = "SELECT number_of_people FROM coronavirus_populations where name_of_location = '$county' ";
	$r = $covid_db->query($q);
	$d = mysqli_fetch_array($r);
	return $d['number_of_people'];
}
function rate_of_infection($county){
	global $covid_db;
	$q = "SELECT rate_of_infection FROM coronavirus_populations where name_of_location = '$county' ";
	$r = $covid_db->query($q);
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
function make_county($county){
        global $covid_db;
        $return = '';
        $t = '0'; // days
        $dt= '1'; // change in days
        // history
        global $maryland_history;
	$aka = county_aka($county);
	$count=0;
	global $today;
	foreach ($maryland_history as $date => $array){
		$last_count = $count;
		$count = intval($array[$aka]);
		if ($count > 0 && $date != 'date'){ 
			$return .= '{ label: "'.$date.'", y: '.$count.' }, ';
		}
		$today[$county] = $count;
	}
        // predictive
        //$next = date('Y-m-d',strtotime($date)+86400);
        //$return .= make_county_prediction($county,$next,$count,$dt);
    	$return = rtrim(trim($return), ",");
    return $return;
}
function make_county_prediction($county,$start,$count,$dt){
    global $debug_in;
    global $debug_out;
    global $covid_db;
    $return = '';
    $start = new DateTime ($start, new DateTimeZone ('UTC'));
    global $days_to_predict;
    $end = new DateTime (" +$days_to_predict days", new DateTimeZone ('UTC'));
    $interval = new DateInterval ('P1D');
    $range = new DatePeriod ($start, $interval, $end);
    $N = $count; // total cases
    $Nmax = total_count($county); // population	
    $a = rate_of_infection($county); // percentage infection rate  
    $day_buffer = 0;
    foreach ($range as $date) {
	$out = $date->format ('Y-m-d');
        $debug_in .= "<li>$out N: $N Nold: $Nold Nmax:$Nmax a:$a</li>";
        $Nold=$N;
        $N=$N+$a*(1-$N/$Nmax)*$N*$dt;   
        $r=($N-$Nold)/$dt;
	if(empty($base)){
		// only set base once
		global $buffer;
		$base = ($N - $r)*$buffer;
		$debug_out .= "<li><b>BASE: $base = ($N - $r) * $buffer</b></li>";
	}
	$r = $r + $base;
	$debug_out .= "<li>$out N:$N r:$r</li>";
	    if ($out > 0){ // drop days without
       		 $return .= '{ label: "'.$out.'", y: '.$r.' }, ';
	    }
	global $today;
	global $normal;
	global $peak;
	global $peak_str;
	$r_int = number_format($r, 0, '.', ',');
        if($r > $peak[$county]){
		$peak[$county] = $r;
		$peak_str[$county] = "<p>On $out $county peaked at $r_int<p>";
        }
	if (intval($today[$county]) > intval($r) && intval($r) != 0 && $normal[$county] == '' && $day_buffer > 14){
		$normal[$county] = "<p style='background-color:pink; '>On $out $county went under ".$today[$county]." to $r_int</p>";    
	}
	$day_buffer++;
    }
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
		text: "The Great State of Maryland - Infection History by Age covid19math.net"
	},
	axisY :{
		includeZero: false,
		title: "Number of Cases",
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
		visible: <?PHP echo show_on_graph('case0to9'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "age 0 to 9",
		dataPoints: [
			<?PHP echo make_county('case0to9'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('case10to19'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "age 10 to 19",
		dataPoints: [
			<?PHP echo make_county('case10to19'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('case20to29'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "age 20 to 29",
		dataPoints: [
			<?PHP echo make_county('case20to29'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('case30to39'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "age 30 to 39",
		dataPoints: [
			<?PHP echo make_county('case30to39'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('case40to49'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "age 40 to 49",
		dataPoints: [
			<?PHP echo make_county('case40to49'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('case50to59'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "age 50 to 59",
		dataPoints: [
			<?PHP echo make_county('case50to59'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('case60to69'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "age 60 to 69",
		dataPoints: [
			<?PHP echo make_county('case60to69'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('case70to79'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "age 70 to 79",
		dataPoints: [
			<?PHP echo make_county('case70to79'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('case80plus'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "age 80 plus",
		dataPoints: [
			<?PHP echo make_county('case80plus'); ?>
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
