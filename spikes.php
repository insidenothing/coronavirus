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
	height: 10px;
	width: 10px;	
}
.up {
	height: 20px;
	width: 20px;
}	
.down {
	height: 20px;
	width: 20px;
}
.unk_big { 
	height: 40px;
	width: 40px;	
}
.same_big { 
	height: 20px;
	width: 20px;	
}
.up_big {
	height: 40px;
	width: 40px;
}	
.down_big {
	height: 40px;
	width: 40px;
}
</style>
<h1>Maryland COVID 19 Spike Monitor - % Change of Infections</h1>
<?PHP
ob_start();
$counter['same']=0;
$counter['up']=0;
$counter['down']=0;
?>
<div class="row">
	<div class="col-sm-2">
		<div class="days45over1000downmenu"><a>HIDE/SHOW days45over1000down</a></div>
		<div class="days45over1000upmenu"><a>HIDE/SHOW days45over1000up</a></div>
		<div class="days45over1000samemenu"><a>HIDE/SHOW days45over1000same</a></div>
	</div>
	<div class="col-sm-2">
		<div class="days45over100downmenu"><a>HIDE/SHOW days45over100down</a></div>
		<div class="days45over100upmenu"><a>HIDE/SHOW days45over100up</a></div>
		<div class="days45over100samemenu"><a>HIDE/SHOW days45over100same</a></div>
	</div>
	<div class="col-sm-2">
		<div class="days45over50downmenu"><a>HIDE/SHOW days45over50down</a></div>
		<div class="days45over50upmenu"><a>HIDE/SHOW days45over50up</a></div>
		<div class="days45over50samemenu"><a>HIDE/SHOW days45over50same</a></div>
	</div>
	<div class="col-sm-2">
		<div class="days45over20downmenu"><a>HIDE/SHOW days45over20down</a></div>
		<div class="days45over20upmenu"><a>HIDE/SHOW days45over20up</a></div>
		<div class="days45over20samemenu"><a>HIDE/SHOW days45over20same</a></div>
	</div>
	<div class="col-sm-2">
		<div class="days45over10downmenu"><a>HIDE/SHOW days45over10down</a></div>
		<div class="days45over10upmenu"><a>HIDE/SHOW days45over10up</a></div>
		<div class="days45over10samemenu"><a>HIDE/SHOW days45over10same</a></div>
	</div>
	<div class="col-sm-2">
		<div class="days45under10downmenu"><a>HIDE/SHOW days45under10down</a></div>
		<div class="days45under10upmenu"><a>HIDE/SHOW days45under10up</a></div>
		<div class="days45under10samemenu"><a>HIDE/SHOW days45under10same</a></div>
	</div>
</div>
<div class="row">
	<?PHP /*
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
  	</div> */ ?>
	<div class="col-sm-2">
		<h4>7 Day Over 100%</h4><ol>
		<?PHP
//		$q = "SELECT day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '100' and day7change_percentage < '1000'  order by day7change_percentage DESC";
		$q = "SELECT day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where percentage_direction = 'up' and report_date = '$date' and day7change_percentage > '100' order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction]]++;
			$id = 'zip'.$zip.'days7over100';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<h4>7 Day Over 50%</h4><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where percentage_direction = 'up' and report_date = '$date' and day7change_percentage > '50' and day7change_percentage < '100'  order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction]]++;
			$id = 'zip'.$zip.'days7over50';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."% </a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<h4>7 Day Over 30%</h4><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where percentage_direction = 'up' and report_date = '$date' and day7change_percentage > '30' and day7change_percentage < '50'  order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction]]++;
			$id = 'zip'.$zip.'days7over30';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."% </a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<h4>7 Day Over 20%</h4><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where percentage_direction = 'up' and report_date = '$date' and day7change_percentage > '20' and day7change_percentage < '30'  order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction]]++;
			$id = 'zip'.$zip.'days7over20';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<h4>7 Day Over 10%</h4><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where percentage_direction = 'up' and report_date = '$date' and day7change_percentage > '10' and day7change_percentage < '20' order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction]]++;
			$id = 'zip'.$zip.'days7over10';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."% </a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<h4>7 Day Under 10%</h4><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where percentage_direction = 'up' and report_date = '$date' and day7change_percentage > '0' and day7change_percentage < '10' order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$img='';	
			$counter[$d[percentage_direction]]++;
			$id = 'zip'.$zip.'days7under10';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."% </a></li>";
		}
		?></ol>
	 </div>
</div>
<div class="row">
	<?PHP /*
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
  	</div> */ ?>
	<div class="col-sm-2">
		<h4>7 Day Over 100%</h4><ol>
		<?PHP
//		$q = "SELECT day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '100' and day7change_percentage < '1000'  order by day7change_percentage DESC";
		$q = "SELECT day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where percentage_direction <> 'up' and report_date = '$date' and day7change_percentage > '100' order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction]]++;
			$id = 'zip'.$zip.'days7over100';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<h4>7 Day Over 50%</h4><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where percentage_direction <> 'up' and report_date = '$date' and day7change_percentage > '50' and day7change_percentage < '100'  order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction]]++;
			$id = 'zip'.$zip.'days7over50';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."% </a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<h4>7 Day Over 30%</h4><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where percentage_direction <> 'up' and report_date = '$date' and day7change_percentage > '30' and day7change_percentage < '50'  order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction]]++;
			$id = 'zip'.$zip.'days7over30';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."% </a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<h4>7 Day Over 20%</h4><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where percentage_direction <> 'up' and report_date = '$date' and day7change_percentage > '20' and day7change_percentage < '30'  order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction]]++;
			$id = 'zip'.$zip.'days7over20';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<h4>7 Day Over 10%</h4><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where percentage_direction <> 'up' and report_date = '$date' and day7change_percentage > '10' and day7change_percentage < '20' order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction]]++;
			$id = 'zip'.$zip.'days7over10';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."% </a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<h4>7 Day Under 10%</h4><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where percentage_direction <> 'up' and report_date = '$date' and day7change_percentage > '0' and day7change_percentage < '10' order by day7change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$img='';	
			$counter[$d[percentage_direction]]++;
			$id = 'zip'.$zip.'days7under10';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."% </a></li>";
		}
		?></ol>
	 </div>
</div>
<?PHP $row = ob_get_clean(); ?>
<div class="row">
	<div class="col-sm-4" style="text-align:center;"><h3><img src='/img/up.png' class='up_big'>7 Day Increasing: <?PHP echo $counter['up'];?></h3></div>
	<div class="col-sm-4" style="text-align:center;"><h3><img src='/img/same.png' class='same_big'>7 Day No Change: <?PHP echo $counter['same'];?></h3></div>
	<div class="col-sm-4" style="text-align:center;"><h3><img src='/img/down.png' class='down_big'>7 Day Decreasing: <?PHP echo $counter['down'];?></h3></div>
</div>






<?PHP
ob_start();
$counter['same']=0;
$counter['up']=0;
$counter['down']=0;
?>
<div class="row">
	<div class="col-sm-2">
	    <h4>14 Day Over 1000%</h4><ol>
	    <?PHP
		$q = "SELECT day14change_percentage, zip_code, percentage_direction14 FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '1000' order by day14change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction14]]++;
			$id = 'zip'.$zip.'days14over1000';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction14].png' class='$d[percentage_direction14]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day14change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>14 Day Over 100%</h4><ol>
	    <?PHP
		$q = "SELECT day14change_percentage, zip_code, percentage_direction14 FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '100' and day14change_percentage < '1000' order by day14change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction14]]++;
			$id = 'zip'.$zip.'days14over100';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction14].png' class='$d[percentage_direction14]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day14change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>14 Day Over 50%</h4><ol>
	    <?PHP
		$q = "SELECT day14change_percentage, zip_code, percentage_direction14 FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '50' and day14change_percentage < '100' order by day14change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction14]]++;
			$id = 'zip'.$zip.'days14over50';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction14].png' class='$d[percentage_direction14]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day14change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>14 Day Over 20%</h4><ol>
	    <?PHP
		$q = "SELECT day14change_percentage, zip_code, percentage_direction14 FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '20' and day14change_percentage < '50' order by day14change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction14]]++;
			$id = 'zip'.$zip.'days14over20';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction14].png' class='$d[percentage_direction14]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day14change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>14 Day Over 10%</h4><ol>
	    <?PHP
		$q = "SELECT day14change_percentage, zip_code, percentage_direction14 FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '10' and day14change_percentage < '20' order by day14change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction14]]++;
			$id = 'zip'.$zip.'days14over10';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction14].png' class='$d[percentage_direction14]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day14change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>14 Day Under 10%</h4><ol>
	    <?PHP
		$q = "SELECT day14change_percentage, zip_code, percentage_direction14 FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '0' and day14change_percentage < '10' order by day14change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction14]]++;
			$id = 'zip'.$zip.'days14under10';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction14].png' class='$d[percentage_direction14]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day14change_percentage']."%</a></li>";
		}
		?></ol>
 	</div>
</div>	
<?PHP $row2 = ob_get_clean(); ?>
<div class="row">
	<div class="col-sm-4" style="text-align:center;"><h3><img src='/img/up.png' class='up_big'>14 Day Increasing: <?PHP echo $counter['up'];?></h3></div>
	<div class="col-sm-4" style="text-align:center;"><h3><img src='/img/same.png' class='same_big'>14 Day No Change: <?PHP echo $counter['same'];?></h3></div>
	<div class="col-sm-4" style="text-align:center;"><h3><img src='/img/down.png' class='down_big'>14 Day Decreasing: <?PHP echo $counter['down'];?></h3></div>
</div>

<?PHP
ob_start();
$counter['same']=0;
$counter['up']=0;
$counter['down']=0;
?>
<div class="row">	
	<div class="col-sm-2">
	    <h4>30 Day Over 1000%</h4><ol>
	    <?PHP
		$q = "SELECT day30change_percentage, zip_code, percentage_direction30 FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '1000' order by day30change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction30]]++;
			$id = 'zip'.$zip.'days30over1000';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction30].png' class='$d[percentage_direction30]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day30change_percentage']."%</a></li>";
		}
	  ?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>30 Day Over 100%</h4><ol>
	    <?PHP
		$q = "SELECT day30change_percentage, zip_code, percentage_direction30 FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '100' and day30change_percentage < '1000' order by day30change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction30]]++;
			$id = 'zip'.$zip.'days30over100';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction30].png' class='$d[percentage_direction30]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day30change_percentage']."%</a></li>";
		}
	  ?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>30 Day Over 50%</h4><ol>
	    <?PHP
		$q = "SELECT day30change_percentage, zip_code, percentage_direction30 FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '50' and day30change_percentage < '100' order by day30change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction30]]++;
			$id = 'zip'.$zip.'days30over50';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction30].png' class='$d[percentage_direction30]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day30change_percentage']."%</a></li>";
		}
	  ?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>30 Day Over 20%</h4><ol>
	    <?PHP
		$q = "SELECT day30change_percentage, zip_code, percentage_direction30 FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '20' and day30change_percentage < '50' order by day30change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction30]]++;
			$id = 'zip'.$zip.'days30over30';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction30].png' class='$d[percentage_direction30]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day30change_percentage']."%</a></li>";
		}
	  ?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>30 Day Over 10%</h4><ol>
	    <?PHP
		$q = "SELECT day30change_percentage, zip_code, percentage_direction30 FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '10' and day30change_percentage < '20' order by day30change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction30]]++;
			$id = 'zip'.$zip.'days30over10';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction30].png' class='$d[percentage_direction30]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day30change_percentage']."%</a></li>";
		}
	  ?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>30 Day Under 10%</h4><ol>
	    <?PHP
		$q = "SELECT day30change_percentage, zip_code, percentage_direction30 FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '0' and day30change_percentage < '10' order by day30change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction30]]++;
			$id = 'zip'.$zip.'days30under10';
			echo "<li id='$id' name='$id'><img src='/img/$d[percentage_direction30].png' class='$d[percentage_direction30]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day30change_percentage']."%</a></li>";
		}
	  ?></ol>
 	 </div>
</div>	
<?PHP $row3 = ob_get_clean(); ?>
<div class="row">
	<div class="col-sm-4" style="text-align:center;"><h3><img src='/img/up.png' class='up_big'>30 Day Increasing: <?PHP echo $counter['up'];?></h3></div>
	<div class="col-sm-4" style="text-align:center;"><h3><img src='/img/same.png' class='same_big'>30 Day No Change: <?PHP echo $counter['same'];?></h3></div>
	<div class="col-sm-4" style="text-align:center;"><h3><img src='/img/down.png' class='down_big'>30 Day Decreasing: <?PHP echo $counter['down'];?></h3></div>
</div>
<?PHP
ob_start();
$counter['same']=0;
$counter['up']=0;
$counter['down']=0;
?>
<div class="row">
	<div class="col-sm-2">
	   <h4>45 Day Over 1000%</h4><ol>
	   <?PHP
		$q = "SELECT day45change_percentage, zip_code, percentage_direction45 FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '1000' order by day45change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction45]]++;
			$id = 'zip'.$zip.'days45over1000';
			$class = 'days45over1000'.$d['percentage_direction45'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction45].png' class='$d[percentage_direction45]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day45change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	   <h4>45 Day Over 100%</h4><ol>
	   <?PHP
		$q = "SELECT day45change_percentage, zip_code, percentage_direction45 FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '100' and day45change_percentage < '1000' order by day45change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction45]]++;
			$id = 'zip'.$zip.'days45over100';
			$class = 'days45over100'.$d['percentage_direction45'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction45].png' class='$d[percentage_direction45]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day45change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	   <h4>45 Day Over 50%</h4><ol>
	   <?PHP
		$q = "SELECT day45change_percentage, zip_code, percentage_direction45 FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '50' and day45change_percentage < '100' order by day45change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction45]]++;
			$id = 'zip'.$zip.'days45over50';
			$class = 'days45over50'.$d['percentage_direction45'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction45].png' class='$d[percentage_direction45]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day45change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	   <h4>45 Day Over 20%</h4><ol>
	   <?PHP
		$q = "SELECT day45change_percentage, zip_code, percentage_direction45 FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '20' and day45change_percentage < '50' order by day45change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction45]]++;
			$id = 'zip'.$zip.'days45over20';
			$class = 'days45over20'.$d['percentage_direction45'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction45].png' class='$d[percentage_direction45]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day45change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	   <h4>45 Day Over 10%</h4><ol>
	   <?PHP
		$q = "SELECT day45change_percentage, zip_code, percentage_direction45 FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '10' and day45change_percentage < '20' order by day45change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction45]]++;
			$id = 'zip'.$zip.'days45over10';
			$class = 'days45over10'.$d['percentage_direction45'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction45].png' class='$d[percentage_direction45]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day45change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	   <h4>45 Day Under 10%</h4><ol>
	   <?PHP
		$q = "SELECT day45change_percentage, zip_code, percentage_direction45 FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '0' and day45change_percentage < '10' order by day45change_percentage DESC";
		$r = $core->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction45]]++;
			$id = 'zip'.$zip.'days45under10';
			$class = 'days45under10'.$d['percentage_direction45'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction45].png' class='$d[percentage_direction45]'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day45change_percentage']."%</a></li>";
		}
		?></ol>
  	</div>
</div>
<?PHP $row4 = ob_get_clean(); ?>
<div class="row">
	<div class="col-sm-4" style="text-align:center;"><h3><img src='/img/up.png' class='up_big'>45 Day Increasing: <?PHP echo $counter['up'];?> [hide]</h3></div>
	<div class="col-sm-4" style="text-align:center;"><h3><img src='/img/same.png' class='same_big'>45 Day No Change: <?PHP echo $counter['same'];?></h3></div>
	<div class="col-sm-4" style="text-align:center;"><h3><img src='/img/down.png' class='down_big'>45 Day Decreasing: <?PHP echo $counter['down'];?></h3></div>
</div>
<?PHP echo $row; ?>
<?PHP echo $row2; ?>
<?PHP echo $row3; ?>	
<?PHP echo $row4; ?>


<script>
$(function() {
    $('.days45over1000downmenu').click(function() {
        var display=$('.days45over1000down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days45over1000down').css('display', display);
    });
    $('.days45over1000samemenu').click(function() {
        var display=$('.days45over1000same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days45over1000same').css('display', display);
    });
    $('.days45over1000upmenu').click(function() {
        var display=$('.days45over1000up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days45over1000up').css('display', display);
    });
    $('.days45over100downmenu').click(function() {
        var display=$('.days45over100down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days45over100down').css('display', display);
    });
    $('.days45over100samemenu').click(function() {
        var display=$('.days45over100same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days45over100same').css('display', display);
    });
    $('.days45over100upmenu').click(function() {
        var display=$('.days45over100up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days45over100up').css('display', display);
    });
    $('.days45over50downmenu').click(function() {
        var display=$('.days45over50down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days45over50down').css('display', display);
    });
    $('.days45over50samemenu').click(function() {
        var display=$('.days45over50same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days45over50same').css('display', display);
    });
    $('.days45over50upmenu').click(function() {
        var display=$('.days45over50up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days45over50up').css('display', display);
    });
    $('.days45over20downmenu').click(function() {
        var display=$('.days45over20down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days45over20down').css('display', display);
    });
    $('.days45over20samemenu').click(function() {
        var display=$('.days45over20same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days45over20same').css('display', display);
    });
    $('.days45over20upmenu').click(function() {
        var display=$('.days45over20up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days45over20up').css('display', display);
    });
    $('.days45over10downmenu').click(function() {
        var display=$('.days45over10down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days45over10down').css('display', display);
    });
    $('.days45over10samemenu').click(function() {
        var display=$('.days45over10same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days45over10same').css('display', display);
    });
    $('.days45over10upmenu').click(function() {
        var display=$('.days45over10up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days45over10up').css('display', display);
    });
		$('.days45under10downmenu').click(function() {
        var display=$('.days45under10down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days45under10down').css('display', display);
    });
    $('.days45under10samemenu').click(function() {
        var display=$('.days45under10same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days45under10same').css('display', display);
    });
    $('.days45under10upmenu').click(function() {
        var display=$('.days45under10up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days45under10up').css('display', display);
    });

});
</script>
<style>
.days45over1000down  	{ display: block; }   
.days45over1000same  	{ display: block; }  
.days45over1000up  	{ display: block; } 
.days45over100down  	{ display: block; }   
.days45over100same  	{ display: block; }  
.days45over100up  	{ display: block; } 
.days45over50down  	{ display: block; }   
.days45over50same  	{ display: block; }  
.days45over50up  	{ display: block; } 
.days45over20down  	{ display: block; }   
.days45over20same  	{ display: block; }  
.days45over20up  	{ display: block; } 
.days45over20down  	{ display: block; }   
.days45over20same  	{ display: block; }  
.days45over20up  	{ display: block; } 
.days45over10down  	{ display: block; }   
.days45over10same  	{ display: block; }  
.days45over10up  	{ display: block; }
.days45under10down  	{ display: block; }   
.days45under10same  	{ display: block; }  
.days45under10up  	{ display: block; } 
</style>


<?PHP include_once('footer.php'); ?>
