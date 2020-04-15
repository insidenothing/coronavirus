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
while($d = mysqli_fetch_array($r)){	
	$links .= "<a href='county.php?county=$d[name_of_location]'>$d[name_of_location]</a>, ";
}
	?>
<table><tr>
	<td><a href='index.php'><img class="img-responsive" src='img/home.png'></a></td>
	<td><a href='zip.php'><img class="img-responsive" src='img/zip.png'></a></td>
	<td><a href='graphs.php'><img class="img-responsive" src='img/graph_county.png'></a></td>
	<td><a href='graph_age.php'><img class="img-responsive" src='img/graph_age.png'></a></td>
	<td><a href='graph_hospital.php'><img class="img-responsive" src='img/graph_hospital.png'></a></td>
	<td><a href='graph_delta.php'><img class="img-responsive" src='img/graph_delta.png'></a></td>
	</tr><tr>
	<td><a href='infection_level.php'><img class="img-responsive" src='img/infected.png'></a></td>
	<td><a href='death_level.php'><img class="img-responsive" src='img/death_rates.png'></a></td>
	<td><a href='signup.php'><img class="img-responsive" src='img/signup.png'></a></td>
	<td><a href='https://www.facebook.com/groups/231583938033989/'><img class="img-responsive" src='img/facebook.png'></a></td>
	<td><div class="fb-share-button" data-href="https://www.covid19math.net<?PHP echo $_SERVER['REQUEST_URI'];?>" data-layout="box_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.mdwestserve.com%2Fcoronavirus%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div></td>
	<td></td>
	</tr>
	<tr>
		<td colspan="6"><?PHP echo "<div>$links</div>"; ?></td>
	</tr>
	</table>
	
