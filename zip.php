<?PHP
if(isset($_GET['novideo'])){
	$logo = 'off';
}
include_once('menu.php');

global $zipData;
$url = 'https://services.arcgis.com/njFNhDsUCentVYJW/arcgis/rest/services/TEST_ZIPCodeCases/FeatureServer/0/query?where=1%3D1&outFields=OBJECTID,ZIPCODE1,ZIPName,ProtectedCount&returnGeometry=false&outSR=4326&f=json';
$zipData = make_maryland_array3($url,'');


function make_datapoints(){
	global $zipData;
	$return = '';
	foreach ($zipData as $zip => $data){
		$name = $data['ZIPName'];
		$count = intval($data['ProtectedCount']);
		$return .= "{ y: $count, label: '$zip $name' },";	
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
		text:"Maryland COVID-19 Outbreak by Zip Code covid19math.net"
	},
	axisX:{
		interval: 1
	},
	axisY2:{
		interlacedColor: "rgba(1,77,101,.2)",
		gridColor: "rgba(1,77,101,.1)",
		title: "Number of Infections"
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







echo '<div class="row"><div class="col-sm-12"><div id="chartContainerZIP" style="height: 5000px; width: 100%;"></div></div></div>';
	
	
echo "</div>";
include_once('footer.php');
