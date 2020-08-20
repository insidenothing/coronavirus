<?PHP
$days_back = 45;
$px = '25px';
$page_description = "$days_back Day Data Acquisition Report";
include_once('menu.php');

$array=array();

function check_zip($zip,$date){
  global $covid_db;
  $q = "select id from coronavirus_zip where zip_code = '$zip' and report_date = '$date'";
  $r = $covid_db->query($q);
  $d = mysqli_fetch_array($r);
  if ($d['id'] > 0){
   return "<span class='found' title='$date'>☑</span>"; 
  }else{
   return "<span class='missing' title='$date'>☒</span>";
  }
}

function check_county($countyDOTstate,$date){
  global $covid_db;
  $parts = explode('.',$countyDOTstate);
  $q = "select id from coronavirus_county where county_name = '$parts[0]' and state_name = '$parts[1]' and report_date = '$date'";
  $r = $covid_db->query($q);
  $d = mysqli_fetch_array($r);
  if ($d['id'] > 0){
   return "<span class='found' title='$date'>☑</span>"; 
  }else{
   return "<span class='missing' title='$date'>☒</span>";
  }
}

function check_state($state,$date){
  global $covid_db;
  $q = "select id from coronavirus_state where state_name = '$state' and report_date = '$date'";
  $r = $covid_db->query($q);
  $d = mysqli_fetch_array($r);
  if ($d['id'] > 0){
   return "<span class='found' title='$date'>☑</span>"; 
  }else{
   return "<span class='missing' title='$date'>☒</span>";
  }
}

/*
// Deleware
$array['state'][]  = 'Delaware';

// NYC
$array['zip'][]  = '11368';

// Arizona Data Quality
$array['zip'][] = '85283';

// Maryland Data Quality
$array['zip'][] = '21093'; // Maryland Zip
$array['countyState'][] = 'Baltimore.Maryland'; // Maryland County

// Florida Data Quality
//$array['zip'][] = '33445'; // Old Florida Zip
$array['zip'][] = 'Palm Beach-33445'; // New Florida Zip
$array['countyState'][] = 'Palm Beach.Florida'; // Florida County

// virginia Data Quality
$array['zip'][] = '23462'; // virginia Zip
$array['countyState'][] = 'Arlington.Virginia'; // virginia County

*/




echo "<style> span { font-size: $px; font-weight:bold; } .found { background-color: green; } .missing { background-color: red; } .cache { background-color: orange; } </style><table>";
echo "<tr><td colspan='2'><h1>Data 'Cache and Load' Status</h1></td></tr>";



$q = "SELECT * FROM coronavirus_api_qc order by state_name, data_type ";
$r = $covid_db->query($q);
while ($d = mysqli_fetch_array($r)){
  echo "<tr><td>$d[state_name]</td><td>$d[data_type]</td><td>$d[data_to_check]</td><td>";
  for($i = $days_back; $i > -1; $i--){
    $date = date("Y-m-d", strtotime("-$i days"));
    if ($d['data_type'] == 'zip'){
      echo check_zip($d['data_to_check'],$date);
    }elseif($d['data_type'] == 'county'){
      echo check_county($d['data_to_check'].'.'.$d['state_name'],$date);
    }elseif($d['data_type'] == 'state'){
      echo check_state($d['data_to_check'],$date);
    }
  }
  echo "</td><tr>";
}
echo "</table>";

include_once('footer.php');
?>
