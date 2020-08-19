<?PHP
$state = 'Delaware';
$page_description = "$state COVID 19 Data Collection";
include_once('../menu.php');
$state = 'Delaware';
$deaths = '';
$cases = '';
$testing = '';
$q = "SELECT * FROM coronavirus_state where state_name = '$state' order by report_date ";
$r = $covid_db->query($q);
while($d = mysqli_fetch_array($r)){
	$deaths .= '{ label: "'.$d['report_date'].'", y: '.intval($d['death_count']).' }, ';
	$cases .= '{ label: "'.$d['report_date'].'", y: '.intval($d['report_count']).' }, ';
	$testing .= '{ label: "'.$d['report_date'].'", y: '.intval($d['testing_count']).' }, ';
}
$deaths = rtrim(trim($deaths), ",");
$cases = rtrim(trim($cases), ",");
$testing = rtrim(trim($testing), ",");
$range = '30'; // one month
$deaths_30 = '';
$cases_30 = '';
$testing_30 = '';
$rows = mysqli_num_rows($r);
$start = $rows - $range;
$range2= $range - 1;
$start = max($start, 0);
$q = "SELECT * FROM coronavirus_state where state_name = '$state' order by report_date limit $start, $range";
$r = $covid_db->query($q);
while($d = mysqli_fetch_array($r)){
	$deaths_30 .= '{ label: "'.$d['report_date'].'", y: '.intval($d['death_count']).' }, ';
	$cases_30 .= '{ label: "'.$d['report_date'].'", y: '.intval($d['report_count']).' }, ';
	$testing_30 .= '{ label: "'.$d['report_date'].'", y: '.intval($d['testing_count']).' }, ';
}
$deaths_30 = rtrim(trim($deaths_30), ",");
$cases_30 = rtrim(trim($cases_30), ",");
$testing_30 = rtrim(trim($testing_30), ",");
?>


<script>
window.onload = function () {

var chartDeaths = new CanvasJS.Chart("chartContainerDeaths", {
	theme:"light2",
	animationEnabled: true,
	exportEnabled: true,
	title:{
		text: "<?PHP echo $state;?> Deaths covid19math.net"
	},
	axisY :{
		includeZero: false,
		title: "People",
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
		name: "Total Deaths",
		dataPoints: [
			<?PHP echo $deaths; ?>
		]
	}]
}
			      
			      
			      );
chartDeaths.render();

	var chartCases = new CanvasJS.Chart("chartContainerCases", {
	theme:"light2",
	animationEnabled: true,
	exportEnabled: true,
	title:{
		text: "<?PHP echo $state;?> Cases covid19math.net"
	},
	axisY :{
		includeZero: false,
		title: "People",
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
		name: "Total Cases",
		dataPoints: [
			<?PHP echo $cases; ?>
		]
	}]
}
			      
			      
			      );
chartCases.render();
	
	var chartTesting = new CanvasJS.Chart("chartContainerTesting", {
	theme:"light2",
	animationEnabled: true,
	exportEnabled: true,
	title:{
		text: "<?PHP echo $state;?> Testing covid19math.net"
	},
	axisY :{
		includeZero: false,
		title: "People",
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
		name: "Total Testing",
		dataPoints: [
			<?PHP echo $testing; ?>
		]
	}]
}
			      
			      
			      );
chartTesting.render();
	
	var chartDeaths_30 = new CanvasJS.Chart("chartContainerDeaths_30", {
	theme:"light2",
	animationEnabled: true,
	exportEnabled: true,
	title:{
		text: "<?PHP echo $state;?> Deaths 30 Day covid19math.net"
	},
	axisY :{
		includeZero: false,
		title: "People",
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
		name: "Total Deaths",
		dataPoints: [
			<?PHP echo $deaths_30; ?>
		]
	}]
}
			      
			      
			      );
chartDeaths_30.render();

	var chartCases_30 = new CanvasJS.Chart("chartContainerCases_30", {
	theme:"light2",
	animationEnabled: true,
	exportEnabled: true,
	title:{
		text: "<?PHP echo $state;?> Cases 30 Day covid19math.net"
	},
	axisY :{
		includeZero: false,
		title: "People",
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
		name: "Total Cases",
		dataPoints: [
			<?PHP echo $cases_30; ?>
		]
	}]
}
			      
			      
			      );
chartCases_30.render();
	
	var chartTesting_30 = new CanvasJS.Chart("chartContainerTesting_30", {
	theme:"light2",
	animationEnabled: true,
	exportEnabled: true,
	title:{
		text: "<?PHP echo $state;?> Testing 30 Day covid19math.net"
	},
	axisY :{
		includeZero: false,
		title: "People",
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
		name: "Total Testing",
		dataPoints: [
			<?PHP echo $testing_30; ?>
		]
	}]
}
			      
			      
			      );
chartTesting_30.render();
	
	
	
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

<script src="../canvasjs.min.js"></script>

<table><tr>
	
	<td><div id="chartContainerDeaths_30" style="height: 370px; margin: 0px auto;"></div></td>
	<td><div id="chartContainerCases_30" style="height: 370px; margin: 0px auto;"></div></td>
	<td><div id="chartContainerTesting_30" style="height: 370px; margin: 0px auto;"></div></td>
	
	</tr></table>


<div id="chartContainerDeaths" style="height: 370px; margin: 0px auto;"></div>

<div id="chartContainerCases" style="height: 370px; margin: 0px auto;"></div>

<div id="chartContainerTesting" style="height: 370px; margin: 0px auto;"></div>

<h1><?PHP echo $state;?> Counties</h1>
<?PHP
$q = "SELECT distinct county_name FROM coronavirus_county where state_name = '$state' order by county_name";
		$r = $covid_db->query($q);
		while($d = mysqli_fetch_array($r)){	
			echo "<span><a href='/county.php?county=$d[county_name]&state=$state'>$d[county_name]</a>, </span>";
		}
?>

<h1><?PHP echo $state;?> ZIP Codes</h1>
<?PHP
$q = "SELECT distinct zip_code FROM coronavirus_zip where state_name = '$state' order by zip_code";
		$r = $covid_db->query($q);
		while($d = mysqli_fetch_array($r)){	
			echo "<span><a href='/zip.php?zip=$d[zip_code]'>$d[zip_code]</a>, </span>";
		}
?>

<h1><?PHP echo $state;?> Data Sources</h1>
<ol>
<?PHP
$q = "SELECT * FROM coronavirus_apis where state_name = '$state'";
		$r = $covid_db->query($q);
		while($d = mysqli_fetch_array($r)){	
			echo "<li><a href='$d[api_url]'><small>$d[api_url]</small></a></li>";
		}
?>
</ol>

<?PHP
include_once('../footer.php');
?>
