<?PHP
if(isset($_GET['novideo'])){
	$logo = 'off';
}
include_once('menu.php');
global $maryland_history;
$maryland_history = make_maryland_array();

global $attributes;
$attributes = make_maryland_array2();

echo '<div class="container">';


echo '
<div class="row">';
global $send_message;
$send_message = 'off';

// Last Version
$r = $core->query("SELECT html, checked_datetime FROM coronavirus order by id DESC limit 0,1");
$d = mysqli_fetch_array($r);
$old = $d['html'];
$json = json_encode($maryland_history);
$new = $core->real_escape_string($json);
$test1 = $old;
$test2 = $json;


// Compare Most Recent to Last Change
$r = $core->query("SELECT id, checked_datetime FROM coronavirus order by id DESC limit 0,1");
$d = mysqli_fetch_array($r);
//global $new_date;
//$new_date = $d['checked_datetime'];
$new_date = $maryland_history['date'];
global $new_id;
$new_id = $d['id'];

$y_time = strtotime($new_date) - 86400;
$yesterday = date('Y-m-d',$y_time);

$dropdown = "<form method='POST'><select name='checked_datetime' class='form-control' id='sel1'>";
$r = $core->query("SELECT checked_datetime FROM coronavirus order by id DESC");
while($d = mysqli_fetch_array($r)){
   $dropdown .= "<option>$d[checked_datetime]</option>"; 
}
$dropdown .= "</select><input value='Load Date' type='submit' class='btn btn-default'></form>";

if (isset($_POST['checked_datetime'])){
    $date = $_POST['checked_datetime'];
    $r = $core->query("SELECT id, html, checked_datetime FROM coronavirus where checked_datetime = '$date' ");
}else{
    // first frport from yesterday to last report of this day
    $r = $core->query("SELECT id, html, checked_datetime FROM coronavirus where checked_datetime like '$yesterday %' order by id ASC limit 1");  
}
$d = mysqli_fetch_array($r);
$old = $d['html'];
global $old_date;
$old_date = $d['checked_datetime'];

echo "<div class='col-sm-4'>";

function total_count($county){
	global $core;
	$q = "SELECT number_of_people FROM coronavirus_populations where name_of_location = '$county' ";
	$r = $core->query($q);
	$d = mysqli_fetch_array($r);
	return $d['number_of_people'];
}

$graph_date = $date = $maryland_history['date'];
?>
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light2", //"light1", "dark1", "dark2"
	title:{
		text: "Maryland COVID-19 Outbreak covid19math.net"
	},
	data: [{
		type: "funnel",
		showInLegend: true,
		legendText: "{label}",
		indexLabel: "{label} - {y}",
		toolTipContent: "<b>{label}</b>: {y}</b>",
		indexLabelFontColor: "black",
		dataPoints: [
			{ y: <?PHP echo $maryland_history[$date]['TotalCases'];?>, label: "Infected" },
			{ y: <?PHP echo $maryland_history[$date]['total_hospitalized'];?>, label: "Hospital" },
			{ y: <?PHP echo $maryland_history[$date]['total_released'];?>,  label: "Recovered" },
			{ y: <?PHP echo $maryland_history[$date]['deaths'];?>, label: "Deaths" }
		]
	}]
});
chart.render();
	
var chart2 = new CanvasJS.Chart("chartContainer2", {
	animationEnabled: true,
	exportEnabled: true,
	title: {
		text: "Maryland Male/Female covid19math.net"
	},
	data: [{
		type: "pie",
		startAngle: 240,
		yValueFormatString: "#####",
		indexLabel: "{label} {y}",
		dataPoints: [
			{y: <?PHP echo $maryland_history[$date]['Male'];?>, label: "Male"},
			{y: <?PHP echo $maryland_history[$date]['Female'];?>, label: "Female"}
		]
	}]
});
chart2.render();
	
var chartCnD = new CanvasJS.Chart("chartContainerCnD", {
	animationEnabled: true,
	theme: "light2",
	exportEnabled: true,
	title: {
		text: "Data by Race covid19math.net"
	},
	toolTip: {
		shared: true
	},
	legend: {
		cursor: "pointer",
		itemclick: toggleDataSeries
	},
	data: [
	{
		type: "column",
		name: "Infections",
		showInLegend: true,
		indexLabelFontSize: 10,
		dataPoints: [
			{ label: 'Asian', y: <?PHP echo $attributes['raceAsian']['CaseCount']; ?> },
			{ label: 'Other', y: <?PHP echo $attributes['raceOther']['CaseCount']; ?> },
			{ label: 'Data not available', y: <?PHP echo $attributes['raceNotAvail']['CaseCount']; ?> },
			{ label: 'White', y: <?PHP echo $attributes['raceWhite']['CaseCount']; ?> },
			{ label: 'African-American', y: <?PHP echo $attributes['raceAfrAmer']['CaseCount']; ?> }	
		]
	},
	{
		type: "area",
		name: "Deaths",
		markerBorderColor: "white",
		markerBorderThickness: 2,
		showInLegend: true,
		indexLabelFontSize: 10,
		axisYType: "secondary",
		dataPoints: [
			{ label: 'Asian', y: <?PHP echo $attributes['raceAsian']['DeathCount']; ?> },
			{ label: 'Other', y: <?PHP echo $attributes['raceOther']['DeathCount']; ?> },
			{ label: 'Data not available', y: <?PHP echo $attributes['raceNotAvail']['DeathCount']; ?> },
			{ label: 'White', y: <?PHP echo $attributes['raceWhite']['DeathCount']; ?>},
			{ label: 'African-American', y: <?PHP echo $attributes['raceAfrAmer']['DeathCount']; ?> }	
		]
	}]
});
chartCnD.render();


function toggleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else {
		e.dataSeries.visible = true;
	}
	e.chart.render();
}
	

}
</script>

<div id="chartContainer" style="height: 740px; width: 100%;"></div>

</div><div class='col-sm-4'>
	
<div id="chartContainerCnD" style="height: 370px; width: 100%;"></div>
<div id="chartContainer2" style="height: 370px; width: 100%;"></div>
	
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<?PHP
/*
echo "<h3>Compare Dates</h3>
<p>$old_date to $new_date</p>";
echo "$dropdown";






echo "<h3>SMS Userlist</h3>";
$rSMS = $core->query("SELECT id FROM coronavirus_sms order by id desc limit 1");
$dSMS = mysqli_fetch_array($rSMS);
echo "<p>Registered Phones:  $dSMS[id]</p>";
*/
echo "</div>";


// Convert json objects to array
$array1 = json_decode($old, true);
$array2 = json_decode($json, true);

function attribute_aka($county){
	global $attributes;
	if ($county == 'caseAfrAmer'){ return $attributes['raceAfrAmer']['CaseCount']; }
	if ($county == 'deathAfrAmer'){ return $attributes['raceAfrAmer']['DeathCount']; }
}
	
function do_math_location($county){
	
	global $maryland_history;
	global $new_id;
	global $new_date;
	global $old_date;
	global $core;
	$today = date('Y-m-d',strtotime($new_date));
	$aka = county_aka($county);
	$count_today = $maryland_history[$today][$aka];
	if ($count_today == 0){
		// failure detected
		// check attributes
		$count_today = attribute_aka($county);
	}
	$yesterday = date('Y-m-d',strtotime($old_date));
	$count_yesterday = $maryland_history[$yesterday][$aka];
	$core->query("update coronavirus set $countyCOVID19Cases = '$count_today' where id = '$new_id' ");
	$count_delta = $count_today - $count_yesterday;
	$dir = 'up';
	if ( $count_today < $count_yesterday){
		$dir = 'down';
	}
	$human_count = number_format($count_today);
	$human_delta = number_format($count_delta);
	if ($count_delta != 0) { sms("$dir $human_delta <b>$county</b> at $human_count. ");  } 
}

ob_start();

// V3
echo '<h3>Covid19math.net Update</h3>';
echo do_math_location('Maryland');
echo do_math_location('deaths');
echo do_math_location('total_hospitalized');
echo do_math_location('total_released');

echo do_math_location('NegativeTests');


echo do_math_location('Allegany');
echo do_math_location('AnneArundel');
echo do_math_location('Baltimore');
echo do_math_location('BaltimoreCity');
echo do_math_location('Calvert');
echo do_math_location('Caroline');
echo do_math_location('Carroll');
echo do_math_location('Cecil');
echo do_math_location('Charles');
echo do_math_location('Dorchester');
echo do_math_location('Frederick');
echo do_math_location('Garrett');
echo do_math_location('Harford');
echo do_math_location('Howard');
echo do_math_location('Kent');
echo do_math_location('Montgomery');
echo do_math_location('PrinceGeorges');
echo do_math_location('QueenAnnes');
echo do_math_location('Somerset');
echo do_math_location('StMarys');
echo do_math_location('Talbot');
echo do_math_location('Washington');
echo do_math_location('Worcester');

echo do_math_location('case0to9');
echo do_math_location('case10to19');
echo do_math_location('case20to29');
echo do_math_location('case30to39');
echo do_math_location('case40to49');
echo do_math_location('case50to59');
echo do_math_location('case60to69');
echo do_math_location('case70to79');
echo do_math_location('case80plus');

echo do_math_location('Male');
echo do_math_location('Female');
	
echo do_math_location('CaseDelta');
echo do_math_location('NegDelta');
echo do_math_location('hospitalizedDelta');
echo do_math_location('releasedDelta');
echo do_math_location('deathsDelta');	

	
	echo do_math_location('caseAfrAmer');	
	echo do_math_location('caseWhite');
	echo do_math_location('caseAsian');
	echo do_math_location('caseOther');
	echo do_math_location('caseNotAVail');
	
	echo do_math_location('deathAfrAmer');	
	echo do_math_location('deathWhite');
	echo do_math_location('deathAsian');
	echo do_math_location('deathOther');
	echo do_math_location('deathNotAvail');
	
	
	
	
	
	
	
$new_master_message = ob_get_clean();

echo "<div class='col-sm-4' style='text-align:left;'>";
echo "$new_master_message";
echo "<p>Update String Legenth: ".strlen($new_master_message)." ($send_message)</p>";
echo "</div>";
if ($send_message == 'on' || isset($_GET['forcesms'])){
	global $core;
	$r = $core->query("SELECT sms_number FROM coronavirus_sms where sms_status = 'confirmed' ");
	while($d = mysqli_fetch_array($r)){
		$sms = trim($d['sms_number']);
		message_send($sms,$new_master_message);
	}
}  
echo "</div></div>";
include_once('footer.php');
