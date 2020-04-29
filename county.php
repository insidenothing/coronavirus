<?PHP
global $output_buffer;
$output_buffer = '';

global $global_graph_height;
$global_graph_height = 0;


global $graph_total;
$graph_total = array();

global $debug5;
$debug5 = 'go...';

//global $county_zip_codes;
//$county_zip_codes = array();
//$county_zip_codes['Maryland']['Allegany'] 		= explode(',',"00000,21501,21502,21502,21502,21503,21504,21504,21505,21505,21521,21524,21528,21529,21530,21532,21539,21540,21540,21542,21543,21545,21555,21556,21557,21560,21562,21562,21766");
include_once('county_zip_codes.php');

global $show;
$show = '';
if(isset($_GET['show'])){
	$show = $_GET['show'];
}
global $days_to_predict;
$days_to_predict = '45';

if(isset($_POST['days'])){
	$days_to_predict = $_POST['days'];	
}
if(isset($_GET['day'])){
	$days_to_predict = $_GET['day'];	
}
global $county;
if(isset($_GET['county'])){	
	$county = $_GET['county'];	
}else{
  	$county = 'Baltimore';	
}
global $state;
if(isset($_GET['state'])){
	$state = $_GET['state'];	
}else{
  	$state = 'Maryland';
}
$logo = 'off';
include_once('/var/www/secure.php'); //outside webserver
include_once('functions.php');


if ($state == 'Maryland'){
	global $maryland_history;
	$maryland_history = make_maryland_array();
	global $zipData;
	$url = 'https://services.arcgis.com/njFNhDsUCentVYJW/arcgis/rest/services/TEST_ZIPCodeCases/FeatureServer/0/query?where=1%3D1&outFields=OBJECTID,ZIPCODE1,ZIPName,ProtectedCount&returnGeometry=false&outSR=4326&f=json';
	$zipData = make_maryland_array3($url,'');
	asort($zipData); // Sort Array (Ascending Order), According to Value - asort()
}
if ($state == 'Florida'){
	
}
	
global $zip_debug;
function make_datapoints(){
	global $zipData;
	global $zip2name;
	global $county;
	global $county_zip_codes;
	global $global_graph_height;
	global $zip_debug;
	global $showzip;
	global $state;
	$match_array = $county_zip_codes[$state][$county];
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
			$zip_debug .= '<span style="background-color:red;"><a href="zipcode.php?zip='.$zip.'">'.$zip.'</a></span> ';
			$showzip[] = $zip;
		}elseif( $key > 0  ){
			$zip_debug .= '<span style="background-color:green;"><a href="zipcode.php?zip='.$zip.'">'.$zip.'</a></span> ';
		}
	}
	$return = rtrim(trim($return), ",");
	return $return;
}


$date = $maryland_history['date'];

$page_description = "$date $county, $state - ZIP Codes";

include_once('menu.php');

global $today;
global $normal;
global $peak;
global $peak_str;
$today = array();
$normal = array();
$peak = array();
$peak_str = array();



$links;
$q = "SELECT distinct name_of_location FROM coronavirus_populations ";
$r = $core->query($q);
while($d = mysqli_fetch_array($r)){	
	$today[$d[name_of_location]] = 0; 	// count
	$peak[$d[name_of_location]] = 0; 	// count
	$dpeak[$d[name_of_location]] = 0; 	// count
	$normal[$d[name_of_location]] = ''; 	// string
	$dnormal[$d[name_of_location]] = ''; 	// string
	$peak_str[$d[name_of_location]] = '<p>'.$d['name_of_location'].' peaked at 0<p>'; // string
	$dpeak_str[$d[name_of_location]] = '<p>'.$d['name_of_location'].' peaked at 0<p>'; // string
	$links .= "<a href='?county=$d[name_of_location]'>$d[name_of_location]</a>, ";
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
	global $graph_total;
	global $debug5;
	$debug5 .= 'make_zip('.$zip.')';
        $return = '';
	$count=0;
	$q = "select * from coronavirus_zip where zip_code = '$zip' order by report_date ";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		$count 	= $d['report_count'];
		$date 	= $d['report_date'];
		$return .= '{ label: "'.$date.'", y: '.intval($count).' }, ';
		if (isset($graph_total[$date])){
			$debug5 .= "$date + $count, ";
			$graph_total[$date] = $graph_total[$date] + $count;
		}else{
			$debug5 .= "$date = $count, ";
			$graph_total[$date] = $count;
		}
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

	

// pull date from last update, not assume today.
$q = "select just_date from coronavirus order by id desc limit 1";
$r = $core->query($q);
$d = mysqli_fetch_array($r);
$date = $d['just_date'];
?>


<?PHP 
ob_start();
$total_up=0;
$total_flat=0;
$total_down=0;
$new_up=0;
$new_flat=0;
$new_down=0;
?>
<!--<div class="row">
  <div class="col-sm-12">-->
	  <?PHP
	$zip_like=' and ( ';
    foreach ($county_zip_codes[$state][$county] as $zip => $data){
      $zip_like .= " zip_code = '$data' or ";
    }
    $zip_like .= " zip_code = '99999' )";  
	//echo  "<p>$zip_like</p>"; ?>
 <!-- </div>
</div>-->


<div class="row">
  <div class="col-sm-6">
  <h3>14+ Day Trends above 0</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_duration > '13' and report_count <> 0 $zip_like order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        $color='orange';
	    if ($d['trend_direction'] == 'FLAT'){
		$color = 'lightgreen';
		}
	    echo "<li style='background-color:$color;'><a href='zipcode.php?zip=$d[zip_code]'>For $d[trend_duration] days, $d[town_name] ( $d[zip_code] ) has been going $d[trend_direction] and is now $d[report_count]</a></li>"; 
    }
    ?>
    </ol>
  </div>
  <div class="col-sm-6">
  <h3>14+ Day Trends at 0</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_duration > '13' and report_count = 0 $zip_like order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        $color='orange';
	    if ($d['trend_direction'] == 'FLAT'){
		$color = 'lightgreen';
		}
	    echo "<li style='background-color:$color;'><a href='zipcode.php?zip=$d[zip_code]'>For $d[trend_duration] days, $d[town_name] ( $d[zip_code] ) has been going $d[trend_direction] and is now $d[report_count]</a></li>"; 
    }
    ?>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-sm-4">
    <h3>Up Trend</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'UP' and trend_duration <> '0' $zip_like order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        echo "<li><a href='zipcode.php?zip=$d[zip_code]'>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count] for $d[trend_duration] days</a></li>"; 
        $total_up++;
    }
    ?>
    </ol>
  </div>
  <div class="col-sm-4">
    <h3>Flat Trend</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'FLAT' and report_count <> '0' and trend_duration <> 0 $zip_like order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        echo "<li><a href='zipcode.php?zip=$d[zip_code]'>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count] for $d[trend_duration] days</a></li>"; 
      $total_flat++;
    }
    ?>
    </ol>
  </div>
  <div class="col-sm-4">
  <h3>Down Trend</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'DOWN' and trend_duration <> '0' $zip_like order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        echo "<li><a href='zipcode.php?zip=$d[zip_code]'>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count] for $d[trend_duration] days</a></li>";
      $total_down++;
    }
    ?>
    </ol>
  </div>
</div>


<div class="row">
  <div class="col-sm-4">
    <h3>New Direction Up</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'UP' and trend_duration = '0' $zip_like order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        echo "<li><a href='zipcode.php?zip=$d[zip_code]'>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count]</a></li>"; 
        $new_up++;
    }
    ?>
    </ol>
  </div>
  <div class="col-sm-4">
    <h3>New Direction Flat</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'FLAT' and report_count <> 0 and trend_duration = '0' $zip_like order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        echo "<li><a href='zipcode.php?zip=$d[zip_code]'>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count]</a></li>";
       $new_flat++;
    }
    ?>
    </ol>
  </div>
  <div class="col-sm-4">
  <h3>New Direction Down</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'DOWN' and trend_duration = '0' $zip_like order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        echo "<li><a href='zipcode.php?zip=$d[zip_code]'>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count]</a></li>";
       $new_down++;
    }
    ?>
    </ol>
  </div>
</div>

<?PHP 
$buffer = ob_get_clean();
?>




  	


<div class="row">
 	<div class="col-sm-6">
		<div id="chartContainer99" style="height: 400px; width: 100%;"></div>
	</div>
 	<div class="col-sm-6">
		<div id="chartContainer88" style="height: 400px; width: 100%;"></div>
	</div>
</div>


<?PHP 
echo $buffer;
?>	


<script src="canvasjs.min.js"></script>
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	theme:"light2",
	animationEnabled: true,
	exportEnabled: true,
	title:{
		text: "<?PHP echo $county;?> covid19math.net"
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
		name: "<?PHP echo $county; ?> Infected",
		dataPoints: [
			<?PHP
			global $graph_total;
			//asort($graph_total);
			foreach ($graph_total as $date => $count){
				$return .= '{ label: "'.$date.'", y: '.intval($count).' }, ';
			}
			$return = rtrim(trim($return), ",");
			echo $return
			?>
		]
	},
	{
		type: "spline",
		visible: false,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "<?PHP echo $county; ?> Fatal",
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
		text: "<?PHP echo $county;?> COVID-19 Outbreak covid19math.net"
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
		text: "<?PHP echo $county;?> Outbreak covid19math.net",
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
			{ y: <?PHP echo intval(total_count($county)); ?>, label: "Population" },
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
		title: "<?PHP echo $county;?> ZIP CODES w/ Cases over 7"
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
		text: "<?PHP echo $county;?> - ZIPs over TIME covid19math.net"
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
		text: "<?PHP echo $county;?> Zipcode Curve Position covid19math.net"
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
		text: "<?PHP echo $county;?> Zipcode New Curve Position covid19math.net"
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

<?PHP
ob_start();	       
?>

<div class="row"><div class="col-sm-12"><div id="chartContainerZIP2" style="height: 500px; width: 100%;"></div></div></div>

<div class="row"><div class="col-sm-12"><div id="chartContainerZIP" style="height: 500px; width: 100%;"></div></div></div>

<div class="row"><div class="col-sm-12"><div id="chartContainer" style="height: 370px; max-width: 1020px; margin: 0px auto;"></div></div></div>

<div class="row">
	<div class='col-sm-4'>
		<div id="chartContainer2" style="height: 400px; max-width: 400px; margin: 0px auto;"></div>	
	</div>
	<div class='col-sm-4'>
		<h3><?PHP echo $county;?>, <?PHP echo $state;?> ZIP Codes</h3>
		<?PHP echo $zip_debug;?>
		<hr>
		<?PHP print_r($graph_total); $debug5 .= 'done'; echo $debug5; ?>
	</div>
	<div class='col-sm-4'>
		<div id="chartContainer3" style="height: 400px; max-width: 400px; margin: 0px auto;"></div>	

	</div>
</div>
<?PHP $output_buffer .= ob_get_clean();	?>



<?PHP echo $output_buffer;?>
	
<?PHP include_once('footer.php'); ?>
	
