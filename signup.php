<?PHP
// database and functions
include_once('menu.php');

// accept link to confirm number
if(isset($_GET['validate'])){
  $sms = $_GET['validate'];
  $rSMS = $core->query("SELECT sms_status FROM coronavirus_sms where sms_number = '$sms' ");
  $dSMS = mysqli_fetch_array($rSMS);
  if ($dSMS['sms_status'] != 'confirmed'){
    $core->query("update coronavirus_sms set sms_status = 'confirmed' where sms_number = '$sms' ");
    sms_one('4433862584',"CONFIRMED USER - $sms");
    sms_one($sms,"Account Validated, Thank You -Patrick");
  }
  die('DONE - CONFIRMED');
}

// inset new neumber, send link via sms to confirm
if(isset($_GET['phone'])){
  $sms = $_GET['phone'];
  $sms = str_replace(' ','',$sms);
  $sms = str_replace(')','',$sms);
  $sms = str_replace('(','',$sms);
  $sms = str_replace('-','',$sms);
  $sms_validate = "Click to Confirm https://www.mdwestserve.com/coronavirus/signup.php?validate=$sms";
  $core->query("insert into coronavirus_sms ( sms_number ) values ('$sms') ");
  sms_one($sms,$sms_validate);
  sms_one('4433862584',"NEW USER - $sms");
  die('DONE - CHECK SMS');
}

?>
<div class="container">
  <div class="row">
    <div class="col-sm-6">
      <h3>Enter Your Phone Number</h3>
      <p><form> <input name='phone'> <input type='submit' value='Sign Up'> </form></p>
    </div>
    <div class="col-sm-6"> 
      <p><img src='phone.jpg'></p>
    </div>
  </div>
</div>


  
  <?PHP
  include_once('footer.php');
  ?>
 
