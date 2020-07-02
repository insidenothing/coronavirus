
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



    $url = 'https://coronavirus.dc.gov/sites/default/files/dc/sites/coronavirus/page_content/attachments/DC-COVID-19-Data-for-July-1-2020_0.xlsx';
    $str = getPage($url);
    echo $str;

die();

    $pattern = '~[a-z]+://\S+~';
    echo "<ol>";
    if($num_found = preg_match_all($pattern, $str, $out))
    {
        foreach ($out[0] as $k => $v) {
            $pos = strpos($v, 'xlsx');
            if ($pos !== false) {
                $p = explode('">', $v);
                    echo "<li>CSV: <b>".$p[0]."</b><br /><small>$v</small></li>";
            }
        }
    }
    echo "</ol>";









?>
