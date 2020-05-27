<?PHP
$page_description = "APIs and Descriptions";
include_once('menu.php');
$q = "SELECT * FROM coronavirus_apis where api_status = 'active' ";
$r = $core->query($q);
while($d = mysqli_fetch_array($r)){
  echo "<li>$d[id] $d[api_status] $d[api_name] $d[api_description] $d[first_found] $d[last_updated] $d[api_url]</li>";
}
include_once('footer.php');
?>
