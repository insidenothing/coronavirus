<?PHP
// break apare the API

function getPage($url){
    $curl = curl_init();
    curl_setopt ($curl, CURLOPT_URL, $url);
    curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("McGuire coronavirus monitor /%d.0",rand(4,50)));
    curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $www = curl_exec ($curl);
    curl_close ($curl);
    return $www;
}

// Maryland
$url = 'https://services.arcgis.com/njFNhDsUCentVYJW/arcgis/rest/services/MASTER_CaseTracker/FeatureServer/0/query?where=1%3D1&outFields=*&returnGeometry=false&outSR=4326&f=json';
$json = getPage($url);

if ($json == '{"error":{"code":504,"message":"Your request has timed out.","details":[]}}'){
	die('504');	
}
if ($json == '{"error":{"code":503,"message":"An error occurred.","details":[]}}'){
	die('503');
}
if ($json == '{"error":{"code":400,"message":"Invalid URL","details":["Invalid URL"]}}'){
	die('400');
}

$array = json_decode($json, true);
echo '<table><tr><td valign="top"><h1>Database</h1><pre>';
print_r($array['fields']);
echo '</pre></td>';
echo '<td valign="top"><h1>Data</h1><pre>';
print_r($array['features']);
echo '</pre></td></tr></table>';
