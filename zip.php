<?PHP
if(isset($_GET['novideo'])){
	$logo = 'off';
}
include_once('menu.php');

global $nocases;

global $zipData;
$url = 'https://services.arcgis.com/njFNhDsUCentVYJW/arcgis/rest/services/TEST_ZIPCodeCases/FeatureServer/0/query?where=1%3D1&outFields=OBJECTID,ZIPCODE1,ZIPName,ProtectedCount&returnGeometry=false&outSR=4326&f=json';
$zipData = make_maryland_array3($url,'');
asort($zipData); // Sort Array (Ascending Order), According to Value - asort()
//ksort($zipData); // Sort Array (Ascending Order), According to Key - ksort()
function make_datapoints(){
	global $zipData;
	global $nocases;
	global $zip2name;
	$total = 0;
	$return = '';
	foreach ($zipData as $zip => $data){
		if($zip != 'url_pulled' && $zip != 'date'){	
			if ($count > 0){
				$total++;
			}
		}
	}	
	foreach ($zipData as $zip => $data){
		if($zip != 'url_pulled' && $zip != 'date'){	
			$count = intval($data['ProtectedCount']);
			$name = substr($zip2name[$zip],0,25); // limit name to 25 characters
			if ($count > 0){
				$return .= "{ y: $count, label: '$total $name' },";
				$total = $total - 1;
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



	<div class="row">
		<div class="col-sm-2"><h3>NO CASES</h3><?PHP echo $nocases;?></div>
		<div class="col-sm-10"><div id="chartContainerZIP" style="height: 8000px; width: 100%;"></div>
		
	</div>
</div>
	
<?PHP	
echo "</div>";
include_once('footer.php');
