<?PHP include_once('blocked_bots.php'); ?>
<html>
<head>
	<?PHP 
	if (empty($logo)){
		$logo == 'on';
	}
	
	
	if(isset($page_description)){
		echo "<title>$page_description</title>";
	}elseif (isset($_POST['checked_datetime'])){ 
		echo "<title>COVID19MATH.net Digital Resources - ".date('Y-m-d',strtotime($_POST['checked_datetime']))."</title>";
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
  <meta property="fb:app_id"        content="964347477327114" />
  <meta property="og:title"         content="COVID19MATH.net Digital Resources" />
  <meta property="og:description"   content="<?PHP echo $page_description;?>" />
	
	<?PHP
	$filename = "img/".date('Y-m-d').".PNG";
	if (file_exists($filename)) {
	    echo '<meta property="og:image"         content="https://www.covid19math.net/'.$filename.'" />';
	} else {
	    echo '<meta property="og:image"         content="https://www.covid19math.net/img/vrus.png" />';
	}
	?>
  
	
	
  <?PHP if (empty($_GET['debug'])){ ?>	
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <?PHP } ?>
<?PHP
global $send_message;
global $core;

include_once('/var/www/secure.php'); //outside webserver
include_once('functions.php');
include_once('slack.php'); 
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
	
	
<script type="text/javascript" src="/simpletreemenu.js">

/***********************************************
* Simple Tree Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* Please keep this notice intact
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>

<link rel="stylesheet" type="text/css" href="/simpletree.css" />
	
	
	
	
	
	
	
	</head>
	<body style="background-color:white">
		<style>
			#rcorners2 {
			  border-radius: 25px;
			}
		</style>

	<?PHP
	
	


?>
	
<div class="container" style='width:100%;'><!--- Open Container -->
	
<a href="/index.php">Home</a> | <a href="javascript:ddtreemenu.flatten('treemenu1', 'expand')">Show All</a> | <a href="javascript:ddtreemenu.flatten('treemenu1', 'contact')">Hide All</a>

<ul id="treemenu1" class="treeview">
	
<?PHP if ( $_SERVER['REMOTE_ADDR'] == '69.250.28.138'){ ?>	
<li>Hello Patrick 	
	<ul>
		<li><a href="https://www.covid19math.net/apis.php">API Status</a></li>
		<li><a target='_Blank' href="https://www.covid19math.net/Maryland/zip.php?run=1">Process MD ZIP Codes</a></li>
		<li><a target='_Blank' href="https://www.covid19math.net/Florida/florida_zip.php?run=1&global_date=<?PHP echo date('Y-m-d');?>">Process FL ZIP Codes for <?PHP echo date('Y-m-d');?></a></li>
		<li><a target='_Blank' href="https://www.covid19math.net/Virginia/virginia_zip.php?run=1">Process VA ZIP Codes</a></li>
		<li><a target='_Blank' href="https://www.covid19math.net/New York/new_york_zip.php?run=1">Process NY ZIP Codes</a></li>
		<li><a target='_Blank' href="https://www.covid19math.net/Maryland/facilities_abstract.php">Process MD Facilities Codes</a></li>
		<li><a target='_Blank' href="https://www.covid19math.net/zipcode.php?zip=21208&auto=1&state=maryland">Find Active / Trend MD</a></li>
		<li><a target='_Blank' href="https://www.covid19math.net/zipcode.php?zip=21208&auto=1&state=florida">Find Active / Trend FL</a></li>
		<li><a target='_Blank' href="https://www.covid19math.net/zipcode.php?zip=21208&auto=1&state=new york">Find Active / Trend NY</a></li>
		<li><a target='_Blank' href="https://www.covid19math.net/zipcode.php?zip=21208&auto=1&state=virginia">Find Active / Trend VA</a></li>
	
	</ul>
</li>
<?PHP } ?>
	
<li>Support 	
	<ul>
		<li><a target='_Blank' href="https://www.etsy.com/shop/PatricksPPE">Buy PPE Here</a></li>
		<li><a target='_Blank' href="https://github.com/sponsors/insidenothing">Sponsor This Website</a></li>
		<li><a target='_Blank' href="http://sales.patrickmcguire.me">Buy Websites Here</a></li>
	</ul>
</li>	
<li>Pages 	
	<ul>	
		<li><a href="/library.php">COVID 19 National API Library</a></li>
		<li><a href="/index.php">COVID 19 Reopen Dashboard</a></li>
		<li><a href="/active_covid.php">Active COVID 19 Infections</a></li>
		<li><a href="/spikes.php">COVID 19 Spike Monitor</a></li>
		<li><a href="/outbreak.php">COVID 19 Outbreak Monitor</a></li>
	</ul>
</li>	
<li>United States
	<ul>
		
		<li>Florida
		<ul>
		<?PHP
		echo "<li><a href='/Florida/index.php'>State Data</a></li>";
		echo "<li><a href='/Florida/active.php'>Active Case Count</a></li>";
		$q = "SELECT distinct name_of_location FROM coronavirus_populations where name_of_location <> 'Florida' and state_of_location = 'Florida' order by name_of_location";
		$r = $core->query($q);
		while($d = mysqli_fetch_array($r)){	
			echo "<li><a href='/county.php?county=$d[name_of_location]'>$d[name_of_location]</a></li>";
		}			
		?>
		</ul>
		</li>
		
		<li>Maryland
		<ul>
		<li><a href="/Maryland/facilities_table.php">Facilities Table</a></li>
		<?PHP
		$q = "SELECT distinct name_of_location FROM coronavirus_populations where name_of_location <> 'Maryland' and state_of_location = 'Maryland' order by name_of_location";
		$r = $core->query($q);
		echo "<li><a href='/Maryland/index.php'>State Data</a></li>";
		echo "<li><a href='/Maryland/active.php'>Active Case Count</a></li>";
		while($d = mysqli_fetch_array($r)){	
			echo "<li><a href='/county.php?county=$d[name_of_location]'>$d[name_of_location]</a></li>";
		}			
		?>
		</ul>
		</li>
		
		
		
		<li>New York
		<ul>
		<?PHP
		echo "<li><a href='/New York/index.php'>State Data</a></li>";
		echo "<li><a href='/New York/active.php'>Active Case Count</a></li>";
		$q = "SELECT distinct name_of_location FROM coronavirus_populations where name_of_location <> 'New York' and state_of_location = 'New York' order by name_of_location";
		$r = $core->query($q);
		while($d = mysqli_fetch_array($r)){	
			echo "<li><a href='/county.php?county=$d[name_of_location]'>$d[name_of_location]</a></li>";
		}			
		?>
		</ul>
		</li>
		
		<li>Virginia
		<ul>
		<?PHP
		echo "<li><a href='/Virginia/index.php'>Virginia Data</a></li>";
		echo "<li><a href='/Virginia/active.php'>Active Case Count</a></li>";
		$q = "SELECT distinct name_of_location FROM coronavirus_populations where name_of_location <> 'Virginia' and state_of_location = 'Virginia' order by name_of_location";
		$r = $core->query($q);
		while($d = mysqli_fetch_array($r)){	
			echo "<li><a href='/county.php?county=$d[name_of_location]'>$d[name_of_location]</a></li>";
		}			
		?>
		</ul>
		</li>
</ul>
</li>
</ul>

<script type="text/javascript">
//ddtreemenu.createTree(treeid, enablepersist, opt_persist_in_days (default is 1))
ddtreemenu.createTree("treemenu1", true)
</script>	
	
	
	
	<?PHP
	// pull date from last update, not assume today.
	$q = "select last_updated from coronavirus_apis where id = '13' order by id desc limit 1";
	$r = $core->query($q);
	$d = mysqli_fetch_array($r);
	$date = $d['last_updated'];
	//if ($date != date('Y-m-d')){
	$pos = strpos($date, date('Y-m-d'));
	global $global_date;
	$global_date = date('Y-m-d');
	if(isset($_GET['global_date'])){
		$global_date = date('Y-m-d',strtotime($_GET['global_date']));
	}
	$q = "SELECT distinct api_url FROM coronavirus_apis";
	$r = $core->query($q);
	$total_apis = mysqli_num_rows($r);
	if ($pos === false && empty($_GET['global_date'])) {	
		$global_date = date('Y-m-d',strtotime('-1 day'));
		?>
		<div class="alert alert-danger">
			We have not received the <?PHP echo date('Y-m-d');?> zip code update from the Maryland Department of Health yet. It is expected at 11:05 AM. Last Update was <?PHP echo $date;?>. View APIs <a href='library.php'>HERE</a>. #BigData #covid19math
		</div>
		<?PHP 
	} elseif ($pos === false && isset($_GET['global_date'])) {	
		//$global_date = date('Y-m-d',strtotime('-1 day'));
		?>
		<div class="alert alert-success">
			Processing Global Date <?PHP echo $global_date;?>. #BigData #covid19math
		</div>
		<?PHP 
	} else{
		$q = "SELECT distinct state_name FROM coronavirus_apis";
		$r = $core->query($q);
		$state_names = mysqli_num_rows($r);
		$q = "SELECT distinct Facility_Name FROM coronavirus_facility";
		$r = $core->query($q);
		$processed_facility = mysqli_num_rows($r);
		$q = "SELECT zip_code FROM coronavirus_zip where report_count <> '0' and report_count <> '7' and change_percentage_time <> '00:00:00' and report_date = '$global_date' ";
		$r = $core->query($q);
		$done = mysqli_num_rows($r);
		$q = "SELECT zip_code FROM coronavirus_zip where report_count <> '0' and report_count <> '7' and change_percentage_time = '00:00:00' and report_date = '$global_date' ";
		$r = $core->query($q);
		$left = mysqli_num_rows($r);
		$processed_zips = $done + $left;
		if ($left > 0){
			?>
			<div class="alert alert-warning">
				Using <?PHP echo $total_apis;?> API's for <?PHP echo $state_names;?> States we are currently Processing Zip Codes for <?PHP echo $date;?>. We have processed <?PHP echo $done;?> and have <?PHP echo $left;?> to process. <?PHP echo number_format($processed_zips); ?> Total. <?PHP echo $processed_facility;?> Living Facilities View APIs <a href='library.php'>HERE</a>. #BigData #covid19math
			</div>
			<?PHP 		
		}else{
			?>
			<div class="alert alert-success">
				Using <?PHP echo $total_apis;?> API's for <?PHP echo $state_names;?> States we have finished processing <?PHP echo number_format($processed_zips);?> ZIP codes and <?PHP echo $processed_facility;?> Living Facilities for <?PHP echo $date;?>! View APIs <a href='library.php'>HERE</a>. #BigData #covid19math
			</div>
			<?PHP 		
		}
	}
	slack_general("$global_date $_SERVER[SCRIPT_NAME] $_SERVER[QUERY_STRING]",'covid19');
	?>
	
	
	<div style='position:absolute; top:10px; right:10px;' class="fb-share-button" data-href="https://www.covid19math.net<?PHP echo $_SERVER['REQUEST_URI'];?>" data-layout="box_count" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.covid19math.net.com&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>
	<form style='position:absolute; top:10px; right:100px;' method='GET' action='/zipcode.php'><input class="form-control input-lg" name='zip' type="number" min="00000" max="99999"><button type="submit" class="btn btn-success">Go to ZIP Code</button></form>
	
	
		
		<?PHP /*
		<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/phase1.php'){ echo "class='active'"; } ?> ><a href="phase1.php">Reopen Maryland Status</a></li>
		<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/phase1.php?state=Florida'){ echo "class='active'"; } ?> ><a href="phase1.php?state=Florida">Reopen Florida Status</a></li>
		<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/florida_death_graph.php'){ echo "class='active'"; } ?> ><a href="florida_death_graph.php">Florida Deaths</a></li>
		<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/graphs.php'){ echo "class='active'"; } ?> ><a href="graphs.php">Maryland</a></li>
		<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/graph_age.php'){ echo "class='active'"; } ?> ><a href="graph_age.php">Ages</a></li>
		<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/graph_hospital.php'){ echo "class='active'"; } ?> ><a href="graph_hospital.php">Hospital Data</a></li>
		<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/graph_delta.php'){ echo "class='active'"; } ?> ><a href="graph_delta.php">Deltas</a></li>
		<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/infection_level.php'){ echo "class='active'"; } ?> ><a href="infection_level.php">Infection Rate</a></li>
		<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/death_level.php'){ echo "class='active'"; } ?> ><a href="death_level.php">Death Rate</a></li>
		<li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == '/signup.php'){ echo "class='active'"; } ?> ><a href="signup.php">SMS Signup</a></li>
		*/ ?>
		
		
	
	
	
	
	

