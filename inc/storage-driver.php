<?php

use Monolog\Logger;

Class LocalStorageDriver implements StorageDriver {

    private $directory = './storage/';

    public function __construct(
        private Logger $logger,
    ){}

    public function store_img($file, $name){
        echo 'Storing image...' . PHP_EOL;
        try {
            $store_file = file_put_contents($this->directory . $name, $file);
            if($store_file === FALSE) throw new ErrorException("\e[0;31mUnable to store image\e[0m\n");
            echo "\e[0;32mFile successfully stored at path: " . $this->directory . $name . "\e[0m\n";
            $this->logger->info('Image stored at path: ' . $this->directory . $name);
        } catch (\Exception $ex){
            echo $ex->getMessage();
            $this->logger->debug($ex->getMessage(), ['user' => get_current_user()]);
        }
    }

    public function get_img($file){
        $this->logger->info('Image requested ' . $file);
        echo 'Binary image below:' . PHP_EOL;
        echo $file;
        
    }

    public function delete_img($path){
        echo 'Deleting image...' . PHP_EOL;
        try {
            $delete_file = unlink($path);
            if($delete_file === FALSE) throw new ErrorException("\e[0;31mUnable to delete image\e[0m\n");
            echo "\e[0;31mFile has been deleted\e[0m\n";
            $this->logger->info('Image deleted at path: ' . $path);
        } catch (\Exception $ex){
            echo $ex->getMessage();
            $this->logger->debug($ex->getMessage(), ['user' => get_current_user()]);
        }
    }
}

interface StorageDriver {

    public function store_img($file, $name);

    public function get_img($file);

    public function delete_img($file);
}