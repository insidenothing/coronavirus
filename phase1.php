<?PHP
// preprocess data using zip.php (reviews all zip codes over known time)
$page_description = "Reopen Maryland - Phase One  - Status";
include_once('menu.php');
?>
<div class="row">
  <div class="col-sm-12">
  <h3>Goals</h3>
    We are setting up this page to track zipcodes across the curve. As they trend higher we count the days, 
    as they flatten off we count the days, as they drop we count the days. Every time the trend changes the
    duration resets. Phase One <b>Starts</b> after 14 days of Down Trend. 
  </div>
</div>

<?PHP
// pull date from last update, not assume today.
$date = date('Y-m-d');
?>


<?PHP 
ob_start();
$total_up=0;
$total_flat=0;
$total_down=0;
$new_up=0;
$new_flat=0;
$new_down=0;
?>

<div class="row">
  <div class="col-sm-4">
    <h3>Up Trend</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'UP' and trend_duration <> '0' order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        echo "<li>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count] for $d[trend_duration] days</li>"; 
        $total_up++;
    }
    ?>
    </ol>
  </div>
  <div class="col-sm-4">
    <h3>Flat Trend</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'FLAT' and report_count <> '0' and trend_duration <> 0 order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        echo "<li>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count] for $d[trend_duration] days</li>"; 
      $total_flat++;
    }
    ?>
    </ol>
  </div>
  <div class="col-sm-4">
  <h3>Down Trend</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'DOWN' and trend_duration <> '0' order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        echo "<li>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count] for $d[trend_duration] days</li>"; 
      $total_down++;
    }
    ?>
    </ol>
  </div>
</div>


<div class="row">
  <div class="col-sm-4">
    <h3>New Direction Up</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'UP' and trend_duration = '0' order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        echo "<li>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count]</li>"; 
        $new_up++;
    }
    ?>
    </ol>
  </div>
  <div class="col-sm-4">
    <h3>New Direction Flat</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'FLAT' and report_count <> 0 and trend_duration = '0' order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        echo "<li>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count]</li>"; 
       $new_flat++;
    }
    ?>
    </ol>
  </div>
  <div class="col-sm-4">
  <h3>New Direction Down</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'DOWN' and trend_duration = '0' order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        echo "<li>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count]</li>"; 
       $new_down++;
    }
    ?>
    </ol>
  </div>
</div>

<?PHP 
$buffer = ob_get_clean();
?>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<script>
	window.onload = function () {
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	title: {
		text: "Maryland Zipcode Curve Position covid19math.net"
	},
	data: [{
		type: "pie",
		startAngle: 240,
		yValueFormatString: "#####",
		indexLabel: "{label} {y}",
		dataPoints: [
			{y: <?PHP echo intval($total_up);?>, label: "UP"},
			{y: <?PHP echo intval($total_flat);?>, label: "FLAT"},
      {y: <?PHP echo intval($total_down);?>, label: "DOWN"}
		]
	}]
});
chart.render();

var chart2 = new CanvasJS.Chart("chartContainer2", {
	animationEnabled: true,
	exportEnabled: true,
	title: {
		text: "Maryland Zipcode New Curve Position covid19math.net"
	},
	data: [{
		type: "pie",
		startAngle: 240,
		yValueFormatString: "#####",
		indexLabel: "{label} {y}",
		dataPoints: [
			{y: <?PHP echo intval($new_up);?>, label: "UP"},
			{y: <?PHP echo intval($new_flat);?>, label: "FLAT"},
      {y: <?PHP echo intval($new_down);?>, label: "DOWN"}
		]
	}]
});
chart2.render();

  	
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

<div class="row">
 	<div class="col-sm-6">
		<div id="chartContainer" style="height: 400px; width: 100%;"></div>
	</div>
 	<div class="col-sm-6">
		<div id="chartContainer2" style="height: 400px; width: 100%;"></div>
	</div>
</div>


<?PHP 
echo $buffer;
?>

<?PHP include_once('footer.php'); ?>
