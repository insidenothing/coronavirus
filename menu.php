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
		$page_description = 'Get SMS Updates';	
	}
	?>
  <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
  <link rel="manifest" href="/coronavirus/site.webmanifest">
  <meta property="og:url"           content="https://www.covid19math.net<?PHP echo $_SERVER['REQUEST_URI'];?>" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="COVID19MATH.net Digital Resources" />
  <meta property="og:description"   content="<?PHP echo $page_description;?>" />
  <meta property="og:image"         content="https://www.covid19math.net/img/vrus.png" />
  <?PHP if (empty($_GET['debug'])){ ?>	
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <?PHP } ?>
<?PHP
global $send_message;
global $core;

include_once('/var/www/secure.php'); //outside webserver
include_once('functions.php'); //outside webserver

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
	<body style="background-color:black">
		<style>
			#rcorners2 {
			  border-radius: 25px;
			}
		</style>
<center><div style="background-color:white; width:1300;" id="rcorners2">
	<?PHP
	if ($logo == 'on'){
		// set logo to anything to hide this
		echo '<img src="img/header.PNG"  class="img-rounded" >';	
	}else{
		echo 'Welcome to https://www.covid19math.net on ' . date('r');	
	}
	
$links;
$q = "SELECT distinct name_of_location FROM coronavirus_populations ";
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
	
<div class="container">
	<div class="fb-share-button" data-href="https://www.covid19math.net<?PHP echo $_SERVER['REQUEST_URI'];?>" data-layout="box_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.mdwestserve.com%2Fcoronavirus%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>
	<ul class="nav nav-tabs">
		<?PHP echo "$links"; ?>
		<li role="presentation" class="dropdown">
		    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
		      Main Menu <span class="caret"></span>
		    </a>
		    <ul class="dropdown-menu">
		       <li><a href="index.php">Home Page</a></li>
            		<li><a href="zip.php">Zip Code Report</a></li>
            		<li><a href="graphs.php">Main 45 Day Predictions</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="graph_age.php">Graph - Ages</a></li>
	    <li><a href="graph_hospital.php">Graph - Hospital Data</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="graph_delta.php">Graph - Deltas over Time</a></li>
	    <li role="separator" class="divider"></li>
			    <li><a href="infection_level.php">Current Infection Rate</a></li>
			    <li><a href="death_level.php">Current Death Rate</a></li>
			    <li role="separator" class="divider"></li>
			    <li><a href="signup.php">SMS Signup</a></li>
			     <li role="separator" class="divider"></li>
			    <li><a href="https://www.facebook.com/groups/covid19md/">Facebook Group - Feedback</a></li>
		    </ul>
		 </li>
	</ul>
	

	

	
