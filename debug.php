<?PHP
// break apart the API
include_once('functions.php');


$history = make_maryland_array();
echo '<p>make_maryland_array()</p><pre>';
print_r($history);
echo '</pre>';


$history = make_maryland_array2();
echo '<p>make_maryland_array2()</p><pre>';
print_r($history);
echo '</pre>';
