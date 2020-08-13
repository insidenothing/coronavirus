<?PHP
$state = 'Arizona';
$page_description = "$state COVID 19 Data Collection";
include_once('../menu.php');
?>
<h1><?PHP echo $state;?></h1>


<h1>Counties</h1>
<?PHP
$q = "SELECT distinct county_name FROM coronavirus_county where state_name = '$state' order by county_name";
		$r = $covid_db->query($q);
		while($d = mysqli_fetch_array($r)){	
			echo "<span><a href='/county.php?county=$d[county_name]&state=$state'>$d[county_name]</a>, </span>";
		}
?>



<h1>ZIP Codes</h1>
<?PHP
$q = "SELECT distinct zip_code FROM coronavirus_zip where state_name = '$state' order by zip_code";
		$r = $covid_db->query($q);
		while($d = mysqli_fetch_array($r)){	
			echo "<span><a href='/zip.php?zip=$d[zip_code]'>$d[zip_code]</a>, </span>";
		}
?>



<?PHP
include_once('../footer.php');
?>
