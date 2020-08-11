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


echo "<style> span { font-size: 25px; font-weight:bold; } .found { background-color: green; } .missing { background-color: red; } </style><table>";
foreach($array[zip] as $k => $v){
  echo "<tr><td>$v</td><td>";
  for($i = 45; $i > 0; $i--){
    $date = date("Y-m-d", strtotime("-$i days"));
    echo "<span style='found' title='$date'>☑</span>";
  }
  echo "</td><tr>";
}
foreach($array[zip] as $k => $v){
  echo "<tr><td>$v</td><td>";
  for($i = 45; $i > 0; $i--){
    $date = date("Y-m-d", strtotime("-$i days"));
    echo "<span style='missing' title='$date'>☒</span>";
  }
  echo "</td><tr>";
}


echo "<table>";


include_once('footer.php');
?>
