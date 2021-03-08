<?php
require_once('/var/www/secure.php');

// Step 1: Register an Application
//TwittterAPIkey
//TwitterAPIsecretkey 
//TwitterBearertoken 


$filteredStream = \Spatie\TwitterLabs\FilteredStream\FilteredStreamFactory::create($TwittterAPIkey, $TwitterAPIsecretkey);

$filteredStream->addRule(
    new \Spatie\TwitterLabs\FilteredStream\Rule('cat has:media', 'cat photos')
);

$filteredStream
    ->onTweet(fn (Tweet $tweet) => print($tweet->text . PHP_EOL))
    ->start();
