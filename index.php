<?PHP
// preprocess data using zip.php (reviews all zip codes over known time)
$page_description = "Today's COVID 19 Data";
include_once('menu.php');
	$date = date('Y-m-d');
	$zip_open=0;
	$zip_closed=0;
	?>
	<div class="row">
	  <div class="col-sm-12">
		  <h1>Phase One Reopen <?PHP echo $date;?></h1><p>The following zip codes are flat for over 2 weeks and ready to look at how to begin phase one.</p>
		  <ol>  
		  <?PHP
		    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_duration > '13' and (trend_direction = 'DOWN' or trend_direction = 'FLAT' ) order by report_count desc";
		    $r = $covid_db->query($q);
		    while($d = mysqli_fetch_array($r)){
		       $zip_open++;
		       echo "<li><a href='zipcode.php?zip=$d[zip_code]'>$d[state_name] $d[zip_code] $d[trend_duration] days $d[trend_direction] at $d[report_count]</a></li>"; 
		    }
		    ?>
		  </ol>
	  </div>
	</div>
	<div class="row">
	  <div class="col-sm-12">
		  <h1>Not Phase One <?PHP echo $date;?></h1>
		  <ol> 
		    <?PHP
		    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_duration > '13' and trend_direction = 'UP' order by report_count desc ";
		    $r = $covid_db->query($q);
		    while($d = mysqli_fetch_array($r)){
			    $zip_closed++;
		       echo "<li><a href='zipcode.php?zip=$d[zip_code]'>$d[state_name] $d[zip_code] $d[trend_duration] days $d[trend_direction]  at $d[report_count]</a></li>"; 
		    }
		    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_duration = '13' order by report_count desc";
		    $r = $covid_db->query($q);
		    while($d = mysqli_fetch_array($r)){
			    $zip_closed++;
		       echo "<li><a href='zipcode.php?zip=$d[zip_code]'>$d[state_name] $d[zip_code] $d[trend_duration] days $d[trend_direction]  at $d[report_count]</a></li>"; 
		    }
		    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_duration < '13' order by report_count desc";
		    $r = $covid_db->query($q);
		    while($d = mysqli_fetch_array($r)){
			    $zip_closed++;
		       echo "<li><a href='zipcode.php?zip=$d[zip_code]'>$d[state_name] $d[zip_code] $d[trend_duration] days $d[trend_direction]  at $d[report_count]</a></li>"; 
		    }
		    ?>
		  </ol> 
	  </div>
	</div>
<?PHP
include_once('footer.php');
?>
