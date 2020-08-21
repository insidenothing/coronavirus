<?PHP
$state = 'Maryland';
$page_description = "$state COVID 19 Data Collection";
include_once('../menu.php');
$state = 'Maryland';
?>
<h1><?PHP echo $state;?> Counties</h1>
<?PHP
$q = "SELECT distinct county_name FROM coronavirus_county where state_name = '$state' order by county_name";
		$r = $covid_db->query($q);
		while($d = mysqli_fetch_array($r)){	
			echo "<span><a href='/county.php?county=$d[county_name]&state=$state'>$d[county_name]</a>, </span>";
		}
?>



<h1><?PHP echo $state;?> ZIP Codes</h1>
<?PHP
$q = "SELECT distinct zip_code FROM coronavirus_zip where state_name = '$state' order by zip_code";
		$r = $covid_db->query($q);
		while($d = mysqli_fetch_array($r)){	
			echo "<span><a href='/zipcode.php?zip=$d[zip_code]'>$d[zip_code]</a>, </span>";
		}
?>


<h1><?PHP echo $state;?> Data Sources</h1>
<ol>
<?PHP
$q = "SELECT * FROM coronavirus_apis where state_name = '$state'";
		$r = $covid_db->query($q);
		while($d = mysqli_fetch_array($r)){	
			echo "<li><a href='$d[api_url]'><small>$d[api_url]</small></a></li>";
		}
?>
</ol>

<?PHP
include_once('../footer.php');
?>
