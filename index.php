<?php 
require './vendor/autoload.php';

use App\Factory\CliFactory;
use App\Factory\LoggerFactory;
use App\Config\ConfigOptions;


// Define & get flags passed to console
$option = getopt('', [ 
    'add',
    'remove',
    'get'
]);

if(count($option) == 1){
    // Option from commandline
    $option = array_keys($option);

    // Initialize Logger
    $log = LoggerFactory::create();

    // Initialize Config
    new ConfigOptions($log);

    // Initialize CLI
    $storage_cli = CliFactory::create('local', $option[0], $log);
}