<?PHP
global $global_graph_height;
$global_graph_height = 0;
global $county_zip_codes;
$county_zip_codes = array();
$county_zip_codes['Allegany'] 		= explode(',',"21501,21502,21502,21502,21503,21504,21504,21505,21505,21521,21524,21528,21529,21530,21532,21539,21540,21540,21542,21543,21545,21555,21556,21557,21560,21562,21562,21766");
$county_zip_codes['AnneArundel']	= explode(',',"20711,20724,20724,20724,20724,20733,20751,20755,20755,20764,20765,20776,20778,20779,21012,21032,21035,21037,21037,21054,21056,21060,21061,21076,21077,21090,21106,21108,21113,21114,21122,21122,21122,21123,21123,21123,21140,21144,21146,21226,21226,21226,21240,21240,21401,21401,21402,21402,21403,21403,21403,21404,21405,21405");
$county_zip_codes['Baltimore'] 		= explode(',',"21013,21020,21022,21023,21027,21030,21030,21030,21031,21031,21051,21052,21053,21055,21057,21071,21082,21087,21087,21092,21093,21093,21094,21094,21105,21111,21111,21117,21120,21120,21128,21131,21131,21133,21133,21136,21139,21152,21152,21153,21155,21155,21156,21162,21204,21204,21204,21204,21207,21207,21207,21208,21208,21219,21219,21220,21220,21221,21221,21222,21222,21227,21227,21227,21227,21228,21228,21234,21234,21234,21236,21236,21237,21237,21244,21244,21282,21282,21284,21284,21284,21285,21285,21286,21286,21286");
$county_zip_codes['BaltimoreCity']	= explode(',',"21201,21201,21202,21202,21203,21205,21206,21206,21209,21209,21210,21210,21211,21212,21212,21213,21213,21214,21215,21215,21216,21217,21217,21218,21223,21223,21224,21224,21225,21225,21225,21229,21229,21230,21230,21230,21231,21233,21239,21239,21270,21279,21281,21297");
$county_zip_codes['Calvert']		= explode(',',"20610,20615,20629,20639,20657,20676,20678,20678,20685,20688,20689,20714,20732,20736,20754");
$county_zip_codes['Caroline']		= explode(',',"21609,21629,21632,21636,21639,21640,21641,21649,21655,21660,21670");
$county_zip_codes['Carroll']		= explode(',',"21048,21048,21074,21074,21080,21088,21088,21102,21102,21102,21104,21104,21157,21157,21158,21757,21757,21757,21764,21776,21784,21784,21784,21784,21787,21791");
$county_zip_codes['Cecil']		= explode(',',"21901,21902,21903,21904,21904,21911,21912,21913,21914,21915,21916,21917,21918,21919,21920,21921,21922,21930");
$county_zip_codes['Charles']		= explode(',',"20601,20602,20602,20603,20603,20604,20604,20611,20612,20616,20617,20625,20632,20637,20640,20640,20643,20645,20645,20646,20646,20658,20658,20661,20662,20664,20675,20677,20682,20693,20695");
$county_zip_codes['Dorchester']		= explode(',',"21613,21622,21626,21627,21631,21634,21643,21648,21659,21664,21669,21672,21675,21677,21835,21869");
$county_zip_codes['Frederick']		= explode(',',"21701,21701,21702,21702,21703,21704,21704,21705,21710,21710,21714,21716,21717,21718,21727,21754,21755,21758,21759,21762,21769,21770,21771,21773,21774,21775,21777,21778,21780,21788,21788,21790,21792,21793,21798");
$county_zip_codes['Garrett']		= explode(',',"21520,21522,21523,21531,21536,21536,21538,21538,21541,21541,21550,21550,21550,21550,21550,21561");
$county_zip_codes['Harford']  		= explode(',',"21001,21005,21009,21010,21010,21014,21015,21017,21018,21028,21034,21040,21047,21050,21078,21084,21085,21130,21132,21154,21160,21160,21161");	
$county_zip_codes['Howard']		= explode(',',"20701,20723,20723,20759,20763,20777,20794,21029,21036,21041,21042,21043,21043,21043,21043,21044,21045,21046,21075,21150,21163,21163,21723,21737,21738,21765,21794,21797");
$county_zip_codes['Kent']		= explode(',',"21610,21620,21635,21635,21645,21650,21651,21661,21667,21678,21678");
$county_zip_codes['Montgomery']		= explode(',',"20812,20813,20814,20815,20815,20816,20817,20817,20818,20824,20825,20825,20827,20827,20830,20832,20833,20837,20838,20839,20841,20842,20847,20848,20849,20850,20851,20852,20852,20853,20854,20854,20855,20855,20859,20859,20860,20861,20862,20866,20868,20871,20872,20874,20874,20875,20876,20877,20877,20878,20878,20878,20879,20879,20879,20880,20882,20882,20883,20884,20885,20886,20886,20891,20895,20896,20898,20901,20902,20902,20903,20904,20904,20905,20905,20906,20906,20907,20908,20910,20911,20912,20912,20913,20913,20914,20914,20915,20915,20916,20916,20918");
$county_zip_codes['PrinceGeorges']	= explode(',',"20607,20608,20613,20623,20703,20703,20704,20705,20706,20706,20706,20707,20708,20708,20709,20709,20710,20712,20715,20716,20716,20717,20717,20718,20719,20720,20721,20721,20722,20722,20722,20725,20726,20731,20735,20737,20738,20740,20740,20741,20743,20743,20743,20744,20745,20745,20746,20746,20746,20747,20747,20748,20748,20748,20748,20749,20750,20752,20753,20757,20762,20762,20768,20769,20770,20772,20773,20774,20774,20774,20774,20774,20774,20775,20781,20782,20782,20782,20782,20782,20783,20783,20784,20784,20784,20784,20785,20785,20785,20785,20787,20787,20788,20791,20792");
$county_zip_codes['QueenAnnes']		= explode(',',"21607,21617,21619,21623,21628,21638,21644,21656,21656,21657,21658,21666,21668");
$county_zip_codes['Somerset']		= explode(',',"21817,21821,21821,21821,21821,21824,21836,21838,21853,21857,21866,21867,21870,21871");
$county_zip_codes['StMarys']		= explode(',',"20606,20609,20618,20619,20620,20621,20621,20622,20624,20626,20627,20628,20630,20634,20635,20636,20650,20653,20656,20659,20660,20667,20670,20674,20680,20684,20686,20686,20687,20690,20692");
$county_zip_codes['Talbot']		= explode(',',"21601,21612,21624,21625,21647,21652,21653,21654,21662,21663,21665,21671,21673,21676,21679");
$county_zip_codes['Washington']		= explode(',',"21711,21713,21715,21719,21719,21720,21721,21722,21722,21733,21734,21736,21740,21741,21742,21747,21748,21750,21756,21767,21779,21781,21782,21783,21795");
$county_zip_codes['Wicomico']		= explode(',',"21801,21802,21803,21804,21810,21814,21826,21830,21837,21840,21849,21850,21852,21856,21861,21865,21874,21875");
$county_zip_codes['Worcester']		= explode(',',"21811,21811,21813,21822,21829,21841,21842,21843,21851,21862,21863,21864,21872");

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
global $zip_debug;
function make_datapoints(){
	global $zipData;
	global $zip2name;
	global $county;
	global $county_zip_codes;
	global $global_graph_height;
	global $zip_debug;
	$match_array = $county_zip_codes[$county];
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
		}elseif( $key > 0  ){
			$zip_debug .= '<span style="background-color:green;">'.$zip.' </span> ';
		}
	}
	$return = rtrim(trim($return), ",");
	return $return;
}


$date = $maryland_history['date'];

$page_description = "$date $county - ZIP Codes + $days_to_predict Day Prediction";

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
			<h3>ZIP Codes used by Maryland Dept. Health</h3>
			<?PHP echo $zip_debug;?>
			
		</div>
		<div class='col-sm-4'>
			<div id="chartContainer3" style="height: 400px; max-width: 400px; margin: 0px auto;"></div>	
			
		</div>
	</div>
</div>
	
<?PHP include_once('footer.php'); ?>
http://www.ciclt.net/sn/clt/capitolimpact/gw_countymap.aspx?State=md&StFIPS=&StName=Maryland	
