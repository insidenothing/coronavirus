<?PHP
if(isset($_GET['novideo'])){
	$logo = 'off';
}
include_once('menu.php');

function coronavirus_zip($zip,$date,$count,$town){
	// the order we call the function will matter...
	global $core;
	$q = "select * from coronavirus_zip where zip_code = '$zip' and report_date = '$date'";
	$r = $core->query($q);
	$d = mysqli_fetch_array($r);
	// look for yesterday
	$date2 = date('Y-m-d',strtotime($date)-86400);
	$q2 = "select * from coronavirus_zip where zip_code = '$zip' and report_date = '$date2'";
	$r2 = $core->query($q2);
	$d2 = mysqli_fetch_array($r2);
	if ($d2['id'] != ''){
		// Let's Process Trend Data
		$last_trend_direction = $d2['trend_direction'];
		$last_trend_duration = $d2['trend_duration'];
		$last_report_count = $d2['report_count'];
		if ($count == $last_report_count){
			$current_trend = 'FLAT';	
		}elseif ($count > $last_report_count){
			$current_trend = 'UP';	
		}else{
			$current_trend = 'DOWN';
		}
		if ($last_trend_direction == $current_trend){
			$current_duration = $last_trend_duration + 1;
		}else{
			$current_duration = 0;
		}
	}else{
		// we reached the start of data collection.	
	}
	if ($d['id'] == ''){
		$core->query("insert into coronavirus_zip (zip_code,report_date,report_count,town_name,state_name,trend_direction,trend_duration) values ('$zip','$date','$count','$town','Maryland','$current_trend','$current_duration') ");
	}else{
		$core->query("update coronavirus_zip set report_count = '$count', trend_direction = '$current_trend', trend_duration = '$current_duration'  where zip_code = '$zip' and report_date = '$date' ");	
	}
}


global $nocases;
global $cases;
global $zipData;
global $date;
if(isset($_GET['date'])){
	$date = $_GET['date'];
	$r = $core->query("select html from coronavirus where url_pulled like '%ZIPCodes_MD_1%' and just_date = '$date' order by id desc");
	$d = mysqli_fetch_array($r);
	$zipData = make_maryland_array3('',$d['html'],'');
	$zipData2 = make_maryland_array3('',''); // this builds the name array
}else{
	$date = date('Y-m-d');
	$zipData = make_maryland_array3('','');
}
asort($zipData); // Sort Array (Ascending Order), According to Value - asort()
//ksort($zipData); // Sort Array (Ascending Order), According to Key - ksort()
function make_datapoints(){
	global $zipData;
	global $nocases;
	global $cases;
	global $zip2name;
	global $date;
	global $showzip;
	$total = 0;
	$return = '';
	foreach ($zipData as $zip => $data){
		if($zip != 'url_pulled' && $zip != 'date'){	
			$count = intval($data['ProtectedCount']);
			if ($count > 0){
				$total++;
			}
		}
	}	
	foreach ($zipData as $zip => $data){
		if($zip != 'url_pulled' && $zip != 'date'){
			$count = intval($data['ProtectedCount']);
			$name = substr($zip2name[$zip],0,25); // limit name to 25 characters
			coronavirus_zip($zip,$date,$count,$zip2name[$zip]);
if ($count > 0){
$showzip[] = $zip;	
$return .= "{ y: $count, label: '#$total $name' },
";
$total = $total - 1;
$cases .= "<span>$zip $name $count, </span>";
}else{
$nocases .= "<div>$zip $name</div>";	
}
		}
	}
	$return = rtrim(trim($return), ",");
	return $return;
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


function makeZIPpoints(){
	global $core;
	global $showzip;
	global $zip2name;
	$return = '';
	$showzip = array_reverse($showzip,true);
	foreach ($showzip as $zip) {
		$name = $zip2name[$zip];
		$return .= '{	
		type: "spline",
		visible: true,
		showInLegend: false,
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
<script>
window.onload = function () {


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
		title: "Number of Infections"
	},
	data: [{
		fontSize: 10,
		type: "bar",
		name: "zip",
		axisYType: "secondary",
		color: "#014D65",
		indexLabelFontSize: 10,
		dataPoints: [
			<?PHP echo make_datapoints(); ?>
		]
	}]
});
chartZIP.render();

function toggleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else {
		e.dataSeries.visible = true;
	}
	e.chart.render();
}

	var chartZIP2 = new CanvasJS.Chart("chartContainerZIP2", {
	theme:"light2",
	animationEnabled: true,
	exportEnabled: true,
	title:{
		text: "Maryland ZIPs over TIME covid19math.net"
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

}
</script>

	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

	<div class="row"><div class="col-sm-12"><div id="chartContainerZIP2" style="height: 1000px; width: 100%;"></div></div></div>

		<div class="col-sm-2"><h3>&lt; 7 CASES</h3><?PHP echo $nocases;?></div>
		<div class="col-sm-10"><div id="chartContainerZIP" style="height: 8000px; width: 100%;"></div>
		
	</div>
	<div class="row">
		<div class="col-sm-12" style='padding: 40px;'><p>ctrl-f support</p><?PHP echo $cases;?></div>
		
		
	</div>

	
<?PHP	
echo "</div>";
include_once('footer.php');
