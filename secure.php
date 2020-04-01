<?PHP
// Fill out and store This file in the directory outside webroot 
$host = '';
$user = '';
$pass = '';
$db_name = '';
$core = mysqli_connect($host,$pass,$user,$db_name) or die("Error " . mysqli_error($core));
