<?PHP
$page_description = "Infection Levels as Percentages of Population";
include_once('menu.php');
global $state_level;
global $maryland_history;
$maryland_history = make_maryland_array();

function case_count($county){
	// infected
	global $maryland_history;
	$date = date('Y-m-d');
	$aka = county_aka($county);
	$val = $maryland_history[$date][$aka];
	$count = intval($val);
	return $count;	
}
function total_count($county){
	// pouplation
	global $core;
	$q = "SELECT number_of_people FROM coronavirus_populations where name_of_location = '$county' ";
	$r = $core->query($q);
	$d = mysqli_fetch_array($r);
	return $d['number_of_people'];	
}
function infection_levelMD($county){
	global $core;
	global $state_level;
	$cases = case_count($county);
	$total = total_count($county);
	$gcd = gmp_gcd($cases, $total);
	$a = $cases / $gcd;
	$b = $total / $gcd;
	$c =  $cases / $total;
	$d = $c * 1000;
	$state_level = $d;
	$e = number_format($d, 5, '.', '');
	$core->query("update coronavirus_populations set rate_of_infection = '$e' where name_of_location = '$county' ");
	echo "<div class='col-sm-6' style='background-color:lightblue; height:150px;'><h3>$county</h3><p><b>Cases</b> $cases : $total <b>Population</b></p><p><b>Reduced</b> $a : $b</p><p><b>Infected Percent of the Population</b> $e%</p></div><div class='col-sm-6' style='background-color:lightblue; height:150px;'><p><img src='img/Infection_rate_formula.jpg' class='img-rounded'></p></div>";
}
function infection_level($county){
	global $core;
	global $state_level;
	$cases = case_count($county);
	$total = total_count($county);
	$gcd = gmp_gcd($cases, $total);
	$a = $cases / $gcd;
	$b = $total / $gcd;
	$c =  $cases / $total;
	$d = $c * 1000;
	$e = number_format($d, 5, '.', '');
	if($cases == 0){
		echo "<div class='col-sm-2' style='background-color:lightgreen;'><h4>$county</h4><p>$cases : $total</p><p>$a : $b</p><p><b>$e%</b></p></div>";	
	}elseif($state_level > $d){
		echo "<div class='col-sm-2' style='background-color:lightyellow;'><h4>$county</h4><p>$cases : $total</p><p>$a : $b</p><p><b>$e%</b></p></div>";
	}else{
		echo "<div class='col-sm-2' style='background-color:#ffbaba;'><h4>$county</h4><p>$cases : $total</p><p>$a : $b</p><p><b>$e%</b></p></div>";	
	}
	$core->query("update coronavirus_populations set rate_of_infection = '$e' where name_of_location = '$county' ");
}
?>

<div class="container">
<div class="row">
<?PHP infection_levelMD('Maryland'); ?>
</div>
</div>
	  
	  
<div class="container">
  <div class="row">

<?PHP

infection_level('Allegany');
infection_level('AnneArundel');
infection_level('Baltimore');
infection_level('BaltimoreCity');
infection_level('Calvert');
infection_level('Caroline');
	  ?> </div>  <div class="row"> <?PHP
infection_level('Carroll');
infection_level('Cecil');
infection_level('Charles');
infection_level('Dorchester');
infection_level('Frederick');
infection_level('Garrett');
	  ?> </div>  <div class="row"> <?PHP
infection_level('Harford');
infection_level('Howard');
infection_level('Kent');
infection_level('Montgomery');
infection_level('PrinceGeorges');
infection_level('QueenAnnes');
	  ?> </div>  <div class="row"> <?PHP
infection_level('Somerset');
infection_level('StMarys');
infection_level('Talbot');
infection_level('Washington');
infection_level('Wicomico');
infection_level('Worcester');
	  ?>
  </div>
</div>	  
<?PHP include_once('footer.php'); ?>
