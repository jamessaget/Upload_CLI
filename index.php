<?php 

require './config.php';
require 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// TASK OBJECTIVES:
// Basic validation on the image
// Storage, retrieval and deletion
// Written as interchangeable module
// Using a PSR-3 compliant logger

// Remaining tasks:
// REFACTOR IF ELSE part of cli_initialize
// Review code style and refactor any remaining

// Define & get flags passed to console
$option = getopt('', [ 
    'add',
    'remove',
    'get'
]);

if(count($option) == 1){
    // Option from commandline
    $option = array_keys($option);

    // Setup Logger
    $log = new Logger('CLI Log');
    $log->pushHandler(new StreamHandler(__DIR__.'/debug.log', Logger::DEBUG));
    set_error_handling($log);

    // Setup LocalStorageDriver Class 
    $storage_driver = new LocalStorageDriver($log);

    // Initialize CLI
    $storage_cli = new ImageStorageCLI($storage_driver, $option[0]);
}