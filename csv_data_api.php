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
  echo "FOUND ".$num_found." LINKS:\n";
  print_r($out[0]);
}

?>
