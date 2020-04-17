<?PHP
global $show;
$show = '';
if(isset($_GET['show'])){
	$show = $_GET['show'];
}
global $days_to_predict;
$days_to_predict = '1';
if(isset($_GET['days'])){
	// stop bot from running animation
	$ua = $_SERVER['HTTP_USER_AGENT'];
	if (preg_match('/facebookexternalhit/si',$ua)) { 
		header('Location: graphs.php?show='.$show); 
		die(); 
	} 
	// animaton
	$days_to_predict = $_GET['days'];
	$next_days = $days_to_predict + 7; 
	if($next_days < 90){
		// limit to 200 days
		if($show != ''){
			echo "<meta http-equiv='refresh' content='5; url=https://www.mdwestserve.com/coronavirus/graphs.php?days=$next_days&show=$show'>";
		}else{
			echo "<meta http-equiv='refresh' content='5; url=https://www.mdwestserve.com/coronavirus/graphs.php?days=$next_days'>";	
		}
	}
}
if(isset($_POST['days'])){
	$days_to_predict = $_POST['days'];	
}
if(isset($_GET['day'])){
	$days_to_predict = $_GET['day'];	
}
$logo = 'off';
$page_description = "Maryland Hospital Data";
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
$r = $core->query($q);
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
function make_county($county){
        global $core;
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
		$return .= '{ label: "'.$date.'", y: '.$count.' }, ';
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
    global $core;
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
        $return .= '{ label: "'.$out.'", y: '.$r.' }, ';
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
		text: "The Great State of Maryland - Hospital Data covid19math.net"
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
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Total Hospitalized",
		dataPoints: [
			<?PHP echo make_county('total_hospitalized'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('total_released'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Total Released",
		dataPoints: [
			<?PHP echo make_county('total_released'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('deaths'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Deaths",
		dataPoints: [
			<?PHP echo make_county('deaths'); ?>
		]
	},
	{
		type: "spline",
		visible: false,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Negative Tests",
		dataPoints: [
			<?PHP echo make_county('NegativeTests'); ?>
		]
	},
	{
		type: "spline",
		visible: false,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Total Cases",
		dataPoints: [
			<?PHP echo make_county('TotalCases'); ?>
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
</head>
<body>
<div id="chartContainer" style="height: 370px; max-width: 1020px; margin: 0px auto;"></div>
<script src="canvasjs.min.js"></script>
	
<?PHP include_once('footer.php'); ?>
