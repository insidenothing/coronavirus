<?PHP

$page_description = "45-Day Data Acquisition";
include_once('menu.php');

$array=array();

// Check Maryland Data Quality
$array['zip'][] = '21093'; // Maryland Zip
$array['countyState'][] = 'Baltimore.Maryland'; // Maryland County

// Check Florida Data Quality
$array['zip'][] = '21093'; // Florida Zip
$array['countyState'][] = 'Palm Beach.Florida'; // Florida County



foreach($array[zip] as $k => $v){
  echo "<li>$k Checking $v</li>";
}


foreach($array[countyState] as $k => $v){
  echo "<li>$k Checking $v</li>";
}



include_once('footer.php');
?>
