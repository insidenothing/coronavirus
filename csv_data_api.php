<?PHP


function getPage($url){
    $curl = curl_init();
    curl_setopt ($curl, CURLOPT_URL, $url);
    curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("McGuire Coronavirus Monitor covid19math.net /%d.0",rand(4,50)));
    curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $html = curl_exec ($curl);
    curl_close ($curl);
    return $html;
}

$url = 'https://www.vdh.virginia.gov/coronavirus/';


$str = getPage($url);


$pattern = '~[a-z]+://\S+~';


if($num_found = preg_match_all($pattern, $str, $out))
{
    foreach ($out[0] as $k => $v) {
        $pos = strpos($v, 'csv');
        if ($pos !== false) {
            $p = explode('">', $v);
                echo "<li>CSV: ".$p[0]."</li>";
                echo "<li>$v</li>";
        }
    }
}

?>
