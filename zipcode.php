<?PHP
include_once('county_zip_codes.php');

global $zip;
if(isset($_GET['zip'])){
	$zip = $_GET['zip'];	
}else{
  	$zip = '99999';	
}

$logo = 'off';

global $zip_debug;

$page_description = "$date $zip - ZIP Codes";

include_once('menu.php');

?><div class="row"><div class="col-sm-12"><h3><?PHP echo $zip;?> History</h3><?PHP
$time_chart='';
$q = "SELECT * FROM `coronavirus_zip` where zip_code = '$zip' order by report_date desc";
$r = $core->query($q);
while ($d = mysqli_fetch_array($r)){
	$time_chart .=  '{ label: "'.$d['report_date'].'", y: '.$d['report_count'].' }, ';
	echo "<li>$d[id] $d[zip_code] $d[report_date] $d[town_name] $d[state_name] $d[report_count] $d[trend_direction] $d[trend_duration]</li>";
}
$time_chart = rtrim(trim($time_chart), ",");
?></div></div>


<script src="canvasjs.min.js"></script>
<script>
window.onload = function () {
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
			<?PHP echo $time_chart; ?>
		]
	});
	chartZIP2.render();	

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


<div class="row"><div class="col-sm-12"><div id="chartContainerZIP2" style="height: 500px; width: 100%;"></div></div></div>

	
<?PHP include_once('footer.php'); ?>
	
