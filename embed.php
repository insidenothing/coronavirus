<?PHP die ('maintenance mode'); ?>
<html>
<head>
	<?PHP 
	if (isset($_POST['checked_datetime'])){ 
		echo "<title>Maryland COVID19 SMS Text Message Monitor - ".$_POST['checked_datetime']."</title>";
	}else{
		echo "<title>Maryland COVID19 SMS Text Message Monitor</title>";
	}
	?>
  <link rel="apple-touch-icon" sizes="180x180" href="/coronavirus/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/coronavirus/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/coronavirus/favicon-16x16.png">
  <link rel="manifest" href="/coronavirus/site.webmanifest">
  <meta property="og:url"           content="https://www.mdwestserve.com/coronavirus/" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="Maryland COVID19 SMS Text Message Monitor" />
  <meta property="og:description"   content="Get SMS Updates" />
  <meta property="og:image"         content="https://www.mdwestserve.com/coronavirus/vrus.png" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?PHP
global $send_message;
global $covid_db;

include_once('/var/www/secure.php'); //outside webserver

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
// nothing
    	echo '<p>'.$msg.'</p>';	
}

function message_send($to,$message){	
	// nothing
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
			p {
				margin:0;
				padding:0;
			}
		</style>
<div style="background-color:white; width:300px" id="rcorners2">
<table><tr>
	<td><a href='signup.php'><img src='signup.png'></a></td>
	<td><div class="fb-share-button" data-href="https://www.mdwestserve.com/coronavirus/" data-layout="box_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.mdwestserve.com%2Fcoronavirus%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div></td>
	<td><a href='https://www.facebook.com/groups/231583938033989/'><img src='facebook.png'></a></td>
	</tr></table>
<?PHP
echo "<div class='container' style='width:300px'><div class='row'>";
global $send_message;
$send_message = 'off';


// Last Version
$r = $covid_db->query("SELECT html, checked_datetime FROM coronavirus order by id DESC limit 0,1");
$d = mysqli_fetch_array($r);
$old = $d['html'];
// Most Recent Version
$mainURL = 'https://services.arcgis.com/njFNhDsUCentVYJW/arcgis/rest/services/MD_COVID19_Case_Counts_by_County';
// Data Set to Return
$url = $mainURL."/FeatureServer/0/query?where=1%3D1&outFields=COUNTY,COVID19Cases,COVID19Deaths,COVID19Recovered&returnGeometry=false&outSR=4326&f=json";
$html = getPage($url);
$new = $covid_db->real_escape_string($html);
$test1 = $old;
$test2 = $html;


// Compare Most Recent to Last Change
$r = $covid_db->query("SELECT id, checked_datetime FROM coronavirus order by id DESC limit 0,1");
$d = mysqli_fetch_array($r);
$new_date = $d['checked_datetime'];
$new_id = $d['id'];

$y_time = strtotime($new_date) - 86400;
$yesterday = date('Y-m-d',$y_time);



if (isset($_POST['checked_datetime'])){
    $date = $_POST['checked_datetime'];
    $r = $covid_db->query("SELECT html, checked_datetime FROM coronavirus where checked_datetime = '$date' ");
}else{
    // first frport from yesterday to last report of this day
    $r = $covid_db->query("SELECT html, checked_datetime FROM coronavirus where checked_datetime like '$yesterday %' order by id ASC limit 1");  
}
$d = mysqli_fetch_array($r);
$old = $d['html'];
$old_date = $d['checked_datetime'];





// Convert json objects to array
$array1 = json_decode($old, true);
$array2 = json_decode($html, true);

// These are the Last Numbers
$current_total_cases = 0;
$current_total_deaths = 0;
$current_total_recovered = 0;
$AlleganyCOVID19Cases1          = $array1['features'][0]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $AlleganyCOVID19Cases1;
$AlleganyCOVID19Deaths1         = $array1['features'][0]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $AlleganyCOVID19Deaths1;	
$AlleganyCOVID19Recovered1      = $array1['features'][0]['attributes']['COVID19Recovered']; 
$current_total_recovered = $current_total_recovered + $AlleganyCOVID19Recovered1;
$AnneArundelCOVID19Cases1	    = $array1['features'][1]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $AnneArundelCOVID19Cases1;
$AnneArundelCOVID19Deaths1	    = $array1['features'][1]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $AnneArundelCOVID19Deaths1;
$AnneArundelCOVID19Recovered1   = $array1['features'][1]['attributes']['COVID19Recovered']; 
$current_total_recovered = $current_total_recovered + $AnneArundelCOVID19Recovered1;
$BaltimoreCOVID19Cases1		    = $array1['features'][2]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $BaltimoreCOVID19Cases1;
$BaltimoreCOVID19Deaths1		= $array1['features'][2]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $BaltimoreCOVID19Deaths1;
$BaltimoreCOVID19Recovered1		= $array1['features'][2]['attributes']['COVID19Recovered']; 
$current_total_recovered = $current_total_recovered + $BaltimoreCOVID19Recovered1;
$BaltimoreCityCOVID19Cases1		= $array1['features'][3]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $BaltimoreCityCOVID19Cases1;
$BaltimoreCityCOVID19Deaths1	= $array1['features'][3]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $BaltimoreCityCOVID19Deaths1;
$BaltimoreCityCOVID19Recovered1	= $array1['features'][3]['attributes']['COVID19Recovered']; 
$current_total_recovered = $current_total_recovered + $BaltimoreCityCOVID19Recovered1;	
$CalvertCOVID19Cases1		    = $array1['features'][4]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $CalvertCOVID19Cases1;
$CalvertCOVID19Deaths1		    = $array1['features'][4]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $CalvertCOVID19Deaths1;
$CalvertCOVID19Recovered1		= $array1['features'][4]['attributes']['COVID19Recovered'];	 
$current_total_recovered = $current_total_recovered + $CalvertCOVID19Recovered1;
$CarolineCOVID19Cases1		    = $array1['features'][5]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $CarolineCOVID19Cases1;
$CarolineCOVID19Deaths1		    = $array1['features'][5]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $CarolineCOVID19Deaths1;
$CarolineCOVID19Recovered1	    = $array1['features'][5]['attributes']['COVID19Recovered'];	 
$current_total_recovered = $current_total_recovered + $CarolineCOVID19Recovered1;
$CarrollCOVID19Cases1		    = $array1['features'][6]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $CarrollCOVID19Cases1;
$CarrollCOVID19Deaths1	        = $array1['features'][6]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $CarrollCOVID19Deaths1;	
$CarrollCOVID19Recovered1		= $array1['features'][6]['attributes']['COVID19Recovered'];	 
$current_total_recovered = $current_total_recovered + $CarrollCOVID19Recovered1;
$CecilCOVID19Cases1		        = $array1['features'][7]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $CecilCOVID19Cases1;
$CecilCOVID19Deaths1		    = $array1['features'][7]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $CecilCOVID19Deaths1;
$CecilCOVID19Recovered1	        = $array1['features'][7]['attributes']['COVID19Recovered'];	 
$current_total_recovered = $current_total_recovered + $CecilCOVID19Recovered1;
$CharlesCOVID19Cases1	        = $array1['features'][8]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $CharlesCOVID19Cases1;
$CharlesCOVID19Deaths1		    = $array1['features'][8]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $CharlesCOVID19Deaths1;
$CharlesCOVID19Recovered1	    = $array1['features'][8]['attributes']['COVID19Recovered'];	 
$current_total_recovered = $current_total_recovered + $CharlesCOVID19Recovered1;
$DorchesterCOVID19Cases1		= $array1['features'][9]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $DorchesterCOVID19Cases1;
$DorchesterCOVID19Deaths1	    = $array1['features'][9]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $DorchesterCOVID19Deaths1;
$DorchesterCOVID19Recovered1    = $array1['features'][9]['attributes']['COVID19Recovered'];	 
$current_total_recovered = $current_total_recovered + $DorchesterCOVID19Recovered1;
$FrederickCOVID19Cases1	        = $array1['features'][10]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $FrederickCOVID19Cases1;
$FrederickCOVID19Deaths1	    = $array1['features'][10]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $FrederickCOVID19Deaths1;
$FrederickCOVID19Recovered1	    = $array1['features'][10]['attributes']['COVID19Recovered'];	 
$current_total_recovered = $current_total_recovered + $FrederickCOVID19Recovered1;
$GarrettCOVID19Cases1	        = $array1['features'][11]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $GarrettCOVID19Cases1;
$GarrettCOVID19Deaths1	        = $array1['features'][11]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $GarrettCOVID19Deaths1;
$GarrettCOVID19Recovered1	    = $array1['features'][11]['attributes']['COVID19Recovered'];	 
$current_total_recovered = $current_total_recovered + $GarrettCOVID19Recovered1;
$HarfordCOVID19Cases1	        = $array1['features'][12]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $HarfordCOVID19Cases1;
$HarfordCOVID19Deaths1		    = $array1['features'][12]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $HarfordCOVID19Deaths1;
$HarfordCOVID19Recovered1		= $array1['features'][12]['attributes']['COVID19Recovered']; 
$current_total_recovered = $current_total_recovered + $HarfordCOVID19Recovered1;
$HowardCOVID19Cases1	        = $array1['features'][13]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $HowardCOVID19Cases1;
$HowardCOVID19Deaths1		    = $array1['features'][13]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $HowardCOVID19Deaths1;
$HowardCOVID19Recovered1	    = $array1['features'][13]['attributes']['COVID19Recovered']; 
$current_total_recovered = $current_total_recovered + $HowardCOVID19Recovered1;
$KentCOVID19Cases1		        = $array1['features'][14]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $KentCOVID19Cases1;
$KentCOVID19Deaths1	            = $array1['features'][14]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $KentCOVID19Deaths1;
$KentCOVID19Recovered1	        = $array1['features'][14]['attributes']['COVID19Recovered']; 
$current_total_recovered = $current_total_recovered + $KentCOVID19Recovered1;
$MontgomeryCOVID19Cases1	    = $array1['features'][15]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $MontgomeryCOVID19Cases1;
$MontgomeryCOVID19Deaths1	    = $array1['features'][15]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $MontgomeryCOVID19Deaths1;
$MontgomeryCOVID19Recovered1	= $array1['features'][15]['attributes']['COVID19Recovered']; 
$current_total_recovered = $current_total_recovered + $MontgomeryCOVID19Recovered1;
$PrinceGeorgesCOVID19Cases1	    = $array1['features'][16]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $PrinceGeorgesCOVID19Cases1;
$PrinceGeorgesCOVID19Deaths1	= $array1['features'][16]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $PrinceGeorgesCOVID19Deaths1;
$PrinceGeorgesCOVID19Recovered1	= $array1['features'][16]['attributes']['COVID19Recovered']; 
$current_total_recovered = $current_total_recovered + $PrinceGeorgesCOVID19Recovered1;
$QueenAnnesCOVID19Cases1	    = $array1['features'][17]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $QueenAnnesCOVID19Cases1;
$QueenAnnesCOVID19Deaths1		= $array1['features'][17]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $QueenAnnesCOVID19Deaths1;
$QueenAnnesCOVID19Recovered1	= $array1['features'][17]['attributes']['COVID19Recovered']; 
$current_total_recovered = $current_total_recovered + $QueenAnnesCOVID19Recovered1;
$SomersetCOVID19Cases1		    = $array1['features'][18]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $SomersetCOVID19Cases1;
$SomersetCOVID19Deaths1	        = $array1['features'][18]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $SomersetCOVID19Deaths1;
$SomersetCOVID19Recovered1	    = $array1['features'][18]['attributes']['COVID19Recovered']; 
$current_total_recovered = $current_total_recovered + $SomersetCOVID19Recovered1;
$StMarysCOVID19Cases1		    = $array1['features'][19]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $StMarysCOVID19Cases1;
$StMarysCOVID19Deaths1	        = $array1['features'][19]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $StMarysCOVID19Deaths1;
$StMarysCOVID19Recovered1	    = $array1['features'][19]['attributes']['COVID19Recovered']; 
$current_total_recovered = $current_total_recovered + $StMarysCOVID19Recovered1;
$TalbotCOVID19Cases1		    = $array1['features'][20]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $TalbotCOVID19Cases1;
$TalbotCOVID19Deaths1		    = $array1['features'][20]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $TalbotCOVID19Deaths1;
$TalbotCOVID19Recovered1		= $array1['features'][20]['attributes']['COVID19Recovered']; 
$current_total_recovered = $current_total_recovered + $TalbotCOVID19Recovered1;
$WashingtonCOVID19Cases1		= $array1['features'][21]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $WashingtonCOVID19Cases1;
$WashingtonCOVID19Deaths1	    = $array1['features'][21]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $WashingtonCOVID19Deaths1;
$WashingtonCOVID19Recovered1	= $array1['features'][21]['attributes']['COVID19Recovered']; 
$current_total_recovered = $current_total_recovered + $WashingtonCOVID19Recovered1;
$WicomicoCOVID19Cases1		    = $array1['features'][22]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $WicomicoCOVID19Cases1;
$WicomicoCOVID19Deaths1	        = $array1['features'][22]['attributes']['COVID19Deaths']; 
$current_total_deaths = $current_total_deaths + $WicomicoCOVID19Deaths1;
$WicomicoCOVID19Recovered1      = $array1['features'][22]['attributes']['COVID19Recovered'];	 
$current_total_recovered = $current_total_recovered + $WicomicoCOVID19Recovered1;
$WorcesterCOVID19Cases1         = $array1['features'][23]['attributes']['COVID19Cases']; 
$current_total_cases = $current_total_cases + $WorcesterCOVID19Cases1;
$WorcesterCOVID19Deaths1	    = $array1['features'][23]['attributes']['COVID19Deaths'];	 
$current_total_deaths = $current_total_deaths + $WorcesterCOVID19Deaths1;
$WorcesterCOVID19Recovered1     = $array1['features'][23]['attributes']['COVID19Recovered']; 
$current_total_recovered = $current_total_recovered + $WorcesterCOVID19Recovered1;



// These are Live Numbers
$current_total_cases2 = 0;
$current_total_deaths2 = 0;
$current_total_recovered2 = 0;
$AlleganyCOVID19Cases2          = $array2['features'][0]['attributes']['COVID19Cases']; 
$current_total_cases2 = $current_total_cases2 + $AlleganyCOVID19Cases2;
$covid_db->query("update coronavirus set AlleganyCOVID19Cases = '$AlleganyCOVID19Cases2' where id = '$new_id' ");
$AlleganyCOVID19Deaths2         = $array2['features'][0]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $AlleganyCOVID19Deaths2;
$covid_db->query("update coronavirus set AlleganyCOVID19Deaths = '$AlleganyCOVID19Deaths2' where id = '$new_id' ");
$AlleganyCOVID19Recovered2      = $array2['features'][0]['attributes']['COVID19Recovered'];  
$current_total_recovered2 = $current_total_recovered2 + $AlleganyCOVID19Recovered2;
$covid_db->query("update coronavirus set AlleganyCOVID19Recovered = '$AlleganyCOVID19Recovered2' where id = '$new_id' ");
$AnneArundelCOVID19Cases2	    = $array2['features'][1]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $AnneArundelCOVID19Cases2;
$covid_db->query("update coronavirus set AnneArundelCOVID19Cases = '$AnneArundelCOVID19Cases2' where id = '$new_id' ");
$AnneArundelCOVID19Deaths2	    = $array2['features'][1]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $AnneArundelCOVID19Deaths2;
$covid_db->query("update coronavirus set AnneArundelCOVID19Deaths = '$AnneArundelCOVID19Deaths2' where id = '$new_id' ");
$AnneArundelCOVID19Recovered2   = $array2['features'][1]['attributes']['COVID19Recovered'];
$current_total_recovered2 = $current_total_recovered2 + $AnneArundelCOVID19Recovered2;
$covid_db->query("update coronavirus set AnneArundelCOVID19Recovered = '$AnneArundelCOVID19Recovered2' where id = '$new_id' ");
$BaltimoreCOVID19Cases2		    = $array2['features'][2]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $BaltimoreCOVID19Cases2;
$covid_db->query("update coronavirus set BaltimoreCOVID19Cases = '$BaltimoreCOVID19Cases2' where id = '$new_id' ");
$BaltimoreCOVID19Deaths2		= $array2['features'][2]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $BaltimoreCOVID19Deaths2;
$covid_db->query("update coronavirus set BaltimoreCOVID19Deaths = '$BaltimoreCOVID19Deaths2' where id = '$new_id' ");
$BaltimoreCOVID19Recovered2		= $array2['features'][2]['attributes']['COVID19Recovered'];
$current_total_recovered2 = $current_total_recovered2 + $BaltimoreCOVID19Recovered2;
$covid_db->query("update coronavirus set BaltimoreCOVID19Recovered = '$BaltimoreCOVID19Recovered2' where id = '$new_id' ");
$BaltimoreCityCOVID19Cases2		= $array2['features'][3]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $BaltimoreCityCOVID19Cases2;
$covid_db->query("update coronavirus set BaltimoreCityCOVID19Cases = '$BaltimoreCityCOVID19Cases2' where id = '$new_id' ");
$BaltimoreCityCOVID19Deaths2	= $array2['features'][3]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $BaltimoreCityCOVID19Deaths2;
$covid_db->query("update coronavirus set BaltimoreCityCOVID19Cases = '$BaltimoreCityCOVID19Cases2' where id = '$new_id' ");
$BaltimoreCityCOVID19Recovered2	= $array2['features'][3]['attributes']['COVID19Recovered'];	
$current_total_recovered2 = $current_total_recovered2 + $BaltimoreCityCOVID19Recovered2;
$covid_db->query("update coronavirus set BaltimoreCityCOVID19Recovered = '$BaltimoreCityCOVID19Recovered2' where id = '$new_id' ");
$CalvertCOVID19Cases2		    = $array2['features'][4]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $CalvertCOVID19Cases2;
$covid_db->query("update coronavirus set CalvertCOVID19Cases = '$CalvertCOVID19Cases2' where id = '$new_id' ");
$CalvertCOVID19Deaths2		    = $array2['features'][4]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $CalvertCOVID19Deaths2;
$covid_db->query("update coronavirus set CalvertCOVID19Deaths = '$CalvertCOVID19Deaths2' where id = '$new_id' ");
$CalvertCOVID19Recovered2		= $array2['features'][4]['attributes']['COVID19Recovered'];	
$current_total_recovered2 = $current_total_recovered2 + $CalvertCOVID19Recovered2;
$covid_db->query("update coronavirus set CalvertCOVID19Recovered = '$CalvertCOVID19Recovered2' where id = '$new_id' ");
$CarolineCOVID19Cases2		    = $array2['features'][5]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $CarolineCOVID19Cases2;
$covid_db->query("update coronavirus set CarolineCOVID19Cases = '$CarolineCOVID19Cases2' where id = '$new_id' ");
$CarolineCOVID19Deaths2		    = $array2['features'][5]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $CarolineCOVID19Deaths2;
$covid_db->query("update coronavirus set CarolineCOVID19Deaths = '$CarolineCOVID19Deaths2' where id = '$new_id' ");
$CarolineCOVID19Recovered2	    = $array2['features'][5]['attributes']['COVID19Recovered'];	
$current_total_recovered2 = $current_total_recovered2 + $CarolineCOVID19Recovered2;
$covid_db->query("update coronavirus set CarolineCOVID19Recovered = '$CarolineCOVID19Recovered2' where id = '$new_id' ");
$CarrollCOVID19Cases2		    = $array2['features'][6]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $CarrollCOVID19Cases2;
$covid_db->query("update coronavirus set CarrollCOVID19Cases = '$CarrollCOVID19Cases2' where id = '$new_id' ");
$CarrollCOVID19Deaths2	        = $array2['features'][6]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $CarrollCOVID19Deaths2;
$covid_db->query("update coronavirus set CarrollCOVID19Deaths = '$CarrollCOVID19Deaths2' where id = '$new_id' ");
$CarrollCOVID19Recovered2		= $array2['features'][6]['attributes']['COVID19Recovered'];	
$current_total_recovered2 = $current_total_recovered2 + $CarrollCOVID19Recovered2;
$covid_db->query("update coronavirus set CarrollCOVID19Recovered = '$CarrollCOVID19Recovered2' where id = '$new_id' ");
$CecilCOVID19Cases2		        = $array2['features'][7]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $CecilCOVID19Cases2;
$covid_db->query("update coronavirus set CecilCOVID19Cases = '$CecilCOVID19Cases2' where id = '$new_id' ");
$CecilCOVID19Deaths2		    = $array2['features'][7]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $CecilCOVID19Deaths2;
$covid_db->query("update coronavirus set CecilCOVID19Deaths = '$CecilCOVID19Deaths2' where id = '$new_id' ");
$CecilCOVID19Recovered2	        = $array2['features'][7]['attributes']['COVID19Recovered'];	
$current_total_recovered2 = $current_total_recovered2 + $CecilCOVID19Recovered2;
$covid_db->query("update coronavirus set CecilCOVID19Recovered = '$CecilCOVID19Recovered2' where id = '$new_id' ");
$CharlesCOVID19Cases2	        = $array2['features'][8]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $CharlesCOVID19Cases2;
$covid_db->query("update coronavirus set CharlesCOVID19Cases = '$CharlesCOVID19Cases2' where id = '$new_id' ");
$CharlesCOVID19Deaths2		    = $array2['features'][8]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $CharlesCOVID19Deaths2;
$covid_db->query("update coronavirus set CharlesCOVID19Deaths = '$CharlesCOVID19Deaths2' where id = '$new_id' ");
$CharlesCOVID19Recovered2	    = $array2['features'][8]['attributes']['COVID19Recovered'];	
$current_total_recovered2 = $current_total_recovered2 + $CharlesCOVID19Recovered2;
$covid_db->query("update coronavirus set CharlesCOVID19Deaths = '$CharlesCOVID19Deaths2' where id = '$new_id' ");
$DorchesterCOVID19Cases2		= $array2['features'][9]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $DorchesterCOVID19Cases2;
$covid_db->query("update coronavirus set DorchesterCOVID19Cases = '$DorchesterCOVID19Cases2' where id = '$new_id' ");
$DorchesterCOVID19Deaths2	    = $array2['features'][9]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $DorchesterCOVID19Deaths2;
$covid_db->query("update coronavirus set DorchesterCOVID19Deaths = '$DorchesterCOVID19Deaths2' where id = '$new_id' ");
$DorchesterCOVID19Recovered2	= $array2['features'][9]['attributes']['COVID19Recovered'];	
$current_total_recovered2 = $current_total_recovered2 + $DorchesterCOVID19Recovered2;
$covid_db->query("update coronavirus set DorchesterCOVID19Deaths = '$DorchesterCOVID19Deaths2' where id = '$new_id' ");
$FrederickCOVID19Cases2	        = $array2['features'][10]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $FrederickCOVID19Cases2;
$covid_db->query("update coronavirus set FrederickCOVID19Cases = '$FrederickCOVID19Cases2' where id = '$new_id' ");
$FrederickCOVID19Deaths2	    = $array2['features'][10]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $FrederickCOVID19Deaths2;
$covid_db->query("update coronavirus set FrederickCOVID19Deaths = '$FrederickCOVID19Deaths2' where id = '$new_id' ");
$FrederickCOVID19Recovered2	    = $array2['features'][10]['attributes']['COVID19Recovered'];	
$current_total_recovered2 = $current_total_recovered2 + $FrederickCOVID19Recovered2;
$covid_db->query("update coronavirus set FrederickCOVID19Recovered = '$FrederickCOVID19Recovered2' where id = '$new_id' ");
$GarrettCOVID19Cases2	        = $array2['features'][11]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $GarrettCOVID19Cases2;
$covid_db->query("update coronavirus set GarrettCOVID19Cases = '$GarrettCOVID19Cases2' where id = '$new_id' ");
$GarrettCOVID19Deaths2	        = $array2['features'][11]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $GarrettCOVID19Deaths2;
$covid_db->query("update coronavirus set GarrettCOVID19Deaths = '$GarrettCOVID19Deaths2' where id = '$new_id' ");
$GarrettCOVID19Recovered2	    = $array2['features'][11]['attributes']['COVID19Recovered'];
$current_total_recovered2 = $current_total_recovered2 + $GarrettCOVID19Recovered2;
$covid_db->query("update coronavirus set GarrettCOVID19Recovered = '$GarrettCOVID19Recovered2' where id = '$new_id' ");
$HarfordCOVID19Cases2	        = $array2['features'][12]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $HarfordCOVID19Cases2;
$covid_db->query("update coronavirus set HarfordCOVID19Cases = '$HarfordCOVID19Cases2' where id = '$new_id' ");
$HarfordCOVID19Deaths2		    = $array2['features'][12]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $HarfordCOVID19Deaths2;
$covid_db->query("update coronavirus set HarfordCOVID19Deaths = '$HarfordCOVID19Deaths2' where id = '$new_id' ");
$HarfordCOVID19Recovered2		= $array2['features'][12]['attributes']['COVID19Recovered'];
$current_total_recovered2 = $current_total_recovered2 + $HarfordCOVID19Recovered2;
$covid_db->query("update coronavirus set HarfordCOVID19Recovered = '$HarfordCOVID19Recovered2' where id = '$new_id' ");
$HowardCOVID19Cases2	        = $array2['features'][13]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $HowardCOVID19Cases2;
$covid_db->query("update coronavirus set HowardCOVID19Cases = '$HowardCOVID19Cases2' where id = '$new_id' ");
$HowardCOVID19Deaths2		    = $array2['features'][13]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $HowardCOVID19Deaths2;
$covid_db->query("update coronavirus set HowardCOVID19Deaths = '$HowardCOVID19Deaths2' where id = '$new_id' ");
$HowardCOVID19Recovered2	    = $array2['features'][13]['attributes']['COVID19Recovered'];
$current_total_recovered2 = $current_total_recovered2 + $HowardCOVID19Recovered2;
$covid_db->query("update coronavirus set HowardCOVID19Recovered = '$HowardCOVID19Recovered2' where id = '$new_id' ");
$KentCOVID19Cases2		        = $array2['features'][14]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $KentCOVID19Cases2;
$covid_db->query("update coronavirus set KentCOVID19Cases = '$KentCOVID19Cases2' where id = '$new_id' ");
$KentCOVID19Deaths2	            = $array2['features'][14]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $KentCOVID19Deaths2;
$covid_db->query("update coronavirus set $KentCOVID19Deaths2 = '$KentCOVID19Deaths2' where id = '$new_id' ");
$KentCOVID19Recovered2	        = $array2['features'][14]['attributes']['COVID19Recovered'];
$current_total_recovered2 = $current_total_recovered2 + $KentCOVID19Recovered2;
$covid_db->query("update coronavirus set KentCOVID19Recovered = '$KentCOVID19Recovered2' where id = '$new_id' ");
$MontgomeryCOVID19Cases2	    = $array2['features'][15]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $MontgomeryCOVID19Cases2;
$covid_db->query("update coronavirus set MontgomeryCOVID19Cases = '$MontgomeryCOVID19Cases2' where id = '$new_id' ");
$MontgomeryCOVID19Deaths2	    = $array2['features'][15]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $MontgomeryCOVID19Deaths2;
$covid_db->query("update coronavirus set MontgomeryCOVID19Deaths = '$MontgomeryCOVID19Deaths2' where id = '$new_id' ");
$MontgomeryCOVID19Recovered2	= $array2['features'][15]['attributes']['COVID19Recovered'];
$current_total_recovered2 = $current_total_recovered2 + $MontgomeryCOVID19Recovered2;
$covid_db->query("update coronavirus set MontgomeryCOVID19Recovered = '$MontgomeryCOVID19Recovered2' where id = '$new_id' ");
$PrinceGeorgesCOVID19Cases2	    = $array2['features'][16]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $PrinceGeorgesCOVID19Cases2;
$covid_db->query("update coronavirus set PrinceGeorgesCOVID19Cases = '$PrinceGeorgesCOVID19Cases2' where id = '$new_id' ");
$PrinceGeorgesCOVID19Deaths2	= $array2['features'][16]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $PrinceGeorgesCOVID19Deaths2;
$covid_db->query("update coronavirus set PrinceGeorgesCOVID19Deaths = '$PrinceGeorgesCOVID19Deaths2' where id = '$new_id' ");
$PrinceGeorgesCOVID19Recovered2	= $array2['features'][16]['attributes']['COVID19Recovered'];
$current_total_recovered2 = $current_total_recovered2 + $PrinceGeorgesCOVID19Recovered2;
$covid_db->query("update coronavirus set PrinceGeorgesCOVID19Deaths = '$PrinceGeorgesCOVID19Deaths2' where id = '$new_id' ");
$QueenAnnesCOVID19Cases2	    = $array2['features'][17]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $QueenAnnesCOVID19Cases2;
$covid_db->query("update coronavirus set QueenAnnesCOVID19Cases = '$QueenAnnesCOVID19Cases2' where id = '$new_id' ");
$QueenAnnesCOVID19Deaths2		= $array2['features'][17]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $QueenAnnesCOVID19Deaths2;
$covid_db->query("update coronavirus set QueenAnnesCOVID19Deaths = '$QueenAnnesCOVID19Deaths2' where id = '$new_id' ");
$QueenAnnesCOVID19Recovered2	= $array2['features'][17]['attributes']['COVID19Recovered'];
$current_total_recovered2 = $current_total_recovered2 + $QueenAnnesCOVID19Recovered2;
$covid_db->query("update coronavirus set QueenAnnesCOVID19Recovered = '$QueenAnnesCOVID19Recovered2' where id = '$new_id' ");
$SomersetCOVID19Cases2		    = $array2['features'][18]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $SomersetCOVID19Cases2;
$covid_db->query("update coronavirus set SomersetCOVID19Cases = '$SomersetCOVID19Cases2' where id = '$new_id' ");
$SomersetCOVID19Deaths2	        = $array2['features'][18]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $SomersetCOVID19Deaths2;
$covid_db->query("update coronavirus set SomersetCOVID19Deaths = '$SomersetCOVID19Deaths2' where id = '$new_id' ");
$SomersetCOVID19Recovered2	    = $array2['features'][18]['attributes']['COVID19Recovered'];
$current_total_recovered2 = $current_total_recovered2 + $SomersetCOVID19Recovered2;
$covid_db->query("update coronavirus set SomersetCOVID19Recovered = '$SomersetCOVID19Recovered2' where id = '$new_id' ");

$StMarysCOVID19Cases2		    = $array2['features'][19]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $StMarysCOVID19Cases2;
$covid_db->query("update coronavirus set StMarysCOVID19Cases = '$StMarysCOVID19Cases2' where id = '$new_id' ");
$StMarysCOVID19Deaths2	        = $array2['features'][19]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $StMarysCOVID19Deaths2;
$covid_db->query("update coronavirus set StMarysCOVID19Deaths = '$StMarysCOVID19Deaths2' where id = '$new_id' ");
$StMarysCOVID19Recovered2	    = $array2['features'][19]['attributes']['COVID19Recovered'];
$current_total_recovered2 = $current_total_recovered2 + $StMarysCOVID19Recovered2;
$covid_db->query("update coronavirus set StMarysCOVID19Recovered = '$StMarysCOVID19Recovered2' where id = '$new_id' ");

$TalbotCOVID19Cases2	        = $array2['features'][20]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $TalbotCOVID19Cases2;
$covid_db->query("update coronavirus set TalbotCOVID19Cases = '$TalbotCOVID19Cases2' where id = '$new_id' ");
$TalbotCOVID19Deaths2		    = $array2['features'][20]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $TalbotCOVID19Deaths2;
$covid_db->query("update coronavirus set TalbotCOVID19Deaths = '$TalbotCOVID19Deaths2' where id = '$new_id' ");
$TalbotCOVID19Recovered2		= $array2['features'][20]['attributes']['COVID19Recovered'];
$current_total_recovered2 = $current_total_recovered2 + $TalbotCOVID19Recovered2;
$covid_db->query("update coronavirus set TalbotCOVID19Recovered = '$TalbotCOVID19Recovered2' where id = '$new_id' ");

$WashingtonCOVID19Cases2		= $array2['features'][21]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $WashingtonCOVID19Cases2;
$covid_db->query("update coronavirus set WashingtonCOVID19Cases = '$WashingtonCOVID19Cases2' where id = '$new_id' ");
$WashingtonCOVID19Deaths2	    = $array2['features'][21]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $WashingtonCOVID19Deaths2;
$covid_db->query("update coronavirus set WashingtonCOVID19Deaths = '$WashingtonCOVID19Deaths2' where id = '$new_id' ");
$WashingtonCOVID19Recovered2	= $array2['features'][21]['attributes']['COVID19Recovered'];
$current_total_recovered2 = $current_total_recovered2 + $WashingtonCOVID19Recovered2;
$covid_db->query("update coronavirus set WashingtonCOVID19Deaths = '$WashingtonCOVID19Deaths2' where id = '$new_id' ");

$WicomicoCOVID19Cases2		    = $array2['features'][22]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $WicomicoCOVID19Cases2;
$covid_db->query("update coronavirus set WicomicoCOVID19Cases = '$WicomicoCOVID19Cases2' where id = '$new_id' ");
$WicomicoCOVID19Deaths2	        = $array2['features'][22]['attributes']['COVID19Deaths'];
$current_total_deaths2 = $current_total_deaths2 + $WicomicoCOVID19Deaths2;
$covid_db->query("update coronavirus set WicomicoCOVID19Deaths = '$WicomicoCOVID19Deaths2' where id = '$new_id' ");
$WicomicoCOVID19Recovered2      = $array2['features'][22]['attributes']['COVID19Recovered'];
$current_total_recovered2 = $current_total_recovered2 + $WicomicoCOVID19Recovered2;
$covid_db->query("update coronavirus set WicomicoCOVID19Recovered = '$WicomicoCOVID19Recovered2' where id = '$new_id' ");

$WorcesterCOVID19Cases2         = $array2['features'][23]['attributes']['COVID19Cases'];
$current_total_cases2 = $current_total_cases2 + $WorcesterCOVID19Cases2;
$covid_db->query("update coronavirus set WorcesterCOVID19Cases = '$WorcesterCOVID19Cases2' where id = '$new_id' ");
$WorcesterCOVID19Deaths2	    = $array2['features'][23]['attributes']['COVID19Deaths'];	
$current_total_deaths2 = $current_total_deaths2 + $WorcesterCOVID19Deaths2;
$covid_db->query("update coronavirus set WorcesterCOVID19Deaths = '$WorcesterCOVID19Deaths2' where id = '$new_id' ");
$WorcesterCOVID19Recovered2     = $array2['features'][23]['attributes']['COVID19Recovered'];
$current_total_recovered2 = $current_total_recovered2 + $WorcesterCOVID19Recovered2;
$covid_db->query("update coronavirus set WorcesterCOVID19Recovered = '$WorcesterCOVID19Recovered2' where id = '$new_id' ");

$AlleganyCOVID19Cases           = $AlleganyCOVID19Cases2 - $AlleganyCOVID19Cases1;  
$AlleganyCOVID19Deaths          = $AlleganyCOVID19Deaths2 - $AlleganyCOVID19Deaths1;        
$AlleganyCOVID19Recovered       = $AlleganyCOVID19Recovered2 - $AlleganyCOVID19Recovered1;      
$AnneArundelCOVID19Cases	    = $AnneArundelCOVID19Cases2 - $AnneArundelCOVID19Cases1;
$AnneArundelCOVID19Deaths	    = $AnneArundelCOVID19Deaths2 - $AnneArundelCOVID19Deaths1;
$AnneArundelCOVID19Recovered    = $AnneArundelCOVID19Recovered2 - $AnneArundelCOVID19Recovered1;  
$BaltimoreCOVID19Cases		    = $BaltimoreCOVID19Cases2 - $BaltimoreCOVID19Cases1;
$BaltimoreCOVID19Deaths		    = $BaltimoreCOVID19Deaths2 - $BaltimoreCOVID19Deaths1;
$BaltimoreCOVID19Recovered		= $BaltimoreCOVID19Recovered2 - $BaltimoreCOVID19Recovered1;
$BaltimoreCityCOVID19Cases		= $BaltimoreCityCOVID19Cases2 - $BaltimoreCityCOVID19Cases1;
$BaltimoreCityCOVID19Deaths	    = $BaltimoreCityCOVID19Deaths2 - $BaltimoreCityCOVID19Deaths1;
$BaltimoreCityCOVID19Recovered	= $BaltimoreCityCOVID19Recovered2 - $BaltimoreCityCOVID19Recovered1;
$CalvertCOVID19Cases		    = $CalvertCOVID19Cases2 - $CalvertCOVID19Cases1; 
$CalvertCOVID19Deaths		    = $CalvertCOVID19Deaths2 - $CalvertCOVID19Deaths1;
$CalvertCOVID19Recovered		= $CalvertCOVID19Recovered2 - $CalvertCOVID19Recovered1;
$CarolineCOVID19Cases		    = $CarolineCOVID19Cases2 - $CarolineCOVID19Cases1;
$CarolineCOVID19Deaths		    = $CarolineCOVID19Deaths2 - $CarolineCOVID19Deaths1;
$CarolineCOVID19Recovered	    = $CarolineCOVID19Recovered2 - $CarolineCOVID19Recovered1;
$CarrollCOVID19Cases		    = $CarrollCOVID19Cases2 - $CarrollCOVID19Cases1;
$CarrollCOVID19Deaths	       	= $CarrollCOVID19Deaths2 - $CarrollCOVID19Deaths1;
$CarrollCOVID19Recovered	    = $CarrollCOVID19Recovered2 - $CarrollCOVID19Recovered1;
$CecilCOVID19Cases		        = $CecilCOVID19Cases2 - $CecilCOVID19Cases1;
$CecilCOVID19Deaths		        = $CecilCOVID19Deaths2 - $CecilCOVID19Deaths1;
$CecilCOVID19Recovered	        = $CecilCOVID19Recovered2 - $CecilCOVID19Recovered1;
$CharlesCOVID19Cases	        = $CharlesCOVID19Cases2 - $CharlesCOVID19Cases1;
$CharlesCOVID19Deaths		    = $CharlesCOVID19Deaths2 - $CharlesCOVID19Deaths1;
$CharlesCOVID19Recovered	    = $CharlesCOVID19Recovered2 - $CharlesCOVID19Recovered1;
$DorchesterCOVID19Cases		    = $DorchesterCOVID19Cases2 - $DorchesterCOVID19Cases1;
$DorchesterCOVID19Deaths	    = $DorchesterCOVID19Deaths2 - $DorchesterCOVID19Deaths1;
$DorchesterCOVID19Recovered   	= $DorchesterCOVID19Recovered2 - $DorchesterCOVID19Recovered1;
$FrederickCOVID19Cases	        = $FrederickCOVID19Cases2 - $FrederickCOVID19Cases1;
$FrederickCOVID19Deaths	        = $FrederickCOVID19Deaths2 - $FrederickCOVID19Deaths1;
$FrederickCOVID19Recovered	    = $FrederickCOVID19Recovered2 - $FrederickCOVID19Recovered1;	
$GarrettCOVID19Cases	        = $GarrettCOVID19Cases2 - $GarrettCOVID19Cases1;
$GarrettCOVID19Deaths	        = $GarrettCOVID19Deaths2 - $GarrettCOVID19Deaths1;
$GarrettCOVID19Recovered	    = $GarrettCOVID19Recovered2 - $GarrettCOVID19Recovered1;
$HarfordCOVID19Cases	        = $HarfordCOVID19Cases2 - $HarfordCOVID19Cases1;
$HarfordCOVID19Deaths		    = $HarfordCOVID19Deaths2 - $HarfordCOVID19Deaths1;
$HarfordCOVID19Recovered		= $HarfordCOVID19Recovered2 - $HarfordCOVID19Recovered1;
$HowardCOVID19Cases	            = $HowardCOVID19Cases2 - $HowardCOVID19Cases1;
$HowardCOVID19Deaths		    = $HowardCOVID19Deaths2 - $HowardCOVID19Deaths1;
$HowardCOVID19Recovered	        = $HowardCOVID19Recovered2 - $HowardCOVID19Recovered1;
$KentCOVID19Cases		        = $KentCOVID19Cases2 - $KentCOVID19Cases1;
$KentCOVID19Deaths	            = $KentCOVID19Deaths2 - $KentCOVID19Deaths1;
$KentCOVID19Recovered	        = $KentCOVID19Recovered2 - $KentCOVID19Recovered1;
$MontgomeryCOVID19Cases	        = $MontgomeryCOVID19Cases2 - $MontgomeryCOVID19Cases1;
$MontgomeryCOVID19Deaths	    = $MontgomeryCOVID19Deaths2 - $MontgomeryCOVID19Deaths1;
$MontgomeryCOVID19Recovered	    = $MontgomeryCOVID19Recovered2 - $MontgomeryCOVID19Recovered1;
$PrinceGeorgesCOVID19Cases      = $PrinceGeorgesCOVID19Cases2 - $PrinceGeorgesCOVID19Cases1;
$PrinceGeorgesCOVID19Deaths	    = $PrinceGeorgesCOVID19Deaths2 - $PrinceGeorgesCOVID19Deaths1;
$PrinceGeorgesCOVID19Recovered	= $PrinceGeorgesCOVID19Recovered2 - $PrinceGeorgesCOVID19Recovered1;
$QueenAnnesCOVID19Cases	        = $QueenAnnesCOVID19Cases2 - $QueenAnnesCOVID19Cases1;
$QueenAnnesCOVID19Deaths		= $QueenAnnesCOVID19Deaths2 - $QueenAnnesCOVID19Deaths1;
$QueenAnnesCOVID19Recovered	    = $QueenAnnesCOVID19Recovered2 - $QueenAnnesCOVID19Recovered1;
$SomersetCOVID19Cases		    = $SomersetCOVID19Cases2 - $SomersetCOVID19Cases1;
$SomersetCOVID19Deaths          = $SomersetCOVID19Deaths2 - $SomersetCOVID19Deaths1;
$SomersetCOVID19Recovered       = $SomersetCOVID19Recovered2 - $SomersetCOVID19Recovered1;
$StMarysCOVID19Cases            = $StMarysCOVID19Cases2 - $StMarysCOVID19Cases1;    
$StMarysCOVID19Deaths           = $StMarysCOVID19Deaths2 - $StMarysCOVID19Deaths1;
$StMarysCOVID19Recovered        = $StMarysCOVID19Recovered2 - $StMarysCOVID19Recovered1;
$TalbotCOVID19Cases             = $TalbotCOVID19Cases2 - $TalbotCOVID19Cases1;
$TalbotCOVID19Deaths            = $TalbotCOVID19Deaths2 - $TalbotCOVID19Deaths1;
$TalbotCOVID19Recovered         = $TalbotCOVID19Recovered2 - $TalbotCOVID19Recovered1;
$WashingtonCOVID19Cases         = $WashingtonCOVID19Cases2 - $WashingtonCOVID19Cases1;
$WashingtonCOVID19Deaths        = $WashingtonCOVID19Deaths2 - $WashingtonCOVID19Deaths1;
$WashingtonCOVID19Recovered     = $WashingtonCOVID19Recovered2 - $WashingtonCOVID19Recovered1;
$WicomicoCOVID19Cases           = $WicomicoCOVID19Cases2 - $WicomicoCOVID19Cases1;
$WicomicoCOVID19Deaths          = $WicomicoCOVID19Deaths2 - $WicomicoCOVID19Deaths1;
$WicomicoCOVID19Recovered	    = $WicomicoCOVID19Recovered2 - $WicomicoCOVID19Recovered1;
$WorcesterCOVID19Cases          = $WorcesterCOVID19Cases2 - $WorcesterCOVID19Cases1;
$WorcesterCOVID19Deaths	        = $WorcesterCOVID19Deaths2 - $WorcesterCOVID19Deaths1;
$WorcesterCOVID19Recovered      = $WorcesterCOVID19Recovered2 - $WorcesterCOVID19Recovered1;



$current_total_casesX      = $current_total_cases2 - $current_total_cases;
$current_total_deathsX      = $current_total_deaths2 - $current_total_deaths;
$current_total_recoveredX      = $current_total_recovered2 - $current_total_recovered;


echo "<div style='text-align:left;'><h3>$new_date</h3>";
if ($current_total_casesX != 0) { sms("Total Cases $current_total_cases to $current_total_cases2");  } 
if ($current_total_deathsX != 0) { sms("Total Deaths $current_total_deaths to $current_total_deaths2");  } 
if ($current_total_recoveredX != 0) { sms("Total Recovered $current_total_recovered to $current_total_recovered2");  } 

if ($AlleganyCOVID19Cases != 0) { sms("Allegany Cases $AlleganyCOVID19Cases1 to $AlleganyCOVID19Cases2");  } 
if ($AlleganyCOVID19Deaths != 0) { sms("Allegany Deaths $AlleganyCOVID19Deaths1 to $AlleganyCOVID19Deaths2"); } 
if ($AlleganyCOVID19Recovered != 0) { sms("Allegany Recovered $AlleganyCOVID19Recovered1 to $AlleganyCOVID19Recovered2"); } 
if ($AnneArundelCOVID19Cases != 0) { sms("Anne Arundel Cases $AnneArundelCOVID19Cases1 to $AnneArundelCOVID19Cases2 "); } 
if ($AnneArundelCOVID19Deaths != 0) { sms("Anne Arundel Deaths $AnneArundelCOVID19Deaths1 to $AnneArundelCOVID19Deaths2 "); } 
if ($AnneArundelCOVID19Recovered != 0) { sms("Anne Arundel Recovered $AnneArundelCOVID19Recovered1 to $AnneArundelCOVID19Recovered2 "); } 
if ($BaltimoreCOVID19Cases != 0) { sms("Baltimore Cases $BaltimoreCOVID19Cases1 to $BaltimoreCOVID19Cases2 "); } 
if ($BaltimoreCOVID19Deaths != 0) { sms("Baltimore Deaths $BaltimoreCOVID19Deaths1 to $BaltimoreCOVID19Deaths2 "); } 
if ($BaltimoreCOVID19Recovered != 0) { sms("Baltimore Recovered $BaltimoreCOVID19Recovered1 to $BaltimoreCOVID19Recovered2 "); } 
if ($BaltimoreCityCOVID19Cases != 0) { sms("Baltimore City Cases $BaltimoreCityCOVID19Cases1 to $BaltimoreCityCOVID19Cases2 "); } 
if ($BaltimoreCityCOVID19Deaths != 0) { sms("Baltimore City Deaths $BaltimoreCityCOVID19Deaths1 to $BaltimoreCityCOVID19Deaths2 "); } 
if ($BaltimoreCityCOVID19Recovered != 0) { sms("Baltimore City Recovered $BaltimoreCityCOVID19Recovered1 to $BaltimoreCityCOVID19Recovered2 "); } 
if ($CalvertCOVID19Cases != 0) { sms("Calvert Cases $CalvertCOVID19Cases1 to $CalvertCOVID19Cases2 "); } 
if ($CalvertCOVID19Deaths != 0) { sms("Calvert Deaths $CalvertCOVID19Deaths1 to $CalvertCOVID19Deaths2 "); } 
if ($CalvertCOVID19Recovered != 0) { sms("Calvert Recovered $CalvertCOVID19Recovered1 to $CalvertCOVID19Recovered2 "); } 
if ($CarolineCOVID19Cases != 0) { sms("Caroline Cases $CarolineCOVID19Cases1 to $CarolineCOVID19Cases2 "); } 
if ($CarolineCOVID19Deaths != 0) { sms("Caroline Deaths $CarolineCOVID19Deaths1 to $CarolineCOVID19Deaths2 "); } 
if ($CarolineCOVID19Recovered != 0) { sms("Caroline Recovered $CarolineCOVID19Recovered1 to $CarolineCOVID19Recovered2 "); } 
if ($CarrollCOVID19Cases != 0) { sms("Carroll Cases $CarrollCOVID19Cases1 to $CarrollCOVID19Cases2 "); } 
if ($CarrollCOVID19Deaths != 0) { sms("Carroll Deaths $CarrollCOVID19Deaths1 to $CarrollCOVID19Deaths2 "); } 
if ($CarrollCOVID19Recovered != 0) { sms("Carroll Recovered $CarrollCOVID19Recovered1 to $CarrollCOVID19Recovered2 "); } 
if ($CecilCOVID19Cases != 0) { sms("Cecil Cases $CecilCOVID19Cases1 to $CecilCOVID19Cases2 "); } 
if ($CecilCOVID19Deaths != 0) { sms("Cecil Deaths $CecilCOVID19Deaths1 to $CecilCOVID19Deaths2 "); } 
if ($CecilCOVID19Recovered != 0) { sms("Cecil Recovered $CecilCOVID19Recovered1 to $CecilCOVID19Recovered2 "); } 
if ($CharlesCOVID19Cases != 0) { sms("Charles Cases $CharlesCOVID19Cases1 to $CharlesCOVID19Cases2 "); } 
if ($CharlesCOVID19Deaths != 0) { sms("Charles Deaths $CharlesCOVID19Deaths1 to $CharlesCOVID19Deaths2 "); } 
if ($CharlesCOVID19Recovered != 0) { sms("Charles Recovered $CharlesCOVID19Recovered1 to $CharlesCOVID19Recovered2 "); } 
if ($DorchesterCOVID19Cases != 0) { sms("Dorchester Cases $DorchesterCOVID19Cases1 to $DorchesterCOVID19Cases2 "); } 
if ($DorchesterCOVID19Deaths != 0) { sms("Dorchester Deaths $DorchesterCOVID19Deaths1 to $DorchesterCOVID19Deaths2 "); } 
if ($DorchesterCOVID19Recovered != 0) { sms("Dorchester Recovered $DorchesterCOVID19Recovered1 to $DorchesterCOVID19Recovered2 "); } 
if ($FrederickCOVID19Cases != 0) { sms("Frederick Cases $FrederickCOVID19Cases1 to $FrederickCOVID19Cases2 "); } 
if ($FrederickCOVID19Deaths != 0) { sms("Frederick Deaths $FrederickCOVID19Deaths1 to $FrederickCOVID19Deaths2 "); } 
if ($FrederickCOVID19Recovered != 0) { sms("Frederick Recovered $FrederickCOVID19Recovered1 to $FrederickCOVID19Recovered2 "); } 	
if ($GarrettCOVID19Cases != 0) { sms("Garrett Cases $GarrettCOVID19Cases1 to $GarrettCOVID19Cases2 "); } 
if ($GarrettCOVID19Deaths != 0) { sms("Garrett Deaths $GarrettCOVID19Deaths1 to $GarrettCOVID19Deaths2 "); } 
if ($GarrettCOVID19Recovered != 0) { sms("Garrett Recovered $GarrettCOVID19Recovered1 to $GarrettCOVID19Recovered2 "); } 
if ($HarfordCOVID19Cases != 0) { sms("Harford Cases $HarfordCOVID19Cases1 to $HarfordCOVID19Cases2 "); } 
if ($HarfordCOVID19Deaths != 0) { sms("Harford Deaths $HarfordCOVID19Deaths1 to $HarfordCOVID19Deaths2 "); } 
if ($HarfordCOVID19Recovered != 0) { sms("Harford Recovered $HarfordCOVID19Recovered1 to $HarfordCOVID19Recovered2 "); } 
if ($HowardCOVID19Cases != 0) { sms("Howard Cases $HowardCOVID19Cases1 to $HowardCOVID19Cases2 "); } 
if ($HowardCOVID19Deaths != 0) { sms("Howard Deaths $HowardCOVID19Deaths1 to $HowardCOVID19Deaths2 "); } 
if ($HowardCOVID19Recovered != 0) { sms("Howard Recovered $HowardCOVID19Recovered1 to $HowardCOVID19Recovered2 "); } 
if ($KentCOVID19Cases != 0) { sms("Kent Cases $KentCOVID19Cases1 to $KentCOVID19Cases2 "); } 
if ($KentCOVID19Deaths != 0) { sms("Kent Deaths $KentCOVID19Deaths1 to $KentCOVID19Deaths2 "); } 
if ($KentCOVID19Recovered != 0) { sms("Kent Recovered $KentCOVID19Recovered1 to $KentCOVID19Recovered2 "); } 
if ($MontgomeryCOVID19Cases != 0) { sms("Montgomery Cases $MontgomeryCOVID19Cases1 to $MontgomeryCOVID19Cases2 "); } 
if ($MontgomeryCOVID19Deaths != 0) { sms("Montgomery Deaths $MontgomeryCOVID19Deaths1 to $MontgomeryCOVID19Deaths2 "); } 
if ($MontgomeryCOVID19Recovered	!= 0) { sms("Montgomery Recovered $MontgomeryCOVID19Recovered1 to $MontgomeryCOVID19Recovered2 "); } 
if ($PrinceGeorgesCOVID19Cases != 0) { sms("Prince Georges Cases $PrinceGeorgesCOVID19Cases1 to $PrinceGeorgesCOVID19Cases2 "); } 
if ($PrinceGeorgesCOVID19Deaths != 0) { sms("Prince Georges Deaths $PrinceGeorgesCOVID19Deaths1 to $PrinceGeorgesCOVID19Deaths2 "); } 
if ($PrinceGeorgesCOVID19Recovered != 0) { sms("Prince Georges Recovered $PrinceGeorgesCOVID19Recovered1 to $PrinceGeorgesCOVID19Recovered2 "); } 
if ($QueenAnnesCOVID19Cases != 0) { sms("Queen Annes Cases $QueenAnnesCOVID19Cases1 to $QueenAnnesCOVID19Cases2 "); } 
if ($QueenAnnesCOVID19Deaths != 0) { sms("Queen Annes Deaths $QueenAnnesCOVID19Deaths1 to $QueenAnnesCOVID19Deaths2 "); } 
if ($QueenAnnesCOVID19Recovered != 0) { sms("Queen Annes Recovered $QueenAnnesCOVID19Recovered1 to $QueenAnnesCOVID19Recovered2 "); } 
if ($SomersetCOVID19Cases != 0) { sms("Somerset Cases $SomersetCOVID19Cases1 to $SomersetCOVID19Cases2 "); } 
if ($SomersetCOVID19Deaths != 0) { sms( "Somerset Deaths $SomersetCOVID19Deaths1 to $SomersetCOVID19Deaths2 "); } 
if ($SomersetCOVID19Recovered != 0) { sms( "Somerset Recovered $SomersetCOVID19Recovered1 to $SomersetCOVID19Recovered2 "); } 
if ($StMarysCOVID19Cases != 0) { sms( "St Marys Cases $StMarysCOVID19Cases1 to $StMarysCOVID19Cases2 "); } 
if ($StMarysCOVID19Deaths != 0) { sms( "$St Marys Deaths $StMarysCOVID19Deaths1 to $StMarysCOVID19Deaths2 "); } 
if ($StMarysCOVID19Recovered != 0) { sms( "St Marys Recovered $StMarysCOVID19Recovered1 to $StMarysCOVID19Recovered2 "); } 
if ($TalbotCOVID19Cases != 0) { sms( "Talbot Cases $TalbotCOVID19Cases1 to $TalbotCOVID19Cases2 "); } 
if ($TalbotCOVID19Deaths != 0) { sms( "Talbot Deaths $TalbotCOVID19Deaths1 to $TalbotCOVID19Deaths2 "); } 
if ($TalbotCOVID19Recovered != 0) { sms( "Talbot Recovered $TalbotCOVID19Recovered1 to $TalbotCOVID19Recovered2 "); } 
if ($WashingtonCOVID19Cases != 0) { sms( "Washington Cases $WashingtonCOVID19Cases1 to $WashingtonCOVID19Cases2 "); } 
if ($WashingtonCOVID19Deaths != 0) { sms( "Washington Deaths $WashingtonCOVID19Deaths1 to $WashingtonCOVID19Deaths2 "); } 
if ($WashingtonCOVID19Recovered != 0) { sms( "Washington Recovered $WashingtonCOVID19Recovered1 to $WashingtonCOVID19Recovered2 "); } 
if ($WicomicoCOVID19Cases != 0) { sms( "Wicomico Cases $WicomicoCOVID19Cases1 to $WicomicoCOVID19Cases2 "); } 
if ($WicomicoCOVID19Deaths != 0) { sms( "Wicomico Deaths $WicomicoCOVID19Deaths1 to $WicomicoCOVID19Deaths2 "); } 
if ($WicomicoCOVID19Recovered != 0) { sms( "Wicomico Recovered $WicomicoCOVID19Recovered1 to $WicomicoCOVID19Recovered2 "); } 
if ($WorcesterCOVID19Cases != 0) { sms( "Worcester Cases $WorcesterCOVID19Cases1 to $WorcesterCOVID19Cases2 "); } 
if ($WorcesterCOVID19Deaths != 0) { sms( "Worcester Deaths $WorcesterCOVID19Deaths1 to $WorcesterCOVID19Deaths2 "); } 
if ($WorcesterCOVID19Recovered != 0) { sms( "Worcester Recovered $WorcesterCOVID19Recovered1 to $WorcesterCOVID19Recovered2 "); } 
echo "<p>$old_date</p></div>";

echo "</div></div>";
?>
  <br>
  &copy 2020 <a target='_Blank' href='http://www.patrickmcguire.me/'>Patrick McGuire</a> 
| <a target='_Blank' href='https://coronavirus.maryland.gov/'>Official Data Source</a>
</div>
</center>
</body>
</html>
