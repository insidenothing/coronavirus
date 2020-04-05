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
	$days_to_predict = $_POST['day'];	
}
$logo = 'off';
$page_description = "Animated Graph of $show Cases - $days_to_predict Day Prediction";
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



$q = "SELECT distinct name_of_location FROM coronavirus_populations ";
$r = $core->query($q);
while($d = mysqli_fetch_array($r)){	
	$today[$d[name_of_location]] = 0; // count
	$peak[$d[name_of_location]] = 0; // count
	$normal[$d[name_of_location]] = ''; // string
	$peak_str[$d[name_of_location]] = '<p>'.$d['name_of_location'].' peaked at 0<p>'; // string
}



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
        $next = date('Y-m-d',strtotime($date)+86400);
        $return .= make_county_prediction($county,$next,$count,$dt);
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
	title:{
		text: "The Great State of Maryland - <?PHP echo $days_to_predict;?> Day Prediction"
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
		visible: <?PHP echo show_on_graph('Maryland'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Maryland",
		dataPoints: [
			<?PHP echo make_county('Maryland'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('Allegany'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Allegany",
		dataPoints: [
			<?PHP echo make_county('Allegany'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('AnneArundel'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Anne Arundel",
		dataPoints: [
			<?PHP echo make_county('AnneArundel'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('Baltimore'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Baltimore",
		dataPoints: [
			<?PHP echo make_county('Baltimore'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('BaltimoreCity'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Baltimore City",
		dataPoints: [
			<?PHP echo make_county('BaltimoreCity'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('Calvert'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Calvert",
		dataPoints: [
			<?PHP echo make_county('Calvert'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('Caroline'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Caroline",
		dataPoints: [
			<?PHP echo make_county('Caroline'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('Carroll'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Carroll",
		dataPoints: [
			<?PHP echo make_county('Carroll'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('Cecil'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Cecil",
		dataPoints: [
			<?PHP echo make_county('Cecil'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('Charles'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Charles",
		dataPoints: [
			<?PHP echo make_county('Charles'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('Dorchester'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Dorchester",
		dataPoints: [
			<?PHP echo make_county('Dorchester'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('Frederick'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Frederick",
		dataPoints: [
			<?PHP echo make_county('Frederick'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('Garrett'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Garrett",
		dataPoints: [
			<?PHP echo make_county('Garrett'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('Harford'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Harford",
		dataPoints: [
			<?PHP echo make_county('Harford'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('Howard'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Howard",
		dataPoints: [
			<?PHP echo make_county('Howard'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('Kent'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Kent",
		dataPoints: [
			<?PHP echo make_county('Kent'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('Montgomery'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Montgomery",
		dataPoints: [
			<?PHP echo make_county('Montgomery'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('PrinceGeorges'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Prince Georges",
		dataPoints: [
			<?PHP echo make_county('PrinceGeorges'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('QueenAnnes'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Queen Annes",
		dataPoints: [
			<?PHP echo make_county('QueenAnnes'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('Somerset'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Somerset",
		dataPoints: [
			<?PHP echo make_county('Somerset'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('StMarys'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "St Marys",
		dataPoints: [
			<?PHP echo make_county('StMarys'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('Talbot'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Talbot",
		dataPoints: [
			<?PHP echo make_county('Talbot'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('Washington'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Washington",
		dataPoints: [
			<?PHP echo make_county('Washington'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('Wicomico'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Wicomico",
		dataPoints: [
			<?PHP echo make_county('Wicomico'); ?>
		]
	},
	{
		type: "spline",
		visible: <?PHP echo show_on_graph('Worcester'); ?>,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Worcester",
		dataPoints: [
			<?PHP echo make_county('Worcester'); ?>
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
<div class="container">
	<div class="row">
		<div class='col-sm-12' style='background-color:lightyellow;'>
			<h3>Enter Days to Predict</h3>
			<form method='POST'>
				<p>1. Days to Predict <input name='days' value='<?PHP echo $days_to_predict; ?>'></p>
				<p>2. Click to <input type='submit' value='Update Graph'></p>
				<p><a href='?days=1&show=<?PHP echo $show; ?>'>Run Animation</a> | <a href='graphs.php'>Reset Animation</a></p>
			</form>
			<p>Open Source : <a target='_Blank' href='https://github.com/insidenothing/coronavirus'>https://github.com/insidenothing/coronavirus</a></p>
		</div>
	</div>
	<div class="row">
		<div class='col-sm-4' style='background-color:lightyellow; text-align:left;'>
			<h3>Today ( Click to View )</h3>
			<?PHP
			$q = "SELECT distinct name_of_location FROM coronavirus_populations where name_of_location = 'Maryland'";
			$r = $core->query($q);
			$d = mysqli_fetch_array($r);	
			$r_int = number_format($today[$d[name_of_location]], 0, '.', ',');
			echo "<p><a href='?show=".$d['name_of_location']."'>".$d['name_of_location']."</a> on ".date('Y-m-d')." at $r_int</p>";
			$q = "SELECT distinct name_of_location FROM coronavirus_populations where name_of_location <> 'Maryland' ";
			$r = $core->query($q);
			while($d = mysqli_fetch_array($r)){	
				echo "<p><a href='?show=".$d['name_of_location']."'>".$d['name_of_location']."</a> on ".date('Y-m-d')." at ".$today[$d[name_of_location]]."</p>";
			}
			?>		
		</div>
		<div class='col-sm-4' style='background-color:lightblue; text-align:left;'>
			<h3>Peak Dates</h3>
			<?PHP
			$q = "SELECT distinct name_of_location FROM coronavirus_populations where name_of_location = 'Maryland'";
			$r = $core->query($q);
			$d = mysqli_fetch_array($r);
			echo $peak_str[$d[name_of_location]];
			$q = "SELECT distinct name_of_location FROM coronavirus_populations where name_of_location <> 'Maryland'  ";
			$r = $core->query($q);
			while($d = mysqli_fetch_array($r)){	
				echo $peak_str[$d[name_of_location]];
			}
			?>
		</div>
		<div class='col-sm-4' style='background-color:lightgreen; text-align:left;'>
			<h3>Recovery Dates</h3>
			<?PHP
			$q = "SELECT distinct name_of_location FROM coronavirus_populations ";
			$r = $core->query($q);
			while($d = mysqli_fetch_array($r)){
				if($today[$d[name_of_location]] < 20){
					$normal[$d[name_of_location]] = '<p>Too few cases to predict (under 20) '.$d['name_of_location'].'.</p>'; // string
				}
				if($normal[$d[name_of_location]] == ''){
					$normal[$d[name_of_location]] = '<p>Recovery not on graph for '.$d['name_of_location'].'.</p>'; // string
				}
			}
			$q = "SELECT distinct name_of_location FROM coronavirus_populations where name_of_location = 'Maryland'";
			$r = $core->query($q);
			$d = mysqli_fetch_array($r);
			echo $normal[$d[name_of_location]];
			$q = "SELECT distinct name_of_location FROM coronavirus_populations where name_of_location <> 'Maryland'  ";
			$r = $core->query($q);
			while($d = mysqli_fetch_array($r)){	
				echo $normal[$d[name_of_location]];
			}
			?>
		</div>
	</div>
	<div class="container">
	<div class="row">
		<div class='col-sm-6' style='background-color:lightorange;'>
			<?PHP echo $debug_in; ?>
		</div>
		<div class='col-sm-6' style='background-color:lightblue;'>
			<?PHP echo $debug_out; ?>
		</div>
	</div>
</div>
	
<?PHP include_once('footer.php'); ?>
