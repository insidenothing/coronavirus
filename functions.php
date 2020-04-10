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

function message_send($to,$master_message){	
	//die('offline');
	// take full message, split and loop
	$buffer='';
	$messages = str_split(strip_tags($master_message), 150);
	global $twillo_account;
	global $twillo_key;
	foreach ($messages as $message) {
		$message = str_replace('_', ' ', $message);	
		$curl = curl_init();
		curl_setopt ($curl, CURLOPT_URL, 'https://api.twilio.com/2010-04-01/Accounts/'.$twillo_account.'/SMS/Messages.xml');
		curl_setopt ($curl, CURLOPT_TIMEOUT, '5');
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, '1');
		$message = str_replace(' ','+',$message);
		$postfields = "From=%2B14433932367&To=$to&Body=$message";
		curl_setopt($curl, CURLOPT_USERPWD, "$twillo_account:$twillo_key"); 
		curl_setopt ($curl, CURLOPT_POSTFIELDS, $postfields);
		$bufferX = curl_exec ($curl);
		$buffer .= htmlspecialchars($bufferX);
		curl_close ($curl);
	}
	return $buffer;
}
	
function county_aka($county){
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
	return $county;
}
function county_daka($county){
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
	return $county;
}

function make_maryland_array($json=''){
	$return = array();
	if ($json != ''){
		$array = json_decode($json, true);
		return $array;
	}
	// old https://services.arcgis.com/njFNhDsUCentVYJW/arcgis/rest/services/MASTER_CaseTracker_1/FeatureServer/0/query?where=1%3D1&outFields=*&returnGeometry=false&outSR=4326&f=json
	// https://services.arcgis.com/njFNhDsUCentVYJW/arcgis/rest/services/MASTER_TotalsTracker/FeatureServer/0/query?where=1%3D1&outFields=*&outSR=4326&f=json
	$url = 'https://services.arcgis.com/njFNhDsUCentVYJW/arcgis/rest/services/MASTER_CaseTracker_1/FeatureServer/0/query?where=1%3D1&outFields=*&returnGeometry=false&outSR=4326&f=json';
	$return['url_pulled'] = $url;
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
	*/
	echo '</div></td></tr></table>';
	$debug = ob_get_clean();
	//echo $debug;
	return $array['features'];
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
