<?PHP
include_once('menu.php');

// test sending a link to the phone over multiple messages?
echo message_send('4433862584','Testing SMS and MMS','https://www.covid19math.net/img/website-maintenance.png');

include_once('footer.php');
