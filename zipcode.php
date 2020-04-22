<?PHP
include_once('county_zip_codes.php');

global $zip;
if(isset($_GET['zip'])){
	$zip = $_GET['zip'];	
}else{
  	$zip = '99999';	
}

$logo = 'off';
include_once('/var/www/secure.php'); //outside webserver
include_once('functions.php');

global $zip_debug;
function make_datapoints(){
	global $zipData;
	global $zip2name;
	global $county;
	global $county_zip_codes;
	global $global_graph_height;
	global $zip_debug;
	global $showzip;
	$match_array = $county_zip_codes['Maryland'][$county];
	$return = '';
	$total=0;
	foreach ($zipData as $zip => $data){
		$count = intval($data['ProtectedCount']);
		$key = array_search($zip, $match_array);
		if ( $key > 0 && $count > 0 ) {
			$global_graph_height = $global_graph_height + 25; // px per line in graph
			$total++;
		}elseif( $key > 0 ){
			$global_graph_height = $global_graph_height + 25; // px per line in graph
		}
	}
	foreach ($zipData as $zip => $data){
		$count = intval($data['ProtectedCount']);
		$key = array_search($zip, $match_array);
		if ( $key > 0  && $count > 0 ) {
			$name = $zip2name[$zip];
			$return .= "{ y: $count, label: '$total $name $zip' },";
			$total = $total - 1;
			$zip_debug .= '<span style="background-color:red;">'.$zip.' </span> ';
			$showzip[] = $zip;
		}elseif( $key > 0  ){
			$zip_debug .= '<span style="background-color:green;">'.$zip.' </span> ';
		}
	}
	$return = rtrim(trim($return), ",");
	return $return;
}


//$date = $maryland_history['date'];

$page_description = "$date $zip - ZIP Codes";

include_once('menu.php');



?><div class="row"><div class="col-sm-12"><h3><?PHP echo $zip;?> History</h3><?PHP

$q = "SELECT * FROM `coronavirus_zip` where zip_code = '$zip' order by report_date desc";
$r = $core->query($q);
while ($d = mysqli_fetch_array($r)){
	echo "<li>$d[id] $d[zip_code] $d[report_date] $d[town_name] $d[state_name] $d[report_count] $d[trend_direction] $d[trend_duration]</li>";
}
?></div></div><?PHP


global $today;
global $normal;
global $peak;
global $peak_str;
$today = array();
$normal = array();
$peak = array();
$peak_str = array();




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
function rate_of_death($county){
	global $core;
	$q = "SELECT rate_of_death FROM coronavirus_populations where name_of_location = '$county' ";
	$r = $core->query($q);
	$d = mysqli_fetch_array($r);
	return $d['rate_of_death'];	
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
function make_zip($zip){
        global $core;
        $return = '';
	$count=0;
	$q = "select * from coronavirus_zip where zip_code = '$zip' order by report_date ";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		$count 	= $d['report_count'];
		$date 	= $d['report_date'];
		$return .= '{ label: "'.$date.'", y: '.$count.' }, ';
	}
    	$return = rtrim(trim($return), ",");
    return $return;
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
		if ($date != 'date'){
			$last_count = $count;
			$count = intval($array[$aka]);
			$return .= '{ label: "'.$date.'", y: '.$count.' }, ';
			$today[$county] = $count;
		}
	}
        // predictive
       // $next = date('Y-m-d',strtotime($date)+86400);
       // $return .= make_county_prediction($county,$next,$count,$dt);
    	$return = rtrim(trim($return), ",");
    return $return;
}
function make_dcounty($county){
        global $core;
        $return = '';
        $t = '0'; // days
        $dt= '1'; // change in days
        // history
        global $maryland_history;
	$aka = county_daka($county);
	$count=0;
	global $today;
	foreach ($maryland_history as $date => $array){
		if($date != 'date'){
			$last_count = $count;
			$count = intval($array[$aka]);
			$return .= '{ label: "'.$date.'", y: '.$count.' }, ';
			$today[$county] = $count;
		}
	}
        // predictive
       // $next = date('Y-m-d',strtotime($date)+86400);
       // $return .= make_dcounty_prediction($county,$next,$count,$dt);
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
	$r_graph = 0;
	if($r > $r_graph){
		$r_graph = $r;
	}
        $return .= '{ label: "'.$out.'", y: '.intval($r_graph).' }, ';
	global $today;
	global $normal;
	global $peak;
	global $peak_str;
	$r_int = number_format($r, 0, '.', ',');
        if($r > $peak[$county]){
		$peak[$county] = $r;
		$datetime1 = new DateTime($out);
		$datetime2 = new DateTime("now");
		$interval = $datetime1->diff($datetime2);
		$from_now = $interval->format('%R%a days');
		$peak_str[$county] = "<p>On $out in $from_now $county infection peaked at $r_int<p>";
        }
	if (intval($today[$county]) > intval($r) && intval($r) != 0 && $normal[$county] == ''){
		$datetime1 = new DateTime($out);
		$datetime2 = new DateTime("now");
		$interval = $datetime1->diff($datetime2);
		$from_now = $interval->format('%R%a days');
		$normal[$county] = "<p style='background-color:pink; '>On $out in $from_now $county infections went under ".$today[$county]." to $r_int</p>";    
	}
	$day_buffer++;
    }
    return $return;
}
function make_dcounty_prediction($county,$start,$count,$dt){
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
    $a = rate_of_death($county); // percentage infection rate  
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
	$r_graph = 0;
	if($r > $r_graph){
		$r_graph = $r;
	}
        $return .= '{ label: "'.$out.'", y: '.intval($r_graph).' }, ';
	global $today;
	global $normal;
	global $peak;
	global $peak_str;
	global $dnormal;
	global $dpeak;
	global $dpeak_str;
	$r_int = number_format($r, 0, '.', ',');
        if($r > $dpeak[$county]){
		$dpeak[$county] = $r;
		$datetime1 = new DateTime($out);
		$datetime2 = new DateTime("now");
		$interval = $datetime1->diff($datetime2);
		$from_now = $interval->format('%R%a days');
		$dpeak_str[$county] = "<p>On $out in $from_now $county deaths peaked at $r_int<p>";
        }
	if (intval($today[$county]) > intval($r) && intval($r) != 0 && $dnormal[$county] == ''){
		$datetime1 = new DateTime($out);
		$datetime2 = new DateTime("now");
		$interval = $datetime1->diff($datetime2);
		$from_now = $interval->format('%R%a days');
		$dnormal[$county] = "<p style='background-color:pink; '>On $out in $from_now $county deaths went under ".$today[$county]." to $r_int</p>";    
	}
	$day_buffer++;
    }
    return $return;
}
$date = $maryland_history['date'];
$AKA = county_aka($county);
$dAKA = county_daka($county);

function makeZIPpoints(){
	global $core;
	global $showzip;
	global $zip2name;
	$return = '';
	foreach ($showzip as $zip) {
		$name = $zip2name[$zip];
		$return .= '{	
		type: "spline",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "'.$name.'",
		dataPoints: [
			'.make_zip($zip).'
		]},';
	}
	$return = rtrim(trim($return), ",");
	return $return;	
}

	


?>






  	




<script src="canvasjs.min.js"></script>
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	theme:"light2",
	animationEnabled: true,
	exportEnabled: true,
	title:{
		text: "<?PHP echo $zip;?> covid19math.net"
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
		name: "<?PHP echo $county; ?> Infected @ <?PHP echo rate_of_infection($county);?>",
		dataPoints: [
			<?PHP echo make_county($county); ?>
		]
	},
	{
		type: "spline",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "<?PHP echo $county; ?> Fatal @ <?PHP echo rate_of_death($county);?>",
		dataPoints: [
			<?PHP echo make_dcounty($county); ?>
		]
	}]
}
			      
			      
			      );
chart.render();
	
var chart2 = new CanvasJS.Chart("chartContainer2", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light2", //"light1", "dark1", "dark2"
	title:{
		text: "<?PHP echo $zip;?> COVID-19 Outbreak covid19math.net"
	},
	data: [{
		type: "funnel",
		showInLegend: true,
		legendText: "{label}",
		indexLabel: "{label} - {y}",
		toolTipContent: "<b>{label}</b>: {y}</b>",
		indexLabelFontColor: "black",
		dataPoints: [
			{ y: <?PHP echo intval($maryland_history[$date][$AKA]);?>, label: "Infected" },
			{ y: <?PHP echo intval($maryland_history[$date][$dAKA]);?>, label: "Deaths" }
		]
	}]
});
chart2.render();
var chart3 = new CanvasJS.Chart("chartContainer3", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light2", //"light1", "dark1", "dark2"
	title:{
		text: "<?PHP echo $zip;?> Outbreak covid19math.net",
		horizontalAlign: "left"
	},
	data: [{
		type: "pie",
		//startAngle: 60,
		//innerRadius: 60,
		indexLabelFontSize: 11,
		indexLabel: "{label} - #percent%",
		toolTipContent: "<b>{label}:</b> {y} (#percent%)",
		dataPoints: [
			{ y: <?PHP echo total_count($county); ?>, label: "Population" },
			{ y: <?PHP echo intval($maryland_history[$date][$AKA]); ?>, label: "Infected" }
		]
	}]
});
chart3.render();	


var chartZIP = new CanvasJS.Chart("chartContainerZIP", {
	animationEnabled: true,
	exportEnabled: true,
	title:{
		fontSize: 18,
		text:"COVID-19 Outbreak by Zip Code covid19math.net"
	},
	axisX:{
		interval: 1
	},
	axisY2:{
		fontSize: 14,
		interlacedColor: "rgba(1,77,101,.2)",
		gridColor: "rgba(1,77,101,.1)",
		title: "<?PHP echo $zip;?> w/ Cases over 7"
	},
	data: [{
		type: "bar",
		name: "zip",
		axisYType: "secondary",
		color: "#014D65",
		indexLabelFontSize: 6,
		dataPoints: [
			<?PHP echo make_datapoints(); ?>
		]
	}]
});
chartZIP.render();
	
var chartZIP2 = new CanvasJS.Chart("chartContainerZIP2", {
	theme:"light2",
	animationEnabled: true,
	exportEnabled: true,
	title:{
		text: "<?PHP echo $zip;?> over TIME covid19math.net"
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
	data: [
		<?PHP echo makeZIPpoints(); ?>
	]
}
			      
			      
			      );
chartZIP2.render();	
	
var chart99 = new CanvasJS.Chart("chartContainer99", {
	animationEnabled: true,
	exportEnabled: true,
	title: {
		text: "<?PHP echo $zip;?> Curve Position covid19math.net"
	},
	data: [{
		type: "pie",
		startAngle: 240,
		yValueFormatString: "#####",
		indexLabel: "{label} {y}",
		dataPoints: [
			{y: <?PHP echo intval($total_up);?>, label: "UP"},
			{y: <?PHP echo intval($total_flat);?>, label: "FLAT"},
      {y: <?PHP echo intval($total_down);?>, label: "DOWN"}
		]
	}]
});
chart99.render();

var chart88 = new CanvasJS.Chart("chartContainer88", {
	animationEnabled: true,
	exportEnabled: true,
	title: {
		text: "<?PHP echo $zip;?> New Curve Position covid19math.net"
	},
	data: [{
		type: "pie",
		startAngle: 240,
		yValueFormatString: "#####",
		indexLabel: "{label} {y}",
		dataPoints: [
			{y: <?PHP echo intval($new_up);?>, label: "UP"},
			{y: <?PHP echo intval($new_flat);?>, label: "FLAT"},
      {y: <?PHP echo intval($new_down);?>, label: "DOWN"}
		]
	}]
});
chart88.render();
	
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
 	<div class="col-sm-6">
		<div id="chartContainer99" style="height: 400px; width: 100%;"></div>
	</div>
 	<div class="col-sm-6">
		<div id="chartContainer88" style="height: 400px; width: 100%;"></div>
	</div>
</div>

<div class="row"><div class="col-sm-12"><div id="chartContainerZIP2" style="height: 500px; width: 100%;"></div></div></div>

<div class="row"><div class="col-sm-12"><div id="chartContainerZIP" style="height: 500px; width: 100%;"></div></div></div>

<div class="row"><div class="col-sm-12"><div id="chartContainer" style="height: 370px; max-width: 1020px; margin: 0px auto;"></div></div></div>

<div class="row">
	<div class='col-sm-4'>
		<div id="chartContainer2" style="height: 400px; max-width: 400px; margin: 0px auto;"></div>	
	</div>
	<div class='col-sm-4'>
		<h3><?PHP echo $zip;?></h3>
		<?PHP echo $zip_debug;?>
	</div>
	<div class='col-sm-4'>
		<div id="chartContainer3" style="height: 400px; max-width: 400px; margin: 0px auto;"></div>	

	</div>
</div>
	
<?PHP include_once('footer.php'); ?>
	
