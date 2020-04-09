<?PHP
// break apart the API
include_once('functions.php');

function getPage($url){
    $curl = curl_init();
    curl_setopt ($curl, CURLOPT_URL, $url);
    curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("McGuire Coronavirus Monitor /%d.0",rand(4,50)));
    curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $www = curl_exec ($curl);
    curl_close ($curl);
    return $www;
}

$history = make_maryland_array();
echo '<pre>';
print_r($history);
echo '</pre>';
