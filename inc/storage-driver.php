<?php

Class LocalStorageDriver implements StorageDriver {

    private $directory = './storage/';

    public function store_img($file, $type, $name){
        echo 'storing image' . PHP_EOL;
        // var_dump($file, $type, $name);
        file_put_contents($this->directory . $name . $type, $file);
        // feedback to user
    }

    public function get_img($file){
        echo 'getting image';
        // feedback to user
    }

    public function delete_img($file){
        echo 'deleting image';
        // call get_img
        // delete image file
        // feedback to user
    }
}

interface StorageDriver {

    public function store_img($file, $type, $name);

    public function get_img($file);

    public function delete_img($file);
}