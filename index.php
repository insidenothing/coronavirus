<?PHP
// preprocess data using zip.php (reviews all zip codes over known time)
$page_description = "Reopen Status - Phase One";
include_once('menu.php');
global $date;
$date = $global_date;
// move inside function?
$q = "SELECT distinct zip_code FROM coronavirus_zip where state_name = 'Maryland'";
$r = $core->query($q);
$total_zip = $r->num_rows;
$flat = 23;
$down = 0;


// pull date from last update, not assume today.
$date = $global_date;
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
	<div id="chartContainer5" style="height: 400px; width: 100%;"></div>
 </div>
</div>
<?PHP 
/*
<div class="row">
  <div class="col-sm-12">
    <h3>We are setting up this page to track zipcodes across the curve. As they trend higher we count the days, 
    as they flatten off we count the days, as they drop we count the days. Every time the trend changes the
	    duration resets.</h3>
  </div>
</div>
<?PHP
*/


function make_reopen($state){
        global $core;
        $return1 = ''; 
	$return2 = ''; 
	$range = '30';
	$q = "SELECT * FROM coronavirus_reopen where state = '$state' ";
	$r = $core->query($q);
	$rows = mysqli_num_rows($r);
	$start = $rows - $range;
	$test1 = $start;
	$range2= $range - 1;
	$start = max($start, 0);
        $q = "SELECT * FROM coronavirus_reopen where state = '$state' limit $start, $range";
	$r = $core->query($q);
	if ($test1 < 0){
		foreach(range(0,$test1) as $days){
			$date = date('Y-m-d',strtotime('-'.$days.' days'));
			$return1 .= '{ label: "'.$date.'", y: 0 }, ';
			$return2 .= '{ label: "'.$date.'", y: 0 }, ';
		}
	}
	while ($d = mysqli_fetch_array($r)){
		$return1 .= '{ label: "'.$d['the_date'].'", y: '.$d['zip_open'].' }, ';
		$return2 .= '{ label: "'.$d['the_date'].'", y: '.$d['zip_closed'].' }, ';
	}
    	$return[] = rtrim(trim($return1), ",");
	$return[] = rtrim(trim($return2), ",");
    	return $return;
}

?>
<script src="canvasjs.min.js"></script>



<script>
	window.onload = function () {
		
		
		
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	title: {
		text: "<?PHP echo $state;?> Zipcode Curve Position <?PHP echo $date;?> covid19math.net"
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
		text: "<?PHP echo $state;?> Zipcode New Curve Position <?PHP echo $date;?> covid19math.net"
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

		var chart5 = new CanvasJS.Chart("chartContainer5", {
	theme:"light2",
	animationEnabled: true,
	exportEnabled: true,
	title:{
		text: "14 Days Flat <?PHP echo $date;?> covid19math.net"
	},
	axisY :{
		includeZero: false,
		title: "Number of ZIP Codes",
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
		type: "line",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Maryland Open",
		dataPoints: [
			<?PHP echo make_reopen('Maryland')[0]; ?>
		]
	},{
		type: "line",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Maryland Closed",
		dataPoints: [
			<?PHP echo make_reopen('Maryland')[1]; ?>
		]
	},{
		type: "line",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Florida Open",
		dataPoints: [
			<?PHP echo make_reopen('Florida')[0]; ?>
		]
	},{
		type: "line",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Florida Closed",
		dataPoints: [
			<?PHP echo make_reopen('Florida')[1]; ?>
		]
	},{
		type: "line",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Virginia Open",
		dataPoints: [
			<?PHP echo make_reopen('Virginia')[0]; ?>
		]
	},{
		type: "line",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "Virginia Closed",
		dataPoints: [
			<?PHP echo make_reopen('Virginia')[1]; ?>
		]
	},{
		type: "line",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "New York Open",
		dataPoints: [
			<?PHP echo make_reopen('New York')[0]; ?>
		]
	},{
		type: "column",
		visible: true,
		showInLegend: true,
		yValueFormatString: "#####",
		name: "New York Closed",
		dataPoints: [
			<?PHP echo make_reopen('New York')[1]; ?>
		]
	}]
}
			      
			      
 );
chart5.render();
  	
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






<?PHP

function state_data($state){
	global $core;
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
	  <h3>14+ Day Trends Flat / Down</h3>
	    <ol>
	    <?PHP
	    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_duration > '13' and state_name = '$state' and report_count <> 0 and trend_direction <> 'up' order by trend_duration DESC";
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
	  <h3>14+ Day Trends Up</h3>
	    <ol>
	    <?PHP
	    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_duration > '13' and state_name = '$state' and report_count <> 0 and trend_direction = 'up' order by trend_duration DESC";
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
	$return			= array();
	$return['buffer'] 	= $buffer;
	$return['new_down'] 	= intval($new_down);
	$return['new_flat'] 	= intval($new_flat);
	$return['new_up'] 	= intval($new_up);
	$return['total_down'] 	= intval($total_down);
	$return['total_flat'] 	= intval($total_flat);
	$return['total_up'] 	= intval($total_up);
	return $return;
}


$array 		= state_data('Maryland');
$buffer 	= $array['buffer'];
$new_down 	= $return['new_down'];
$new_flat 	= $return['new_flat'];
$new_up 	= $return['new_up'];
$total_down 	= $return['total_down'];
$total_flat	= $return['total_flat'];
$total_up	= $return['total_up'];

echo $buffer;

function count_open_zips($state){
	global $core;
	global $global_date;
	$date = $global_date;
	$zip_open=0;
	$zip_closed=0;
	?>
	<div class="row">
	  <div class="col-sm-12">
		  <h1>Phase One Reopen <?PHP echo $date.' '.$state;?></h1><p>The following zip codes are flat or down for over 2 weeks and ready to look at how to begin phase one.</p>
		    <?PHP
		    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_duration > '13' and state_name = '$state' and (trend_direction = 'DOWN' or trend_direction = 'FLAT' ) order by report_count desc";
		    $r = $core->query($q);
		    while($d = mysqli_fetch_array($r)){
		       $zip_open++;
		       echo "[ <a href='zipcode.php?zip=$d[zip_code]'>$d[zip_code] at $d[report_count]</a> ]"; 
		    }
		    ?>
	  </div>
	</div>
	<div class="row">
	  <div class="col-sm-12">
		  <h1>Not Phase One <?PHP echo $date.' '.$state;?></h1>
		    <?PHP
		    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_duration > '13' and state_name = '$state' and trend_direction = 'UP' order by report_count desc ";
		    $r = $core->query($q);
		    while($d = mysqli_fetch_array($r)){
			    $zip_closed++;
		       echo "[ <a href='zipcode.php?zip=$d[zip_code]'>$d[zip_code] at $d[report_count]</a> ]"; 
		    }
		    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_duration < '13' and state_name = '$state' order by report_count desc";
		    $r = $core->query($q);
		    while($d = mysqli_fetch_array($r)){
			    $zip_closed++;
		       echo "[ <a href='zipcode.php?zip=$d[zip_code]'>$d[zip_code] at $d[report_count]</a> ]"; 
		    }
		    ?>
	  </div>
	</div>
	<?PHP
	$q = "select * from coronavirus_reopen where the_date = '$date' and state = '$state'";
	$r = $core->query($q);
	$d = mysqli_fetch_array($r);
	if ($d['id'] == ''){
		$q = "insert into coronavirus_reopen (zip_closed,zip_open,the_date,state) values ('$zip_closed','$zip_open','$date','$state') ";	
	}else{
		$q = "update coronavirus_reopen set zip_closed = '$zip_closed', zip_open = '$zip_open' where the_date = '$date' and state = '$state' ";		
	}
	$core->query($q);
	slack_general("$q",'covid19-sql');
}

// This makes the data in the top graphs 
count_open_zips('Maryland');
count_open_zips('Florida');
count_open_zips('Virginia');
count_open_zips('New York');
?>


<div class="row">
 	<div class="col-sm-6">
		<div id="chartContainer" style="height: 400px; width: 100%;"></div>
	</div>
 	<div class="col-sm-6">
		<div id="chartContainer2" style="height: 400px; width: 100%;"></div>
	</div>
</div> 



<?PHP
include_once('footer.php');
?>
