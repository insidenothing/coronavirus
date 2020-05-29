<?PHP
$page_description = "Maryland COVID 19 Spike Monitor";
include_once('menu.php');
global $zipcode;
global $global_date;
$zipcode = array();
$q = "select distinct zip_code, town_name from coronavirus_zip where town_name <> ''";
$r = $core->query($q);
while($d = mysqli_fetch_array($r)){
	$zip = $d['zip_code'];
	$zipcode[$zip] = $d['town_name'];
}
$date = $global_date;
if(isset($_GET['zip']) && isset($_GET['name'])){
	$add_zip = $_GET['zip'];
	$new_name = $_GET['name'];
 	$core->query("update coronavirus_zip set town_name = '$new_name' where zip_code = '$add_zip' and report_date = '$date' ");	
}
?>

<div class="row">
	<div class="col-sm-2">
		<p>7 Day Over 1000%</p><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '1000' order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day7change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<p>7 Day Over 100%</p><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '100' and day7change_percentage < '1000'  order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day7change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<p>7 Day Over 50%</p><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '50' and day7change_percentage < '100'  order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day7change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<p>7 Day Over 20%</p><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '20' and day7change_percentage < '50'  order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day7change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<p>7 Day Over 10%</p><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '10' and day7change_percentage < '20' order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day7change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<p>7 Day Under 10%</p><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '0' and day7change_percentage < '10' order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day7change_percentage']."%</a></li>";
		}
		?></ol>
	 </div>
</div>

<div class="row">
	<div class="col-sm-2">
	    <p>14 Day Over 1000%</p><ol>
	    <?PHP
		$q = "SELECT day14change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '1000' order by day14change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day14change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	    <p>14 Day Over 100%</p><ol>
	    <?PHP
		$q = "SELECT day14change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '100' and day14change_percentage < '1000' order by day14change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day14change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	    <p>14 Day Over 50%</p><ol>
	    <?PHP
		$q = "SELECT day14change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '50' and day14change_percentage < '100' order by day14change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day14change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	    <p>14 Day Over 20%</p><ol>
	    <?PHP
		$q = "SELECT day14change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '20' and day14change_percentage < '50' order by day14change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day14change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	    <p>14 Day Over 10%</p><ol>
	    <?PHP
		$q = "SELECT day14change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '10' and day14change_percentage < '20' order by day14change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day14change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	    <p>14 Day Under 10%</p><ol>
	    <?PHP
		$q = "SELECT day14change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '0' and day14change_percentage < '10' order by day14change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day14change_percentage']."%</a></li>";
		}
		?></ol>
 	</div>
</div>	
	
<div class="row">	
	<div class="col-sm-2">
	    <p>30 Day Over 1000%</p><ol>
	    <?PHP
		$q = "SELECT day30change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '1000' order by day30change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day30change_percentage']."%</a></li>";
		}
	  ?></ol>
  	</div>
	<div class="col-sm-2">
	    <p>30 Day Over 100%</p><ol>
	    <?PHP
		$q = "SELECT day30change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '100' and day30change_percentage < '1000' order by day30change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day30change_percentage']."%</a></li>";
		}
	  ?></ol>
  	</div>
	<div class="col-sm-2">
	    <p>30 Day Over 50%</p><ol>
	    <?PHP
		$q = "SELECT day30change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '50' and day30change_percentage < '100' order by day30change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day30change_percentage']."%</a></li>";
		}
	  ?></ol>
  	</div>
	<div class="col-sm-2">
	    <p>30 Day Over 20%</p><ol>
	    <?PHP
		$q = "SELECT day30change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '20' and day30change_percentage < '50' order by day30change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day30change_percentage']."%</a></li>";
		}
	  ?></ol>
  	</div>
	<div class="col-sm-2">
	    <p>30 Day Over 10%</p><ol>
	    <?PHP
		$q = "SELECT day30change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '10' and day30change_percentage < '20' order by day30change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day30change_percentage']."%</a></li>";
		}
	  ?></ol>
  	</div>
	<div class="col-sm-2">
	    <p>30 Day Under 10%</p><ol>
	    <?PHP
		$q = "SELECT day30change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '0' and day30change_percentage < '10' order by day30change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day30change_percentage']."%</a></li>";
		}
	  ?></ol>
 	 </div>
</div>	
	
	
<div class="row">
	<div class="col-sm-2">
	   <p>45 Day Over 1000%</p><ol>
	   <?PHP
		$q = "SELECT day45change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '1000' order by day45change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day45change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	   <p>45 Day Over 100%</p><ol>
	   <?PHP
		$q = "SELECT day45change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '100' and day45change_percentage < '1000' order by day45change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day45change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	   <p>45 Day Over 50%</p><ol>
	   <?PHP
		$q = "SELECT day45change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '50' and day45change_percentage < '100' order by day45change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day45change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	   <p>45 Day Over 20%</p><ol>
	   <?PHP
		$q = "SELECT day45change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '20' and day45change_percentage < '50' order by day45change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day45change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	   <p>45 Day Over 10%</p><ol>
	   <?PHP
		$q = "SELECT day45change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '10' and day45change_percentage < '20' order by day45change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day45change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	   <p>45 Day Under 10%</p><ol>
	   <?PHP
		$q = "SELECT day45change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '0' and day45change_percentage < '10' order by day45change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day45change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
</div>

<?PHP include_once('footer.php'); ?>
