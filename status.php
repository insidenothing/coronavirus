<?PHP
$days_back = 45;
$px = '25px';
$page_description = "$days_back Day Data Acquisition Report";
include_once('menu.php');
$array=array();
function check_zip($zip,$date,$api_id){
  global $covid_db;
  $q = "select id from coronavirus_zip where zip_code = '$zip' and report_date = '$date'";
  $r = $covid_db->query($q);
  $d = mysqli_fetch_array($r);
  if ($d['id'] > 0){
   return "<span class='found' title='$date'>☑</span>"; 
  }else{
   $miss = "<span class='missing' title='$date'>☒</span>";
   return check_cache($miss,$date,$api_id);
  }
}
function check_county($countyDOTstate,$date,$api_id){
  global $covid_db;
  $parts = explode('.',$countyDOTstate);
  $q = "select id from coronavirus_county where county_name = '$parts[0]' and state_name = '$parts[1]' and report_date = '$date'";
  $r = $covid_db->query($q);
  $d = mysqli_fetch_array($r);
  if ($d['id'] > 0){
   return "<span class='found' title='$date'>☑</span>"; 
  }else{
   $miss = "<span class='missing' title='$date'>☒</span>";
   return check_cache($miss,$date,$api_id);
  }
}
function check_state($state,$date,$api_id){
  global $covid_db;
  $q = "select id from coronavirus_state where state_name = '$state' and report_date = '$date'";
  $r = $covid_db->query($q);
  $d = mysqli_fetch_array($r);
  if ($d['id'] > 0){
   return "<span class='found' title='$date'>☑</span>"; 
  }else{
   $miss = "<span class='missing' title='$date'>☒</span>";
   return check_cache($miss,$date,$api_id);
  }
}
function check_facility($name,$state,$date,$api_id){
  global $covid_db;
  $q = "select id from coronavirus_facility where Facility_Name like '%$name%' and state_name = '$state' and report_date = '$date'";
  $r = $covid_db->query($q);
  $d = mysqli_fetch_array($r);
  if ($d['id'] > 0){
   return "<span class='found' title='$date'>☑</span>"; 
  }else{
   $miss = "<span class='missing' title='$date'>☒</span>";
   return check_cache($miss,$date,$api_id);
  } 
}
function check_cache($input_html,$date,$id){
  global $covid_db;
  $q = "SELECT * FROM coronavirus_api_cache where cache_date_time like '$date %' and api_id = '$id'";
  $r = $covid_db->query($q);
  $d = mysqli_fetch_array($r);
  if ($d['id'] > 0){
   return "<span class='cache' title='$date'>☑</span>"; 
  }else{
   return $input_html; 
  }   
}
echo "<style> span { font-size: $px; font-weight:bold; } .found { background-color: green; } .missing { background-color: red; } .cache { background-color: orange; } </style>";

echo "<h3><span class='found' title='found'>☑</span> Data Loaded, <span class='cache' title='cache'>☑</span> Data Cached, <span class='missing' title='missing'>☒</span> Missing Data </h3>";

echo "<table>";
echo "<tr><td colspan='4'><h1>Data 'Cache and Load' Status</h1></td></tr>";
$q = "SELECT * FROM coronavirus_api_qc order by state_name, data_type ";
$r = $covid_db->query($q);
while ($d = mysqli_fetch_array($r)){
  echo "<tr><td>$d[state_name]</td><td>$d[data_type]</td><td>$d[data_to_check]</td><td>";
  for($i = $days_back; $i > -1; $i--){
    $date = date("Y-m-d", strtotime("-$i days"));
    if ($d['data_type'] == 'zip'){
      echo check_zip($d['data_to_check'],$date,$d['api_id']);
    }elseif($d['data_type'] == 'county'){
      echo check_county($d['data_to_check'].'.'.$d['state_name'],$date,$d['api_id']);
    }elseif($d['data_type'] == 'state'){
      echo check_state($d['data_to_check'],$date,$d['api_id']);
    }elseif($d['data_type'] == 'facility'){
      echo check_facility($d['data_to_check'],$d['state_name'],$date,$d['api_id']); 
    }
  }
  echo "</td><tr>";
}
echo "</table>";
include_once('footer.php');
?>
