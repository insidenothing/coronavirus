<?PHP
// preprocess data using zip.php (reviews all zip codes over known time)
$page_description = "Reopen Maryland - Phase One  - Status";
include_once('menu.php');
?>
<div class="row">
  <div class="col-sm-12">
  <h3>Goals</h3>
    We are setting up this page to track anything with a downwards trend sorting by days of down trend.
  </div>
</div>

<?PHP
// pull date from last update, not assume today.
$date = date('Y-m-d');
?>

<div class="row">
  <div class="col-sm-6">
  <h3>Up Trend</h3>
    <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'UP' order by trend_duration DESC";
    while($d = mysqli_fetch_array($r)){
        echo "<li>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count] for $d[trend_duration] days</li>"; 
    }
    ?>
    </ol>
  </div>
  <h3>Flat Trend</h3>
  <ol>
  <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'FLAT' order by trend_duration DESC";
    while($d = mysqli_fetch_array($r)){
        echo "<li>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count] for $d[trend_duration] days</li>"; 
    }
    ?>
    </ol>
  </div>
  <h3>Down Trend</h3>
  <ol>
    <?PHP
    $q = "SELECT * FROM coronavirus_zip where report_date = '$date' and trend_direction = 'DOWN' order by trend_duration DESC";
    while($d = mysqli_fetch_array($r)){
        echo "<li>$d[town_name] $d[zip_code] $d[trend_direction] at $d[report_count] for $d[trend_duration] days</li>"; 
    }
    ?>
    </ol>
  </div>
</div>



<?PHP include_once('footer.php'); ?>
