<?PHP
if(isset($_GET['novideo'])){
	$logo = 'off';
}
include_once('menu.php');
global $maryland_history;
$maryland_history = make_maryland_array();

global $attributes;
$attributes = make_maryland_array2();

global $zipData;
$url = 'https://services.arcgis.com/njFNhDsUCentVYJW/arcgis/rest/services/TEST_ZIPCodeCases/FeatureServer/0/query?where=1%3D1&outFields=OBJECTID,ZIPCODE1,ZIPName,ProtectedCount&returnGeometry=false&outSR=4326&f=json';
$zipData = make_maryland_array3($url,'');
asort($zipData); // Sort Array (Ascending Order), According to Value - asort()




echo '
<div class="row">';
global $send_message;
$send_message = 'off';

// Last Version
$r = $covid_db->query("SELECT html, checked_datetime FROM coronavirus order by id DESC limit 0,1");
$d = mysqli_fetch_array($r);
$old = $d['html'];
$json = json_encode($maryland_history);
$new = $covid_db->real_escape_string($json);
$test1 = $old;
$test2 = $json;


// Compare Most Recent to Last Change
$r = $covid_db->query("SELECT id, checked_datetime FROM coronavirus order by id DESC limit 0,1");
$d = mysqli_fetch_array($r);
//global $new_date;
//$new_date = $d['checked_datetime'];
$new_date = $maryland_history['date'];
global $new_id;
$new_id = $d['id'];

$y_time = strtotime($new_date) - 86400;
$yesterday = date('Y-m-d',$y_time);

$dropdown = "<form method='POST'><select name='checked_datetime' class='form-control' id='sel1'>";
$r = $covid_db->query("SELECT checked_datetime FROM coronavirus order by id DESC");
while($d = mysqli_fetch_array($r)){
   $dropdown .= "<option>$d[checked_datetime]</option>"; 
}
$dropdown .= "</select><input value='Load Date' type='submit' class='btn btn-default'></form>";

if (isset($_POST['checked_datetime'])){
    $date = $_POST['checked_datetime'];
    $r = $covid_db->query("SELECT id, html, checked_datetime FROM coronavirus where checked_datetime = '$date' ");
}else{
    // first frport from yesterday to last report of this day
    $r = $covid_db->query("SELECT id, html, checked_datetime FROM coronavirus where checked_datetime like '$yesterday %' order by id ASC limit 1");  
}
$d = mysqli_fetch_array($r);
$old = $d['html'];
global $old_date;
$old_date = $d['checked_datetime'];

echo "<div class='col-sm-4'>";

function total_count($county){
	global $covid_db;
	$q = "SELECT number_of_people FROM coronavirus_populations where name_of_location = '$county' ";
	$r = $covid_db->query($q);
	$d = mysqli_fetch_array($r);
	return $d['number_of_people'];
}

$graph_date = $date = $maryland_history['date'];

function make_datapoints(){
	global $zipData;
	global $zip2name;
	$return = '';
	foreach ($zipData as $zip => $data){
		$count = intval($data['ProtectedCount']);
		if ($count > 300){
			$name = $zip2name[$zip];
			$return .= "{ y: $count, label: '$name $zip' },";
		}
	}
	$return = rtrim(trim($return), ",");
	return $return;
}
function make_datapoints2(){
	global $zipData;
	global $zip2name;
	$return = '';
	foreach ($zipData as $zip => $data){
		$count = intval($data['ProtectedCount']);
		if ($count < 15 && $count > 0){
			$name = $zip2name[$zip];
			$return .= "{ y: $count, label: '$name $zip' },";
		}
	}
	$return = rtrim(trim($return), ",");
	return $return;
}
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
			{ y: <?PHP echo $maryland_history[$date]['deaths'];?>, label: "Deaths" },
			{ y: <?PHP echo $maryland_history[$date]['pDeaths'];?>, label: "Prob Deaths" }
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
			{y: <?PHP echo intval($maryland_history[$date]['genMale']);?>, label: "Male Cases"},
			{y: <?PHP echo intval($maryland_history[$date]['genFemale']);?>, label: "Female Cases"},
			{y: <?PHP echo intval($maryland_history[$date]['deathGenMale']);?>, label: "Male Deaths"},
			{y: <?PHP echo intval($maryland_history[$date]['deathGenFemale']);?>, label: "Female Deaths"},
			{y: <?PHP echo intval($maryland_history[$date]['pDeathGenMale']);?>, label: "Male Prob Deaths"},
			{y: <?PHP echo intval($maryland_history[$date]['pDeathGenFemale']);?>, label: "Female Prob Deaths"}
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
			{ label: 'Asian', y: <?PHP echo intval($maryland_history[$date]['caseAsian']); ?> },
			{ label: 'Other', y: <?PHP echo intval($maryland_history[$date]['caseOther']); ?> },
			{ label: 'Data not available', y: <?PHP echo intval($maryland_history[$date]['caseNotAVail']); ?> },
			{ label: 'Hispanic', y: <?PHP echo intval($maryland_history[$date]['caseHispanic']); ?> },
			{ label: 'White', y: <?PHP echo intval($maryland_history[$date]['caseWhite']); ?> },
			{ label: 'African-American', y: <?PHP echo intval($maryland_history[$date]['caseAfrAmer']); ?> }	
		]
	},
	{
		type: "area",
		name: "Deaths",
		markerBorderColor: "orange",
		markerBorderThickness: 2,
		showInLegend: true,
		indexLabelFontSize: 10,
		axisYType: "secondary",
		dataPoints: [
			{ label: 'Asian', y: <?PHP echo intval($maryland_history[$date]['deathAsian']); ?> },
			{ label: 'Other', y: <?PHP echo intval($maryland_history[$date]['deathOther']); ?> },
			{ label: 'Data not available', y: <?PHP echo intval($maryland_history[$date]['deathNotAVail']); ?> },
			{ label: 'Hispanic', y: <?PHP echo intval($maryland_history[$date]['deathHispanic']); ?> },
			{ label: 'White', y: <?PHP echo intval($maryland_history[$date]['deathWhite']); ?>},
			{ label: 'African-American', y: <?PHP echo intval($maryland_history[$date]['deathAfrAmer']); ?> }	
		]
	},
	{
		type: "area",
		name: "Prob Deaths",
		markerBorderColor: "blue",
		markerBorderThickness: 2,
		showInLegend: true,
		indexLabelFontSize: 10,
		axisYType: "secondary",
		dataPoints: [
			{ label: 'Asian', y: <?PHP echo intval($maryland_history[$date]['pDeathAsian']); ?> },
			{ label: 'Other', y: <?PHP echo intval($maryland_history[$date]['pDeathOther']); ?> },
			{ label: 'Data not available', y: <?PHP echo intval($maryland_history[$date]['pDeathNotAVail']); ?> },
			{ label: 'Hispanic', y: <?PHP echo intval($maryland_history[$date]['pDeathHispanic']); ?> },
			{ label: 'White', y: <?PHP echo intval($maryland_history[$date]['pDeathWhite']); ?>},
			{ label: 'African-American', y: <?PHP echo intval($maryland_history[$date]['pDeathAfrAmer']); ?> }	
		]
	}]
});
chartCnD.render();

var chartZIP = new CanvasJS.Chart("chartContainerZIP", {
	animationEnabled: true,
	exportEnabled: true,
	title:{
		fontSize: 14,
		text:"Maryland COVID-19 Outbreak by Zip Code covid19math.net"
	},
	axisX:{
		interval: 1
	},
	axisY2:{
		fontSize: 14,
		interlacedColor: "rgba(1,77,101,.2)",
		gridColor: "rgba(1,77,101,.1)",
		title: "ZIPs w/ Cases over 300"
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
	animationEnabled: true,
	exportEnabled: true,
	title:{
		fontSize: 14,
		text:"Maryland COVID-19 Outbreak by Zip Code covid19math.net"
	},
	axisX:{
		interval: 1
	},
	axisY2:{
		fontSize: 14,
		interlacedColor: "rgba(1,77,101,.2)",
		gridColor: "rgba(1,77,101,.1)",
		title: "ZIPs w/ Cases under 15"
	},
	data: [{
		type: "bar",
		name: "zip",
		axisYType: "secondary",
		color: "#014D65",
		indexLabelFontSize: 6,
		dataPoints: [
			<?PHP echo make_datapoints2(); ?>
		]
	}]
});
chartZIP2.render();	
	
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
$rSMS = $covid_db->query("SELECT id FROM coronavirus_sms order by id desc limit 1");
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
	
	if ($county == 'caseWhite'){ return $attributes['raceWhite']['CaseCount']; }
	if ($county == 'deathWhite'){ return $attributes['raceWhite']['DeathCount']; }
	
	if ($county == 'caseAsian'){ return $attributes['raceAsian']['CaseCount']; }
	if ($county == 'deathAsian'){ return $attributes['raceAsian']['DeathCount']; }
	
	if ($county == 'caseOther'){ return $attributes['raceOther']['CaseCount']; }
	if ($county == 'deathOther'){ return $attributes['raceOther']['DeathCount']; }
	
	if ($county == 'caseNotAVail'){ return $attributes['raceNotAvail']['CaseCount']; }
	if ($county == 'deathNotAvail'){ return $attributes['raceNotAvail']['DeathCount']; }
}
	
function do_math_location($county){
	
	global $maryland_history;
	global $new_id;
	global $new_date;
	global $old_date;
	global $covid_db;
	$today = date('Y-m-d',strtotime($new_date));
	$aka = county_aka($county);
	$count_today = $maryland_history[$today][$aka];
	
	$yesterday = date('Y-m-d',strtotime($old_date));
	$count_yesterday = $maryland_history[$yesterday][$aka];
	$covid_db->query("update coronavirus set $countyCOVID19Cases = '$count_today' where id = '$new_id' ");
	
	if ($count_today == 0){
		// failure detected
		// check attributes
		$count_fix = attribute_aka($county);
		//echo "<p>PATCH $count_today to $count_fix for $county ($count_yesterday)</p>";
		$count_today = $count_fix;
	}
	
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
echo do_math_location('bedsICU');
echo do_math_location('bedsAcute');
echo do_math_location('bedsTotal');
echo do_math_location('total_hospitalized');
echo do_math_location('total_released');
echo do_math_location('NegativeTests');

echo '<h4>County by County</h4>';
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
echo do_math_location('Wicomico'); 
echo do_math_location('Worcester');
echo '<h4>Age Groups</h4>';
echo do_math_location('case0to9');
echo do_math_location('case10to19');
echo do_math_location('case20to29');
echo do_math_location('case30to39');
echo do_math_location('case40to49');
echo do_math_location('case50to59');
echo do_math_location('case60to69');
echo do_math_location('case70to79');
echo do_math_location('case80plus');
echo '<h4>Deltas</h4>';	
echo do_math_location('CaseDelta');
echo do_math_location('NegDelta');
echo do_math_location('hospitalizedDelta');
echo do_math_location('releasedDelta');
echo do_math_location('deathsDelta');	
	
	
	
$new_master_message = ob_get_clean();

echo "<div class='col-sm-4' style='text-align:left;'>";
echo "$new_master_message";
echo "<p>Update String Legenth: ".strlen($new_master_message)." ($send_message)</p>";
echo "</div>";
if ($send_message == 'on' || isset($_GET['forcesms'])){
	global $covid_db;
	//$r = $covid_db->query("SELECT sms_number FROM coronavirus_sms where sms_status = 'confirmed' ");
	//while($d = mysqli_fetch_array($r)){
		//$sms = trim($d['sms_number']);
		//message_send($sms,$new_master_message);
	//}
	$covid_db->query("insert into coronavirus_msg (msg,msg_made_datetime) values ('$new_master_message',NOW() ) ");
}  
echo "</div>";
	
echo '<div class="row"><div class="col-sm-6"><div id="chartContainerZIP" style="height: 1200px; width: 100%;"></div></div>';
echo '<div class="col-sm-6"><div id="chartContainerZIP2" style="height: 1200px; width: 100%;"></div></div></div>';	
	
echo "</div>";
include_once('footer.php');
