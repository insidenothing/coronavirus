<?PHP
include_once('/var/www/secure.php');
function slack_bypass($msg,$room){
    	global $slack_api;
	$room = str_replace("'",'-',strtolower(str_replace(' ','-',$room)));
	$thisroom = $room;
	$msg = urlencode($msg);
	$token = $slack_api;
	$url = "https://slack.com/api/chat.postMessage?token=$token&channel=$thisroom&text=$msg";
	$curl = curl_init();
	curl_setopt ($curl, CURLOPT_URL, $url);
	curl_setopt ($curl, CURLOPT_TIMEOUT,"2");
	curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("McGuire/%d.0",rand(18,40)));
	curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$html = curl_exec ($curl);
	curl_close ($curl);
	if (empty($html)){
	    return $url;
	}
	return $html;
}
function slack_general($msg,$room){
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	    	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
	    	$ip = $_SERVER['REMOTE_ADDR'];
	}
	
    	global $slack_api;
	$room = str_replace("'",'-',strtolower(str_replace(' ','-',$room)));
	$thisroom = $room;
	/*
	if ($ip != '69.250.28.138'){
		if (isset($_SERVER['HTTP_USER_AGENT'])){
			$add = "[".$ip."][".$_SERVER['HTTP_USER_AGENT']."][".$_SERVER['PHP_SELF']."] ";
		}else{
			header('Location: callback.php?msg=Missing HTTP_USER_AGENT');
		}
		$msg = $add.$msg;	
	}
	*/
	$msg = str_replace('http://','_______',$msg);
	$msg = str_replace('https://','________',$msg);
	$msg = str_replace('.net','____',$msg);
	$msg = str_replace('.com','____',$msg);
	$msg = urlencode($msg);
	$token = $slack_api;
	if (isset($_COOKIE['name'])){
		$name = str_replace("'",'-',strtolower(str_replace(' ','-',$_COOKIE['name'])));
	}else{
		$name = '';	
	}
	/*
	$url = "https://slack.com/api/channels.create?token=$token&name=$thisroom&pretty=1";
	$curl = curl_init();
	curl_setopt ($curl, CURLOPT_URL, $url);
	curl_setopt ($curl, CURLOPT_TIMEOUT,"2");
	curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("McGuire/%d.0",rand(18,40)));
	curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$html = curl_exec ($curl);
	curl_close ($curl);
	*/
	$url = "https://slack.com/api/chat.postMessage?token=$token&channel=$thisroom&text=$msg";
	$curl = curl_init();
	curl_setopt ($curl, CURLOPT_URL, $url);
	curl_setopt ($curl, CURLOPT_TIMEOUT,"2");
	curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("McGuire/%d.0",rand(18,40)));
	curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$html = curl_exec ($curl);
	curl_close ($curl);
	if (empty($html)){
	    return $url;
	}
	return $html;
}
