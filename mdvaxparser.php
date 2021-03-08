<?php
require_once('/var/www/secure.php');

// Step 1: Register an Application
//TwittterAPIkey
//TwitterAPIsecretkey 
//TwitterBearertoken 

// Step 2: Create an OAuth Signature

$oauth_hash = '';

$oauth_hash .= 'oauth_consumer_key='.$TwittterAPIkey.'&';

$oauth_hash .= 'oauth_nonce=' . time() . '&';

$oauth_hash .= 'oauth_signature_method=HMAC-SHA1&';

$oauth_hash .= 'oauth_timestamp=' . time() . '&';

$oauth_hash .= 'oauth_token='.$TwitterBearertoken.'&';

$oauth_hash .= 'oauth_version=1.0';

$base = '';

$base .= 'GET';

$base .= '&';

$base .= rawurlencode('https://api.twitter.com/1.1/statuses/user_timeline.json');

$base .= '&';

$base .= rawurlencode($oauth_hash);

$key = '';

$key .= rawurlencode($TwitterAPIsecretkey);

$key .= '&';

$key .= rawurlencode($TwitterBearertoken);

$signature = base64_encode(hash_hmac('sha1', $base, $key, true));

$signature = rawurlencode($signature);

// Step 3: Construct the cURL Headers

$oauth_header = '';

$oauth_header .= 'oauth_consumer_key="'.$TwittterAPIkey.'", ';

$oauth_header .= 'oauth_nonce="' . time() . '", ';

$oauth_header .= 'oauth_signature="' . $signature . '", ';

$oauth_header .= 'oauth_signature_method="HMAC-SHA1", ';

$oauth_header .= 'oauth_timestamp="' . time() . '", ';

$oauth_header .= 'oauth_token="'.$TwitterBearertoken.'", ';

$oauth_header .= 'oauth_version="1.0", ';

$curl_header = array("Authorization: Oauth {$oauth_header}", 'Expect:');

// Step 4: Make the cURL Request

$curl_request = curl_init();

curl_setopt($curl_request, CURLOPT_HTTPHEADER, $curl_header);

curl_setopt($curl_request, CURLOPT_HEADER, false);

curl_setopt($curl_request, CURLOPT_URL, 'https://api.twitter.com/1.1/statuses/user_timeline.json');

curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, true);

curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, false);

$json = curl_exec($curl_request);

curl_close($curl_request);

$array = json_decode($json, true);

print_r($array);
