<?PHP
// break apart the API
include_once('menu.php');


echo "<div style='text-align:left;'><h1>Known URLs</h1>";
$r = $core->query("select distinct url_pulled from coronavirus where url_pulled <> ''");
while ($d = mysqli_fetch_array($r)){
  $r2 = $core->query("select * from coronavirus where url_pulled = '$d[url_pulled]' order by id desc");
  $d2 = mysqli_fetch_array($r2);
  echo "<p>$d2[checked_datetime] $d[url_pulled]</p>";
}



$history = make_maryland_array();
echo '<h1>Historic Data</h1><p>make_maryland_array()</p><pre>';
print_r($history);
echo '</pre>';



$history = make_maryland_array2();
echo '<h1>Latest Data</h1><p>make_maryland_array2()</p><pre>';
print_r($history);
echo '</pre>';




$url = 'https://services.arcgis.com/njFNhDsUCentVYJW/arcgis/rest/services/TEST_ZIPCodeCases/FeatureServer/0/query?where=1%3D1&outFields=OBJECTID,ZIPCODE1,ZIPName,ProtectedCount&returnGeometry=false&outSR=4326&f=json';
$history = make_maryland_array3($url,'');
echo '<h1>Zipcode Data</h1><p>make_maryland_array3()</p><pre>';
print_r($history);
echo '</pre></div>';

include_once('footer.php');
