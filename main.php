<?php 

require './config.php';
require './inc/image-storage.php';


// await user input of image path

$storage_cli = new ImageStorageCLI();
// $storage_cli->get_img_path();
$storage_cli->get_img();
// new ImageStorageCLI($line);

// pass image path to class

// example path
// ./images/test-image.png

// send feedback to user

