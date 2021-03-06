<?PHP 
//https://stackoverflow.com/questions/125113/php-code-to-convert-a-mysql-query-to-csv
include_once('/var/www/secure.php'); //outside webserver
include_once('functions.php'); //outside webserver
set_hits(); // internal page counter
//https://stackoverflow.com/questions/14629636/mysql-field-name-to-the-new-mysqli
function mysqli_field_name($result, $field_offset)
{
    $properties = mysqli_fetch_field_direct($result, $field_offset);
    return is_object($properties) ? $properties->name : null;
}


$q = "SELECT * FROM coronavirus_zip ORDER BY report_date, zip_code";

$r = $covid_db->query($q);

$fields = mysqli_num_fields ( $r );

for ( $i = 0; $i < $fields; $i++ )
{
    $header .= mysqli_field_name( $r , $i ) . "\t";
}
// https://www.php.net/manual/en/mysqli-result.fetch-row.php
while( $row = $r->fetch_row() )
{
    $line = '';
    foreach( $row as $value )
    {                                            
        if ( ( !isset( $value ) ) || ( $value == "" ) )
        {
            $value = "\t";
        }
        else
        {
            $value = str_replace( '"' , '""' , $value );
            $value = '"' . $value . '"' . "\t";
        }
        $line .= $value;
    }
    $data .= trim( $line ) . "\n";
}
$data = str_replace( "\r" , "" , $data );

if ( $data == "" )
{
    $data = "\n(0) Records Found!\n";                        
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=covid19math".time().".xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data";
