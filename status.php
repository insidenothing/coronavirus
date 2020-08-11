<?PHP

$page_description = "45-Day Data Acquisition";
include_once('menu.php');

$array=array();

// Check Maryland Data Quality
$array['zip'][] = '21093'; // Maryland Zip
$array['countyState'][] = 'Baltimore.Maryland'; // Maryland County

// Check Florida Data Quality
$array['zip'][] = '33445'; // Florida Zip
$array['countyState'][] = 'Palm Beach.Florida'; // Florida County

// Check virginia Data Quality
$array['zip'][] = '23462'; // virginia Zip
$array['countyState'][] = 'Arlington.virginia'; // virginia County

foreach($array[zip] as $k => $v){
  echo "<div>$v";
  for($i = 45; $i > 0; $i--){
    $date = date("Y-m-d", strtotime("-$i days"));
    echo "<span title='$date'>☑</span>";
  }
  echo "</div>";
}


foreach($array[countyState] as $k => $v){
   echo "<div>$v";
  for($i = 45; $i > 0; $i--){
    $date = date("Y-m-d", strtotime("-$i days"));
    echo "<span title='$date'>☒</span>";
  }
  echo "</div>";
}



include_once('footer.php');
?>
