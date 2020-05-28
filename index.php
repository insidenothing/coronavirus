<?PHP
// preprocess data using zip.php (reviews all zip codes over known time)
if (isset($_GET['state'])){
	$state = $_GET['state'];
}else{
	$state = 'Maryland';
}
$page_description = "Reopen $state - Phase One  - Status";
include_once('menu.php');
$q = "SELECT distinct zip_code FROM coronavirus_zip where state_name = '$state'";
$r = $core->query($q);
$total_zip = $r->num_rows;
$flat = 23;
$down = 0;
?>

<?PHP
// pull date from last update, not assume today.
$q = "select just_date from coronavirus order by id desc limit 1";
$r = $core->query($q);
$d = mysqli_fetch_array($r);
$date = $d['just_date'];
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
  <div class="col-sm-12">
	  <h1>Phase One Reopen</h1><p>The following zip codes are flat or down for over 2 weeks and ready to look at how to begin phase one.</p>
 	    <?PHP
	    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_duration > '13' and state_name = '$state' and (trend_direction = 'DOWN' or trend_direction = 'FLAT' ) order by report_count desc";
	    $r = $core->query($q);
	    while($d = mysqli_fetch_array($r)){
	       echo "[ <a href='zipcode.php?zip=$d[zip_code]'>$d[zip_code] at $d[report_count]</a> ]"; 
	    }
	    ?>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
	  <h1>Not Phase One</h1>
	    <?PHP
	    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_duration > '13' and state_name = '$state' and trend_direction = 'UP' order by report_count desc ";
	    $r = $core->query($q);
	    while($d = mysqli_fetch_array($r)){
	       echo "[ <a href='zipcode.php?zip=$d[zip_code]'>$d[zip_code] at $d[report_count]</a> ]"; 
	    }
	    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_duration < '13' and state_name = '$state' order by report_count desc";
	    $r = $core->query($q);
	    while($d = mysqli_fetch_array($r)){
	       echo "[ <a href='zipcode.php?zip=$d[zip_code]'>$d[zip_code] at $d[report_count]</a> ]"; 
	    }
	    ?>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
  <h3>Goals</h3>
    We are setting up this page to track zipcodes across the curve. As they trend higher we count the days, 
    as they flatten off we count the days, as they drop we count the days. Every time the trend changes the
    duration resets.
  </div>
</div>
<?PHP
// pull date from last update, not assume today.
$q = "select just_date from coronavirus order by id desc limit 1";
$r = $core->query($q);
$d = mysqli_fetch_array($r);
$date = $d['just_date'];

ob_start();
$total_up=0;
$total_flat=0;
$total_down=0;
$new_up=0;
$new_flat=0;
$new_down=0;
?>
<div class="row">
  <div class="col-sm-6">
  <h3>14+ Day Trends above 0</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_duration > '13' and state_name = '$state' and report_count <> 0 order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        $color='orange';
	    if ($d['trend_direction'] == 'FLAT'){
		$color = 'lightgreen';
		}
	    echo "<li style='background-color:$color;'><a href='zipcode.php?zip=$d[zip_code]'>For $d[trend_duration] days, $d[town_name] ( $d[zip_code] ) has been going $d[trend_direction] and is now $d[report_count]</a></li>"; 
    }
    ?>
    </ol>
  </div>
	<div class="col-sm-6">
  <h3>14+ Day Trends at 0</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_duration > '13' and state_name = '$state' and report_count = 0 order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        $color='orange';
	    if ($d['trend_direction'] == 'FLAT'){
		$color = 'lightgreen';
		}
	    echo "<li style='background-color:$color;'><a href='zipcode.php?zip=$d[zip_code]'>For $d[trend_duration] days, $d[town_name] ( $d[zip_code] ) has been going $d[trend_direction] and is now $d[report_count]</a></li>"; 
    }
    ?>
    </ol>
  </div>
</div>
<div class="row">
  <div class="col-sm-4">
    <h3>Up Trend</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'UP' and trend_duration <> '0' and state_name = '$state' order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        echo "<li><a href='zipcode.php?zip=$d[zip_code]'>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count] for $d[trend_duration] days</a></li>"; 
        $total_up++;
    }
    ?>
    </ol>
  </div>
  <div class="col-sm-4">
    <h3>Flat Trend</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'FLAT' and report_count <> '0' and trend_duration <> 0 and state_name = '$state' order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
      echo "<li><a href='zipcode.php?zip=$d[zip_code]'>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count] for $d[trend_duration] days</a></li>"; 
      $total_flat++;
    }
    ?>
    </ol>
  </div>
  <div class="col-sm-4">
  <h3>Down Trend</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'DOWN' and trend_duration <> '0' and state_name = '$state' order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
      echo "<li><a href='zipcode.php?zip=$d[zip_code]'>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count] for $d[trend_duration] days</a></li>"; 
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
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'UP' and trend_duration = '0' and state_name = '$state' order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
	echo "<li><a href='zipcode.php?zip=$d[zip_code]'>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count]</a></li>"; 
        $new_up++;
    }
    ?>
    </ol>
  </div>
  <div class="col-sm-4">
    <h3>New Direction Flat</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'FLAT' and report_count <> 0 and trend_duration = '0' and state_name = '$state' order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
       echo "<li><a href='zipcode.php?zip=$d[zip_code]'>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count]</a></li>"; 
       $new_flat++;
    }
    ?>
    </ol>
  </div>
  <div class="col-sm-4">
  <h3>New Direction Down</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'DOWN' and trend_duration = '0' and state_name = '$state' order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
       echo "<li><a href='zipcode.php?zip=$d[zip_code]'>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count]</a></li>"; 
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
		text: "<?PHP echo $state;?> Zipcode Curve Position covid19math.net"
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
		text: "<?PHP echo $state;?> Zipcode New Curve Position covid19math.net"
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
include_once('footer.php');
?>
