<?php 
namespace App\Factory;
use App\Classes\ImageStorageCli;
use App\Interfaces\StorageDriver;

class CliFactory {
    public static function create(StorageDriver $storage_driver, string $option){
        return new ImageStorageCLI($storage_driver, $option);
    }
}