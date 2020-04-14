<?PHP
global $global_graph_height;
$global_graph_height = 0;
global $county_zip_codes;
$county_zip_codes = array();
$county_zip_codes['Allegany'] 		= explode(',',"21502,21505,21521,21528,21524,21530,21529,21532,21766,21540,21539,21542,21545,21543,21555,21557,21556,21560,21562");
$county_zip_codes['AnneArundel']	= explode(',',"20701,20711,20714,20724,20733,21012,20751,20754,20755,21032,20758,21035,21037,20765,20764,21401,21403,21402,21405,20776,20779,21056,20778,21409,21054,21060,21062,21061,21077,21076,20794,21090,21108,21106,21113,21114,21122,21123,21144,21140,21146");
$county_zip_codes['Baltimore'] 		= explode(',',"21207,21206,21209,21208,21210,21212,21219,21221,21220,21222,21224,21227,21229,21228,21234,21236,21235,21239,21237,21241,21250,21013,21244,21252,21022,21020,21027,21023,21031,21030,21282,21286,21051,21053,21052,21057,21071,21074,21082,21087,21092,21093,21102,21105,21104,21111,21117,21120,21128,21131,21133,21139,21136,21153,21152,21155,21156,21162,21161,21163,21204");
$county_zip_codes['BaltimoreCity']	= explode(',',"21211,21213,21215,21214,21217,21216,21218,21223,21225,21226,21231,21230,21251,21263,21287,21201,21202,21205");
$county_zip_codes['Calvert']		= explode(',',"20657,20676,20678,20629,20685,20688,20732,20689,20639,20736");
$county_zip_codes['Caroline']		= explode(',',"21609,21655,21660,21629,21632,21636,21639,21641");
$county_zip_codes['Carroll']		= explode(',',"21157,21158,21048");
$county_zip_codes['Cecil']		= explode(',',"21915,21914,21917,21916,21919,21918,21921,21920,21930,21922,21901,21903,21911,21904,21913,21912");
$county_zip_codes['Charles']		= explode(',',"");
$county_zip_codes['Dorchester']		= explode(',',"");
$county_zip_codes['Frederick']		= explode(',',"");
$county_zip_codes['Garrett']		= explode(',',"");
$county_zip_codes['Harford']  		= explode(',',"21078,21085,21084,21005,21001,21009,21015,21014,21018,21130,21017,21132,21028,21034,21154,21040,21160,21047,21050");	
$county_zip_codes['Howard']		= explode(',',"");
$county_zip_codes['Kent']		= explode(',',"");
$county_zip_codes['Montgomery']		= explode(',',"");
$county_zip_codes['PrinceGeorges']	= explode(',',"");
$county_zip_codes['QueenAnnes']		= explode(',',"");
$county_zip_codes['Somerset']		= explode(',',"");
$county_zip_codes['StMarys']		= explode(',',"");
$county_zip_codes['Talbot']		= explode(',',"");
$county_zip_codes['Washington']		= explode(',',"");
$county_zip_codes['Wicomico']		= explode(',',"");
$county_zip_codes['Worcester']		= explode(',',"");

global $show;
$show = '';
if(isset($_GET['show'])){
	$show = $_GET['show'];
}
global $days_to_predict;
$days_to_predict = '45';
if(isset($_GET['days'])){
	// stop bot from running animation
	$ua = $_SERVER['HTTP_USER_AGENT'];
	if (preg_match('/facebookexternalhit/si',$ua)) { 
		header('Location: county.php?show='.$show); 
		die(); 
	} 
	// animaton
	$days_to_predict = $_GET['days'];
	$next_days = $days_to_predict + 7; 
	if($next_days < 90){
		// limit to 200 days
		if($show != ''){
			echo "<meta http-equiv='refresh' content='5; url=https://www.mdwestserve.com/coronavirus/county.php?days=$next_days&show=$show'>";
		}else{
			echo "<meta http-equiv='refresh' content='5; url=https://www.mdwestserve.com/coronavirus/county.php?days=$next_days'>";	
		}
	}
}
if(isset($_POST['days'])){
	$days_to_predict = $_POST['days'];	
}
if(isset($_GET['day'])){
	$days_to_predict = $_GET['day'];	
}
if(isset($_GET['county'])){
  global $county;
	$county = $_GET['county'];	
}else{
  $county = 'Maryland';	
}
$logo = 'off';
include_once('/var/www/secure.php'); //outside webserver
include_once('functions.php');

global $maryland_history;
$maryland_history = make_maryland_array();


global $zipData;
$url = 'https://services.arcgis.com/njFNhDsUCentVYJW/arcgis/rest/services/TEST_ZIPCodeCases/FeatureServer/0/query?where=1%3D1&outFields=OBJECTID,ZIPCODE1,ZIPName,ProtectedCount&returnGeometry=false&outSR=4326&f=json';
$zipData = make_maryland_array3($url,'');
asort($zipData); // Sort Array (Ascending Order), According to Value - asort()
function make_datapoints(){
	global $zipData;
	global $zip2name;
	global $county;
	global $county_zip_codes;
	global $global_graph_height;
	$match_array = $county_zip_codes[$county];
	$return = '';
	$total=0;
	foreach ($zipData as $zip => $data){
		$count = intval($data['ProtectedCount']);
		$key = array_search($zip, $match_array);
		if ( $key > 0 ) {
			//$name = $zip2name[$zip];
			//$return .= "{ y: $count, label: '$name $zip' },";
			//$global_graph_height = $global_graph_height + 25; // px per line in graph
			$total++;
		}
	}
	foreach ($zipData as $zip => $data){
		$count = intval($data['ProtectedCount']);
		$key = array_search($zip, $match_array);
		if ( $key > 0 ) {
			$name = $zip2name[$zip];
			$return .= "{ y: $count, label: '$total $name $zip' },";
			$global_graph_height = $global_graph_height + 25; // px per line in graph
			$total = $total - 1;
		}
	}
	$return = rtrim(trim($return), ",");
	return $return;
}


$date = $maryland_history['date'];

$page_description = "$date $county - $days_to_predict Day Prediction";

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
        $next = date('Y-m-d',strtotime($date)+86400);
        $return .= make_county_prediction($county,$next,$count,$dt);
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
        $next = date('Y-m-d',strtotime($date)+86400);
        $return .= make_dcounty_prediction($county,$next,$count,$dt);
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

?>
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	theme:"light2",
	animationEnabled: true,
	exportEnabled: true,
	title:{
		text: "<?PHP echo $county;?> - <?PHP echo $days_to_predict;?> Day Prediction covid19math.net"
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
		name: "<?PHP echo $county; ?> Dead @ <?PHP echo rate_of_death($county);?>",
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
			{ y: <?PHP echo $maryland_history[$date][$AKA];?>, label: "Infected" },
			{ y: <?PHP echo $maryland_history[$date][$dAKA];?>, label: "Deaths" }
		]
	}]
});
chart2.render();
var chart3 = new CanvasJS.Chart("chartContainer3", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light2", //"light1", "dark1", "dark2"
	title:{
		text: "<?PHP echo $county;?> Peak Outbreak covid19math.net",
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
			{ y: <?PHP echo intval($peak[$county]); ?>, label: "Infected" }
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

<script src="canvasjs.min.js"></script>
<div class="container">
	<div class="row"><div class="col-sm-12"><div id="chartContainerZIP" style="height: <?PHP echo $global_graph_height;?>px; width: 100%;"></div></div></div>
	<div class="row"><div class="col-sm-12"><div id="chartContainer" style="height: 370px; max-width: 1020px; margin: 0px auto;"></div></div></div>
	<div class="row">
		<div class='col-sm-4'>
			<div id="chartContainer2" style="height: 400px; max-width: 400px; margin: 0px auto;"></div>	
		</div>
		<div class='col-sm-4'>
			<h3><?PHP echo $county;?> Data</h3>
			<?PHP echo $peak_str[$county];?>
			<?PHP echo $dpeak_str[$county];?>
			<?PHP echo $normal[$county];?>
			<?PHP echo $dnormal[$county];?>
			<h3>ZIP Codes</h3>
			<ol>
			<?PHP  foreach ($county_zip_codes[$county] as $zip => $data){
			echo "<li>$zip => $data</li>";
			}?>
			</ol>
			<h3>Other Counties</h3>
			<?PHP echo $links; ?>
		</div>
		<div class='col-sm-4'>
			<div id="chartContainer3" style="height: 400px; max-width: 400px; margin: 0px auto;"></div>	
			
		</div>
	</div>
</div>
	
<?PHP include_once('footer.php'); ?>
