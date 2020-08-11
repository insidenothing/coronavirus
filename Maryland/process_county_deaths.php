<?PHP
include_once('../menu.php');

if(isset($_GET['global_date'])){
	$global_date = date('Y-m-d',strtotime($_GET['global_date']));
}

if (isset($_GET['delete'])){
	$delete = date('Y-m-d');
	$covid_db->query(" delete from coronavirus_county where report_date = '$delete' and state_name = 'maryland'");
	die('done '.$delete);
}

if (isset($_GET['delete_date'])){
	$delete = $_GET['delete_date'];
	$covid_db->query(" delete from coronavirus_county where report_date = '$delete' and state_name = 'maryland'");
	die('done '.$delete);
}

global $zipcode;
$zipcode = array();
$q = "select distinct zip_code, town_name from coronavirus_zip where town_name <> ''";
$r = $covid_db->query($q);
while($d = mysqli_fetch_array($r)){
	$zip = $d['zip_code'];
	$zipcode[$zip] = $d['town_name'];
}


function coronavirus_county($zip,$date,$count){
	if ($count == 0){
		echo "[skip - count too low $zip for $date]";
		return 1;
	}
	global $covid_db;
	global $zipcode;
	$town = $zipcode[$zip];
	$testing=0;
	$q = "select * from coronavirus_county where county_name = '$zip' and report_date = '$date' and state_name = 'maryland'";
	$r = $covid_db->query($q);
	$d = mysqli_fetch_array($r);
	if ($d['id'] == ''){
		echo "[skip insert $zip $date $count]";
		//$q = "insert into coronavirus_county (testing_count,county_name,report_date,death_count,town_name,state_name,trend_direction,trend_duration) values ('$testing','$zip','$date','$count','$town','maryland','$current_trend','$current_duration') ";
	}else{
		echo "[update $zip $date $count]";
		$q = "update coronavirus_county set death_count = '$count' where county_name = '$zip' and state_name='maryland' and report_date = '$date' ";	
	}
	$covid_db->query($q);
	//slack_general("$q",'covid19-sql');
}


global $nocases;
global $cases;
global $zipData;
global $date;








if($global_date == date('Y-m-d') || isset($_GET['id'])){

	
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$r = $covid_db->query("select * from coronavirus_api_cache where id = '$id' order by id desc limit 0, 1"); // always get the latest from the cache
	}else{
		$r = $covid_db->query("select * from coronavirus_api_cache where api_id = '8' order by id desc limit 0, 1"); // always get the latest from the cache	
	}

	// watch for microsoft characters =(
	$d = mysqli_fetch_array($r);

	$date = substr($d['cache_date_time'],0,10);
	
	
$pieces = json_decode($d['raw_response'], true); 
 

  foreach ($pieces['features'] as $key => $value){
	  	$time = $value['attributes']['DATE'] / 1000;
		$date = date('Y-m-d',$time+14400);
	  	//echo "<li>$date </li>";
	   		    $count = $value['attributes']['Allegany'];
			    	    coronavirus_county('Allegany',$date,$count);
                            $count = $value['attributes']['Anne_Arundel'];
				    coronavirus_county('Anne_Arundel',$date,$count);
                            $count = $value['attributes']['Baltimore'];
				    coronavirus_county('Baltimore',$date,$count);
                            $count = $value['attributes']['Baltimore_City'];
				    coronavirus_county('Baltimore_City',$date,$count);
                            $count = $value['attributes']['Calvert'];
				    coronavirus_county('Calvert',$date,$count);
                            $count = $value['attributes']['Caroline'];
				    coronavirus_county('Caroline',$date,$count);
                            $count = $value['attributes']['Carroll'];
				    coronavirus_county('Carroll',$date,$count);
                            $count = $value['attributes']['Cecil'];
				    coronavirus_county('Cecil',$date,$count);
                            $count = $value['attributes']['Charles'];
				    coronavirus_county('Charles',$date,$count);
                            $count = $value['attributes']['Dorchester'];
				    coronavirus_county('Dorchester',$date,$count);
                            $count = $value['attributes']['Frederick'];
				    coronavirus_county('Frederick',$date,$count);
                            $count = $value['attributes']['Garrett'];
				    coronavirus_county('Garrett',$date,$count);
                            $count = $value['attributes']['Harford'];
				    coronavirus_county('Harford',$date,$count);
                            $count = $value['attributes']['Howard'];
				    coronavirus_county('Howard',$date,$count);
                            $count = $value['attributes']['Kent'];
				    coronavirus_county('Kent',$date,$count);
                            $count = $value['attributes']['Montgomery'];
				    coronavirus_county('Montgomery',$date,$count);
                            $count = $value['attributes']['Prince_Georges'];
				    coronavirus_county('Prince_Georges',$date,$count);
                            $count = $value['attributes']['Queen_Annes'];
				    coronavirus_county('Queen_Annes',$date,$count);
                            $count = $value['attributes']['Somerset']; 
				    coronavirus_county('Somerset',$date,$count);
                            $count = $value['attributes']['St_Marys']; 
				    coronavirus_county('St_Marys',$date,$count);
                            $count = $value['attributes']['Talbot'];
				    coronavirus_county('Talbot',$date,$count);
                            $count = $value['attributes']['Washington'];
				    coronavirus_county('Washington',$date,$count);
                            $count = $value['attributes']['Wicomico'];
				    coronavirus_county('Wicomico',$date,$count);
                            $count = $value['attributes']['Worcester'];
				    coronavirus_county('Worcester',$date,$count);
                            $count = $value['attributes']['Unknown']; 
				    coronavirus_county('Unknown',$date,$count);
	  	/*
		$date = $global_date;
	  	$zip = intval(substr(trim($pieces2),0,5));	
	  	if ($zip != 0){
			$count = preg_replace("/[^a-zA-Z0-9]+/", "_", $pieces2);
			$count = str_replace($zip,'_',$count); 
			$count = str_replace('Tribal','_',$count); 
			$count = str_replace('Data','_',$count); 
			$count = str_replace('Suppressed','_',$count); 
			$piecesX = explode('_',$count);
			$bits = count($piecesX) - 1;
			$count = intval($piecesX[$bits]);
			echo "<li>coronavirus_county($zip,$date,$count)</li>";
			//coronavirus_county($zip,$date,$count);
		}
	  	
		
		$count = $pieces2['number_of_cases'];
		$testing = $pieces2['number_of_pcr_testing'];
		if ($count == 'Suppressed*'){
			$count = 4;
		}
		if ($testing == 'Suppressed*'){
			$testing = 4;
		}
		if ($zip == 'Not Reported'){
			$zip = '00002';
		}
		if ($zip == 'Out-of-State'){
			$zip = '00004';
		}
		if ($date != '1969-12-31'){
			echo "<li>$date - $zip - $count / $testing</li>";  
			      if (empty($_GET['run'])){
				//die('missing run=1');
			      }
			//coronavirus_county($zip,$date,$count,$testing);
		}
		*/
	}
  
}

echo "<pre>";
print_r($pieces);
echo "</pre>";	




$q = "update coronavirus_county set change_percentage_time = '' where state_name = 'maryland' ";
$covid_db->query($q);
die('DONE '.$q);
