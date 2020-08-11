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
$page_description = "Maryland Case Deltas";
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
		text: "The Great State of Maryland - <?PHP echo $page_description; ?> covid19math.net"
	},
	axisY :{
		includeZero: false,
		title: "Change in Cases",
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
		visible: false,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Case Delta",
		dataPoints: [
			<?PHP echo make_county('CaseDelta'); ?>
		]
	},
	{
		type: "spline",
		visible: false,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Neg Delta",
		dataPoints: [
			<?PHP echo make_county('NegDelta'); ?>
		]
	},
	{
		type: "spline",
		visible: false,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Hospitalized Delta",
		dataPoints: [
			<?PHP echo make_county('hospitalizedDelta'); ?>
		]
	},
	{
		type: "spline",
		visible: false,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Released Delta",
		dataPoints: [
			<?PHP echo make_county('releasedDelta'); ?>
		]
	},
	{
		type: "spline",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Deaths Delta",
		dataPoints: [
			<?PHP echo make_county('deathsDelta'); ?>
		]
	},
	{
		type: "line",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Deaths Delta Low Trend",
		dataPoints: [
			{ label: "2020-03-03", y: 0 },
			{ label: "2020-03-04", y: 0 },
			{ label: "2020-03-05", y: 0 },
			{ label: "2020-03-06", y: 0 },
			{ label: "2020-03-07", y: 0 },
			{ label: "2020-03-08", y: 0 },
			{ label: "2020-03-09", y: 0 },
			{ label: "2020-03-10", y: 0 },
			{ label: "2020-03-11", y: 0 },
			{ label: "2020-03-12", y: 0 },
			{ label: "2020-03-13", y: 0 },
			{ label: "2020-03-14", y: 0 },
			{ label: "2020-03-15", y: 0 },
			{ label: "2020-03-16", y: 0 },
			{ label: "2020-03-17", y: 0 },
			{ label: "2020-03-18", y: 0 },
			{ label: "2020-03-19", y: 0 },
			{ label: "2020-03-20", y: 0 },
			{ label: "2020-03-21", y: 0 },
			{ label: "2020-03-22", y: 0 },
			{ label: "2020-03-23", y: 0 },
			{ label: "2020-03-24", y: 0 },
			{ label: "2020-03-25", y: 0 },
			{ label: "2020-03-26", y: 0 },
			{ label: "2020-03-27", y: 0 },
			{ label: "2020-03-28", y: 0 },
			{ label: "2020-03-29", y: 0 },
			{ label: "2020-03-30", y: 1 },
			{ label: "2020-03-31", y: 2 },
			{ label: "2020-04-01", y: 3 },
			{ label: "2020-04-02", y: 4 },
			{ label: "2020-04-03", y: 5 },
			{ label: "2020-04-04", y: 6 },
			{ label: "2020-04-05", y: 8 },
			{ label: "2020-04-06", y: 9 },
			{ label: "2020-04-07", y: 10 },
			{ label: "2020-04-08", y: 11 },
			{ label: "2020-04-09", y: 12 },
			{ label: "2020-04-10", y: 13 },
			{ label: "2020-04-11", y: 14 },
			{ label: "2020-04-12", y: 15 },
			{ label: "2020-04-13", y: 16 },
			{ label: "2020-04-14", y: 17 },
			{ label: "2020-04-15", y: 18 },
			{ label: "2020-04-16", y: 19 },
			{ label: "2020-04-17", y: 20 },
			{ label: "2020-04-18", y: 21 },
			{ label: "2020-04-19", y: 22 },
			{ label: "2020-04-20", y: 23 },
			{ label: "2020-04-21", y: 24 },
			{ label: "2020-04-22", y: 25 },
			{ label: "2020-04-23", y: 26 },
			{ label: "2020-04-24", y: 27 },
			{ label: "2020-04-25", y: 28 },
			{ label: "2020-04-26", y: 29 },
			{ label: "2020-04-27", y: 30 },
			{ label: "2020-04-28", y: 31 }
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
