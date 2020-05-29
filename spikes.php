<?PHP
$page_description = "Maryland COVID 19 Spike Monitor";
include_once('menu.php');
global $zipcode;
$zipcode = array();
$q = "select distinct zip_code, town_name from coronavirus_zip where town_name <> ''";
$r = $core->query($q);
while($d = mysqli_fetch_array($r)){
	$zip = $d['zip_code'];
	$zipcode[$zip] = $d['town_name'];
}
$date = date('Y-m-d');
?>
<h1>Over 1000%</h1>
<div class="row">
	<div class="col-sm-3">
    	<h1>7 Day</h1><ol>
	<?PHP
    	$q = "SELECT day7change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '1000' order by day7change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day7change_percentage']."%</a></li>";
	}
		?></ol>
  </div>
	<div class="col-sm-3">
    <h1>14 Day</h1><ol>
    <?PHP
    	$q = "SELECT day14change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '1000' order by day14change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day14change_percentage']."%</a></li>";
	}
		?></ol>
  </div>
  <div class="col-sm-3">
    <h1>30 Day</h1><ol>
    <?PHP
    	$q = "SELECT day30change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '1000' order by day30change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day30change_percentage']."%</a></li>";
	}
	  ?></ol>
  </div>
	<div class="col-sm-3">
   <h1>45 Day</h1><ol>
   <?PHP
    	$q = "SELECT day45change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '1000' order by day45change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day45change_percentage']."%</a></li>";
	}
		?></ol>
  </div>
</div>


<h1>Over 100%</h1>
<div class="row">
	<div class="col-sm-3">
    	<h1>7 Day</h1><ol>
	<?PHP
    	$q = "SELECT day7change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '100' and day7change_percentage < '1000'  order by day7change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day7change_percentage']."%</a></li>";
	}
		?></ol>
  </div>
	<div class="col-sm-3">
    <h1>14 Day</h1><ol>
    <?PHP
    	$q = "SELECT day14change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '100' and day14change_percentage < '1000' order by day14change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day14change_percentage']."%</a></li>";
	}
		?></ol>
  </div>
  <div class="col-sm-3">
    <h1>30 Day</h1><ol>
    <?PHP
    	$q = "SELECT day30change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '100' and day30change_percentage < '1000' order by day30change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day30change_percentage']."%</a></li>";
	}
	  ?></ol>
  </div>
	<div class="col-sm-3">
   <h1>45 Day</h1><ol>
   <?PHP
    	$q = "SELECT day45change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '100' and day45change_percentage < '1000' order by day45change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day45change_percentage']."%</a></li>";
	}
		?></ol>
  </div>
</div>

<h1>Over 50%</h1>
<div class="row">
	<div class="col-sm-3">
    	<h1>7 Day</h1><ol>
	<?PHP
    	$q = "SELECT day7change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '50' and day7change_percentage < '100'  order by day7change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day7change_percentage']."%</a></li>";
	}
		?></ol>
  </div>
	<div class="col-sm-3">
    <h1>14 Day</h1><ol>
    <?PHP
    	$q = "SELECT day14change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '50' and day14change_percentage < '100' order by day14change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day14change_percentage']."%</a></li>";
	}
		?></ol>
  </div>
  <div class="col-sm-3">
    <h1>30 Day</h1><ol>
    <?PHP
    	$q = "SELECT day30change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '50' and day30change_percentage < '100' order by day30change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day30change_percentage']."%</a></li>";
	}
	  ?></ol>
  </div>
	<div class="col-sm-3">
   <h1>45 Day</h1><ol>
   <?PHP
    	$q = "SELECT day45change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '50' and day45change_percentage < '100' order by day45change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day45change_percentage']."%</a></li>";
	}
		?></ol>
  </div>
</div>

<h1>Over 20%</h1>
<div class="row">
	<div class="col-sm-3">
    	<h1>7 Day</h1><ol>
	<?PHP
    	$q = "SELECT day7change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '20' and day7change_percentage < '50'  order by day7change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day7change_percentage']."%</a></li>";
	}
		?></ol>
  </div>
	<div class="col-sm-3">
    <h1>14 Day</h1><ol>
    <?PHP
    	$q = "SELECT day14change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '20' and day14change_percentage < '50' order by day14change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day14change_percentage']."%</a></li>";
	}
		?></ol>
  </div>
  <div class="col-sm-3">
    <h1>30 Day</h1><ol>
    <?PHP
    	$q = "SELECT day30change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '20' and day30change_percentage < '50' order by day30change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day30change_percentage']."%</a></li>";
	}
	  ?></ol>
  </div>
	<div class="col-sm-3">
   <h1>45 Day</h1><ol>
   <?PHP
    	$q = "SELECT day45change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '20' and day45change_percentage < '50' order by day45change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day45change_percentage']."%</a></li>";
	}
		?></ol>
  </div>
</div>





<h1>Over 10%</h1>
<div class="row">
	<div class="col-sm-3">
    	<h1>7 Day</h1><ol>
	<?PHP
    	$q = "SELECT day7change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '10' and day7change_percentage < '20' order by day7change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day7change_percentage']."%</a></li>";
	}
		?></ol>
  </div>
	<div class="col-sm-3">
    <h1>14 Day</h1><ol>
    <?PHP
    	$q = "SELECT day14change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '10' and day14change_percentage < '20' order by day14change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day14change_percentage']."%</a></li>";
	}
		?></ol>
  </div>
  <div class="col-sm-3">
    <h1>30 Day</h1><ol>
    <?PHP
    	$q = "SELECT day30change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '10' and day30change_percentage < '20' order by day30change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day30change_percentage']."%</a></li>";
	}
	  ?></ol>
  </div>
	<div class="col-sm-3">
   <h1>45 Day</h1><ol>
   <?PHP
    	$q = "SELECT day45change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '10' and day45change_percentage < '20' order by day45change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day45change_percentage']."%</a></li>";
	}
		?></ol>
  </div>
</div>

<h1>Under 10%</h1>
<div class="row">
	<div class="col-sm-3">
    	<h1>7 Day</h1><ol>
	<?PHP
    	$q = "SELECT day7change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day7change_percentage < '10' order by day7change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day7change_percentage']."%</a></li>";
	}
		?></ol>
  </div>
	<div class="col-sm-3">
    <h1>14 Day</h1><ol>
    <?PHP
    	$q = "SELECT day14change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day14change_percentage < '10' order by day14change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day14change_percentage']."%</a></li>";
	}
		?></ol>
  </div>
  <div class="col-sm-3">
    <h1>30 Day</h1><ol>
    <?PHP
    	$q = "SELECT day30change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day30change_percentage < '10' order by day30change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day30change_percentage']."%</a></li>";
	}
	  ?></ol>
  </div>
	<div class="col-sm-3">
   <h1>45 Day</h1><ol>
   <?PHP
    	$q = "SELECT day45change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day45change_percentage < '10' order by day45change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$zipcode[$d[zip_code]]." ".$d['day45change_percentage']."%</a></li>";
	}
		?></ol>
  </div>
</div>



<?PHP include_once('footer.php'); ?>
