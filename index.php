<?php 
require './vendor/autoload.php';

use App\Factory\CliFactory;


// Define & get flags passed to console
$option = getopt('', [ 
    'add',
    'remove',
    'get'
]);

if(count($option) == 1){
    // Option from commandline
    $option = array_keys($option);

    // Initialize CLI
    $storage_cli = CliFactory::create($option[0]);
}