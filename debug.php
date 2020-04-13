<?PHP
// break apart the API
include_once('functions.php');

echo "<table><tr><td valign='top'>";

$history = make_maryland_array();
echo '<h1>Historic Data</h1><p>make_maryland_array()</p><pre>';
print_r($history);
echo '</pre>';

echo "</td><td valign='top'>";

$history = make_maryland_array2();
echo '<h1>Latest Data</h1><p>make_maryland_array2()</p><pre>';
print_r($history);
echo '</pre>';


echo "</td><td valign='top'>";

$url = 'https://services.arcgis.com/njFNhDsUCentVYJW/arcgis/rest/services/TEST_ZIPCodeCases/FeatureServer/0/query?where=1%3D1&outFields=OBJECTID,ZIPCODE1,ZIPName,ProtectedCount&returnGeometry=false&outSR=4326&f=json';
$history = make_maryland_array3($url,'');
echo '<h1>Zipcode Data</h1><p>make_maryland_array3()</p><pre>';
print_r($history);
echo '</pre>';

echo "</td></tr></table>";
