<?PHP
$state = 'Virginia';
$page_description = ucwords($state)." COVID 19 Spike Monitor";
include_once('../menu.php');
global $zipcode;
global $global_date;
$zipcode = array();
$q = "select distinct zip_code, town_name from coronavirus_zip where town_name <> ''";
$r = $covid_db->query($q);
while($d = mysqli_fetch_array($r)){
	$zip = $d['zip_code'];
	$zipcode[$zip] = $d['town_name'];
}
$date = $global_date;
if(isset($_GET['zip']) && isset($_GET['name'])){
	$add_zip = $_GET['zip'];
	$new_name = $_GET['name'];
 	$covid_db->query("update coronavirus_zip set town_name = '$new_name' where zip_code = '$add_zip' and report_date = '$date' ");	
}
if(isset($_GET['reset'])){
 	$covid_db->query("update coronavirus_zip set change_percentage_time = '00:00:00' where report_date = '$date' ");	
}
?>
<style>
.unk { 
	height: 20px;
	width: 20px;	
}
.samedir { 
	height: 10px;
	width: 10px;	
}
.updir {
	height: 20px;
	width: 20px;
}	
.downdir {
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
	li{
		white-space:pre;
	}
</style>
<h1><?PHP echo ucwords($state);?> COVID 19 Spike Monitor - % Change of Infections</h1>
<?PHP
ob_start();
$counter['same']=0;
$counter['up']=0;
$counter['down']=0;
?>



<div class="row">
	<?PHP /*
	<div class="col-sm-2">
		<h4>7 Day Over 1000%</h4><ol>
		<?PHP
		$q = "SELECT day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '1000' and state_name = '$state' order by day7change_percentage DESC";
		$r = $covid_db->query($q);
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
//		$q = "SELECT day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '100' and day7change_percentage < '1000' and state_name = '$state' order by day7change_percentage DESC";
		$q = "SELECT report_count, day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '100' order by day7change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction]]++;
			$id = 'zip'.$zip.'days7over100';
			$class = 'days7over100'.$d['percentage_direction'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."% to ".$d['report_count']."</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<h4>7 Day Over 50%</h4><ol>
		<?PHP
		$q = "SELECT report_count, day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '50' and day7change_percentage < '100' and state_name = '$state'  order by day7change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction]]++;
			$id = 'zip'.$zip.'days7over50';
			$class = 'days7over50'.$d['percentage_direction'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."% to ".$d['report_count']."</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<h4>7 Day Over 30%</h4><ol>
		<?PHP
		$q = "SELECT report_count, day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '30' and day7change_percentage < '50' and state_name = '$state'  order by day7change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction]]++;
			$id = 'zip'.$zip.'days7over30';
			$class = 'days7over30'.$d['percentage_direction'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."% to ".$d['report_count']."</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<h4>7 Day Over 20%</h4><ol>
		<?PHP
		$q = "SELECT report_count, day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '20' and day7change_percentage < '30' and state_name = '$state'  order by day7change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction]]++;
			$id = 'zip'.$zip.'days7over20';
			$class = 'days7over20'.$d['percentage_direction'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."% to ".$d['report_count']."</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<h4>7 Day Over 10%</h4><ol>
		<?PHP
		$q = "SELECT report_count, day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '10' and day7change_percentage < '20' and state_name = '$state' order by day7change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction]]++;
			$id = 'zip'.$zip.'days7over10';
			$class = 'days7over10'.$d['percentage_direction'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."% to ".$d['report_count']."</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
		<h4>7 Day Under 10%</h4><ol>
		<?PHP
		$q = "SELECT report_count, day7change_percentage, zip_code, percentage_direction FROM coronavirus_zip where report_date = '$date' and day7change_percentage > '0' and day7change_percentage < '10' and state_name = '$state' order by day7change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$img='';	
			$counter[$d[percentage_direction]]++;
			$id = 'zip'.$zip.'days7under10';
			$class = 'days7under10'.$d['percentage_direction'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction].png' class='$d[percentage_direction]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day7change_percentage']."% to ".$d['report_count']."</a></li>";
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
		$q = "SELECT report_count, day14change_percentage, zip_code, percentage_direction14 FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '1000' and state_name = '$state' order by day14change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction14]]++;
			$id = 'zip'.$zip.'days14over1000';
			$class = 'days14over1000'.$d['percentage_direction14'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction14].png' class='$d[percentage_direction14]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day14change_percentage']."% to ".$d['report_count']."</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>14 Day Over 100%</h4><ol>
	    <?PHP
		$q = "SELECT report_count, day14change_percentage, zip_code, percentage_direction14 FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '100' and day14change_percentage < '1000' and state_name = '$state' order by day14change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction14]]++;
			$id = 'zip'.$zip.'days14over100';
			$class = 'days14over100'.$d['percentage_direction14'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction14].png' class='$d[percentage_direction14]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day14change_percentage']."% to ".$d['report_count']."</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>14 Day Over 50%</h4><ol>
	    <?PHP
		$q = "SELECT report_count, day14change_percentage, zip_code, percentage_direction14 FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '50' and day14change_percentage < '100' and state_name = '$state' order by day14change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction14]]++;
			$id = 'zip'.$zip.'days14over50';
			$class = 'days14over50'.$d['percentage_direction14'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction14].png' class='$d[percentage_direction14]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day14change_percentage']."% to ".$d['report_count']."</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>14 Day Over 20%</h4><ol>
	    <?PHP
		$q = "SELECT report_count, day14change_percentage, zip_code, percentage_direction14 FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '20' and day14change_percentage < '50' and state_name = '$state' order by day14change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction14]]++;
			$id = 'zip'.$zip.'days14over20';
			$class = 'days14over20'.$d['percentage_direction14'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction14].png' class='$d[percentage_direction14]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day14change_percentage']."% to ".$d['report_count']."</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>14 Day Over 10%</h4><ol>
	    <?PHP
		$q = "SELECT report_count, day14change_percentage, zip_code, percentage_direction14 FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '10' and day14change_percentage < '20' and state_name = '$state' order by day14change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction14]]++;
			$id = 'zip'.$zip.'days14over10';
			$class = 'days14over10'.$d['percentage_direction14'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction14].png' class='$d[percentage_direction14]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day14change_percentage']."% to ".$d['report_count']."</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>14 Day Under 10%</h4><ol>
	    <?PHP
		$q = "SELECT report_count, day14change_percentage, zip_code, percentage_direction14 FROM coronavirus_zip where report_date = '$date' and day14change_percentage > '0' and day14change_percentage < '10' and state_name = '$state' order by day14change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction14]]++;
			$id = 'zip'.$zip.'days14under10';
			$class = 'days14under10'.$d['percentage_direction14'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction14].png' class='$d[percentage_direction14]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day14change_percentage']."% to ".$d['report_count']."</a></li>";
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
		$q = "SELECT report_count, day30change_percentage, zip_code, percentage_direction30 FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '1000' and state_name = '$state' order by day30change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction30]]++;
			$id = 'zip'.$zip.'days30over1000';
			$class = 'days30over1000'.$d['percentage_direction30'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction30].png' class='$d[percentage_direction30]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day30change_percentage']."% to ".$d['report_count']."</a></li>";
		}
	  ?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>30 Day Over 100%</h4><ol>
	    <?PHP
		$q = "SELECT report_count, day30change_percentage, zip_code, percentage_direction30 FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '100' and day30change_percentage < '1000' and state_name = '$state' order by day30change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction30]]++;
			$id = 'zip'.$zip.'days30over100';
			$class = 'days30over100'.$d['percentage_direction30'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction30].png' class='$d[percentage_direction30]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day30change_percentage']."% to ".$d['report_count']."</a></li>";
		}
	  ?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>30 Day Over 50%</h4><ol>
	    <?PHP
		$q = "SELECT report_count, day30change_percentage, zip_code, percentage_direction30 FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '50' and day30change_percentage < '100' and state_name = '$state' order by day30change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction30]]++;
			$id = 'zip'.$zip.'days30over50';
			$class = 'days30over50'.$d['percentage_direction30'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction30].png' class='$d[percentage_direction30]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day30change_percentage']."% to ".$d['report_count']."</a></li>";
		}
	  ?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>30 Day Over 20%</h4><ol>
	    <?PHP
		$q = "SELECT report_count, day30change_percentage, zip_code, percentage_direction30 FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '20' and day30change_percentage < '50' and state_name = '$state' order by day30change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction30]]++;
			$id = 'zip'.$zip.'days30over30';
			$class = 'days30over20'.$d['percentage_direction30'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction30].png' class='$d[percentage_direction30]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day30change_percentage']."% to ".$d['report_count']."</a></li>";
		}
	  ?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>30 Day Over 10%</h4><ol>
	    <?PHP
		$q = "SELECT report_count, day30change_percentage, zip_code, percentage_direction30 FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '10' and day30change_percentage < '20' and state_name = '$state' order by day30change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction30]]++;
			$id = 'zip'.$zip.'days30over10';
			$class = 'days30over10'.$d['percentage_direction30'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction30].png' class='$d[percentage_direction30]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day30change_percentage']."% to ".$d['report_count']."</a></li>";
		}
	  ?></ol>
  	</div>
	<div class="col-sm-2">
	    <h4>30 Day Under 10%</h4><ol>
	    <?PHP
		$q = "SELECT report_count, day30change_percentage, zip_code, percentage_direction30 FROM coronavirus_zip where report_date = '$date' and day30change_percentage > '0' and day30change_percentage < '10' and state_name = '$state' order by day30change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction30]]++;
			$id = 'zip'.$zip.'days30under10';
			$class = 'days30under10'.$d['percentage_direction30'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction30].png' class='$d[percentage_direction30]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day30change_percentage']."% to ".$d['report_count']."</a></li>";
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
		$q = "SELECT report_count, day45change_percentage, zip_code, percentage_direction45 FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '1000' and state_name = '$state' order by day45change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction45]]++;
			$id = 'zip'.$zip.'days45over1000';
			$class = 'days45over1000'.$d['percentage_direction45'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction45].png' class='$d[percentage_direction45]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day45change_percentage']."% to ".$d['report_count']."</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	   <h4>45 Day Over 100%</h4><ol>
	   <?PHP
		$q = "SELECT report_count, day45change_percentage, zip_code, percentage_direction45 FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '100' and day45change_percentage < '1000' and state_name = '$state' order by day45change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction45]]++;
			$id = 'zip'.$zip.'days45over100';
			$class = 'days45over100'.$d['percentage_direction45'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction45].png' class='$d[percentage_direction45]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day45change_percentage']."% to ".$d['report_count']."</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	   <h4>45 Day Over 50%</h4><ol>
	   <?PHP
		$q = "SELECT report_count, day45change_percentage, zip_code, percentage_direction45 FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '50' and day45change_percentage < '100' and state_name = '$state' order by day45change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction45]]++;
			$id = 'zip'.$zip.'days45over50';
			$class = 'days45over50'.$d['percentage_direction45'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction45].png' class='$d[percentage_direction45]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day45change_percentage']."% to ".$d['report_count']."</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	   <h4>45 Day Over 20%</h4><ol>
	   <?PHP
		$q = "SELECT report_count, day45change_percentage, zip_code, percentage_direction45 FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '20' and day45change_percentage < '50' and state_name = '$state' order by day45change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction45]]++;
			$id = 'zip'.$zip.'days45over20';
			$class = 'days45over20'.$d['percentage_direction45'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction45].png' class='$d[percentage_direction45]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day45change_percentage']."% to ".$d['report_count']."</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	   <h4>45 Day Over 10%</h4><ol>
	   <?PHP
		$q = "SELECT report_count, day45change_percentage, zip_code, percentage_direction45 FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '10' and day45change_percentage < '20' and state_name = '$state' order by day45change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction45]]++;
			$id = 'zip'.$zip.'days45over10';
			$class = 'days45over10'.$d['percentage_direction45'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction45].png' class='$d[percentage_direction45]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day45change_percentage']."% to ".$d['report_count']."</a></li>";
		}
		?></ol>
  	</div>
	<div class="col-sm-2">
	   <h4>45 Day Under 10%</h4><ol>
	   <?PHP
		$q = "SELECT report_count, day45change_percentage, zip_code, percentage_direction45 FROM coronavirus_zip where report_date = '$date' and day45change_percentage > '0' and day45change_percentage < '10' and state_name = '$state' order by day45change_percentage DESC";
		$r = $covid_db->query($q);
		while ($d = mysqli_fetch_array($r)){
			$zip_c = $d['zip_code'];
			$name = $zipcode[$zip_c];
			$counter[$d[percentage_direction45]]++;
			$id = 'zip'.$zip.'days45under10';
			$class = 'days45under10'.$d['percentage_direction45'];
			echo "<li id='$id' name='$id' class='$class'><img src='/img/$d[percentage_direction45].png' class='$d[percentage_direction45]dir'><a href='zipcode.php?zip=".$d['zip_code']."'>".$d['zip_code']." $name ".$d['day45change_percentage']."% to ".$d['report_count']."</a></li>";
		}
		?></ol>
  	</div>
</div>
<?PHP $row4 = ob_get_clean(); ?>
<div class="row">
	<div class="col-sm-4" style="text-align:center;"><h3><img src='/img/up.png' class='up_big'>45 Day Increasing: <?PHP echo $counter['up'];?></h3></div>
	<div class="col-sm-4" style="text-align:center;"><h3><img src='/img/same.png' class='same_big'>45 Day No Change: <?PHP echo $counter['same'];?></h3></div>
	<div class="col-sm-4" style="text-align:center;"><h3><img src='/img/down.png' class='down_big'>45 Day Decreasing: <?PHP echo $counter['down'];?></h3></div>
</div>





<div class="row">
	<div class="col-sm-12">Use the following Buttons to HIDE/SHOW data below. 
		<button class="allon">show all</button> 
		<button class="alloff">hide all</button> 
		<button class="downmenu btn-success">down</button> 
		<button class="upmenu btn-danger">up</button> 
		<button class="samemenu btn-info">same</button>
		<button class="menuA">1000</button>
		<button class="menuB">100</button>
		<button class="menuC">50</button>
		<button class="menuD">30</button>
		<button class="menuE">20</button>
		<button class="menuF">10</button>
		<button class="menuG">0</button>
	</div>
</div>
<div class="row">
	<div class="col-sm-2">
		<button class="days7over100downmenu btn-success">days7over100down</button>
		<button class="days7over100upmenu btn-danger">days7over100up</button>
		<button class="days7over100samemenu btn-info">days7over100same</button>
	</div>
	<div class="col-sm-2">
		<button class="days7over50downmenu btn-success">days7over50down</button>
		<button class="days7over50upmenu btn-danger">days7over50up</button>
		<button class="days7over50samemenu btn-info">days7over50same</button>
	</div>
	<div class="col-sm-2">
		<button class="days7over30downmenu btn-success">days7over30down</button>
		<button class="days7over30upmenu btn-danger">days7over30up</button>
		<button class="days7over30samemenu btn-info">days7over30same</button>
	</div>
	<div class="col-sm-2">
		<button class="days7over20downmenu btn-success">days7over20down</button>
		<button class="days7over20upmenu btn-danger">days7over20up</button>
		<button class="days7over20samemenu btn-info">days7over20same</button>
	</div>
	<div class="col-sm-2">
		<button class="days7over10downmenu btn-success">days7over10down</button>
		<button class="days7over10upmenu btn-danger">days7over10up</button>
		<button class="days7over10samemenu btn-info">days7over10same</button>
	</div>
	<div class="col-sm-2">
		<button class="days7under10downmenu btn-success">days7under10down</button>
		<button class="days7under10upmenu btn-danger">days7under10up</button>
		<button class="days7under10samemenu btn-info">days7under10same</button>
	</div>
</div>
<?PHP echo $row; ?>
<div class="row">
	<div class="col-sm-2">
		<button class="days14over1000downmenu btn-success">days14over1000down</button>
		<button class="days14over1000upmenu btn-danger">days14over1000up</button>
		<button class="days14over1000samemenu btn-info">days14over1000same</button>
	</div>
	<div class="col-sm-2">
		<button class="days14over100downmenu btn-success">days14over100down</button>
		<button class="days14over100upmenu btn-danger">days14over100up</button>
		<button class="days14over100samemenu btn-info">days14over100same</button>
	</div>
	<div class="col-sm-2">
		<button class="days14over50downmenu btn-success">days14over50down</button>
		<button class="days14over50upmenu btn-danger">days14over50up</button>
		<button class="days14over50samemenu btn-info">days14over50same</button>
	</div>
	<div class="col-sm-2">
		<button class="days14over20downmenu btn-success">days14over20down</button>
		<button class="days14over20upmenu btn-danger">days14over20up</button>
		<button class="days14over20samemenu btn-info">days14over20same</button>
	</div>
	<div class="col-sm-2">
		<button class="days14over10downmenu btn-success">days14over10down</button>
		<button class="days14over10upmenu btn-danger">days14over10up</button>
		<button class="days14over10samemenu btn-info">days14over10same</button>
	</div>
	<div class="col-sm-2">
		<button class="days14under10downmenu btn-success">days14under10down</button>
		<button class="days14under10upmenu btn-danger">days14under10up</button>
		<button class="days14under10samemenu btn-info">days14under10same</button>
	</div>
</div>
<?PHP echo $row2; ?>
<div class="row">
	<div class="col-sm-2">
		<button class="days30over1000downmenu btn-success">days30over1000down</button>
		<button class="days30over1000upmenu btn-danger">days30over1000up</button>
		<button class="days30over1000samemenu btn-info">days30over1000same</button>
	</div>
	<div class="col-sm-2">
		<button class="days30over100downmenu btn-success">days30over100down</button>
		<button class="days30over100upmenu btn-danger">days30over100up</button>
		<button class="days30over100samemenu btn-info">days30over100same</button>
	</div>
	<div class="col-sm-2">
		<button class="days30over50downmenu btn-success">days30over50down</button>
		<button class="days30over50upmenu btn-danger">days30over50up</button>
		<button class="days30over50samemenu btn-info">days30over50same</button>
	</div>
	<div class="col-sm-2">
		<button class="days30over20downmenu btn-success">days30over20down</button>
		<button class="days30over20upmenu btn-danger">days30over20up</button>
		<button class="days30over20samemenu btn-info">days30over20same</button>
	</div>
	<div class="col-sm-2">
		<button class="days30over10downmenu btn-success">days30over10down</button>
		<button class="days30over10upmenu btn-danger">days30over10up</button>
		<button class="days30over10samemenu btn-info">days30over10same</button>
	</div>
	<div class="col-sm-2">
		<button class="days30under10downmenu btn-success">days30under10down</button>
		<button class="days30under10upmenu btn-danger">days30under10up</button>
		<button class="days30under10samemenu btn-info">days30under10same</button>
	</div>
</div>
<?PHP echo $row3; ?>	
<div class="row">
	<div class="col-sm-2">
		<button class="days45over1000downmenu btn-success">days45over1000down</button>
		<button class="days45over1000upmenu btn-danger">days45over1000up</button>
		<button class="days45over1000samemenu btn-info">days45over1000same</button>
	</div>
	<div class="col-sm-2">
		<button class="days45over100downmenu btn-success">days45over100down</button>
		<button class="days45over100upmenu btn-danger">days45over100up</button>
		<button class="days45over100samemenu btn-info">days45over100same</button>
	</div>
	<div class="col-sm-2">
		<button class="days45over50downmenu btn-success">days45over50down</button>
		<button class="days45over50upmenu btn-danger">days45over50up</button>
		<button class="days45over50samemenu btn-info">days45over50same</button>
	</div>
	<div class="col-sm-2">
		<button class="days45over20downmenu btn-success">days45over20down</button>
		<button class="days45over20upmenu btn-danger">days45over20up</button>
		<button class="days45over20samemenu btn-info">days45over20same</button>
	</div>
	<div class="col-sm-2">
		<button class="days45over10downmenu btn-success">days45over10down</button>
		<button class="days45over10upmenu btn-danger">days45over10up</button>
		<button class="days45over10samemenu btn-info">days45over10same</button>
	</div>
	<div class="col-sm-2">
		<button class="days45under10downmenu btn-success">days45under10down</button>
		<button class="days45under10upmenu btn-danger">days45under10up</button>
		<button class="days45under10samemenu btn-info">days45under10same</button>
	</div>
</div>
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

	
    $('.days30over1000downmenu').click(function() {
        var display=$('.days30over1000down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days30over1000down').css('display', display);
    });
    $('.days30over1000samemenu').click(function() {
        var display=$('.days30over1000same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days30over1000same').css('display', display);
    });
    $('.days30over1000upmenu').click(function() {
        var display=$('.days30over1000up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days30over1000up').css('display', display);
    });
    $('.days30over100downmenu').click(function() {
        var display=$('.days30over100down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days30over100down').css('display', display);
    });
    $('.days30over100samemenu').click(function() {
        var display=$('.days30over100same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days30over100same').css('display', display);
    });
    $('.days30over100upmenu').click(function() {
        var display=$('.days30over100up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days30over100up').css('display', display);
    });
    $('.days30over50downmenu').click(function() {
        var display=$('.days30over50down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days30over50down').css('display', display);
    });
    $('.days30over50samemenu').click(function() {
        var display=$('.days30over50same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days30over50same').css('display', display);
    });
    $('.days30over50upmenu').click(function() {
        var display=$('.days30over50up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days30over50up').css('display', display);
    });
    $('.days30over20downmenu').click(function() {
        var display=$('.days30over20down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days30over20down').css('display', display);
    });
    $('.days30over20samemenu').click(function() {
        var display=$('.days30over20same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days30over20same').css('display', display);
    });
    $('.days30over20upmenu').click(function() {
        var display=$('.days30over20up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days30over20up').css('display', display);
    });
    $('.days30over10downmenu').click(function() {
        var display=$('.days30over10down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days30over10down').css('display', display);
    });
    $('.days30over10samemenu').click(function() {
        var display=$('.days30over10same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days30over10same').css('display', display);
    });
    $('.days30over10upmenu').click(function() {
        var display=$('.days30over10up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days30over10up').css('display', display);
    });
		$('.days30under10downmenu').click(function() {
        var display=$('.days30under10down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days30under10down').css('display', display);
    });
    $('.days30under10samemenu').click(function() {
        var display=$('.days30under10same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days30under10same').css('display', display);
    });
    $('.days30under10upmenu').click(function() {
        var display=$('.days30under10up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days30under10up').css('display', display);
    });
	
	
	
	
	
	
    $('.days14over1000downmenu').click(function() {
        var display=$('.days14over1000down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days14over1000down').css('display', display);
    });
    $('.days14over1000samemenu').click(function() {
        var display=$('.days14over1000same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days14over1000same').css('display', display);
    });
    $('.days14over1000upmenu').click(function() {
        var display=$('.days14over1000up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days14over1000up').css('display', display);
    });
    $('.days14over100downmenu').click(function() {
        var display=$('.days14over100down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days14over100down').css('display', display);
    });
    $('.days14over100samemenu').click(function() {
        var display=$('.days14over100same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days14over100same').css('display', display);
    });
    $('.days14over100upmenu').click(function() {
        var display=$('.days14over100up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days14over100up').css('display', display);
    });
    $('.days14over50downmenu').click(function() {
        var display=$('.days14over50down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days14over50down').css('display', display);
    });
    $('.days14over50samemenu').click(function() {
        var display=$('.days14over50same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days14over50same').css('display', display);
    });
    $('.days14over50upmenu').click(function() {
        var display=$('.days14over50up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days14over50up').css('display', display);
    });
    $('.days14over20downmenu').click(function() {
        var display=$('.days14over20down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days14over20down').css('display', display);
    });
    $('.days14over20samemenu').click(function() {
        var display=$('.days14over20same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days14over20same').css('display', display);
    });
    $('.days14over20upmenu').click(function() {
        var display=$('.days14over20up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days14over20up').css('display', display);
    });
    $('.days14over10downmenu').click(function() {
        var display=$('.days14over10down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days14over10down').css('display', display);
    });
    $('.days14over10samemenu').click(function() {
        var display=$('.days14over10same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days14over10same').css('display', display);
    });
    $('.days14over10upmenu').click(function() {
        var display=$('.days14over10up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days14over10up').css('display', display);
    });
    $('.days14under10downmenu').click(function() {
        var display=$('.days14under10down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days14under10down').css('display', display);
    });
    $('.days14under10samemenu').click(function() {
        var display=$('.days14under10same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days14under10same').css('display', display);
    });
    $('.days14under10upmenu').click(function() {
        var display=$('.days14under10up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days14under10up').css('display', display);
    });
	
	
	
	
	
    $('.days7over30downmenu').click(function() {
        var display=$('.days7over30down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days7over30down').css('display', display);
    });
    $('.days7over30samemenu').click(function() {
        var display=$('.days7over30same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days7over30same').css('display', display);
    });
    $('.days7over30upmenu').click(function() {
        var display=$('.days7over30up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days7over30up').css('display', display);
    });
    $('.days7over100downmenu').click(function() {
        var display=$('.days7over100down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days7over100down').css('display', display);
    });
    $('.days7over100samemenu').click(function() {
        var display=$('.days7over100same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days7over100same').css('display', display);
    });
    $('.days7over100upmenu').click(function() {
        var display=$('.days7over100up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days7over100up').css('display', display);
    });
    $('.days7over50downmenu').click(function() {
        var display=$('.days7over50down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days7over50down').css('display', display);
    });
    $('.days7over50samemenu').click(function() {
        var display=$('.days7over50same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days7over50same').css('display', display);
    });
    $('.days7over50upmenu').click(function() {
        var display=$('.days7over50up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days7over50up').css('display', display);
    });
    $('.days7over20downmenu').click(function() {
        var display=$('.days7over20down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days7over20down').css('display', display);
    });
    $('.days7over20samemenu').click(function() {
        var display=$('.days7over20same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days7over20same').css('display', display);
    });
    $('.days7over20upmenu').click(function() {
        var display=$('.days7over20up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days7over20up').css('display', display);
    });
    $('.days7over10downmenu').click(function() {
        var display=$('.days7over10down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days7over10down').css('display', display);
    });
    $('.days7over10samemenu').click(function() {
        var display=$('.days7over10same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days7over10same').css('display', display);
    });
    $('.days7over10upmenu').click(function() {
        var display=$('.days7over10up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days7over10up').css('display', display);
    });
    $('.days7under10downmenu').click(function() {
        var display=$('.days7under10down').css('display') == 'block' ? 'none' : 'block'; 
        $('.days7under10down').css('display', display);
    });
    $('.days7under10samemenu').click(function() {
        var display=$('.days7under10same').css('display') == 'block' ? 'none' : 'block'; 
        $('.days7under10same').css('display', display);
    });
    $('.days7under10upmenu').click(function() {
        var display=$('.days7under10up').css('display') == 'block' ? 'none' : 'block'; 
        $('.days7under10up').css('display', display);
    });
	
	
    $('.upmenu').click(function() {
        var display=$("[class$=up]").css('display') == 'block' ? 'none' : 'block'; 
        $("[class$=up]").css('display', display);
    });	
    $('.downmenu').click(function() {
        var display=$("[class$=down]").css('display') == 'block' ? 'none' : 'block'; 
        $("[class$=down]").css('display', display);
    });	
    $('.samemenu').click(function() {
        var display=$("[class$=same]").css('display') == 'block' ? 'none' : 'block'; 
        $("[class$=same]").css('display', display);
    });	
	
	
	
    $('.menuA').click(function() {
        var display=$("[id$=1000]").css('display') == 'block' ? 'none' : 'block'; 
        $("[id$=1000]").css('display', display);
    });	
    $('.menuB').click(function() {
        var display=$("[id$=100]").css('display') == 'block' ? 'none' : 'block'; 
        $("[id$=100]").css('display', display);
    });	
    $('.menuC').click(function() {
        var display=$("[id$=50]").css('display') == 'block' ? 'none' : 'block'; 
        $("[id$=50]").css('display', display);
    });	
    $('.menuD').click(function() {
        var display=$("[id$=30]").css('display') == 'block' ? 'none' : 'block'; 
        $("[id$=30]").css('display', display);
    });	
    $('.menuE').click(function() {
        var display=$("[id$=20]").css('display') == 'block' ? 'none' : 'block'; 
        $("[id$=20]").css('display', display);
    });	
    $('.menuF').click(function() {
        var display=$("[id$=over10]").css('display') == 'block' ? 'none' : 'block'; 
        $("[id$=over10]").css('display', display);
    });	
    $('.menuG').click(function() {
        var display=$("[id$=under10]").css('display') == 'block' ? 'none' : 'block'; 
        $("[id$=under10]").css('display', display);
    });	
	
    $('.alloff').click(function() {
        $("[class$=up]").css('display', 'none'); 
        $("[class$=down]").css('display', 'none');     
        $("[class$=same]").css('display', 'none');    
    });	
	
    $('.allon').click(function() {    
        $("[class$=up]").css('display', 'block');	
        $("[class$=down]").css('display', 'block');    
        $("[class$=same]").css('display', 'block');    
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
	
.days30over1000down  	{ display: block; }   
.days30over1000same  	{ display: block; }  
.days30over1000up  	{ display: block; } 
.days30over100down  	{ display: block; }   
.days30over100same  	{ display: block; }  
.days30over100up  	{ display: block; } 
.days30over50down  	{ display: block; }   
.days30over50same  	{ display: block; }  
.days30over50up  	{ display: block; } 
.days30over20down  	{ display: block; }   
.days30over20same  	{ display: block; }  
.days30over20up  	{ display: block; } 
.days30over20down  	{ display: block; }   
.days30over20same  	{ display: block; }  
.days30over20up  	{ display: block; } 
.days30over10down  	{ display: block; }   
.days30over10same  	{ display: block; }  
.days30over10up  	{ display: block; }
.days30under10down  	{ display: block; }   
.days30under10same  	{ display: block; }  
.days30under10up  	{ display: block; } 
	
.days14over1000down  	{ display: block; }   
.days14over1000same  	{ display: block; }  
.days14over1000up  	{ display: block; } 
.days14over100down  	{ display: block; }   
.days14over100same  	{ display: block; }  
.days14over100up  	{ display: block; } 
.days14over50down  	{ display: block; }   
.days14over50same  	{ display: block; }  
.days14over50up  	{ display: block; } 
.days14over20down  	{ display: block; }   
.days14over20same  	{ display: block; }  
.days14over20up  	{ display: block; } 
.days14over20down  	{ display: block; }   
.days14over20same  	{ display: block; }  
.days14over20up  	{ display: block; } 
.days14over10down  	{ display: block; }   
.days14over10same  	{ display: block; }  
.days14over10up  	{ display: block; }
.days14under10down  	{ display: block; }   
.days14under10same  	{ display: block; }  
.days14under10up  	{ display: block; } 	
		
.days7over30down  	{ display: block; }   
.days7over30same  	{ display: block; }  
.days7over30up  	{ display: block; } 
.days7over100down  	{ display: block; }   
.days7over100same  	{ display: block; }  
.days7over100up  	{ display: block; } 
.days7over50down  	{ display: block; }   
.days7over50same  	{ display: block; }  
.days7over50up  	{ display: block; } 
.days7over20down  	{ display: block; }   
.days7over20same  	{ display: block; }  
.days7over20up  	{ display: block; } 
.days7over20down  	{ display: block; }   
.days7over20same  	{ display: block; }  
.days7over20up  	{ display: block; } 
.days7over10down  	{ display: block; }   
.days7over10same  	{ display: block; }  
.days7over10up  	{ display: block; }
.days7under10down  	{ display: block; }   
.days7under10same  	{ display: block; }  
.days7under10up  	{ display: block; } 	
	
</style>


<?PHP include_once('../footer.php'); ?>
