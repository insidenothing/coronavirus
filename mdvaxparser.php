<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('/var/www/secure.php');
//TwittterAPIkey
//TwitterAPIsecretkey 
//TwitterBearertoken 


$filteredStream = \Spatie\TwitterLabs\FilteredStream\FilteredStreamFactory::create($TwittterAPIkey, $TwitterAPIsecretkey);




/*

$filteredStream->addRule(
    new \Spatie\TwitterLabs\FilteredStream\Rule('cat has:media', 'cat photos')
);

$filteredStream->onTweet(fn (Tweet $tweet) => print($tweet->text . PHP_EOL))->start();
*/
