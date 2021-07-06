<?php 
require './vendor/autoload.php';

use App\Factory\CliFactory;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Classes\LocalStorageDriver;
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

    // Setup Logger
    $log = new Logger('CLI Log');
    $log->pushHandler(new StreamHandler(__DIR__ . '/debug.log', Logger::DEBUG));
    new ConfigOptions($log);

    // Setup LocalStorageDriver Class 
    $storage_driver = new LocalStorageDriver($log);

    // Initialize CLI
    $storage_cli = CliFactory::create($storage_driver, $option[0]);
}