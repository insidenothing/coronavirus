<?PHP
// break apart the API
include_once('menu.php');

  $date = date('Y-m-d');
	$r = $core->query("select raw_response from coronavirus_api_cache where id = '13' and just_date = '$date' order by id desc");
	$d = mysqli_fetch_array($r);
	$zipData = make_maryland_array3('',$d['raw_response'],'');
	$zipData2 = make_maryland_array3('',''); // this builds the name array

echo "<pre>".print_r($zipData)."</pre>";

echo "<pre>".print_r($zipData2)."</pre>";

include_once('footer.php');
