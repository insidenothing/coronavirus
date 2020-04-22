<html>
<head>
	<?PHP 
	if (empty($logo)){
		$logo == 'on';
	}
	
	
	if(isset($page_description)){
		echo "<title>$page_description</title>";
	}elseif (isset($_POST['checked_datetime'])){ 
		echo "<title>COVID19MATH.net Digital Resources - ".$_POST['checked_datetime']."</title>";
	}else{
		echo "<title>COVID19MATH.net Digital Resources</title>";
	}
	if (empty($page_description)){
		$page_description = 'COVID19MATH.net Digital Resources';	
	}
	?>
  <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <meta property="og:url"           content="https://www.covid19math.net<?PHP echo $_SERVER['REQUEST_URI'];?>" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="COVID19MATH.net Digital Resources" />
  <meta property="og:description"   content="<?PHP echo $page_description;?>" />
  <meta property="og:image"         content="https://www.covid19math.net/img/vrus.png" />
  <?PHP if (empty($_GET['debug'])){ ?>	
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <?PHP } ?>
<?PHP
global $send_message;
global $core;

include_once('/var/www/secure.php'); //outside webserver
include_once('functions.php'); //outside webserver
set_hits(); // internal page counter
?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-162868936-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-162868936-1');
</script>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v6.0"></script>
	</head>
	<body style="background-color:white">
		<style>
			#rcorners2 {
			  border-radius: 25px;
			}
		</style>

	<?PHP
	
	
$links;
$q = "SELECT distinct name_of_location FROM coronavirus_populations where name_of_location <> 'Maryland'";
$r = $core->query($q);
	$loc_test='';
	if (isset($_GET['county'])){
		$loc_test = $_GET['county'];
	}
while($d = mysqli_fetch_array($r)){	
	if ($d['name_of_location'] == $loc_test){
		$links .= "<li role='presentation' class='active'><a href='county.php?county=$d[name_of_location]'>$d[name_of_location]</a></li>";	
	}else{
		$links .= "<li role='presentation'><a href='county.php?county=$d[name_of_location]'>$d[name_of_location]</a></li>";
	}
	
	//<li role="presentation"><a href="#">Home</a></li>
}
	?>
	
<div class="container"><!--- Open Container -->
	<?PHP
	// pull date from last update, not assume today.
	$q = "select checked_datetime, just_date from coronavirus where url_pulled like '%ZIPCodes_MD%' order by id desc limit 1";
	$r = $core->query($q);
	$d = mysqli_fetch_array($r);
	$date = $d['just_date'];
	if ($date != date('Y-m-d')){
		?>
		<div class="alert alert-primary" role="alert">
			We have not received the <?PHP echo date('Y-m-d');?> zip code update from the Maryland Department of Health yet. It is expected at 10:05 AM. Everything will show "FLAT" until then. Last Update was <?PHP echo $d['checked_datetime'];?>.
		</div>
		<?PHP 
	} 
	?>
	<?PHP
	// pull date from last update, not assume today.
	$q = "select checked_datetime, just_date from coronavirus where url_pulled like '%casetracker%' order by id desc limit 1";
	$r = $core->query($q);
	$d = mysqli_fetch_array($r);
	$date = $d['just_date'];
	if ($date != date('Y-m-d')){
		?>
		<div class="alert alert-primary" role="alert">
			We have not received the <?PHP echo date('Y-m-d');?> daily update from the Maryland Department of Health yet. It is expected at 10:05 AM. Everything will show "FLAT" until then. Last Update was <?PHP echo $d['checked_datetime'];?>.
		</div>
		<?PHP 
	} 
	?>
	<ul class="nav nav-pills">
		<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/index.php'){ echo "class='active'"; } ?> ><a href="index.php">Home</a></li>
		<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/phase1.php'){ echo "class='active'"; } ?> ><a href="phase1.php">Reopen Status</a></li>
		<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/florida_zip.php'){ echo "class='active'"; } ?> ><a href="florida_zip.php">FL Zip Codes</a></li>
		<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/zip.php'){ echo "class='active'"; } ?> ><a href="zip.php">MD Zip Codes</a></li>
		<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/graphs.php'){ echo "class='active'"; } ?> ><a href="graphs.php">Maryland</a></li>
		<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/graph_age.php'){ echo "class='active'"; } ?> ><a href="graph_age.php">Ages</a></li>
		<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/graph_hospital.php'){ echo "class='active'"; } ?> ><a href="graph_hospital.php">Hospital Data</a></li>
		<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/graph_delta.php'){ echo "class='active'"; } ?> ><a href="graph_delta.php">Deltas</a></li>
		<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/infection_level.php'){ echo "class='active'"; } ?> ><a href="infection_level.php">Infection Rate</a></li>
		<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/death_level.php'){ echo "class='active'"; } ?> ><a href="death_level.php">Death Rate</a></li>
		<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/signup.php'){ echo "class='active'"; } ?> ><a href="signup.php">SMS Signup</a></li>
		<li role='presentation'><div class="fb-share-button" data-href="https://www.covid19math.net<?PHP echo $_SERVER['REQUEST_URI'];?>" data-layout="box_count" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.covid19math.net.com&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div></li>
	</ul>
	<ul class="nav nav-tabs">
		<?PHP echo "$links"; ?>
	</ul>
	
