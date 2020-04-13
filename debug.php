<?PHP
// break apart the API
include_once('functions.php');


$history = make_maryland_array();
echo '<p>make_maryland_array()</p><pre>';
print_r($history);
echo '</pre>';


$history = make_maryland_array2();
echo '<p>make_maryland_array2()</p><pre>';
print_r($history);
echo '</pre>';




$url = 'https://services.arcgis.com/njFNhDsUCentVYJW/arcgis/rest/services/TEST_ZIPCodeCases/FeatureServer/0/query?where=1%3D1&outFields=OBJECTID,ZIPCODE1,ZIPName,ProtectedCount&returnGeometry=false&outSR=4326&f=json';
$history = make_maryland_array3($url,'');
echo '<p>make_maryland_array3()</p><pre>';
print_r($history);
echo '</pre>';
