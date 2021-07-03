<?php 

require './config.php';
require './inc/image-storage-cli.php';
require './inc/storage-driver.php';

// TASK:
// Basic validation on the image
// Storage, retrieval and deletion
// Written as interchangeable module
// Using a PS3 compliant logger

// Define & get flags passed to console
$option = getopt('', [ 
    'add',
    'delete',
    'get'
]);

if(count($option) == 1){
    $option = array_keys($option);
    $storage_driver = new LocalStorageDriver();
    $storage_cli = new ImageStorageCLI($storage_driver, $option[0]);
}