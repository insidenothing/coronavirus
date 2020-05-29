<?PHP
$page_description = "Maryland COVID 19 Spike Monitor";
include_once('menu.php');
$date = date('Y-m-d');
?>
<div class="row">
	<div class="col-sm-3">
    	<h1>7 Day</h1><ol>
	<?PHP
    	$q = "SELECT day7change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day7change_percentage <> '' order by day7change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$d['day7change_percentage']."%</a></li>";
	}
		?></ol>
  </div>
	<div class="col-sm-3">
    <h1>14 Day</h1><ol>
    <?PHP
    	$q = "SELECT day14change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day14change_percentage <> '' order by day7change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$d['day14change_percentage']."%</a></li>";
	}
		?></ol>
  </div>
  <div class="col-sm-3">
    <h1>30 Day</h1><ol>
    <?PHP
    	$q = "SELECT day30change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day30change_percentage <> '' order by day7change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$d['day30change_percentage']."%</a></li>";
	}
	  ?></ol>
  </div>
	<div class="col-sm-3">
   <h1>45 Day</h1><ol>
   <?PHP
    	$q = "SELECT day45change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day45change_percentage <> '' order by day7change_percentage DESC";
	$r = $core->query($q);
	while ($d = mysqli_fetch_array($r)){
		echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." ".$d['day45change_percentage']."%</a></li>";
	}
		?></ol>
  </div>
</div>
<?PHP include_once('footer.php'); ?>
