<?PHP
if(isset($_GET['novideo'])){
	$logo = 'off';
}
include_once('menu.php');

function coronavirus_zip($zip,$date,$count,$town){
	global $core;
	$q = "select * from coronavirus_zip where zip_code = '$zip' and report_date = '$date'";
	$r = $core->query($q);
	$d = mysqli_fetch_array($r);
	if ($d['id'] == ''){
		$core->query("insert into coronavirus_zip (zip_code,report_date,report_count,town_name) values ('$zip','$date','$count','$town') ");
	}else{
		$core->query("update coronavirus_zip set report_count = '$count' where zip_code = '$zip' and report_date = '$date' ");	
	}
}


global $nocases;
global $cases;
global $zipData;
$zipData = make_maryland_array3('','');
asort($zipData); // Sort Array (Ascending Order), According to Value - asort()
//ksort($zipData); // Sort Array (Ascending Order), According to Key - ksort()
function make_datapoints(){
	global $zipData;
	global $nocases;
	global $cases;
	global $zip2name;
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
			coronavirus_zip($zip,date('Y-m-d'),$count);
			$name = substr($zip2name[$zip],0,25); // limit name to 25 characters
if ($count > 0){
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
	

}
</script>

	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>



		<div class="col-sm-2"><h3>&lt; 7 CASES</h3><?PHP echo $nocases;?></div>
		<div class="col-sm-10"><div id="chartContainerZIP" style="height: 8000px; width: 100%;"></div>
		
	</div>
	<div class="row">
		<div class="col-sm-12" style='padding: 40px;'><p>ctrl-f support</p><?PHP echo $cases;?></div>
		
		
	</div>

	
<?PHP	
echo "</div>";
include_once('footer.php');
