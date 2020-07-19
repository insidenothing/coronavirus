<?PHP
function format_json($json){
	$return = array();
	$array = json_decode($json, true);
	return $return;
}

function make_florida_zip_array2($url='',$json='',$force=''){
	global $zip2name;
	global $debug;
	global $arcgis_key;
	global $core;
	$return = array();
	if ($json != ''){
		$array = json_decode($json, true);
		return $array;
	}
	$url = 'https://services1.arcgis.com/CY1LXxl9zlJeBuRZ/ArcGIS/rest/services/Florida_COVID_19_Deaths_by_Day/FeatureServer/0/query?where=1%3D1&objectIds=&time=&resultType=none&outFields=*&returnIdsOnly=false&returnUniqueIdsOnly=false&returnCountOnly=false&returnDistinctValues=false&cacheHint=false&orderByFields=&groupByFieldsForStatistics=&outStatistics=&having=&resultOffset=&resultRecordCount=&sqlFormat=none&f=pjson&token=';
	$return['url_pulled'] = $url;
	if($force == ''){
		$q = "select raw_response from coronavirus where url_pulled = '$url' order by id desc";
		$debug .= "<p>USING SAVED VERSION $q</p>";
		$r = $core->query($q);
		$d = mysqli_fetch_array($r);
		$json = $d['raw_response'];
	}else{
		$json = getPage($url);
		global $raw;
		$raw = $json;
	}
	if ($json == '{"error":{"code":499,"message":"Token Required","messageCode":"GWM_0003","details":["Token Required"]}}'){
		die('499');	
	}
	if ($json == '{"error":{"code":504,"message":"Your request has timed out.","details":[]}}'){
		die('504');	
	}
	if ($json == '{"error":{"code":503,"message":"An error occurred.","details":[]}}'){
		die('503');
	}
	if ($json == '{"error":{"code":400,"message":"Invalid URL","details":["Invalid URL"]}}'){
		die('400');
	}
	if ($json == '{
  "error" : 
  {
    "code" : 400, 
    "message" : "Cannot perform query. Invalid query parameters.", 
    "details" : [
      "Unable to perform query. Please check your parameters."
    ]
  }
}'){
	die('400');	
	}
	ob_start();
	$array = json_decode($json, true);
	echo '<pre>';
	print_r($array);
	echo '</pre>';
	$debug .= ob_get_clean();
	foreach ($array['features'] as $key => $value){
		$date = $value['attributes']['Date'];
		$return[$date]['Deaths'] = $value['attributes']['Deaths'];
	}
	return $return;
}
function make_florida_zip_array($url='',$json='',$force=''){
	global $zip2name;
	global $debug;
	global $arcgis_key;
	global $core;
	$return = array();
	$return['url_pulled'] = $url;
	if ($json == '{"error":{"code":499,"message":"Token Required","messageCode":"GWM_0003","details":["Token Required"]}}'){
		die('499');	
	}
	if ($json == '{"error":{"code":504,"message":"Your request has timed out.","details":[]}}'){
		die('504');	
	}
	if ($json == '{"error":{"code":503,"message":"An error occurred.","details":[]}}'){
		die('503');
	}
	if ($json == '{"error":{"code":400,"message":"Invalid URL","details":["Invalid URL"]}}'){
		die('400');
	}
	if ($json == '{
  "error" : 
  {
    "code" : 400, 
    "message" : "Cannot perform query. Invalid query parameters.", 
    "details" : [
      "Unable to perform query. Please check your parameters."
    ]
  }
}'){
	die('400');	
	}
	ob_start();
	$array = json_decode($json, true);
	echo '<pre>';
	print_r($array);
	echo '</pre>';
	$debug .= ob_get_clean();
	foreach ($array['features'] as $key => $value){
		$zip = $value['attributes']['ZIP'];
		$return[$zip]['ProtectedCount'] = $value['attributes']['Cases'];
		$zip2name[$zip] = $value['attributes']['c_places'] ;
	}
	return $return;
}



function get_hits(){
	global $core;
	$page = $_SERVER['SCRIPT_NAME'];
	$q = "select * from coronavirus_stats where REQUEST_URI = '$page' ";
	$r = $core->query($q);
	$d = mysqli_fetch_array($r);
	$stat = "$page received $d[hit_counter] hits since $d[started_on].";
	return $stat;
}

function set_hits(){
	global $core;
	$page = $_SERVER['SCRIPT_NAME'];
	$q = "select * from coronavirus_stats where REQUEST_URI = '$page' ";
	$r = $core->query($q);
	$d = mysqli_fetch_array($r);
	if ($d['id'] > 0){
		$up = $d['hit_counter'] + 1;
		$core->query("update coronavirus_stats set hit_counter = '$up', last_hit = NOW() where REQUEST_URI = '$page' ");
	}else{
		$core->query("insert into coronavirus_stats ( hit_counter, REQUEST_URI, started_on  ) values ( '1', '$page', NOW() ) ");
	}
	
}
function getPage($url){
	$url = str_replace('[month]',date('F'),$url); // replace month January through December
	$url = str_replace('[day]',date('j'),$url); // replace day 1 to 31
	$url = str_replace('[yesterday]',date('j',strtotime('yesterday')),$url); // replace day 1 to 31
	$url = str_replace('[year]',date('Y'),$url); // replace year Examples: 1999 or 2003
	
    $curl = curl_init();
    curl_setopt ($curl, CURLOPT_URL, $url);
    curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("McGuire Coronavirus Monitor covid19math.net /%d.0",rand(4,50)));
    curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt ($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt ($curl, CURLOPT_HTTPHEADER, array("Cookie: policy_accepted=true"));
    $html = curl_exec ($curl);
    curl_close ($curl);
    return $html;
}
function getPageDebug($url){
	$url = str_replace('[month]',date('F'),$url); // replace month January through December
	$url = str_replace('[day]',date('j'),$url); // replace day 1 to 31
	$url = str_replace('[yesterday]',date('j',strtotime('yesterday')),$url); // replace day 1 to 31
	$url = str_replace('[year]',date('Y'),$url); // replace year Examples: 1999 or 2003
	
    $curl = curl_init();
    curl_setopt ($curl, CURLOPT_URL, $url);
    curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("McGuire Coronavirus Monitor covid19math.net /%d.0",rand(4,50)));
    curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt ($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt ($curl, CURLOPT_HTTPHEADER, array("Cookie: policy_accepted=true"));
    $html = curl_exec ($curl);
    curl_close ($curl);
    echo "<div>getPageDebug()</div><div>$url</div><div>$html</div>";
    return $html;
}

function clean_up_county($str){
	$str = str_replace("'",'',$str); // remove single quotes
	$str = str_replace(' ','',$str); // remove spaces
	$str = str_replace('.','',$str); // remove .
	$str = str_replace('-','to',$str); // covert '-' to 'to'
	return $str;
}

function sms_one($to,$message){
    //global $send_message;
    //$url = "https://www.mdwestserve.com/sms/message_send/$to/".str_replace(' ','_',$msg);
    message_send($to,$message);
    //getPage($url);
}

function sms($msg){
    	global $send_message;
    	if ($send_message == 'on'){
		global $core;
		$r = $core->query("SELECT sms_number FROM coronavirus_sms where sms_status = 'confirmed' ");
		while($d = mysqli_fetch_array($r)){
			$sms = trim($d['sms_number']);
			$url = "https://www.mdwestserve.com/sms/message_send/$sms/COVID19_".str_replace(' ','_',$msg);
			//getPage($url);
		}
	}
    	echo '<div>'.$msg.' </div>';	
}

function message_send($to,$master_message,$media=''){	
	if ($media != ''){
		$media= '&MediaUrl='.$media;
	}
	//die('offline');
	// take full message, split and loop
	$buffer='';
	$messages = str_split(strip_tags($master_message), 150);
	global $twillo_account;
	global $twillo_key;
	
	foreach ($messages as $message) {
		$message = str_replace('_', ' ', $message);	
		$curl = curl_init();
		curl_setopt ($curl, CURLOPT_URL, 'https://api.twilio.com/2010-04-01/Accounts/'.$twillo_account.'/Messages.json');
		curl_setopt ($curl, CURLOPT_TIMEOUT, '5');
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, '1');
		$message = str_replace(' ','+',$message);
		$postfields = "From=%2B14433932367&To=$to&Body=$message$media";
		curl_setopt($curl, CURLOPT_USERPWD, "$twillo_account:$twillo_key"); 
		curl_setopt ($curl, CURLOPT_POSTFIELDS, $postfields);
		$bufferX = curl_exec ($curl);
		$buffer .= htmlspecialchars($bufferX);
		curl_close ($curl);
	}
	return $buffer;
}
	
function county_aka($county){
	// aliases not in death or prob death
	if ($county == 'MarylandNegative'){ return 'NegativeTests'; }
	if ($county == 'MarylandICU'){ return 'bedsICU'; }
	if ($county == 'MarylandAcute'){ return 'bedsAcute'; }
	if ($county == 'MarylandTotal'){ return 'bedsTotal'; }
	if ($county == 'Maryland_hospitalized'){ return 'total_hospitalized'; }	
	if ($county == 'Maryland_released'){ return 'total_released'; }	
	if ($county == 'under18'){ return 'under18'; }
	if ($county == '18to64'){ return '18to64'; }
	if ($county == '65plus'){ return '65plus'; }
	// three stage data
	if ($county == 'DOD'){ return 'DOD'; } // not listed yet... 
 	if ($county == 'Allegany'){ return 'ALLE'; }
        if ($county == 'AnneArundel'){ return 'ANNE'; }
        if ($county == 'Baltimore'){ return 'BALT'; }
        if ($county == 'BaltimoreCity'){ return 'BCITY'; }
        if ($county == 'Calvert'){ return 'CALV'; }
        if ($county == 'Caroline'){ return 'CARO'; }
        if ($county == 'Carroll'){ return 'CARR'; }
        if ($county == 'Cecil'){ return 'CECI'; }
        if ($county == 'Charles'){ return 'CHAR'; }
        if ($county == 'Dorchester'){ return 'DORC'; }
        if ($county == 'Frederick'){ return 'FRED'; }
        if ($county == 'Garrett'){ return 'GARR'; }
        if ($county == 'Harford'){ return 'HARF'; }
        if ($county == 'Howard'){ return 'HOWA'; }
        if ($county == 'Kent'){ return 'KENT'; }
        if ($county == 'Montgomery'){ return 'MONT'; }
        if ($county == 'PrinceGeorges'){ return 'PRIN'; }
        if ($county == 'QueenAnnes'){ return 'QUEE'; }
        if ($county == 'Somerset'){ return 'SOME'; }
        if ($county == 'StMarys'){ return 'STMA'; }
        if ($county == 'Talbot'){ return 'TALB'; }
        if ($county == 'Washington'){ return 'WASH'; }
        if ($county == 'Wicomico'){ return 'WICO'; }
        if ($county == 'Worcester'){ return 'WORC'; }
	if ($county == 'Maryland'){ return 'TotalCases'; }
	if ($county == '0to9'){ return 'case0to9'; }
	if ($county == '10to19'){ return 'case10to19'; }
	if ($county == '20to29'){ return 'case20to29'; }
	if ($county == '30to39'){ return 'case30to39'; }
	if ($county == '40to49'){ return 'case40to49'; }
	if ($county == '50to59'){ return 'case50to59'; }
	if ($county == '60to69'){ return 'case60to69'; }
	if ($county == '70to79'){ return 'case70to79'; }
	if ($county == '80plus'){ return 'case80plus'; }
	if ($county == 'AgeUnknown'){ return 'caseAgeUnknown'; }
	if ($county == 'genMale'){ return 'genMale'; }
	if ($county == 'genFemale'){ return 'genFemale'; }
	if ($county == 'genUnkn'){ return 'genUnkn'; }
	if ($county == 'AfrAmer'){ return 'caseAfrAmer'; }
	if ($county == 'White'){ return 'caseWhite'; }
	if ($county == 'Hispanic'){ return 'caseHispanic'; }
	if ($county == 'Asian'){ return 'caseAsian'; }
	if ($county == 'Other'){ return 'caseOther'; }
	if ($county == 'NotAVail'){ return 'caseNotAVail'; }
	
	return $county;
}
function county_daka($county){
	if ($county == 'DOD'){ return 'deathDOD'; }
 	if ($county == 'Allegany'){ return 'deathALLE'; }
        if ($county == 'AnneArundel'){ return 'deathANNE'; }
        if ($county == 'Baltimore'){ return 'deathBALT'; }
        if ($county == 'BaltimoreCity'){ return 'deathBCITY'; }
        if ($county == 'Calvert'){ return 'deathCALV'; }
        if ($county == 'Caroline'){ return 'deathCARO'; }
        if ($county == 'Carroll'){ return 'deathCARR'; }
        if ($county == 'Cecil'){ return 'deathCECI'; }
        if ($county == 'Charles'){ return 'deathCHAR'; }
        if ($county == 'Dorchester'){ return 'deathDORC'; }
        if ($county == 'Frederick'){ return 'deathFRED'; }
        if ($county == 'Garrett'){ return 'deathGARR'; }
        if ($county == 'Harford'){ return 'deathHARF'; }
        if ($county == 'Howard'){ return 'deathHOWA'; }
        if ($county == 'Kent'){ return 'deathKENT'; }
        if ($county == 'Montgomery'){ return 'deathMONT'; }
        if ($county == 'PrinceGeorges'){ return 'deathPRIN'; }
        if ($county == 'QueenAnnes'){ return 'deathQUEE'; }
        if ($county == 'Somerset'){ return 'deathSOME'; }
        if ($county == 'StMarys'){ return 'deathSTMA'; }
        if ($county == 'Talbot'){ return 'deathTALB'; }
        if ($county == 'Washington'){ return 'deathWASH'; }
        if ($county == 'Wicomico'){ return 'deathWICO'; }
        if ($county == 'Worcester'){ return 'deathWORC'; }
	if ($county == 'Maryland'){ return 'deaths'; }
	if ($county == '0to9'){ return 'death0to9'; }
	if ($county == '10to19'){ return 'death10to19'; }
	if ($county == '20to29'){ return 'death20to29'; }
	if ($county == '30to39'){ return 'death30to39'; }
	if ($county == '40to49'){ return 'death40to49'; }
	if ($county == '50to59'){ return 'death50to59'; }
	if ($county == '60to69'){ return 'death60to69'; }
	if ($county == '70to79'){ return 'death70to79'; }
	if ($county == '80plus'){ return 'death80plus'; }
	if ($county == 'AgeUnknown'){ return 'deathAgeUnknown'; }
	if ($county == 'genMale'){ return 'deathGenMale'; }
	if ($county == 'genFemale'){ return 'deathGenFemale'; }
	if ($county == 'genUnkn'){ return 'deathGenUnkn'; }
	if ($county == 'AfrAmer'){ return 'deathAfrAmer'; }
	if ($county == 'White'){ return 'deathWhite'; }
	if ($county == 'Hispanic'){ return 'deathHispanic'; }
	if ($county == 'Asian'){ return 'deathAsian'; }
	if ($county == 'Other'){ return 'deathOther'; }
	if ($county == 'NotAVail'){ return 'deathNotAVail'; }
	
	return $county;
}
function county_pdaka($county){
	if ($county == 'DOD'){ return 'pDeathDOD'; }
 	if ($county == 'Allegany'){ return 'pDeathALLE'; }
        if ($county == 'AnneArundel'){ return 'pDeathANNE'; }
        if ($county == 'Baltimore'){ return 'pDeathBALT'; }
        if ($county == 'BaltimoreCity'){ return 'pDeathBCITY'; }
        if ($county == 'Calvert'){ return 'pDeathCALV'; }
        if ($county == 'Caroline'){ return 'pDeathCARO'; }
        if ($county == 'Carroll'){ return 'pDeathCARR'; }
        if ($county == 'Cecil'){ return 'pDeathCECI'; }
        if ($county == 'Charles'){ return 'pDeathCHAR'; }
        if ($county == 'Dorchester'){ return 'pDeathDORC'; }
        if ($county == 'Frederick'){ return 'pDeathFRED'; }
        if ($county == 'Garrett'){ return 'pDeathGARR'; }
        if ($county == 'Harford'){ return 'pDeathHARF'; }
        if ($county == 'Howard'){ return 'pDeathHOWA'; }
        if ($county == 'Kent'){ return 'pDeathKENT'; }
        if ($county == 'Montgomery'){ return 'pDeathMONT'; }
        if ($county == 'PrinceGeorges'){ return 'pDeathPRIN'; }
        if ($county == 'QueenAnnes'){ return 'pDeathQUEE'; }
        if ($county == 'Somerset'){ return 'pDeathSOME'; }
        if ($county == 'StMarys'){ return 'pDeathSTMA'; }
        if ($county == 'Talbot'){ return 'pDeathTALB'; }
        if ($county == 'Washington'){ return 'pDeathWASH'; }
        if ($county == 'Wicomico'){ return 'pDeathWICO'; }
        if ($county == 'Worcester'){ return 'pDeathWORC'; }
	if ($county == 'Maryland'){ return 'pDeaths'; }
	if ($county == '0to9'){ return 'pDeath0to9'; }
	if ($county == '10to19'){ return 'pDeath10to19'; }
	if ($county == '20to29'){ return 'pDeath20to29'; }
	if ($county == '30to39'){ return 'pDeath30to39'; }
	if ($county == '40to49'){ return 'pDeath40to49'; }
	if ($county == '50to59'){ return 'pDeath50to59'; }
	if ($county == '60to69'){ return 'pDeath60to69'; }
	if ($county == '70to79'){ return 'pDeath70to79'; }
	if ($county == '80plus'){ return 'pDeath80plus'; }
	if ($county == 'AgeUnknown'){ return 'pDeathAgeUnknown'; }
	if ($county == 'genMale'){ return 'pDeathGenMale'; }
	if ($county == 'genFemale'){ return 'pDeathGenFemale'; }
	if ($county == 'genUnkn'){ return 'pDeathGenUnkn'; }
	if ($county == 'AfrAmer'){ return 'pDeathAfrAmer'; }
	if ($county == 'White'){ return 'pDeathWhite'; }
	if ($county == 'Hispanic'){ return 'pDeathHispanic'; }
	if ($county == 'Asian'){ return 'pDeathAsian'; }
	if ($county == 'Other'){ return 'pDeathOther'; }
	if ($county == 'NotAVail'){ return 'pDeathNotAVail'; }
	return $county;
}
function make_maryland_array($json=''){
	//$return = array();
	//if ($json != ''){
	//	$array = json_decode($json, true);
	//	return $array;
	//}
	// old https://services.arcgis.com/njFNhDsUCentVYJW/arcgis/rest/services/MASTER_CaseTracker_1/FeatureServer/0/query?where=1%3D1&outFields=*&returnGeometry=false&outSR=4326&f=json
	// https://services.arcgis.com/njFNhDsUCentVYJW/arcgis/rest/services/MASTER_TotalsTracker/FeatureServer/0/query?where=1%3D1&outFields=*&outSR=4326&f=json
	
	//$url = 'https://services.arcgis.com/njFNhDsUCentVYJW/arcgis/rest/services/MD_COVID_19_CasesByCounty/FeatureServer/0/query?where=1%3D1&outFields=*&outSR=4326&f=json';
	//$url = 'https://services.arcgis.com/njFNhDsUCentVYJW/arcgis/rest/services/MASTER_CaseTracker_3/FeatureServer/0/query?where=1%3D1&outFields=*&returnGeometry=false&outSR=4326&f=json';
	//$return['url_pulled'] = $url;
	//$json = getPage($url);
	
	global $core;
	$q = "SELECT * FROM `coronavirus_api_cache` where api_id = '20' order by id DESC limit 0, 1";
	$r = $core->query($q);
	$d = mysqli_fetch_array($r);
	$json = $d['raw_response'];
	
	
	global $raw;
	$raw = $json;
	if ($json == '{"error":{"code":499,"message":"Token Required","messageCode":"GWM_0003","details":["Token Required"]}}'){
		die('499');	
	}
	if ($json == '{"error":{"code":504,"message":"Your request has timed out.","details":[]}}'){
		die('504');	
	}
	if ($json == '{"error":{"code":503,"message":"An error occurred.","details":[]}}'){
		die('503');
	}
	if ($json == '{"error":{"code":400,"message":"Invalid URL","details":["Invalid URL"]}}'){
		die('400');
	}
	ob_start();
	$array = json_decode($json, true);
	echo '<table><tr><td valign="top"><h1>Database</h1><pre>';
	print_r($array['fields']);
	echo '</pre></td>';
	echo '<td valign="top"><h1>Data</h1><div>';
	 
	foreach ($array['features'] as $key => $value){
		$time = $value['attributes']['ReportDate'] / 1000;
		$date = date('Y-m-d',$time+14400);
		$return[$date] = $value['attributes'];
		$return['date'] = $date; // last date used in the array
		echo "<h3>UPDATE $date</h1>";
		foreach ($value['attributes'] as $key2 => $value2){
			echo "<li>$key2 => $value2</li>";
		}
	}
	echo '</div></td></tr></table>';
	$debug = ob_get_clean();
	//echo $debug;
	return $return;
}

function make_maryland_array2($json=''){
	$return = array();
	if ($json != ''){
		$array = json_decode($json, true);
		return $array;
	}
	// old https://services.arcgis.com/njFNhDsUCentVYJW/arcgis/rest/services/MASTER_CaseTracker_1/FeatureServer/0/query?where=1%3D1&outFields=*&returnGeometry=false&outSR=4326&f=json
	// 
	$url = 'https://services.arcgis.com/njFNhDsUCentVYJW/arcgis/rest/services/MASTER_TotalsTracker/FeatureServer/0/query?where=1%3D1&outFields=*&outSR=4326&f=json';
	$return['url_pulled'] = $url;
	$json = getPage($url);
	global $raw;
	$raw = $json;
	if ($json == '{"error":{"code":499,"message":"Token Required","messageCode":"GWM_0003","details":["Token Required"]}}'){
		die('499');	
	}
	if ($json == '{"error":{"code":504,"message":"Your request has timed out.","details":[]}}'){
		die('504');	
	}
	if ($json == '{"error":{"code":503,"message":"An error occurred.","details":[]}}'){
		die('503');
	}
	if ($json == '{"error":{"code":400,"message":"Invalid URL","details":["Invalid URL"]}}'){
		die('400');
	}
	ob_start();
	$array = json_decode($json, true);
	echo '<table><tr><td valign="top"><h1>Database</h1><pre>';
	print_r($array['fields']);
	echo '</pre></td>';
	echo '<td valign="top"><h1>Data</h1><div>';
	/* 
	
		$time = $value['attributes']['ReportDate'] / 1000;
		$date = date('Y-m-d',$time+14400);
		$return[$date] = $value['attributes'];
		$return['date'] = $date; // last date used in the array
		echo "<h3>UPDATE $date</h1>";
		foreach ($value['attributes'] as $key2 => $value2){
			echo "<li>$key2 => $value2</li>";
		}
	}
	*/
	echo '</div></td></tr></table>';
	$debug = ob_get_clean();
	//echo $debug;
	
	//$array['features']['url_pulled'] = $url;
	
	foreach ($array['features'] as $key => $value){
		$dem = clean_up_county($value['attributes']['Demographic']);
		$return[$dem]['CaseCount'] = $value['attributes']['CaseCount'];
		$return[$dem]['DeathCount'] = $value['attributes']['DeathCount'];	
	}
	
	return $return;
}

global $zip2name;
function make_maryland_array3($json,$date){
	global $zip2name;
	global $debug;
	global $arcgis_key;
	global $core;
	$return = array();
	global $raw;
	$raw = $json;
	if ($json == '{"error":{"code":499,"message":"Token Required","messageCode":"GWM_0003","details":["Token Required"]}}'){
		die('499');	
	}
	if ($json == '{"error":{"code":504,"message":"Your request has timed out.","details":[]}}'){
		die('504');	
	}
	if ($json == '{"error":{"code":503,"message":"An error occurred.","details":[]}}'){
		die('503');
	}
	if ($json == '{"error":{"code":400,"message":"Invalid URL","details":["Invalid URL"]}}'){
		die('400');
	}
	if ($json == '{
  "error" : 
  {
    "code" : 400, 
    "message" : "Cannot perform query. Invalid query parameters.", 
    "details" : [
      "Unable to perform query. Please check your parameters."
    ]
  }
}'){
	die('400');	
	}
	ob_start();
	$array = json_decode($json, true);
	echo '<pre>';
	print_r($array);
	echo '</pre>';
	$debug .= ob_get_clean();
	foreach ($array['features'] as $key => $value){
		$zip = $value['attributes']['ZIP_CODE'];
		if ($date != ''){
		 $date_formated = $date;	
		}else{
		 $date_formated = 'total'.$date_formated = date('m_d_Y');	
		}
		$return[$zip] = $value['attributes'][$date_formated];
	}
	return $return;
}
function wikidata(){
  global $core;
$return = array();
$i=1; 
$url = "https://en.m.wikipedia.org/wiki/2020_coronavirus_pandemic_in_Maryland";
$html = getPage($url);
$array = explode('timeline',strtolower($html));
$array = explode('january',$array[5]);
foreach ($array as $v) {
  if ($i == 1){
      $graph = str_replace('mw-ui-icon mw-ui-icon-element mw-ui-icon-minerva-edit-enabled edit-page mw-ui-icon-flush-right','',$v);
      $graph = str_replace('" data-section="1" class="">edit','',$graph);
      $graph = str_replace('covid-19 cases in maryland, united states','',$graph);
      $graph = str_replace('<div class="plainlinks hlist navbar mini"><ul><li class="nv-view"><a href="/wiki/template:2019%e2%80%9320_coronavirus_pandemic_data/united_states/maryland_medical_cases_chart" title="template:2019–20 coronavirus pandemic data/united states/maryland medical cases chart"><abbr title="view this template">v</abbr></a></li><li class="nv-talk"><a href="/wiki/template_talk:2019%e2%80%9320_coronavirus_pandemic_data/united_states/maryland_medical_cases_chart" title="template talk:2019–20 coronavirus pandemic data/united states/maryland medical cases chart"><abbr title="discuss this template">t</abbr></a></li><li class="nv-edit"><a class="external text" href="https://en.wikipedia.org/w/index.php?title=template:2019%e2%80%9320_coronavirus_pandemic_data/united_states/maryland_medical_cases_chart&amp;action=edit"><abbr title="edit this template">e</abbr></a></li></ul></div>','',$graph);
      $graph = str_replace('()','',$graph);
      $graph = str_replace('the number of cases confirmed in maryland.','',$graph); 
      $graph = str_replace('cases:','',$graph);
      $graph = str_replace('sources:','',$graph);
      $graph = str_replace('[2]','',$graph);
      $return['graph'] = $graph;
      //echo $graph;   
  }
  if ($i == 6){
      echo "<hr>";
      $array2 = explode('statistics',$v);
      $i2=1;
      foreach ($array2 as $v2) {
        if ($i2 == 4){
          $chart = str_replace('mw-ui-icon mw-ui-icon-element mw-ui-icon-minerva-edit-enabled edit-page mw-ui-icon-flush-right','',$v2);
          $chart = str_replace('" data-section="1" class="">edit','',$chart);
          $chart = str_replace('2019 novel coronavirus (covid-19) cases in maryland as of march 25, 2020','',$chart);
          $chart = str_replace('edit','',$chart);
          $chart = str_replace('[1]','',$chart);
          $chart = str_replace('" data-section="22" class="">','',$chart);
          $array3 = explode('references',$chart);
          $chart = $array3[0];
          $return['chart'] = $chart;
          //echo $chart;
          $chart = str_replace('<tr><th scope="col">county
</th>
<th scope="col">confirmed <br> cases
</th>
<th scope="col">deaths
</th>
<th scope="col">recoveries
</th></tr>','',$chart);
          $chart = str_replace('<table class="wikitable sortable" style="text-align:right"><caption><sup id="cite_ref-:3_1-3" class="reference"><a href="#cite_note-:3-1"></a></sup></caption>
<tbody>','',$chart);
          
  $r = $core->query("SELECT html, checked_datetime FROM coronavirus_wiki order by id DESC limit 0,1");
  $d = mysqli_fetch_array($r);
  $old = $d['html'];        
          
  $test1 = $old;
  $test2 = $chart;
  $send_wiki_message = 'off';
if ($test1 != $test2){
    // origional alert and insert
    $new = $core->real_escape_string($chart);
    $core->query("insert into coronavirus_wiki (checked_datetime, html) values (NOW(), '$new')");
    $send_wiki_message = 'on';
    //$url = "https://www.mdwestserve.com/sms/message_send/4433862584/Coronavirus_Update";
    //getPage($url);
 
}
          
           // Latest Data
          $array4 = explode('</tr>',$chart);
          foreach ($array4 as $v4) {
            $csv = str_replace('</td>',',',$v4);
            //echo $csv;
            $clean = strip_tags($csv);                   
            echo "<div>";
            $array5 = explode(',',$clean); 
            $county = trim($array5[0]);
            $cases = $array5[1];
            $deaths = $array5[2];
            $recovered = $array5[3];
            $new_deaths[$county] = intval($deaths);
            if ($new_deaths[$county] > 0){
              //echo "<li>Watch $county deaths ".$new_deaths[$county]." </li>"; 
            }
            $new_recovered[$county] = intval($recovered);
            if ($new_recovered[$county] > 0){
              //echo "<li>Watch $county recovered ".$new_recovered[$county]." </li>"; 
            }
            echo "</div>";
          }
          ob_start();
          $r = $core->query("SELECT html, checked_datetime FROM coronavirus_wiki order by id DESC limit 1,1");
          $d = mysqli_fetch_array($r);
          // Whats changed
          $array4 = explode('</tr>',$d['html']);
          foreach ($array4 as $v4) {
            $csv = str_replace('</td>',',',$v4);
            //echo $csv;
            $clean = strip_tags($csv);                   
            //echo "<div><b>$county</b> ";
            $array5 = explode(',',$clean); 
            $county = trim($array5[0]);
            $cases = $array5[1];
            $deaths = $array5[2];
            $recovered = $array5[3];
            $old_deaths[$county] = intval($deaths);
            $old_recovered[$county] = intval($recovered);

            if ($old_deaths[$county] != $new_deaths[$county]){
              echo "<p> $county deaths ".$old_deaths[$county]." to ".$new_deaths[$county]." </p>"; 
            }
            
             if ($old_recovered[$county] != $new_recovered[$county]){
              echo "<p> $county recovered ".$old_recovered[$county]." to ".$new_recovered[$county]." </p>"; 
            }
            //echo "Last Value there are $deaths deaths $recovered recovered."  ;
            //echo "</div>";
          }
          
          $changes = ob_get_clean();
	  $changes = ucwords($changes);	
          $messages = str_split(strip_tags($changes), 150);
          foreach ($messages as $msg) {
             if ($send_wiki_message == 'on'){
              global $core;
              $r = $core->query("SELECT sms_number FROM coronavirus_sms where sms_status = 'confirmed' ");
              while($d = mysqli_fetch_array($r)){
                $sms = trim($d['sms_number']);
                //message_send($sms,$msg);
              }
            }  
          }
          $return['changes'] = $changes;       
          //echo $changes;
        }
        $i2++;
      }
  }
  $i++;
}
return $return;
}
