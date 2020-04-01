<html>
<head>
	<?PHP 
	if(isset($page_description)){
		echo "<title>$page_description</title>";
	}elseif (isset($_POST['checked_datetime'])){ 
		echo "<title>Maryland COVID19 Digital Resources - ".$_POST['checked_datetime']."</title>";
	}else{
		echo "<title>Maryland COVID19 Digital Resources</title>";
	}
	if (empty($page_description)){
		$page_description = 'Get SMS Updates';	
	}
	?>
  <link rel="apple-touch-icon" sizes="180x180" href="/coronavirus/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/coronavirus/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/coronavirus/favicon-16x16.png">
  <link rel="manifest" href="/coronavirus/site.webmanifest">
  <meta property="og:url"           content="https://www.mdwestserve.com<?PHP echo $_SERVER['REQUEST_URI'];?>" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="Maryland COVID19 Digital Resources" />
  <meta property="og:description"   content="<?PHP echo $page_description;?>" />
  <meta property="og:image"         content="https://www.mdwestserve.com/coronavirus/vrus.png" />
  <?PHP if (empty($_GET['debug'])){ ?>	
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <?PHP } ?>
<?PHP
global $send_message;
global $core;

include_once('../secure.php'); //outside webserver

function getPage($url){
    $curl = curl_init();
    curl_setopt ($curl, CURLOPT_URL, $url);
    curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("McGuire coronavirus monitor /%d.0",rand(4,50)));
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
    	echo '<p>'.$msg.'</p>';	
}

function message_send($to,$message){	
	$message = str_replace('_', ' ', $message);	
	$curl = curl_init();
	curl_setopt ($curl, CURLOPT_URL, 'https://api.twilio.com/2010-04-01/Accounts/AC2708b19f42abb601cf49e9a235f3a99c/SMS/Messages.xml');
	curl_setopt ($curl, CURLOPT_TIMEOUT, '5');
	curl_setopt ($curl, CURLOPT_RETURNTRANSFER, '1');
	$message = str_replace(' ','+',$message);
	$postfields = "From=%2B14433932367&To=$to&Body=$message";
	curl_setopt($curl, CURLOPT_USERPWD, "AC2708b19f42abb601cf49e9a235f3a99c:be2f0a72190fffe8009251109746216b"); 
	curl_setopt ($curl, CURLOPT_POSTFIELDS, $postfields);
	$buffer = curl_exec ($curl);
	$buffer = htmlspecialchars($buffer);
	curl_close ($curl);
	return $buffer;
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

?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-133212884-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-133212884-1');
</script>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v6.0"></script>
	</head>
	<body style="background-color:black">
		<style>
			#rcorners2 {
			  border-radius: 25px;
			}
		</style>
<center><div style="background-color:white; width:1300;" id="rcorners2">
	<?PHP
	if (empty($logo)){
		// set logo to anything to hide this
		echo '<img src="header.PNG"  class="img-rounded" >';	
	}
	?>
<table><tr>
	<td><a href='index.php'><img src='home.png'></a></td>
	<td><a href='graphs.php'><img src='graphs.png'></a></td>
	<td><a href='infection_level.php'><img src='infected.png'></a></td>
	<td><a href='signup.php'><img src='signup.png'></a></td>
	<td><a href='https://www.facebook.com/groups/231583938033989/'><img src='facebook.png'></a></td>
	<td><a href='wiki.php'><img src='recovered.png'></a></td>
	<td><a href='https://www.patrickmcguire.me/'><img src='blog.png'></a></td>
	<td><a href='bright.php'><img src='bright.png'></a></td>
	<td><div class="fb-share-button" data-href="https://www.mdwestserve.com<?PHP echo $_SERVER['REQUEST_URI'];?>" data-layout="box_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.mdwestserve.com%2Fcoronavirus%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div></td>
	
	</tr></table>

