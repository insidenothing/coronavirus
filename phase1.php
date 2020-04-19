<?PHP
// preprocess data using zip.php (reviews all zip codes over known time)
$page_description = "Reopen Maryland - Phase One  - Status";
include_once('menu.php');
?>
<div class="row">
  <div class="col-sm-12">
  <h3>Goals</h3>
    We are setting up this page to track zipcodes across the curve. As they trend higher we count the days, 
    as they flatten off we count the days, as they drop we count the days. Every time the trend changes the
    duration resets. Phase One <b>Starts</b> after 14 days of Down Trend. 
  </div>
</div>

<?PHP
// pull date from last update, not assume today.
$date = date('Y-m-d');
?>




<div class="row">
  <div class="col-sm-4">
    <h3>Up Trend</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'UP' and trend_duration <> '0' order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        echo "<li>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count] for $d[trend_duration] days</li>"; 
    }
    ?>
    </ol>
  </div>
  <div class="col-sm-4">
    <h3>Flat Trend</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'FLAT' and report_count <> '0' and trend_duration <> 0 order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        echo "<li>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count] for $d[trend_duration] days</li>"; 
    }
    ?>
    </ol>
  </div>
  <div class="col-sm-4">
  <h3>Down Trend</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'DOWN' and trend_duration <> '0' order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        echo "<li>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count] for $d[trend_duration] days</li>"; 
    }
    ?>
    </ol>
  </div>
</div>


<div class="row">
  <div class="col-sm-4">
    <h3>New Direction Up</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'UP' and trend_duration = '0' order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        echo "<li>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count]</li>"; 
    }
    ?>
    </ol>
  </div>
  <div class="col-sm-4">
    <h3>New Direction Flat</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'FLAT' and report_count <> 0 and trend_duration = '0' order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        echo "<li>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count]</li>"; 
    }
    ?>
    </ol>
  </div>
  <div class="col-sm-4">
  <h3>New Direction Down</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'DOWN' and trend_duration = '0' order by trend_duration DESC";
    $r = $core->query($q);
    while($d = mysqli_fetch_array($r)){
        echo "<li>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count]</li>"; 
    }
    ?>
    </ol>
  </div>
</div>



<?PHP include_once('footer.php'); ?>
