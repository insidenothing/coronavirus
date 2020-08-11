<?PHP

$page_description = "45-Day Data Acquisition";
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


echo "<style> span { font-size: 25px; font-weight:bold; } .found { background-color: green; } .missing { background-color: red; } </style><table>";
foreach($array[zip] as $k => $v){
  echo "<tr><td>$v</td><td>";
  for($i = 45; $i > -1; $i--){
    $date = date("Y-m-d", strtotime("-$i days"));
    echo check_zip($v,$date);
  }
  echo "</td><tr>";
}
foreach($array[countyState] as $k => $v){
  echo "<tr><td>$v</td><td>";
  for($i = 45; $i > -1; $i--){
    $date = date("Y-m-d", strtotime("-$i days"));
    echo check_county($v,$date);
  }
  echo "</td><tr>";
}


echo "<table>";


include_once('footer.php');
?>
