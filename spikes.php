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
if(isset($_GET['reset'])){
 	$core->query("update coronavirus_zip set change_percentage_time = '00:00:00' where report_date = '$date' ");	
}
?>
<style>
.unk { 
	height: 20px;
	width: 20px;	
}
.same { 
	height: 15px;
	width: 15px;	
}
.up {
	height: 20px;
	width: 20px;
}	
.down {
	height: 20px;
	width: 20px;
}	
</style>
<div class="row">
	<div class="col-sm-2">
		<h4>7 Day Over 1000%</h4><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '1000' order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			echo "<li><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<h4>7 Day Over 100%</h4><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '100' and day7change_percentage < '1000'  order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			echo "<li><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<h4>7 Day Over 50%</h4><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '50' and day7change_percentage < '100'  order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			echo "<li><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."% </a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<h4>7 Day Over 20%</h4><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '20' and day7change_percentage < '50'  order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			echo "<li><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<h4>7 Day Over 10%</h4><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '10' and day7change_percentage < '20' order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			
			echo "<li><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."% </a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<h4>7 Day Under 10%</h4><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '0' and day7change_percentage < '10' order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$img='';	
			if($d['percentage_direction'] == 'down'){
				$img='<img height="20" width="20" src="img/green_down.png">';	
			}elseif($d['percentage_direction'] == 'up'){
				$img='<img height="20" width="20" src="img/red_up.png">';	
			}
			echo "<li><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."% </a></li>";
		}
		?></ol>
	 </div>
</div>

<div class="row">
	<div class="col-sm-2">
	    <h4>14 Day Over 1000%</h4><ol>
	    <?PHP
		$q = "SELECT day14change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '1000' order by day14change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day14change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>14 Day Over 100%</h4><ol>
	    <?PHP
		$q = "SELECT day14change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '100' and day14change_percentage < '1000' order by day14change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day14change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>14 Day Over 50%</h4><ol>
	    <?PHP
		$q = "SELECT day14change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '50' and day14change_percentage < '100' order by day14change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day14change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>14 Day Over 20%</h4><ol>
	    <?PHP
		$q = "SELECT day14change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '20' and day14change_percentage < '50' order by day14change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day14change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>14 Day Over 10%</h4><ol>
	    <?PHP
		$q = "SELECT day14change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '10' and day14change_percentage < '20' order by day14change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day14change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>14 Day Under 10%</h4><ol>
	    <?PHP
		$q = "SELECT day14change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '0' and day14change_percentage < '10' order by day14change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day14change_percentage']."%</a></li>";
		}
		?></ol>
 	</div>
</div>	
	
<div class="row">	
	<div class="col-sm-2">
	    <h4>30 Day Over 1000%</h4><ol>
	    <?PHP
		$q = "SELECT day30change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '1000' order by day30change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day30change_percentage']."%</a></li>";
		}
	  ?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>30 Day Over 100%</h4><ol>
	    <?PHP
		$q = "SELECT day30change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '100' and day30change_percentage < '1000' order by day30change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day30change_percentage']."%</a></li>";
		}
	  ?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>30 Day Over 50%</h4><ol>
	    <?PHP
		$q = "SELECT day30change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '50' and day30change_percentage < '100' order by day30change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day30change_percentage']."%</a></li>";
		}
	  ?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>30 Day Over 20%</h4><ol>
	    <?PHP
		$q = "SELECT day30change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '20' and day30change_percentage < '50' order by day30change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day30change_percentage']."%</a></li>";
		}
	  ?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>30 Day Over 10%</h4><ol>
	    <?PHP
		$q = "SELECT day30change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '10' and day30change_percentage < '20' order by day30change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day30change_percentage']."%</a></li>";
		}
	  ?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>30 Day Under 10%</h4><ol>
	    <?PHP
		$q = "SELECT day30change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '0' and day30change_percentage < '10' order by day30change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day30change_percentage']."%</a></li>";
		}
	  ?></ol>
 	 </div>
</div>	
	
	
<div class="row">
	<div class="col-sm-2">
	   <h4>45 Day Over 1000%</h4><ol>
	   <?PHP
		$q = "SELECT day45change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '1000' order by day45change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day45change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	   <h4>45 Day Over 100%</h4><ol>
	   <?PHP
		$q = "SELECT day45change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '100' and day45change_percentage < '1000' order by day45change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day45change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	   <h4>45 Day Over 50%</h4><ol>
	   <?PHP
		$q = "SELECT day45change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '50' and day45change_percentage < '100' order by day45change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day45change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	   <h4>45 Day Over 20%</h4><ol>
	   <?PHP
		$q = "SELECT day45change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '20' and day45change_percentage < '50' order by day45change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day45change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	   <h4>45 Day Over 10%</h4><ol>
	   <?PHP
		$q = "SELECT day45change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '10' and day45change_percentage < '20' order by day45change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day45change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	   <h4>45 Day Under 10%</h4><ol>
	   <?PHP
		$q = "SELECT day45change_percentage, zip_code FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '0' and day45change_percentage < '10' order by day45change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			echo "<li><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day45change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
</div>

<?PHP include_once('footer.php'); ?>
