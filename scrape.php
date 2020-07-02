<?PHP
include_once('menu.php');


function getPage($url){
    $curl = curl_init();
    curl_setopt ($curl, CURLOPT_URL, $url);
    curl_setopt ($curl, CURLOPT_VERBOSE, true);
    curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("McGuire Coronavirus Monitor covid19math.net /%d.0",rand(4,50)));
    curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $verbose = fopen('php://temp', 'w+');
    curl_setopt ($curl, CURLOPT_STDERR, $verbose);
    $html = curl_exec ($curl);  
    if ($result === FALSE) {
           printf("cUrl error (#%d): %s<br>\n", curl_errno($curl),
           htmlspecialchars(curl_error($curl)));
    }
    rewind($verbose);
    $verboseLog = stream_get_contents($verbose);
    slack_general($verboseLog,'covid19-apis');
    curl_close ($curl);
     echo $url;
    return $html;
}


$url = 'https://public.tableau.com/profile/population.health.dhec#!/vizhome/ZipCodeCountyLevel/CountyOption1';
    $str = getPage($url);
    echo $str;

die();
